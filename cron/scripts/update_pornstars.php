<?php

$projectRoot = dirname(__DIR__, 2);
$cronRoot = dirname(__DIR__);

require_once $cronRoot . '/CronController.php';

require_once $projectRoot . '/Http/models/cron/PornstarsUpdater.php';

use Core\App;
use Http\models\cron\PornstarsUpdater;

App::setContainer($container);

$updater = new PornstarsUpdater();
$updater->updatePornstars();
