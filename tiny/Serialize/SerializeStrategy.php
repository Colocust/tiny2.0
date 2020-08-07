<?php declare(strict_types=1);

namespace Tiny\Serialize;


interface SerializeStrategy {
    public function encode(object $object): string;

    public function decode(string $string): \stdClass;
}