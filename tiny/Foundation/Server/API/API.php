<?php declare(strict_types=1);


namespace Tiny\Foundation\Server;


use Tiny\Annotation\ClassAnnotation;
use Tiny\API\HttpStatus;
use Tiny\Exception\APIException;
use Tiny\Logger;
use Tiny\Net;
use Tiny\Serialize\SerializeStrategy;
use Tiny\Validate;

abstract class API extends \Tiny\API {

  /**
   * @var $net_ Net
   */
  private $net_;
  /**
   * @var $request_ Request
   */
  private $request_;

  /**
   * @var $parseStrategy_ SerializeStrategy
   */
  private $parseStrategy_;

  protected function go(\Tiny\API\Request $request, \Tiny\API\Response $response) {
    if ($this->needToken() && !$this->authToken($request)) {
      @$response->data->code = Code::TOKEN_EXPIRE_CODE;
      Logger::getInstance()->warn('token not set or error');
      return;
    }
    $this->request_ = $request->data;
    $response->data = $this->run();
  }

  protected function parseRequestParameter(\Tiny\API\Request $request, \Tiny\API\Response $response): bool {
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

    Validate::check($request->data, $this->getRequestClass());

    return true;
  }

  protected function parseResponseParameter(\Tiny\API\Request $request, \Tiny\API\Response $response): void {
    Validate::check($response->data, $this->getResponseClass());

    if (empty($response->data)) {
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

  public function getResponseClass(): Response {
    $requestClass = $this->requestClass();
    $requestClassName = get_class($requestClass);

    $pos = strrpos($requestClassName, 'Request');
    if (!$pos) {
      $errMsg = get_class($this) . "不能通过Request类找到指定的Response类";
      throw new APIException($errMsg);
    }

    $responseClassName = substr($requestClassName, 0, $pos) . 'Response';

    $classInstance = new ClassAnnotation($responseClassName);
    /**
     * @var $responseClass Response
     */
    $responseClass = $classInstance->getClassInstanceWithoutConstruct();
    return $responseClass;
  }

}