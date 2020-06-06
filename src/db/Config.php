<?php declare(strict_types=1);


namespace TinyDB;


use Tiny\OperationConfig;

interface Config extends OperationConfig {
  const URI = '';
  const USER = '';
  const PASSWORD = '';
  const DBNAME = '';
}