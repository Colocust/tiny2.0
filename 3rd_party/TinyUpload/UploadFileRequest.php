<?php


namespace API;


class UploadFileRequest extends Request {
  /**
   * @var UploadFileRequestItem
   * @uses \Tiny\Util\Required
   */
  public $file;
}
