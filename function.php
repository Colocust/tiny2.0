<?php

use Tiny\Container;
use Tiny\Config;

if (!function_exists('config')) {
    function config(string $name) {
        return Container::getInstance()->get(Config::class)->get($name);
    }
}