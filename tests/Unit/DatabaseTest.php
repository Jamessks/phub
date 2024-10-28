<?php

namespace Tests\Core;

use PDO;
use Core\Database;


it('connects to the database', function () {
    $database = new Database();
    expect($database->connection)->toBeInstanceOf(PDO::class);
});

it('connects to the database and fetches a record', function () {
    $db = new Database();

    $result = $db->query('SELECT id FROM pornstars LIMIT 1', [])->get();

    expect($result)->toBeArray();
    expect($result)->not->toBeEmpty();
});
