<?php declare(strict_types=1);


namespace Tiny\Algorithm\Linear;


use Tiny\Exception\AlgorithmException;

class Stack {
  private $stack;
  private $size;

  public function __construct() {
    $this->stack = [];
    $this->size = 0;
  }

  public function pop() {
    if ($this->isEmpty()) {
      throw new AlgorithmException('Empty Stack');
    }
    $ret = array_pop($this->stack);
    $this->size--;
    return $ret;
  }

  public function push($element): void {
    array_push($this->stack, $element);
    $this->size++;
  }

  public function peek() {
    if ($this->isEmpty()) {
      throw new \Exception();
    }
    return $this->stack[$this->size - 1];
  }


  public function isEmpty(): bool {
    return $this->size == 0;
  }

  public function getSize(): int {
    return $this->size;
  }
}

