<?php declare(strict_types=1);


namespace Tiny\Algorithm\Tree;


class Node {
    public $key;
    public $left;
    public $right;

    public function __construct($key) {
        $this->key = $key;
        $this->left = null;
        $this->right = null;
    }
}