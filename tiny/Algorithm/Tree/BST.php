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

  public function add($element): void {
    $this->root = $this->addNode($element, $this->root);
  }

  private function addNode($element, BSTNode $node = null): BSTNode {
    if (is_null($node)) {
      $this->size++;
      return new BSTNode($element);
    }
    if ($node->element > $element) {
      $node->left = $this->addNode($element, $node->left);
    }
    if ($node->element < $element) {
      $node->right = $this->addNode($element, $node->right);
    }
    return $node;
  }

  public function contains($element, BSTNode $node = null): bool {
    if (is_null($node)) {
      return false;
    }

    if ($node->element > $element) {
      return $this->contains($element, $node->left);
    }
    if ($node->element < $element) {
      return $this->contains($element, $node->right);
    }
    return true;
  }

  public function minElement() {
    if ($this->isEmpty()) {
      throw new AlgorithmException('BST is empty');
    }
    return $this->minNode($this->root)->element;
  }

  private function minNode(BSTNode $node): BSTNode {
    if (is_null($node->left)) {
      return $node;
    }
    return $this->minNode($node->left);
  }

  public function maxElement() {
    if ($this->isEmpty()) {
      throw new AlgorithmException('BST is empty');
    }
    return $this->maxNode($this->root)->element;
  }

  private function maxNode(BSTNode $node): BSTNode {
    if (is_null($node->right)) {
      return $node;
    }
    return $this->maxNode($node->right);
  }

  public function removeMinElement() {
    $min = $this->minElement();
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

  public function removeMaxElement() {
    $max = $this->maxElement();
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

  public function remove($element): void {
    $this->root = $this->removeNode($element, $this->root);
  }

  private function removeNode($element, BSTNode $node = null): ?BSTNode {
    if (is_null($node)) {
      return null;
    }

    if ($node->element > $element) {
      $node->left = $this->removeNode($element, $node->left);
      return $node;
    }

    if ($node->element < $element) {
      $node->right = $this->removeNode($element, $node->right);
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

    $results[] = $node->element;
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
    $results[] = $node->element;
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
    $results[] = $node->element;

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
      $results[] = $pop->element;
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

      $results[] = $deQueue->element;
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