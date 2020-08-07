<?php declare(strict_types=1);


namespace Tiny\API;


class HttpStatus {
    const SUC = 200;
    const ARGS_FORMAT_ERROR = 400;
    const NOT_FOUND = 404;
    const ARGS_ERROR = 415;
    const FAILED = 500;
    const DEFAULT = 0;
}