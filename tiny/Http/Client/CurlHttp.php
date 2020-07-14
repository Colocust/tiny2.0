<?php declare(strict_types=1);


namespace Tiny\Http\Client;


interface CurlHttp {
  public function __construct(HttpBuilder $builder);

  public function send(): ?string;
}