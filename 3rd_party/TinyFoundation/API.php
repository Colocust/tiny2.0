<?php


namespace API;


use Tiny\HttpStatus;
use Tiny\Logger;
use Tiny\Net;
use Tiny\Util\Clazz;
use Tiny\Util\Validator;

abstract class API extends \Tiny\API {

  protected $uid = null;

  private $request_;
  /**
   * @var $net_ Net
   */
  private $net_;

  abstract public function requestClass(): Clazz;

  abstract protected function doRun(): Response;

  /**
   * @param \Tiny\Request $request
   * @param \Tiny\Response $response
   * @return bool
   * @throws \ReflectionException
   */
  protected function beforeRun(\Tiny\Request $request, \Tiny\Response $response): bool {
    $this->request_ = $request->data;
    $clazz = new \ReflectionClass($this->requestClass()->getName());

    $requestData = $clazz->newInstanceWithoutConstructor();

    try {
      $validator = $this->validateForRequestData();
      $validator->goCheck($request->data, $requestData);
    } catch (\Error $error) {
      $response->httpStatusMsg = $error->getMessage();
      $response->httpStatus = HttpStatus::ARGS_ERROR;
      return false;
    }

    return true;
  }

  protected function run(\Tiny\Request $request, \Tiny\Response $response) {
    if ($this->needToken() && !$this->checkToken($request)) {
      $response->data = new ErrorResponse(Code::TOKEN_EXPIRE_CODE, 'token not set or error');
      Logger::getInstance()->warn('token not set or error');
      return;
    }
    $response->data = $this->doRun();
  }

  /**
   * @param \Tiny\Request $request
   * @param \Tiny\Response $response
   * @return bool|void
   * @throws \ReflectionException
   * @throws \Exception
   */
  protected function afterRun(\Tiny\Request $request, \Tiny\Response $response) {
    $clazz = new \ReflectionClass($this->responseClass()->getName());
    $responseData = $clazz->newInstanceWithoutConstructor();

    try {
      $validator = $this->validateForResponseData();
      $validator->goCheck($response->data, $responseData);
    } catch (\Error $error) {
      $response->httpStatusMsg = $error->getMessage();
      $response->httpStatus = HttpStatus::ARGS_ERROR;
      return false;
    }
    return true;
  }

  //检测此API是否需要token
  protected function needToken(): bool {
    return true;
  }

  //校验token
  protected function checkToken(\Tiny\Request $request): bool {
    if (empty($request->token) || !is_string($request->token)) {
      return false;
    }

    $this->net_ = Net::readNetById($request->token);
    if (!$this->net_) {
      return false;
    }
    return true;
  }

  protected function getNet(): Net {
    return $this->net_;
  }

  /**
   * @return Clazz
   * @throws \Exception
   */
  public function responseClass(): Clazz {
    $clazz = $this->requestClass();
    $pos = strrpos($clazz->getName(), 'Request');
    if ($pos === false) {
      throw new \Exception(get_class($this) .
        "参数验证时不能通过Request类找到指定的Response类");
    }
    $res = Clazz::forClass(substr($clazz->getName(), 0, $pos) . "Response");
    try {
      new \ReflectionClass($res->getName());
    } catch (\ReflectionException $e) {
      throw new \Exception(get_class($this) .
        "参数验证时不能通过Request类找到指定的Response类，因为没有找到"
        . $res->getName());
    }
    return $res;
  }

  final protected function validateForRequestData(): Validator {
    return new Validator();
  }

  final protected function validateForResponseData(): Validator {
    return new Validator();
  }

  public function getRequest(): Request {
    return $this->request_;
  }
}