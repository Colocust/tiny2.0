<?php declare(strict_types=1);


namespace Tiny\Algorithm\Tree;


class BSTNode {
  public $left;
  public $right;
  public $element;

  public function __construct($element) {
    $this->element = $element;
    $this->left = null;
    $this->right = null;
  }
}