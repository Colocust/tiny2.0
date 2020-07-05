<?php declare(strict_types=1);


namespace Tiny\Foundation\Server;


use Tiny\API\HttpStatus;
use Tiny\Converter;
use Tiny\Exception\ConverterException;
use Tiny\Logger;
use Tiny\Net;
use Tiny\Serialize\SerializeStrategy;

abstract class API extends \Tiny\API {
  /**
   * @var $net_ Net
   */
  private $net_;
  private $request_;
  /**
   * @var $parseStrategy_ SerializeStrategy
   */
  private $parseStrategy_;

  protected function go(\Tiny\API\Request $request, \Tiny\API\Response $response) {
    $this->request_ = $this->getRequestClass();

    try {
      Converter::toUserDefinedObject($request->data, $this->request_);
    } catch (ConverterException $e) {
      Logger::getInstance()->fatal($e->getMessage());
      $response->httpStatus = HttpStatus::ARGS_ERROR;
      return;
    }
    if ($this->needToken() && !$this->authToken($request)) {
      $response->data->code = Code::TOKEN_EXPIRE_CODE;
      Logger::getInstance()->warn('token not set or error');
      return;
    }

    try {
      $response->data = Converter::toStdClass($this->run());
    } catch (ConverterException $e) {
      Logger::getInstance()->fatal($e->getMessage());
      $response->httpStatus = HttpStatus::ARGS_ERROR;
      return;
    }
  }

  protected function parseRequest(\Tiny\API\Request $request, \Tiny\API\Response $response): bool {
    if (empty($request->data)) {
      $request->data = new \stdClass();
      return true;
    }

    $request->data = $this->parseStrategy_->decode($request->data);

    if ($request->data === false) {
      $response->httpStatus = HttpStatus::ARGS_FORMAT_ERROR;
      Logger::getInstance()->error('PHP parse:decode(request->data) error');
      return false;
    }

    $request->token = @$request->data->token;
    unset($request->data->token);

    return true;
  }

  protected function parseResponse(\Tiny\API\Request $request, \Tiny\API\Response $response): void {
    if (!isset($response->data) || is_null($response->data)) {
      return;
    }
    $response->data = $this->parseStrategy_->encode($response->data);

    if ($response->data === false) {
      unset($response->data);
      $response->httpStatus = HttpStatus::ARGS_FORMAT_ERROR;
      Logger::getInstance()->error('PHP parse:decode(request->data) error');
    }
  }

  abstract protected function requestClass(): Request;

  abstract protected function run(): Response;

  final protected function setParseStrategy(SerializeStrategy $strategy): void {
    $this->parseStrategy_ = $strategy;
  }

  private function authToken(\Tiny\API\Request $request): bool {
    if (is_null($request->token)) {
      return false;
    }

    $this->net_ = Net::readById($request->token);

    if (is_null($this->net_)) {
      return false;
    }
    return true;
  }

  protected function needToken(): bool {
    return true;
  }

  final protected function getNet(): Net {
    return $this->net_;
  }

  final public function getRequest(): Request {
    return $this->request_;
  }

  public function getRequestClass(): Request {
    return $this->requestClass();
  }
}