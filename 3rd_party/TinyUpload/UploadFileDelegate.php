<?php


namespace Tiny;


interface UploadFileDelegate {
  public static function fileUploadDir(): string;

  public static function fileUrl(): string;
}