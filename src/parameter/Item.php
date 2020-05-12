<?php declare(strict_types=1);


namespace API;


class Item {
  /**
   * @var int
   * @uses \Tiny\Annotation\Uses\Required
   */
  public $a;
  /**
   * @var int
   * @uses \Tiny\Annotation\Uses\Optional
   */
  public $b;
}