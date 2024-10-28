<?php

namespace Http\models;

use Core\App;
use Core\Database;
use Http\models\Aliases;
use Http\models\Attributes;
use Http\models\Thumbnails;
use Redis;

class Pornstar
{
    private ?Attributes $attributes = null;
    private ?int $id = null;
    private ?string $name = null;
    private ?string $license = null;
    private ?string $wlStatus = null;
    private ?Aliases $aliases = null;
    private ?string $link = null;
    private ?Thumbnails $thumbnails = null;

    public function __construct(array $attributes, int $id, string $name, string $license, string $wlStatus, array $aliases, string $link, array $thumbnails)
    {
        $this->setAttributes($attributes);
        $this->setId($id);
        $this->setName($name);
        $this->setLicense($license);
        $this->setWlStatus($wlStatus);
        $this->setAliases($aliases);
        $this->setLink($link);
        $this->setThumbnails($thumbnails);
    }

    public function setAttributes(array $attributes)
    {
        $this->attributes = new Attributes([
            'hairColor' => $attributes['hairColor'] ?? null,
            'ethnicity' => $attributes['ethnicity'] ?? null,
            'tattoos' => $attributes['tattoos'] ?? null,
            'piercings' => $attributes['piercings'] ?? null,
            'breastSize' => $attributes['breastSize'] ?? null,
            'breastType' => $attributes['breastType'] ?? null,
            'gender' => $attributes['gender'] ?? null,
            'orientation' => $attributes['orientation'] ?? null,
            'age' => $attributes['age'] ?? null,
            'stats' => $attributes['stats'] ?? null
        ]);
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function setLicense(string $license)
    {
        $this->license = $license;
    }

    public function setWlStatus(string $wlStatus)
    {
        $this->wlStatus = $wlStatus;
    }

    public function setAliases(array $aliases)
    {
        $this->aliases = new Aliases($aliases);
    }

    public function setThumbnails(array $thumbnails)
    {
        foreach ($thumbnails as $thumbnail) {
            $this->thumbnails = new Thumbnails([
                'height' => $thumbnail['height'] ?? null,
                'width' => $thumbnail['width'] ?? null,
                'type' => $thumbnail['type'] ?? null,
                'urls' => $thumbnail['urls'] ?? null,
            ]);
        }
    }

    public function setLink(string $link)
    {
        $this->link = $link;
    }

    public function getAttributes(): ?Attributes
    {
        return $this->attributes;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getLicense(): ?string
    {
        return $this->license;
    }

    public function getWlStatus(): ?string
    {
        return $this->wlStatus;
    }

    public function getAliases(): ?Aliases
    {
        return $this->aliases;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function getThumbnails(): ?Thumbnails
    {
        return $this->thumbnails;
    }

    public static function batchInsertPornstars($pornstarObjects = [])
    {
        self::batchInsertRelatedData($pornstarObjects);
    }

    public static function extractImageFileName($url)
    {
        $parts = explode(')', basename($url));
        return end($parts);
    }

    public static function fetchPornstarsThumbnails()
    {
        $db = App::resolve(Database::class);

        $results = $db->query('SELECT urls FROM thumbnails', [])->getColumn();

        return $results;
    }

    public static function fetchPornstarsIds()
    {
        $db = App::resolve(Database::class);

        $results = $db->query('SELECT id FROM pornstars', [])->getColumn();

        return $results;
    }

    public static function deleteBatchPornstars($pornstarsToDelete = [])
    {
        if (empty($pornstarsToDelete)) {
            echo "No pornstars to delete." . PHP_EOL;
            return 0;
        }

        $db = App::resolve(Database::class);

        $placeholders = implode(',', array_fill(0, count($pornstarsToDelete), '?'));
        $sql = "DELETE FROM pornstars WHERE id IN ($placeholders)";
        $db->query($sql, $pornstarsToDelete);

        return $db->statement->rowCount();
    }

    public static function getPornstarsThumbnails(array $ids)
    {
        $db = App::resolve(Database::class);

        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $sql = "SELECT urls 
        FROM thumbnails 
        WHERE pornstar_id IN ($placeholders)";
        $results = $db->query($sql, $ids)->getColumn();

        return $results;
    }

    public static function deleteBatchAliases($aliasesToDelete = [])
    {
        if (empty($aliasesToDelete)) {
            return;
        }

        $db = App::resolve(Database::class);

        $placeholders = implode(',', array_fill(0, count($aliasesToDelete), '?'));
        $sql = "DELETE FROM aliases WHERE pornstar_id IN ($placeholders)";
        $db->query($sql, $aliasesToDelete);

        return $db->statement->rowCount();
    }

    public static function deleteBatchThumbnails($thumbnailsToDelete = [])
    {
        if (empty($thumbnailsToDelete)) {
            return;
        }

        $db = App::resolve(Database::class);

        $placeholders = implode(',', array_fill(0, count($thumbnailsToDelete), '?'));
        $sql = "DELETE FROM thumbnails WHERE pornstar_id IN ($placeholders)";
        $db->query($sql, $thumbnailsToDelete);

        return $db->statement->rowCount();
    }

    protected static function batchInsertRelatedData($pornstarObjects)
    {
        $db = App::resolve(Database::class);

        $pornstarValues = [];
        $pornstarParams = [];
        $aliasValues = [];
        $aliasParams = [];
        $attributeValues = [];
        $attributeParams = [];
        $thumbnailValues = [];
        $thumbnailParams = [];
        $statValues = [];
        $statParams = [];
        $aliasesToDelete = [];
        $thumbnailsToDelete = [];

        foreach ($pornstarObjects as $index => $pornstar) {
            $pornstarId = $pornstar->getId();
            $aliasesToDelete[] = $pornstarId;
            $thumbnailsToDelete[] = $pornstarId;

            // Prepare pornstars for insertion.
            $pornstarValues[] = "(:id{$index}, :name{$index}, :license{$index}, :wlStatus{$index}, :link{$index})";

            $pornstarParams["id{$index}"] = $pornstarId;
            $pornstarParams["name{$index}"] = $pornstar->getName();
            $pornstarParams["license{$index}"] = $pornstar->getLicense();
            $pornstarParams["wlStatus{$index}"] = $pornstar->getWlStatus();
            $pornstarParams["link{$index}"] = $pornstar->getLink();

            foreach ($pornstar->getAliases()->getAliases() as $aliasIndex => $alias) {
                $aliasValues[] = "(:alias{$index}_{$aliasIndex}, :pornstar_id{$index})";
                $aliasParams["alias{$index}_{$aliasIndex}"] = $alias ?? null;
                $aliasParams["pornstar_id{$index}"] = $pornstarId;
            }

            // Prepare pornstar attributes for insertion.
            $attributes = $pornstar->getAttributes();
            if ($attributes) {
                $attributeValues[] = "(:hairColor{$index}, :ethnicity{$index}, :tattoos{$index}, :piercings{$index}, :breastSize{$index}, :breastType{$index}, :gender{$index}, :orientation{$index}, :age{$index}, :pornstar_id{$index})";

                $attributeParams["hairColor{$index}"] = $attributes->getHairColor();
                $attributeParams["ethnicity{$index}"] = $attributes->getEthnicity();
                $attributeParams["tattoos{$index}"] = $attributes->getTattoos();
                $attributeParams["piercings{$index}"] = $attributes->getPiercings();
                $attributeParams["breastSize{$index}"] = $attributes->getBreastSize();
                $attributeParams["breastType{$index}"] = $attributes->getBreastType();
                $attributeParams["gender{$index}"] = $attributes->getGender();
                $attributeParams["orientation{$index}"] = $attributes->getOrientation();
                $attributeParams["age{$index}"] = $attributes->getAge();
                $attributeParams["pornstar_id{$index}"] = $pornstarId;
            }

            // Prepare pornstar thumbnails for insertion.
            $thumbnails = $pornstar->getThumbnails();
            if ($thumbnails) {
                $thumbnailValues[] = "(:height{$index}, :width{$index}, :type{$index}, :urls{$index}, :pornstar_id{$index})";

                $thumbnailParams["height{$index}"] = $thumbnails->getHeight();
                $thumbnailParams["width{$index}"] = $thumbnails->getWidth();
                $thumbnailParams["type{$index}"] = $thumbnails->getType();
                $thumbnailParams["urls{$index}"] = $thumbnails->getUrls();
                $thumbnailParams["pornstar_id{$index}"] = $pornstarId;
            }

            // Prepare pornstar stats for insertion.
            $stats = $pornstar->getAttributes()->getStats();

            if ($stats) {
                $statValues[] = "(:subscriptions{$index}, :monthlySearches{$index}, :views{$index}, :videosCount{$index}, :premiumVideosCount{$index}, :whiteLabelVideosCount{$index}, :rank_value{$index}, :rankPremium{$index}, :rankWl{$index}, :pornstar_id{$index})";

                $statParams["subscriptions{$index}"] = $stats->getSubscriptions();
                $statParams["monthlySearches{$index}"] = $stats->getMonthlySearches();
                $statParams["views{$index}"] = $stats->getViews();
                $statParams["videosCount{$index}"] = $stats->getVideosCount();
                $statParams["premiumVideosCount{$index}"] = $stats->getPremiumVideosCount();
                $statParams["whiteLabelVideosCount{$index}"] = $stats->getWhiteLabelVideoCount();
                $statParams["rank_value{$index}"] = $stats->getRankValue();
                $statParams["rankPremium{$index}"] = $stats->getRankPremium();
                $statParams["rankWl{$index}"] = $stats->getRankWl();
                $statParams["pornstar_id{$index}"] = $pornstarId;
            }
        }

        if (!empty($pornstarValues)) {
            $pornstarSql = "INSERT INTO pornstars (id, name, license, wlStatus, link) VALUES " . implode(", ", $pornstarValues) . " 
            ON DUPLICATE KEY UPDATE 
                name = VALUES(name), 
                license = VALUES(license), 
                wlStatus = VALUES(wlStatus), 
                link = VALUES(link)";
            $db->query($pornstarSql, $pornstarParams);
        }

        // We dont want to upsert the aliases so batch delete them and insert them instead.
        Pornstar::deleteBatchAliases($aliasesToDelete);
        // Insert Aliases in batch
        if (!empty($aliasValues)) {
            $aliasSql = "INSERT INTO aliases (alias, pornstar_id) VALUES " . implode(", ", $aliasValues) . " 
                ON DUPLICATE KEY UPDATE 
                alias = VALUES(alias), 
                pornstar_id = VALUES(pornstar_id)";
            $db->query($aliasSql, $aliasParams);
        }

        // Insert Attributes in batch
        if (!empty($attributeValues)) {
            $attributeSql = "INSERT INTO attributes (hairColor, ethnicity, tattoos, piercings, breastSize, breastType, gender, orientation, age, pornstar_id) VALUES " . implode(", ", $attributeValues) . " 
                ON DUPLICATE KEY UPDATE 
                hairColor = VALUES(hairColor), 
                ethnicity = VALUES(ethnicity), 
                tattoos = VALUES(tattoos), 
                piercings = VALUES(piercings), 
                breastSize = VALUES(breastSize), 
                breastType = VALUES(breastType), 
                gender = VALUES(gender), 
                orientation = VALUES(orientation),
                age = VALUES(age), 
                pornstar_id = VALUES(pornstar_id)";
            $db->query($attributeSql, $attributeParams);
        }

        // We dont want to upsert the thumbnails so batch delete them and insert them instead.
        Pornstar::deleteBatchThumbnails($thumbnailsToDelete);
        if (!empty($thumbnailValues)) {
            // Insert Thumbnails in batch
            $thumbnailSql = "INSERT INTO thumbnails (height, width, type, urls, pornstar_id) VALUES " . implode(", ", $thumbnailValues) . " 
                ON DUPLICATE KEY UPDATE 
                height = VALUES(height),
                width = VALUES(width),
                type = VALUES(type),
                urls = VALUES(urls),
                pornstar_id = VALUES(pornstar_id)";
            $db->query($thumbnailSql, $thumbnailParams);
        }

        if (!empty($statValues)) {
            $statSql = "INSERT INTO stats (subscriptions, monthlySearches, views, videosCount, premiumVideosCount, whiteLabelVideoCount, rank_value, rankPremium, rankWl, pornstar_id) VALUES " . implode(", ", $statValues) . " 
                ON DUPLICATE KEY UPDATE 
                subscriptions = VALUES(subscriptions),
                monthlySearches = VALUES(monthlySearches),
                views = VALUES(views),
                videosCount = VALUES(videosCount),
                premiumVideosCount = VALUES(premiumVideosCount),
                whiteLabelVideoCount = VALUES(whiteLabelVideoCount),
                rank_value = VALUES(rank_value),
                rankPremium = VALUES(rankPremium),
                rankWl = VALUES(rankWl),
                pornstar_id = VALUES(pornstar_id)";
            $db->query($statSql, $statParams);
        }

        echo ' Insertion of batch Complete!' . PHP_EOL;
    }
}
