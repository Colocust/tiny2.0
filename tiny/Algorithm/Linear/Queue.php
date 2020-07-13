<?php declare(strict_types=1);


namespace Tiny\Algorithm\Linear;


use Tiny\Exception\AlgorithmException;

class Queue extends LinkedList {
  /**
   * @var Node
   */

  private $tail;

  public function __construct() {
    $this->tail = null;
    parent::__construct();
  }

  public function enQueue($element): void {
    $this->size++;

    if (is_null($this->tail)) {
      $this->tail = new Node($element);
      $this->dummyHead->next = $this->tail;
      return;
    }

    $this->tail->next = new Node($element);
    $this->tail = $this->tail->next;
  }

  public function deQueue() {
    if ($this->isEmpty()) {
      throw new AlgorithmException('Empty Queue');
    }

    $node = $this->dummyHead->next;
    $this->dummyHead->next = $node->next;

    if (is_null($this->dummyHead->next)) {
      $this->tail = null;
    }

    $this->size--;
    return $node->element;
  }

  public function getFront() {
    if ($this->isEmpty()) {
      throw new AlgorithmException('Empty Queue');
    }
    return $this->get(0);
  }

  public function isEmpty(): bool {
    return $this->size == 0;
  }

  public function getSize(): int {
    return $this->size;
  }
}