<?php declare(strict_types=1);


namespace Tiny\Http\Client;


use Tiny\Logger;

class CurlPostHttp implements CurlHttp {

  private $builder_;

  public function __construct(HttpBuilder $builder) {
    $this->builder_ = $builder;
  }

  public function send(): ?string {
    $curl = curl_init($this->builder_->getUrl());

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $headers = [];
    foreach ($this->builder_->getAllHeaders() as $key => $value) {
      $headers[] = $key . ": " . $value;
    }
    if (count($headers) != 0) {
      curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    }

    curl_setopt($curl, CURLOPT_POST, 1);
    $data = $this->builder_->getContent();

    if ($data === "" | $data === null) {
      Logger::getInstance()->error(
        "curl post error! url is " . $this->builder_->getUrl()
        . ", and requestData is empty");

      curl_close($curl);
      return null;
    }

    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

    $res = curl_exec($curl);
    $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    if ($res === false || curl_errno($curl) || !($httpcode >= 200 && $httpcode < 300)) {
      Logger::getInstance()->error(
        "curl post error! url is " . $this->builder_->getUrl()
        . ", and errcode is " . curl_error($curl));

      curl_close($curl);
      return null;
    }

    curl_close($curl);
    return $res;
  }

}