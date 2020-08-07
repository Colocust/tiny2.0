<?php declare(strict_types=1);


namespace Tiny\Annotation\Uses;


use Tiny\Annotation\Uses;

class Optional implements Uses {

    public function isRequired(): bool {
        return false;
    }

    public function isOptional(): bool {
        return true;
    }

    public function getName(): string {
        return 'Optional';
    }
}