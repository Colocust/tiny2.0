<?php declare(strict_types=1);


namespace Tiny;


class Config {
    private $config = [];

    public function get(string $name) {
        $names = explode('.', $name);
        $config = $this->config;
        foreach ($names as $str) {
            if (isset($config[$str])) {
                $config = $config[$str];
            } else {
                throw new \Exception('wrong config name' . $str);
            }
        }
        return $config;
    }

    public function load() {
        $dir = __ROOT__ . '/config';
        $this->parseFile($dir);
    }

    private function parseFile(string $dir): void {
        $files = scandir($dir);
        foreach ($files as $file) {
            $pathInfo = pathinfo($file);
            if (@$pathInfo['extension'] !== PHP_EXT) {
                continue;
            }

            $values = include $dir . "/$file";
            $this->set($pathInfo['filename'], $values);
        }
    }

    private function set(string $key, array $values): void {
        $this->config[$key] = $values;
    }

    private function __construct() {
    }
}