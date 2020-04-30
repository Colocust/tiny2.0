<?php


namespace API;


class UploadFileRequestItem {
  /**
   * @var string
   * @uses \Tiny\Util\Required
   */
  public $name;
  /**
   * @var string
   * @uses \Tiny\Util\Required
   */
  public $type;
  /**
   * @var string
   * @uses \Tiny\Util\Required
   */
  public $tmp_name;
  /**
   * @var int
   * @uses \Tiny\Util\Required
   */
  public $error;
  /**
   * @var int
   * @uses \Tiny\Util\Required
   */
  public $size;
}