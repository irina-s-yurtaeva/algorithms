<?php

namespace Otus\ex06_SimpleSort;

class SortQuick extends SortAlgs
{
	public function run(): static
	{

		$this->quickSort(0, $this->length - 1);

		return $this;
	}

	private function quickSort(int $leftIndex, int $rightIndex)
	{
		$this->checkTime();

		if ($leftIndex >= $rightIndex)
		{
			return;
		}

		$m = $this->quickSplit($leftIndex, $rightIndex);
		$this->quickSort($leftIndex, $m - 1);
		$this->quickSort($m, $rightIndex);
	}

	private function quickSplit(int $leftIndex, int $rightIndex): int
	{
		$separatorIndex = $leftIndex - 1;
		for ($rawPartStartIndex = $leftIndex; $rawPartStartIndex < $rightIndex; $rawPartStartIndex++)
		{
			if ($this->needToSwap($rightIndex, $rawPartStartIndex))
			{
				$this->swap($rawPartStartIndex, ++$separatorIndex);
			}
		}
		$this->swap($rightIndex, ++$separatorIndex);

		return $separatorIndex;
	}
}
