<?php declare(strict_types=1);


namespace Tiny\Algorithm\Tree;


use Tiny\Exception\AlgorithmException;

class MaxHeap {
    private $heap;
    private $size;

    public function __construct(array $heap = []) {
        $this->heap = $heap;
        $this->size = count($heap);
    }

    public function getHeap(): array {
        return $this->heap;
    }

    public function getSize(): int {
        return $this->size;
    }

    public function isEmpty(): bool {
        return $this->size === 0;
    }

    public function parent(int $index): int {
        if ($index === 0) {
            throw new AlgorithmException("index don't have parent");
        }
        return (int)(($index - 1) / 2);
    }

    public function leftChild(int $index): int {
        return ($index * 2) + 1;
    }

    public function rightChild(int $index): int {
        return ($index * 2) + 2;
    }

    public static function heapify(array $data): MaxHeap {
        $heap = new self($data);
        for ($i = $heap->parent($heap->getSize() - 1); $i >= 0; $i--) {
            $heap->siftDown($i);
        }

        return $heap;
    }

    public function add($element): void {
        $this->heap[] = $element;
        $this->size++;
        $this->siftUp($this->getSize() - 1);
    }

    public function findMax() {
        return $this->heap[0];
    }

    public function replace($element) {
        $max = $this->findMax();
        $this->heap[0] = $element;
        $this->siftDown(0);
        return $max;
    }

    public function extractMax() {
        $max = $this->findMax();
        $this->swap(0, $this->getSize() - 1);
        $this->siftDown(0);
        array_splice($this->heap, $this->getSize() - 1, 1);
        $this->size--;
        return $max;
    }

    private function siftUp(int $index): void {
        while ($index > 0 && $this->heap[$this->parent($index)] < $this->heap[$index]) {
            $this->swap($index, $this->parent($index));
            $index = $this->parent($index);
        }
    }

    private function siftDown(int $index): void {
        while ($this->leftChild($index) < $this->getSize()) {
            $i = $this->leftChild($index);

            if ($i + 1 < $this->getSize() && $this->heap[$i] < $this->heap[$i + 1]) {
                $i++;
            }

            if ($this->heap[$index] >= $this->heap[$i]) {
                break;
            }

            $this->swap($i, $index);
            $index = $i;
        }
    }

    private function swap(int $i, int $j): void {
        if ($i < 0 || $j < 0 || $i >= $this->getSize() || $j >= $this->getSize()) {
            throw new AlgorithmException('wrong index');
        }
        $temp = $this->heap[$i];
        $this->heap[$i] = $this->heap[$j];
        $this->heap[$j] = $temp;
    }
}