<?php declare(strict_types=1);

use Tiny\Loader;
use Tiny\Main;
use Tiny\Pool\Redis\RedisPool;
use Tiny\Task;

define('__ROOT__', __DIR__);

class Server {

  const HOST = '0.0.0.0';
  const PORT = 9502;

  public function __construct() {
    $server = new Swoole\WebSocket\Server(self::HOST, self::PORT);

    $GLOBALS['WEBSOCKET_SERVER'] = $server;

    $server->set(['worker_num' => 2, 'task_worker_num' => 2]);

    $server->on('start', function ($server) {
      swoole_set_process_name("HTTP_SERVER");
    });

    $server->on('task', function ($server, $taskId, $workId, $task) {
      /**
       * @var $task Task
       */
      $task->go();
      return 'Task FINISH';
    });

    $server->on('finish', function ($server, $taskId, $data) {
    });

    $server->on('request', function ($request, $response) {
      RedisPool::init();
      $main = new Main();
      $main->swooleGo($request, $response);
    });

    $server->on('WorkerStart', function ($server, $worker_id) {
      include_once __ROOT__ . '/tiny/Loader/Loader.php';
      include_once __ROOT__ . '/Config.php';
      Loader::register();
    });

    $server->on('message', [$this, 'onMessage']);
    $server->on('open', [$this, 'onOpen']);
    $server->on('close', [$this, 'onClose']);

    $server->start();
  }

  public function onMessage($ws, $frame) {
    echo 'message';
  }

  public function onOpen($server, $request) {
    echo 'open';
  }

  public function onClose($server, $fd) {
    echo 'close';
  }
}

\Co::set(['hook_flags' => SWOOLE_HOOK_ALL | SWOOLE_HOOK_CURL]);

new Server();

