<?php declare(strict_types=1);


namespace Tiny\Http\Login;


use Tiny\Http\Code;
use Tiny\Http\JsonAPI;
use Tiny\Http\Response;
use Tiny\Logger;
use Tiny\Net;

abstract class LoginAPI extends JsonAPI {

    abstract protected function login(bool &$loginState): LoginAPIResponse;

    protected function needToken(): bool {
        return false;
    }

    abstract protected function isSupportMultiClient(): bool;

    abstract protected function getUID();

    protected function run(): Response {
        $loginState = false;

        $response = $this->login($loginState);
        if (!$loginState && $response->code !== Code::SUCCESS) {
            $response->token = "";
            Logger::getInstance()->error("Login Failed");
            return $response;
        }

        $uid = $this->getUID();
        //默认token有效期为1个月
        $net = Net::createByOwner($uid, 60 * 60 * 24 * 30, $this->isSupportMultiClient());
        $response->token = $net->getID();
        return $response;
    }
}