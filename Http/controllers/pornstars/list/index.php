<?php

use Core\App;
use Core\Database;
use Http\utils\renderers\PaginatorRenderer;
use Http\utils\paginators\PornstarPaginator;

$db = App::resolve(Database::class);

$perPage = 20;
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Instantiate the paginator
$paginatorService = new PornstarPaginator($db, $perPage);
list($paginatedResults, $paginator) = $paginatorService->getPaginatedResults($currentPage);
$paginatorRenderer = new PaginatorRenderer($paginator);

view("/pornstars/list/index.view.php", [
    'paginatedResults' => $paginatedResults,
    'paginator' => $paginatorRenderer,
    'heading' => 'Pornstars'
]);
