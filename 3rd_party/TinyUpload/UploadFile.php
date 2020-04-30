<?php


namespace API;

use Tiny\DelegateManager;
use Tiny\Logger;
use Tiny\UploadFileDelegate;
use Tiny\Util\Clazz;

class UploadFile extends API {

  private static $path;
  private static $ext;
  private static $max_size = 512000;

  public function requestClass(): Clazz {
    return Clazz::forClass(UploadFileRequest::class);
  }

  protected function doRun(): Response {
    $request = UploadFileRequest::fromAPI($this);
    $response = new UploadFileResponse();

    /**
     * @var $delegate UploadFileDelegate
     */
    $delegate = DelegateManager::getDelegateClassName(
      Clazz::forClass(UploadFileDelegate::class));

    if (!$delegate) {
      Logger::getInstance()->error("UploadFileDelegate not found delegate");
      return new UploadFileResponse(Code::ELSE_ERROR);
    }

    self::$path = $delegate::fileUploadDir();

    $temp = explode(".", $request->file->name);
    self::$ext = end($temp);

    if ($request->file->error !== 0) {
      Logger::getInstance()->error('文件上传错误');
      return new ErrorResponse();
    }

    if ($request->file->size > self::$max_size) {
      Logger::getInstance()->error('文件大小超出最大限制,此文件大小为' . $request->file->size . 'kb');
      return new ErrorResponse();
    }

    $fileName = self::makeFileName();
    move_uploaded_file($request->file->tmp_name,
      self::$path . DIRECTORY_SEPARATOR . $fileName . '.' . self::$ext);
    $response->url = $delegate::fileUrl() . $fileName . '.' . self::$ext;
    return $response;
  }

  private static function makeFileName(): string {
    return md5(uniqid());
  }
}