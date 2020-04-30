<?php


namespace Tiny;


class Main {

  public static function run() {
    ini_set('date.timezone', 'Asia/Shanghai');
    ini_set('display_errors', 'Off');
    ini_set('log_errors', 'On');
    error_reporting(E_ALL);

    $response = new Response();
    try {
      $request = new Request();
      $request->api = str_replace('/', '\\', $_SERVER['PATH_INFO']);

      if (!class_exists($request->api)) {
        $response->httpStatus = HttpStatus::NOT_FOUND;
        $response->httpStatusMsg = "API Not Found";
        return;
      }

      if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        $response->httpStatus = HttpStatus::FAILED;
        $response->httpStatusMsg = "目前仅支持POST的请求方式";
        return;
      }

      if (strtolower($_SERVER['REQUEST_METHOD']) == 'options') {
        $httpHeaders["Access-Control-Allow-Origin"] = "*";
        $httpHeaders["Access-Control-Max-Age"] = 24 * 3600;
        $httpHeaders["Access-Control-Allow-Headers"] =
          " accept, content-Type, _t, _i, _f, _l, _s,Accept-Language,"
          . "Content-Language,Origin, No-Cache, X-Requested-With, If-Modified-Since,"
          . " Pragma, Last-Modified, Cache-Control, Expires, Content-Type, "
          . "X-E4M-With,authorization,application/x-www-form-urlencoded,multipart/form-data,text/plain";
        $httpHeaders["Access-Control-Allow-Methods"] = "OPTIONS, POST";
        foreach ($httpHeaders as $header => $value) {
          header($header . ': ' . $value);
        }
        return;
      }

      Logger::getInstance()->info('start');

      $requests = json_decode(file_get_contents("php://input"));
      $request->data = new \API\Request();
      foreach ($requests as $key => $value) {
        $request->data->{$key} = $value;
      }
      /**
       * @var $api \API\API
       */
      $api = new $request->api;
      $api->process($request, $response);
    } catch (\Exception $exception) {
      $response->httpStatus = HttpStatus::FAILED;
      $response->httpStatusMsg = "PHP Run Error";
      Logger::getInstance()->fatal("500 PHP Run Error", $exception);
    } catch (\Error $error) {
      $response->httpStatus = HttpStatus::FAILED;
      $response->httpStatusMsg = "PHP Run Error";
      Logger::getInstance()->fatal("500 PHP Run Error", $error);
    }

    if ($response->httpStatus != HttpStatus::SUC) {
      Logger::getInstance()->fatal($response->httpStatusMsg);
      header("HTTP/1.1 " . $response->httpStatus . " " . $response->httpStatusMsg);

      foreach ($response->httpHeaders as $header => $value) {
        header($header . ': ' . $value);
      }

      return;
    }

    foreach ($response->httpHeaders as $header => $value) {
      header($header . ': ' . $value);
    }

    if (isset($response->data)) {
      echo json_encode($response->data);
    }
  }
}