<?php declare(strict_types=1);

namespace Tiny;

require_once 'tiny/Loader/Loader.php';
require_once __ROOT__ . '/Config.php';

define('__ROOT__', __DIR__);

Loader::register();
$main = new Main();
$main->fpmGo();

