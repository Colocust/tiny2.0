<?php declare(strict_types=1);


namespace Tiny\Algorithm\Linear;


class Node {
  public $next;
  public $element;

  public function __construct($element, Node $next = null) {
    $this->element = $element;
    $this->next = $next;
  }
}