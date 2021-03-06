<?php declare(strict_types=1);


namespace Tiny\Http\Client;


use Tiny\Logger;

class CurlGetHttp implements CurlHttp {

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

        $value = $this->builder_->getUrl();
        if ($this->builder_->getContent()) {
            $value .= '?' . $this->builder_->getContent();
        }
        curl_setopt($curl, CURLOPT_URL, $value);

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