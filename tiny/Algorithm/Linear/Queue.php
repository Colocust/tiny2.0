<?php declare(strict_types=1);


namespace Tiny\Algorithm;


use Tiny\Exception\AlgorithmException;

class Queue {
  private $queue;
  private $size;

  public function __construct() {
    $this->queue = [];
    $this->size = 0;
  }

  public function enQueue($value): void {
    array_push($this->queue, $value);
    $this->size++;
  }

  public function deQueue() {
    if ($this->isEmpty()) {
      throw new AlgorithmException('queue is empty');
    }
    $this->size--;
    return array_shift($this->queue);
  }

  public function getFront() {
    if ($this->isEmpty()) {
      throw new AlgorithmException('queue is empty');
    }
    return $this->queue[0];
  }

  public function isEmpty(): bool {
    return $this->size == 0;
  }

  public function getSize(): int {
    return $this->size;
  }

  public function getQueue(): array {
    return $this->queue;
  }

}