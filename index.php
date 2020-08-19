<?php declare(strict_types=1);

namespace Tiny;

require_once 'tiny/Kernel/Loader.php';

define('__ROOT__', __DIR__);
define('PHP_EXT', 'php');

Loader::register();
Container::getInstance()->get(Config::class)->load();
$main = new Main();
$main->fpmGo();

