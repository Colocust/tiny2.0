<?php declare(strict_types=1);

namespace Tiny;


use Tiny\Helper\Time;

class Logger {

  private static $instance = null;
  private static $filePath;
  private static $fileName;

  private function __construct() {
    self::$fileName = 'error.log';
    self::$filePath = __ROOT__ . DIRECTORY_SEPARATOR . self::$fileName;
  }

  private function __clone() {
    return $this;
  }

  public static function getInstance(): Logger {
    if (self::$instance === null) {
      self::$instance = new static();
    }
    return self::$instance;
  }

  public function info(string $message): void {
    $this->addLog('INFO', $message);
  }

  public function warn(string $message): void {
    $this->addLog('WARN', $message);
  }

  public function error(string $message, ?\Throwable $throwable = null): void {
    $this->addLog('ERROR', $message . $throwable);
  }

  public function fatal(string $message, ?\Throwable $throwable = null): void {
    $this->addLog('FATAL', $message . $throwable);
  }

  private function addLog(string $type, string $message): void {
    //找到调用Logger的信息
    $backtrace = debug_backtrace();
    array_shift($backtrace);

    //初始化调用Logger的文件
    $caller = '(' . $backtrace[0]['file'] . ':' . $backtrace[0]['line'] . ')';

    //开始写入文件
    $file = fopen(self::$filePath, 'a');
    fwrite($file, sprintf($this->makeMessage(), $type, $caller, $message));
    fclose($file);
  }

  private function makeMessage(): string {
    return Time::getCurrentMillSecondToString()
      . " %s %s"
      . '['
      . @$_SERVER['REQUEST_URI']
      . ']'
      . ' --- '
      . "%s"
      . PHP_EOL;
  }
}