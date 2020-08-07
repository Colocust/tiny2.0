<?php declare(strict_types=1);


namespace Tiny;


class TaskCenter {

    public static function post(Task $task) {
        $GLOBALS['WEBSOCKET_SERVER']->task($task);
    }

}