<?php


namespace Tiny;


class Logger {
  private static $instance = null;
  private static $filePath;
  private static $fileName;

  private function __construct() {
    self::$fileName = 'error.log';
    self::$filePath = getcwd() . DIRECTORY_SEPARATOR . self::$fileName;
  }

  private function __clone() {
  }

  public static function getInstance(): Logger {
    if (self::$instance === null)
      self::$instance = new static();
    return self::$instance;
  }

  public function info(string $message, ?\Throwable $throwable = null): void {
    $this->addLog("INFO", $message . $throwable);
  }

  public function warn(string $message, ?\Throwable $throwable = null): void {
    $this->addLog("WARN", $message . $throwable);
  }

  public function error(string $message, ?\Throwable $throwable = null): void {
    $this->addLog("ERROR", $message . $throwable);
  }

  public function fatal(string $message, ?\Throwable $throwable = null): void {
    $this->addLog("FATAL", $message . $throwable);
  }

  //写入日志
  private function addLog(string $type, string $message): void {
    //找到调用Logger的信息
    $backtrace = debug_backtrace();
    array_shift($backtrace);

    //初始化调用Logger的文件
    $caller = '(' . $backtrace[0]['file'] . ":" . $backtrace[0]['line'] . ')';

    //开始写入文件
    $file = fopen(self::$filePath, 'a');
    fwrite($file, sprintf($this->makeMessage(), $type, $caller, $message));
    fclose($file);
  }

  //组装存储日志信息
  private function makeMessage(): string {
    if (!isset($_SERVER['PATH_INFO'])) $_SERVER['PATH_INFO'] = "";
    return Time::getCurrentMillSecondToString()
      . " %s %s"
      . '['
      . $_SERVER['PATH_INFO']
      . ']'
      . ' --- '
      . "%s"
      . PHP_EOL;
  }
}