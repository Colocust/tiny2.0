<?php declare(strict_types=1);


namespace Tiny;


use Tiny\API\HttpStatus;
use Tiny\API\Request;
use Tiny\API\Response;

class Main {
  private $request_;
  private $response_;

  public function __construct() {
    ini_set('date.timezone', 'Asia/Shanghai');
    ini_set('display_errors', 'On');
    error_reporting(E_ALL);
    $this->request_ = new Request();
    $this->response_ = new Response();
  }

  private function go() {
    Logger::getInstance()->info('start');
    try {
      if (!class_exists($this->request_->api)) {
        $this->response_->httpStatus = HttpStatus::NOT_FOUND;
        Logger::getInstance()->fatal('API NOT FOUND');
        return;
      }

      if ($this->request_->method !== 'POST') {
        Logger::getInstance()->fatal('Not Support' . $this->request_->method . 'Request Method');
        $this->response_->httpStatus = HttpStatus::FAILED;
        return;
      }

      /**
       * @var $api API
       */
      $api = new $this->request_->api;
      $api->process($this->request_, $this->response_);

    } catch (\Exception $exception) {
      $this->response_->httpStatus = HttpStatus::FAILED;
      Logger::getInstance()->fatal("500 PHP Run Error", $exception);
    } catch (\Error $error) {
      $this->response_->httpStatus = HttpStatus::FAILED;
      Logger::getInstance()->fatal("500 PHP Run Error", $error);
    }
  }

  public function fpmGo() {
    $this->request_->api = str_replace('/', '\\', $_SERVER['REQUEST_URI']);
    $this->request_->data = file_get_contents("php://input");
    $this->request_->method = $_SERVER['REQUEST_METHOD'];

    $this->go();

    foreach ($this->response_->httpHeaders as $header => $value) {
      header($header . ': ' . $value);
    }

    if ($this->response_->httpStatus != HttpStatus::SUC) {
      header("HTTP/1.1 " . $this->response_->httpStatus);

      return;
    }

    if (isset($this->response_->data)) {
      echo $this->response_->data;
    }
    Logger::getInstance()->info('end');
  }

  public function swooleGo($httpRequest, $httpResponse) {
    $this->request_->api = str_replace('/', '\\', $httpRequest->server['request_uri']);
    $this->request_->method = $httpRequest->server['request_method'];
    $this->request_->data = $httpRequest->rawContent();

    $this->go();

    foreach ($this->response_->httpHeaders as $header => $value) {
      $httpResponse->header($header, $value);
    }

    $httpResponse->status($this->response_->httpStatus);

    if ($this->response_->httpStatus != HttpStatus::SUC) {
      $this->response_->data = null;
    }
    $httpResponse->end($this->response_->data);
    Logger::getInstance()->info('end');
  }
}