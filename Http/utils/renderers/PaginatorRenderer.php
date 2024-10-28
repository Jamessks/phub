<?php

namespace Http\utils\renderers;

class PaginatorRenderer
{
    protected $paginator;

    public function __construct($paginator)
    {
        $this->paginator = $paginator;
    }

    public function render()
    {
        // Start collecting pagination HTML
        $html = '<div class="flex justify-center items-center space-x-2 p-4 bg-black text-white sm:flex-row flex-col">';

        // Define pagination values
        $currentPage = $this->paginator->currentPage();
        $lastPage = $this->paginator->lastPage();
        $path = $this->paginator->path();

        // Previous link
        if ($currentPage > 1) {
            $html .= '<a href="' . $path . '?page=' . ($currentPage - 1) . '" class="px-3 py-1 text-orange-700 hover:bg-orange-700 hover:text-white rounded">Previous</a> ';
        }

        // Page numbers with max 3 around current page
        $start = max(1, $currentPage - 1);
        $end = min($lastPage, $currentPage + 1);

        // Adjust end to show 3 pages near current if there’s a gap
        if ($end + 1 < $lastPage) {
            $end = $currentPage + 1;
        }

        // Render page numbers
        for ($i = $start; $i <= $end; $i++) {
            if ($i == $currentPage) {
                $html .= '<strong class="px-3 py-1 text-orange-700 bg-gray-800 rounded">' . $i . '</strong> ';
            } else {
                $html .= '<a href="' . $path . '?page=' . $i . '" class="px-3 py-1 text-orange-700 hover:bg-orange-700 hover:text-white rounded">' . $i . '</a> ';
            }
        }

        // Ellipsis and last page if needed
        if ($end < $lastPage - 1) {
            $html .= '<span class="px-3 py-1 text-gray-500">...</span> ';
        }

        if ($end < $lastPage) {
            $html .= '<a href="' . $path . '?page=' . $lastPage . '" class="px-3 py-1 text-orange-700 hover:bg-orange-700 hover:text-white rounded">' . $lastPage . '</a> ';
        }

        // Next link
        if ($currentPage < $lastPage) {
            $html .= '<a href="' . $path . '?page=' . ($currentPage + 1) . '" class="px-3 py-1 text-orange-700 hover:bg-orange-700 hover:text-white rounded">Next</a>';
        }

        $html .= '</div>';

        echo $html;
    }
}
