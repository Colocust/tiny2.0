<?php declare(strict_types=1);


namespace Tiny;


use Tiny\API\HttpStatus;
use Tiny\API\Request;
use Tiny\API\Response;

class Main {

  public function go($httpRequest, $httpResponse) {
    ini_set('date.timezone', 'Asia/Shanghai');
    ini_set('display_errors', 'Off');
    error_reporting(E_ALL);

    $response = new Response();
    try {
      $request = new Request();
      $request->api = str_replace('/', '\\', $httpRequest->server['request_uri']);

      Logger::getInstance()->info('start');

      do {
        if (!class_exists($request->api)) {
          Logger::getInstance()->fatal('API NOT FOUND');
          $response->httpStatus = HttpStatus::NOT_FOUND;
          break;
        }

        if ($httpRequest->server['request_method'] != 'POST') {
          Logger::getInstance()->fatal('Not Support' . $httpRequest->server['request_method'] . 'Request Method');
          $response->httpStatus = HttpStatus::FAILED;
          break;
        }

        $request->data = $httpRequest->rawContent();
        /**
         * @var $api API
         */
        $api = new $request->api;
        $api->process($request, $response);
      } while (false);

    } catch (\Exception $exception) {
      $response->httpStatus = $exception->getCode();
      Logger::getInstance()->fatal($exception->getMessage(), $exception);
    } catch (\Error $error) {
      $response->httpStatus = HttpStatus::FAILED;
      Logger::getInstance()->fatal($error->getMessage(), $error);
    }

    foreach ($response->httpHeaders as $header => $value) {
      $httpResponse->header($header, $value);
    }

    $httpResponse->status($response->httpStatus);

    if ($response->httpStatus != HttpStatus::SUC) {
      $response->data = null;
    }
    $httpResponse->end($response->data);
    Logger::getInstance()->info('end');
  }
}