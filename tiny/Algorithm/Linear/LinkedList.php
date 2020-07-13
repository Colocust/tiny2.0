<?php declare(strict_types=1);


namespace Tiny\Algorithm\Linear;


class LinkedList {
  protected $dummyHead;
  protected $size;

  public function __construct() {
    $this->dummyHead = new Node(null);
    $this->size = 0;
  }

  public function add(int $index, $element) {
    if ($index < 0 || $index > $this->size) {
      throw new \Exception('Wrong Index');
    }

    $prev = $this->dummyHead;
    for ($i = 0; $i < $index; $i++) {
      $prev = $prev->next;
    }

    $prev->next = new Node($element, $prev->next);
    $this->size++;
  }

  public function addFirst($element) {
    $this->add(0, $element);
  }

  public function addLast($element) {
    $this->add($this->size, $element);
  }

  public function get(int $index) {
    if ($index < 0 || $index >= $this->size) {
      throw new \Exception('Wrong Index');
    }

    $current = $this->dummyHead->next;
    for ($i = 0; $i < $index; $i++) {
      $current = $current->next;
    }
    return $current->element;
  }

  public function getFirst() {
    return $this->get(0);
  }

  public function getLast() {
    return $this->get($this->size - 1);
  }

  public function set(int $index, $element): void {
    if ($index < 0 || $index >= $this->size) {
      throw new \Exception('wrong index');
    }

    $current = $this->dummyHead->next;
    for ($i = 0; $i < $index; $i++) {
      $current = $current->next;
    }
    $current->element = $element;
  }

  public function contains($element): bool {
    $current = $this->dummyHead->next;
    while (!is_null($current)) {
      if ($current->element == $element) {
        return true;
      }
      $current = $current->next;
    }
    return false;
  }

  public function remove(int $index): Node {
    if ($index < 0 || $index >= $this->size) {
      throw new \Exception('wrong index');
    }
    $prev = $this->dummyHead;
    for ($i = 0; $i < $index; $i++) {
      $prev = $prev->next;
    }
    $ret = $prev->next;
    $prev->next = $ret->next;
    $ret->next = null;

    $this->size--;
    return $ret;
  }

  public function removeFirst(): Node {
    return $this->remove(0);
  }

  public function removeLast(): Node {
    return $this->remove($this->size - 1);
  }

  public function getSize(): int {
    return $this->size;
  }

}