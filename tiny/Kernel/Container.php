<?php declare(strict_types=1);


namespace Tiny;


class Container {
    private $instances = [];

    /**
     * @var self
     */
    private static $instance = null;

    private function __construct() {
    }

    public static function getInstance(): Container {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function get(string $name): object {
        return self::$instance->make($name);
    }

    private function make(string $name): object {
        $instance = @$this->instances[$name];
        if (is_null($instance)) {
            $instance = $this->invokeClass($name);
            $this->instances[$name] = $instance;
        }

        return $instance;
    }

    public function invokeClass($name): object {
        $reflectionClass = new \ReflectionClass($name);
        return $reflectionClass->newInstanceWithoutConstructor();
    }
}