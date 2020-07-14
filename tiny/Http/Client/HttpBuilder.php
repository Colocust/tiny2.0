<?php declare(strict_types=1);


namespace Tiny\Http\Client;


class HttpBuilder {
  private $url_;
  private $content_;
  private $headers_ = [];

  public function setUrl(string $url): HttpBuilder {
    $this->url_ = $url;
    return $this;
  }

  public function setContent(string $content): HttpBuilder {
    $this->content_ = $content;
    return $this;
  }

  public function addHeader(string $key, string $value): HttpBuilder {
    $this->headers_[$key] = $value;
    return $this;
  }

  public function getUrl(): string {
    return $this->url_;
  }

  public function getContent(): string {
    return $this->content_;
  }

  public function getHeader(string $key): ?string {
    return @$this->headers_[$key];
  }

  public function getAllHeaders(): array {
    return $this->headers_;
  }
}