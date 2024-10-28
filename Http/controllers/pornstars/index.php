<?php

use Http\models\data\PornstarData;
use Core\RedisManagement\RedisKeys;
use Core\RedisManagement\RedisManager;

$id = $_GET['id'] ?? null;

if (!$id) {
    abort();
}

$redisManager = new RedisManager();

$redisKey = RedisKeys::pornstarDataKey($id);
$data = $redisManager->get($redisKey);

// Fetch data from cache or database fallback.
if ($data === false) {
    $pornstarData = new PornstarData();
    $data = $pornstarData->fetchPornstarData($id);

    $redisManager->set($redisKey, serialize($data), 3600);
} else {
    $data = unserialize($data);
}

view("/pornstars/index.view.php", [
    'heading' => 'Pornstar Profile',
    'data' => $data,
]);
