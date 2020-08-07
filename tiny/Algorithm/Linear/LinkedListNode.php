<?php declare(strict_types=1);


namespace Tiny\Algorithm\Linear;


class LinkedListNode {
    public $next;
    public $element;

    public function __construct($element, LinkedListNode $next = null) {
        $this->element = $element;
        $this->next = $next;
    }
}