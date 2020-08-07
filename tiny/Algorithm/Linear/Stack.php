<?php declare(strict_types=1);


namespace Tiny\Algorithm\Linear;


use Tiny\Exception\AlgorithmException;

class Stack extends LinkedList {

    public function __construct() {
        parent::__construct();
    }

    public function push($element): void {
        $next = $this->dummyHead->next;
        $node = new LinkedListNode($element);
        $this->dummyHead->next = $node;
        $node->next = $next;

        $this->size++;
    }

    public function pop() {
        if ($this->isEmpty()) {
            throw new AlgorithmException('Stack is empty');
        }
        $this->size--;

        $pop = $this->dummyHead->next;
        $this->dummyHead->next = $pop->next;

        return $pop->element;
    }

    public function peek() {
        if ($this->isEmpty()) {
            throw new AlgorithmException('Stack is empty');
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

