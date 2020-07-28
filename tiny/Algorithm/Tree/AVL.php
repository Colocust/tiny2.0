<?php declare(strict_types=1);


namespace Tiny\Algorithm\Tree;


use Tiny\Exception\AlgorithmException;

class AVL extends BST {

  public function add($key): void {
    $this->root = $this->addNode($key, $this->root);
  }

  private function addNode($key, ?AVLNode $node): AVLNode {
    if (is_null($node)) {
      return new AVLNode($key);
    }

    if ($node->key > $key) {
      $node->left = $this->addNode($key, $node->left);
    }
    if ($node->key < $key) {
      $node->right = $this->addNode($key, $node->right);
    }

    return $this->rotate($node);
  }

  private function leftRotate(AVLNode $node): AVLNode {
    /**
     * @var $right AVLNode
     */
    $right = $node->right;
    $node->right = $right->left;
    $right->left = $node;

    $node->height = max($this->getHeight($node->left), $this->getHeight($node->right)) + 1;
    $right->height = max($this->getHeight($right->left), $this->getHeight($right->right)) + 1;

    return $right;
  }

  private function rightRotate(AVLNode $node): AVLNode {
    /**
     * @var $left AVLNode
     */
    $left = $node->left;
    $node->left = $left->right;
    $left->right = $node;

    $node->height = max($this->getHeight($node->left), $this->getHeight($node->right)) + 1;
    $left->height = max($this->getHeight($left->left), $this->getHeight($left->right)) + 1;

    return $left;
  }

  private function rotate(AVLNode $node): AVLNode {
    $node->height = max($this->getHeight($node->left), $this->getHeight($node->right)) + 1;

    $balanceFactor = $this->getBalanceFactor($node);
    //右旋转
    //           y                           x
    //        x    T3    右旋转            z     y
    //      z  T2      =========>       T1    T2 T3
    //    T1
    if ($balanceFactor > 1 && $this->getBalanceFactor($node->left) > 0) {
      return $this->rightRotate($node);
    }
    //左旋转
    //           y                               x
    //        T1    x            左旋转        y     z
    //            T2  z         =======>    T1 T2    T3
    //                 T3
    if ($balanceFactor < -1 && $this->getBalanceFactor($node->right) < 0) {
      return $this->leftRotate($node);
    }
    //左右旋转
    //           y                           x
    //        x    T3    右旋转            z     y
    //      z  T2      =========>       T1    T2 T3
    //           T1
    if ($balanceFactor > 1 && $this->getBalanceFactor($node->left) < 0) {
      $node->left = $this->leftRotate($node->left);
      return $this->rightRotate($node);
    }
    //右左旋转
    //          z                            z                                 x
    //       T1   y         右旋转         T1    x           左旋转           z     y
    //          x  T3    ==========>         T2   y       =========>      T1 T2    T3
    //        T2                                   T3
    if ($balanceFactor < -1 && $this->getBalanceFactor($node->right) > 0) {
      return $this->leftRotate($node);
    }
    return $node;
  }

  public function remove($key): void {
    $node = $this->getNode($key, $this->root);
    if (is_null($node)) {
      throw new AlgorithmException('not found key' . $key);
    }

    $this->root = $this->removeNode($key, $this->root);
  }

  private function removeNode($key, ?AVLNode $node): ?AVLNode {
    if (is_null($node)) {
      return null;
    }
    if ($node->key > $key) {
      $node->left = $this->removeNode($key, $node->left);
      $ret = $node;
    } else if ($node->key < $key) {
      $node->right = $this->removeNode($key, $node->right);
      $ret = $node;
    } else {
      if (is_null($node->left)) {
        $this->size--;
        $right = $node->right;
        $node->right = null;
        $ret = $right;
      } else if (is_null($node->right)) {
        $this->size--;
        $left = $node->left;
        $node->left = null;
        $ret = $left;
      } else {
        $ret = $this->minNode($node->right);
        $ret->right = $this->removeNode($ret->key, $node->right);
        $ret->left = $node->left;
        $node->left = null;
        $node->right = null;
      }
    }

    if (is_null($ret)) {
      return null;
    }

    return $this->rotate($ret);
  }

  public function removeMin(): void {
    $this->remove($this->min());
  }

  public function removeMax(): void {
    $this->remove($this->max());
  }

  private function isBalance(?AVLNode $node): bool {
    if (is_null($node)) {
      return true;
    }

    $factor = $this->getBalanceFactor($node);
    if (abs($factor) > 1) {
      return false;
    }

    return $this->isBalance($node->left) && $this->isBalance($node->right);
  }

  private function getBalanceFactor(?AVLNode $node): int {
    if (is_null($node)) {
      return 0;
    }

    return $this->getHeight($node->left) - $this->getHeight($node->right);
  }

  private function getHeight(?AVLNode $node): int {
    if (!$node) {
      return 0;
    }
    return $node->height;
  }

}