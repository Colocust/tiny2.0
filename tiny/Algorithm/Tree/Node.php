<?php declare(strict_types=1);


namespace Tiny\Algorithm\Tree;


class Node {
  public $left;
  public $right;
  public $key;

  public function __construct($key) {
    $this->key = $key;
    $this->left = null;
    $this->right = null;
  }
}