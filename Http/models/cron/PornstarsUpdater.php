<?php

namespace Http\models\cron;

use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use Http\models\Pornstar;
use Core\RedisManagement\RedisKeys;
use Core\RedisManagement\RedisManager;

class PornstarsUpdater
{
    protected $client;
    protected $redis;
    protected $imagePath;
    protected $invalidImages = [];
    protected $pornstarIds = [];

    public function __construct()
    {
        $this->client = new Client();
        $this->redis = new RedisManager();
        $this->imagePath = $_ENV['FULL_IMAGE_PATH'];
    }

    public function updatePornstars()
    {
        $batchSize = 25;
        // In case this fails, a locally stored JSON file will be called instead.
        $batch = array_chunk($this->fetchJsonData()['items'], $batchSize);

        foreach ($batch as $pornstarBatch) {
            $promises = [];
            $pornstars = [];

            foreach ($pornstarBatch as $pornstar) {
                $pornstarId = $pornstar['id'];

                $this->pornstarIds[] = $pornstarId;

                if (!empty($thumbnail = $pornstar['thumbnails'])) {
                    $newImageUrl = $thumbnail[0]['urls'][0];

                    $imageFileName = $newImageUrl ? Pornstar::extractImageFileName($newImageUrl) : null;

                    if ($newImageUrl && !$this->isImageCached($imageFileName)) {
                        $promises[] = $this->attemptDownloadImage($pornstarId, $newImageUrl, $imageFileName);
                    } else {
                        echo 'Image for ID ' . $pornstar['id'] . ' is cached and was not downloaded' . PHP_EOL;
                    }
                }

                // After image caching, attach records to Pornstar objects and batch upsert them to db.
                $pornstarObject = new Pornstar(
                    $pornstar['attributes'],
                    $pornstar['id'],
                    $pornstar['name'],
                    $pornstar['license'],
                    $pornstar['wlStatus'],
                    $pornstar['aliases'],
                    $pornstar['link'],
                    !empty($pornstar['thumbnails']) && !in_array($pornstar['thumbnails'][0]['urls'][0], $this->invalidImages) ? $pornstar['thumbnails'] : []
                );
                $pornstars[] = $pornstarObject;
            }

            Promise\Utils::settle($promises)->wait();
            Pornstar::batchInsertPornstars($pornstars);

            unset($promises, $pornstarBatch);
        }

        // Delete stale data, pornstars, their related data and images.
        if (!empty($this->pornstarIds)) {
            $this->deleteStalePornstarData();
        }

        $this->deleteOrphanImages();

        // Remove cached data for Pornstar profile pages
        $deletedCount = $this->redis->deleteAllByPattern(RedisKeys::pornstarDataKey("*"));
        echo 'Pornstar data cached keys removed ' .  $deletedCount . PHP_EOL;
    }

    protected function isImageCached($fileName)
    {
        return file_exists($this->imagePath . $fileName);
    }

    protected function attemptDownloadImage($id, $url, $fileName)
    {
        $imagePath = $this->imagePath . $fileName;
        // Download the image.
        try {
            $this->client->get($url, ['sink' => $imagePath]);
            echo "Downloaded image for pornstar ID: $id" . PHP_EOL;
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            if ($e->getResponse()->getStatusCode() === 404) {
                // Guzzle's efficiency relies on downloading the resource in any case, therefore we validate and remove it.
                echo "Image not found for pornstar ID: $id. URL: $url. Removing it..." . PHP_EOL;
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                    $this->invalidImages[] = $url;
                }
            } else {
                echo "Client error: " . $e->getMessage() . PHP_EOL;
            }
        } catch (\Exception $e) {
            echo "An error occurred: " . $e->getMessage() . PHP_EOL;
        }
    }

    protected function deleteStalePornstarData()
    {
        // Fetch pornstar IDs from the database
        $validIds = Pornstar::fetchPornstarsIds();

        // Store the difference between stored pornstar ids and ids from JSON.
        $pornstarsToDelete = array_diff($validIds, $this->pornstarIds);

        if (!empty($pornstarsToDelete)) {
            $imagesToDelete = Pornstar::getPornstarsThumbnails($pornstarsToDelete);

            // Remove locally stored thumbnails of pornstars to be deleted.
            // DB stored thumbnails will be deleted through cascading pornstar_id from pornstars table.
            foreach ($imagesToDelete as $image) {
                $imagePath = $this->imagePath . $image;
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                    echo 'Removed locally stored image: ' . $imagePath . PHP_EOL;
                }
            }

            // Proceed with deletion of any abandoned pornstar records.
            echo 'Attempting to delete ' . count($pornstarsToDelete) . ' abandoned pornstars.' . PHP_EOL;
            Pornstar::deleteBatchPornstars($pornstarsToDelete);
            echo 'Deletion process finished.' . PHP_EOL;
        }
    }

    protected function deleteOrphanImages()
    {

        // The database is the single source of truth for thumbnails, fetch them and delete thumbnails from images dir as needed.
        $validThumbnails = Pornstar::fetchPornstarsThumbnails();


        // List all images of the images directory.
        $images = scandir($_ENV['FULL_IMAGE_PATH']);

        // Do not process the default image and the rest of directories found.
        $filteredImages = array_filter($images, function ($image) {
            return $image !== '.' && $image !== '..' && $image !== $_ENV['DEFAULT_IMAGE'];
        });

        $orphanThumbnails = array_diff($filteredImages, $validThumbnails);

        $numbersChecked = count($filteredImages);
        $orphanImages = 0;

        // Remove images that don't correspond to any pornstar.
        if (!empty($orphanThumbnails)) {
            foreach ($orphanThumbnails as $orphanThumbnail) {
                $numbersChecked += 1;
                $thumbnailPath = $_ENV['FULL_IMAGE_PATH'] . $orphanThumbnail;
                if (file_exists($thumbnailPath)) {
                    unlink($thumbnailPath);
                    $orphanImages += 1;
                }
            }
        }
        echo 'Images processed: ' . $numbersChecked . PHP_EOL;
        echo 'Orphan images deleted: ' . $orphanImages . PHP_EOL;
    }

    protected function fetchJsondataLocal()
    {
        ini_set('memory_limit', '256M');
        $jsonFilePath = '/var/www/phub/public/test/test1.json';

        if (file_exists($jsonFilePath)) {
            $jsonData = file_get_contents($jsonFilePath);
            return json_decode($jsonData, true);
        } else {
            echo "File not found.";
        }
    }

    protected function fetchJsonData()
    {
        try {
            $response = $this->client->get('https://www.pornhub.com/files/json_feed_pornstars.json');
            return json_decode($response->getBody()->getContents(), true);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            return $this->fetchJsondataLocal();
        }
    }
}
