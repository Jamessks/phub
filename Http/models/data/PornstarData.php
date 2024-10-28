<?php

namespace Http\models\data;

use Core\App;
use Exception;
use Core\Database;
use Http\models\data\enum\Has;

class PornstarData
{
    protected $db;

    public function __construct()
    {
        $this->db = App::resolve(Database::class);
    }

    public function fetchPornstarOrFail(int $id)
    {
        $results = $this->db->query('SELECT id FROM pornstars WHERE id = :id', [
            'id' => $id
        ])->findOrFail();

        return $results;
    }

    public function fetchPornstarData(int $id)
    {
        $sql = "
            SELECT 
                p.id AS pornstar_id, p.name, p.license, p.wlStatus, p.link,
                
                s.subscriptions, s.monthlySearches, s.views, s.videosCount, 
                s.premiumVideosCount, s.whiteLabelVideoCount, s.rank_value, 
                s.rankPremium, s.rankWl,

                a.hairColor, a.ethnicity, a.tattoos, a.piercings, 
                a.breastSize, a.breastType, a.gender, a.orientation, a.age,

                t.height AS thumbnail_height, t.width AS thumbnail_width, 
                t.type AS thumbnail_type, t.urls AS thumbnail_url,
                al.alias AS alias_name
            FROM 
                pornstars p
            LEFT JOIN stats s ON p.id = s.pornstar_id
            LEFT JOIN attributes a ON p.id = a.pornstar_id
            LEFT JOIN thumbnails t ON p.id = t.pornstar_id
            LEFT JOIN aliases al ON p.id = al.pornstar_id

            WHERE 
                p.id = :id
        ";

        $results = $this->db->query($sql, ['id' => $id])->get();

        if (empty($results)) {
            abort();
        }
        // Organize data from the query result
        $data = [
            'pornstar' => [
                'id' => $results[0]['pornstar_id'],
                'name' => $results[0]['name'],
                'license' => $results[0]['license'],
                'wlStatus' => $results[0]['wlStatus'],
                'link' => $results[0]['link']
            ],
            'stats' => [
                'subscriptions' => $results[0]['subscriptions'],
                'monthlySearches' => $results[0]['monthlySearches'],
                'views' => $results[0]['views'],
                'videosCount' => $results[0]['videosCount'],
                'premiumVideosCount' => $results[0]['premiumVideosCount'],
                'whiteLabelVideoCount' => $results[0]['whiteLabelVideoCount'],
                'rank_value' => $results[0]['rank_value'],
                'rankPremium' => $results[0]['rankPremium'],
                'rankWl' => $results[0]['rankWl']
            ],
            'attributes' => [
                'hairColor' => $results[0]['hairColor'] ?? Has::Unspecified->value,
                'ethnicity' => $results[0]['ethnicity'] ?? Has::Unspecified->value,
                'piercings' => Has::fromValue($results[0]['piercings'])->value,
                'tattoos' => Has::fromValue($results[0]['tattoos'])->value,
                'breastSize' => $results[0]['breastSize'] ?? Has::Unspecified->value,
                'breastType' => $results[0]['breastType'] ?? Has::Unspecified->value,
                'gender' => $results[0]['gender'],
                'orientation' => $results[0]['orientation'],
                'age' => $results[0]['age'] ?? Has::Unspecified->value,
            ],
            'thumbnail' => [
                'height' => $results[0]['thumbnail_height'],
                'width' => $results[0]['thumbnail_width'],
                'type' => $results[0]['thumbnail_type'],
                'url' => $results[0]['thumbnail_url']
            ],
            'aliases' => !empty($results[0]['alias_name']) ? array_map(fn($row) => $row['alias_name'], $results) : []
        ];

        return $data;
    }
}
