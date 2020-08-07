<?php declare(strict_types=1);


namespace Tiny\Algorithm\Tree;


class AVLNode extends BSTNode {
    public $height;

    public function __construct($key) {
        $this->height = 1;
        parent::__construct($key);
    }
}