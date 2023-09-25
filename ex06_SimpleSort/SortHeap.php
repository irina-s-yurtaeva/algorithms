<?php

namespace Otus\ex06_SimpleSort;

class SortHeap extends SortAlgs
{
	public function run(): static
	{
		// the first line up
		$arrayLength = $this->length;
		for (
			$vertexIndex = ceil($arrayLength / 2 - 1);
			$vertexIndex >= 0;  $vertexIndex--
		)
		{
			$this->heapify($vertexIndex, $arrayLength);
		}
		// Selection sort + heapify
		for ($i = $arrayLength - 1; $i > 0; $i--)
		{
			$this->swap(0, $i);
			$this->heapify(0, $i);
		}

		return $this;
	}

	private function heapify(int $rootIndex, int $arraySize): void
	{
		$currentIndex = $rootIndex;
		$leftIndex = 2 * $currentIndex + 1;
		$rightIndex = 2 * $currentIndex + 2;
		$largestChildIndex = $rightIndex;
		if ($rightIndex >= $arraySize)
			$largestChildIndex = $leftIndex < $arraySize ? $leftIndex : null;
		else if ($this->needToSwap($leftIndex, $rightIndex))
			$largestChildIndex = $leftIndex;

		if ($largestChildIndex !== null && $this->needToSwap($largestChildIndex, $rootIndex))
		{
			$this->swap($rootIndex, $largestChildIndex);
			$this->heapify($largestChildIndex, $arraySize);
		}
	}
}
