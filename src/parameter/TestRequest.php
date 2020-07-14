<?php declare(strict_types=1);


namespace API;



use Tiny\Http\Request;

class TestRequest extends Request {
  /**
   * @var string
   * @uses \Tiny\Annotation\Uses\Required
   */
  public $id;
}