<?php declare(strict_types=1);


namespace Tiny;


use Tiny\API\HttpStatus;
use Tiny\API\Request;
use Tiny\API\Response;

class Main {
    private $api_;
    private $data_;

    private function go(): Response {
        ini_set('date.timezone', 'Asia/Shanghai');
        ini_set('display_errors', 'Off');
        error_reporting(E_ALL);

        Logger::getInstance()->info('start');
        $response = new Response();

        try {
            if (!class_exists($this->api_)) {
                $response->httpStatus = HttpStatus::NOT_FOUND;
                Logger::getInstance()->fatal('API NOT FOUND');
                return $response;
            }

            $request = new Request();
            $request->data = $this->data_;

            $api = new $this->api_;
            $api->process($request, $response);

        } catch (\Throwable $throwable) {
            $response->httpStatus = HttpStatus::FAILED;
            Logger::getInstance()->fatal("500 PHP Run Error", $throwable);
        }
        return $response;
    }

    public function fpmGo() {
        $this->api_ = str_replace('/', '\\', $_SERVER['REQUEST_URI']);
        $this->data_ = file_get_contents("php://input");

        $response = $this->go();

        foreach ($response->httpHeaders as $header => $value) {
            header($header . ': ' . $value);
        }

        header("HTTP/1.1 " . $response->httpStatus);
        if ($response->httpStatus != HttpStatus::SUC) {
            return;
        }

        echo $response->data;
        Logger::getInstance()->info('end');
    }

    public function swooleGo($httpRequest, $httpResponse) {
        $this->api_ = str_replace('/', '\\', $httpRequest->server['request_uri']);
        $this->data_ = $httpRequest->rawContent();

        $response = $this->go();

        foreach ($response->httpHeaders as $header => $value) {
            $httpResponse->header($header, $value);
        }

        $httpResponse->status($response->httpStatus);
        if ($response->httpStatus != HttpStatus::SUC) {
            return;
        }

        $httpResponse->end($response->data);
        Logger::getInstance()->info('end');
    }
}