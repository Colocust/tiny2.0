<?php declare(strict_types=1);


namespace Tiny\Annotation;


interface Uses {

  public function isRequired(): bool;

  public function isOptional(): bool;

  public function getName(): string;
}