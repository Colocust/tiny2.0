<?php declare(strict_types=1);

namespace Tiny\Algorithm\Tree;

use Tiny\Algorithm\Linear\Queue;
use Tiny\Algorithm\Linear\Stack;
use Tiny\Exception\AlgorithmException;

class BST {
    protected $root;
    protected $size;

    public function __construct() {
        $this->root = null;
        $this->size = 0;
    }

    public function getRoot(): ?BSTNode {
        return $this->root;
    }

    public function isEmpty(): bool {
        return $this->size === 0;
    }

    public function getSize(): int {
        return $this->size;
    }

    public function getNode($key, ?BSTNode $node): ?BSTNode {
        if (is_null($node)) {
            return null;
        }

        if ($node->key == $key) {
            return $node;
        }
        if ($node->key > $key) {
            return $this->getNode($key, $node->left);
        }
        return $this->getNode($key, $node->right);
    }

    public function add($key): void {
        $this->root = $this->addNode($key, $this->root);
    }

    private function addNode($key, ?BSTNode $node): BSTNode {
        if (is_null($node)) {
            $this->size++;
            return new BSTNode($key);
        }
        if ($node->key > $key) {
            $node->left = $this->addNode($key, $node->left);
        }
        if ($node->key < $key) {
            $node->right = $this->addNode($key, $node->right);
        }
        return $node;
    }

    public function contains($key, ?BSTNode $node): bool {
        if (is_null($node)) {
            return false;
        }

        if ($node->key > $key) {
            return $this->contains($key, $node->left);
        }
        if ($node->key < $key) {
            return $this->contains($key, $node->right);
        }
        return true;
    }

    public function min() {
        if ($this->isEmpty()) {
            throw new AlgorithmException('BST is empty');
        }
        return $this->minNode($this->root)->key;
    }

    protected function minNode(BSTNode $node): BSTNode {
        if (is_null($node->left)) {
            return $node;
        }
        return $this->minNode($node->left);
    }

    public function max() {
        if ($this->isEmpty()) {
            throw new AlgorithmException('BST is empty');
        }
        return $this->maxNode($this->root)->key;
    }

    protected function maxNode(BSTNode $node): BSTNode {
        if (is_null($node->right)) {
            return $node;
        }
        return $this->maxNode($node->right);
    }

    public function removeMin() {
        $min = $this->min();
        $this->root = $this->removeMinNode($this->root);
        return $min;
    }

    private function removeMinNode(BSTNode $node): ?BSTNode {
        if (is_null($node->left)) {
            $this->size--;
            $right = $node->right;
            $node->right = null;
            return $right;
        }

        $node->left = $this->removeMinNode($node->left);
        return $node;
    }

    public function removeMax() {
        $max = $this->max();
        $this->root = $this->removeMaxNode($this->root);
        return $max;
    }

    private function removeMaxNode(BSTNode $node): ?BSTNode {
        if (is_null($node->right)) {
            $this->size--;
            $left = $node->left;
            $node->left = null;
            return $left;
        }

        $node->right = $this->removeMaxNode($node->right);
        return $node;
    }

    public function remove($key): void {
        $this->root = $this->removeNode($key, $this->root);
    }

    private function removeNode($key, ?BSTNode $node): ?BSTNode {
        if (is_null($node)) {
            return null;
        }

        if ($node->key > $key) {
            $node->left = $this->removeNode($key, $node->left);
            return $node;
        }

        if ($node->key < $key) {
            $node->right = $this->removeNode($key, $node->right);
            return $node;
        }

        if (is_null($node->left)) {
            $this->size--;
            $right = $node->right;
            $node->right = null;
            return $right;
        }

        if (is_null($node->right)) {
            $this->size--;
            $left = $node->left;
            $node->left = null;
            return $left;
        }

        $min = $this->minNode($node->right);
        $min->right = $this->removeMinNode($node->right);
        $min->left = $node->left;
        $node->left = null;
        $node->right = null;

        return $min;
    }

    public function preOrder(BSTNode $node): array {
        $results = [];

        $results[] = $node->key;
        if ($node->left) {
            $results = array_merge($results, $this->preOrder($node->left));
        }
        if ($node->right) {
            $results = array_merge($results, $this->preOrder($node->right));
        }

        return $results;
    }

    public function inOrder(BSTNode $node): array {
        $results = [];

        if ($node->left) {
            $results = array_merge($results, $this->inOrder($node->left));
        }
        $results[] = $node->key;
        if ($node->right) {
            $results = array_merge($results, $this->inOrder($node->right));
        }

        return $results;
    }

    public function postOrder(BSTNode $node): array {
        $results = [];

        if ($node->left) {
            $results = array_merge($results, $this->postOrder($node->left));
        }
        if ($node->right) {
            $results = array_merge($results, $this->postOrder($node->right));
        }
        $results[] = $node->key;

        return $results;
    }

    public function BFS(BSTNode $node): array {
        $results = [];

        $stack = new Stack();
        $stack->push($node);
        while (!$stack->isEmpty()) {
            /**
             * @var $pop BSTNode
             */
            $pop = $stack->pop();
            $results[] = $pop->key;
            if ($pop->right) {
                $stack->push($pop->right);
            }
            if ($pop->left) {
                $stack->push($pop->left);
            }
        }

        return $results;
    }

    public function DFS(BSTNode $node): array {
        $results = [];

        $queue = new Queue();
        $queue->enQueue($node);

        while (!$queue->isEmpty()) {
            /**
             * @var $deQueue BSTNode
             */
            $deQueue = $queue->deQueue();

            $results[] = $deQueue->key;
            if ($deQueue->left) {
                $queue->enQueue($deQueue->left);
            }
            if ($deQueue->right) {
                $queue->enQueue($deQueue->right);
            }
        }

        return $results;
    }
}