<?php

namespace Http\utils\paginators;

use Core\Database;
use Illuminate\Pagination\LengthAwarePaginator;

class PornstarPaginator
{
    protected $db;
    protected $perPage;

    public function __construct(Database $db, $perPage = 10)
    {
        $this->db = $db;
        $this->perPage = $perPage;
    }

    public function getPaginatedResults($currentPage = 1)
    {
        // Get the total count of records in the 'pornstars' table
        $totalRecords = $this->db->query("SELECT COUNT(*) as count FROM pornstars")->find()['count'];

        // Calculate the offset for the current page
        $offset = ($currentPage - 1) * $this->perPage;

        // Fetch the records for the current page
        $query = "
            SELECT pornstars.id, pornstars.name, pornstars.link, 
                   MIN(thumbnails.urls) AS thumbnail_url
            FROM pornstars
            LEFT JOIN thumbnails ON thumbnails.pornstar_id = pornstars.id
            GROUP BY pornstars.id
            ORDER BY pornstars.name ASC
            LIMIT {$this->perPage} OFFSET {$offset}
        ";

        $results = $this->db->query($query)->get();

        // Instantiate the paginator
        $paginator = new LengthAwarePaginator(
            $results,
            $totalRecords,
            $this->perPage,
            $currentPage,
            ['path' => '/pornstars/list']
        );

        // Return both results and paginator
        return [$results, $paginator];
    }
}
