<?php declare(strict_types=1);


namespace API;


use Tiny\Foundation\Server\Request;

class TestRequest extends Request {
  /**
   * @var Item[]
   * @uses \Tiny\Annotation\Uses\Required
   */
  public $id;
}