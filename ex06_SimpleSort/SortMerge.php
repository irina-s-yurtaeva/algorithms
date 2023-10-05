<?php

namespace Otus\ex06_SimpleSort;

class SortMerge extends SortAlgs
{
	public function run(): static
	{

		$this->mergeSort(0, $this->length - 1);

		return $this;
	}

	private function mergeSort(int $leftIndex, int $rightIndex)
	{
		$this->checkTime();

		if ($leftIndex >= $rightIndex)
		{
			return;
		}

		$m = floor(($leftIndex + $rightIndex) / 2);
			$this->mergeSort($leftIndex, $m);
		$this->mergeSort($m + 1, $rightIndex);
		$this->merge($leftIndex, $m, $rightIndex);
	}

	private function merge(int $leftIndex, int $medianIndex, int $rightIndex): void
	{
		$this->visualizer?->onSelect($leftIndex, $rightIndex);

		$buffer = [];
		$a = $leftIndex;
		$b = $medianIndex + 1;
		$m = 0;
		while ($a <= $medianIndex && $b <= $rightIndex)
		{
			$index = $this->needToSwap($a, $b) ? $b++ : $a++;
			$buffer[$m++] = $this->array[$index];
		}
		while ($a <= $medianIndex)
		{
			$buffer[$m++] = $this->array[$a++];
		}
		while ($b <= $rightIndex)
		{
			$buffer[$m++] = $this->array[$b++];
		}

		for ($i = $leftIndex; $i <= $rightIndex; $i++)
		{
			$this->array[$i] = $buffer[$i - $leftIndex];
			$this->assignment += 2;
		}

		$this->visualizer?->onDeselect($leftIndex, $rightIndex);
	}
}
