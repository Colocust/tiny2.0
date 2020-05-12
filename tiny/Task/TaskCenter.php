<?php declare(strict_types=1);


namespace Tiny;


class TaskCenter {

  public static function post(Task $task) {
    $_SERVER['SWOOLE_SERVER']->task($task);
  }

}