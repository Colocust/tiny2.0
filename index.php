<?php declare(strict_types=1);

namespace Tiny;

require_once 'tiny/Loader/Loader.php';

Loader::register();
$main = new Main();
$main->fpmGo();

