<?php declare(strict_types=1);


namespace Tiny\Http\Login;


abstract class MultiClientLoginAPI extends LoginAPI {

    protected function isSupportMultiClient(): bool {
        return true;
    }

}