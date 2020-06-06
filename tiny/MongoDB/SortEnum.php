<?php declare(strict_types=1);


namespace Tiny\MongoDB;


use Tiny\Enum\Enum;

class SortEnum extends Enum {
  const ASC = 1;
  const DESC = -1;
}