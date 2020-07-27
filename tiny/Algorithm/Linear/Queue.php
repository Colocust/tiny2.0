<?php declare(strict_types=1);


namespace Tiny\Algorithm\Linear;


use Tiny\Exception\AlgorithmException;

class Queue extends LinkedList {
  /**
   * @var $tail LinkedListNode
   */
  private $tail;

  public function __construct() {
    $this->tail = null;
    parent::__construct();
  }

  public function enQueue($element): void {
    $this->size++;

    if ($this->isEmpty()) {
      $this->tail = new LinkedListNode($element);
      $this->dummyHead->next = $this->tail;
      return;
    }

    $this->tail->next = new LinkedListNode($element);
    $this->tail = $this->tail->next;
  }

  public function deQueue() {
    if ($this->isEmpty()) {
      throw new AlgorithmException('Queue is empty');
    }
    $this->size--;

    $next = $this->dummyHead->next;
    $this->dummyHead->next = $next->next;

    if (is_null($this->dummyHead->next)) {
      $this->tail = null;
    }

    return $next->element;
  }

  public function getFront() {
    if ($this->isEmpty()) {
      throw new AlgorithmException('Queue is empty');
    }
    return $this->get(0);
  }

  public function isEmpty(): bool {
    return $this->size === 0;
  }
}