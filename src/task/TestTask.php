<?php declare(strict_types=1);


namespace Helper;


use Tiny\Foundation\Client\CurlGetHttp;
use Tiny\Foundation\Client\HttpBuilder;
use Tiny\Logger;
use Tiny\Task;

class TestTask extends Task {

  public function go() {
    $builder = new HttpBuilder();
    $builder->setUrl('https://restapi.amap.com/v3/geocode/regeo');
    $builder->setContent('key=cc747e4dcfc6867b2114a29675156f3b&location=104.061994,30.538206');
    $curlGetHttp = new CurlGetHttp($builder);
    $res = $curlGetHttp->send();
    Logger::getInstance()->info($res);
  }
}