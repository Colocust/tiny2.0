<?php declare(strict_types=1);


namespace Tiny\MongoDB;


class Info {
  /**
   * @var string
   * @uses \Tiny\Annotation\Uses\Required
   */
  public $_id;

  public function toArray() {
    $object = json_decode(json_encode($this), true);
    return array_filter($object, function ($v, $k) {
      return $v !== null;
    }, ARRAY_FILTER_USE_BOTH);
  }
}