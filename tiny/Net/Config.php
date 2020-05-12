<?php declare(strict_types=1);


namespace Tiny\Net;


use Tiny\OperationConfig;

interface Config extends OperationConfig {
  const HOST = "";
  const PORT = "";
  const TIMEOUT = "";
  const DB = "";
}