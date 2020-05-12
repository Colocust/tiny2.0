<?php declare(strict_types=1);

use Tiny\Loader;
use Tiny\Main;
use Tiny\Task;

define('__ROOT__', __DIR__);

class Server {

  const HOST = '0.0.0.0';
  const PORT = 9502;
  private $server = null;

  public function __construct() {
    $this->server = new Swoole\WebSocket\Server(self::HOST, self::PORT);

    $this->server->set(['worker_num' => 4, 'task_worker_num' => 4,]);

    $this->server->on('start', function ($server) {
      swoole_set_process_name("HTTP_SERVER");
    });

    $this->server->on('task', function ($server, $taskId, $workId, $task) {
      /**
       * @var $task Task
       */
      $task->go();
      return 'Task FINISH';
    });

    $this->server->on('finish', function ($server, $taskId, $data) {
    });

    $this->server->on('request', function ($request, $response) {
      $_SERVER['SWOOLE_SERVER'] = $this->server;

      $main = new Main();
      $main->go($request, $response);
    });

    $this->server->on('WorkerStart', function ($server, $worker_id) {
      include_once __ROOT__ . '/tiny/Loader/Loader.php';
      Loader::register();
    });

    $this->server->on('message', [$this, 'onMessage']);
    $this->server->on('open', [$this, 'onOpen']);
    $this->server->on('close', [$this, 'onClose']);

    $this->server->start();
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
