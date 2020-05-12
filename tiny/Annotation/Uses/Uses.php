<?php declare(strict_types=1);


namespace Tiny\Annotation;


interface Uses {

  function isRequired(): bool;

  function isOptional(): bool;
}