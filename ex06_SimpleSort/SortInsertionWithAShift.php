<?php

namespace Otus\ex06_SimpleSort;

class SortInsertionWithAShift extends SortAlgs
{
	public function run(): static
	{
		$maxI = $this->length;

		for ($i = 1; $i < $maxI; $i++)
		{
			$inspected = $i;
			$found = $i;
			for ($j = $i - 1; $j >= 0; $j--)
			{
				if ($this->needToSwap($j, $inspected))
				{
					$found = $j;
					continue;
				}
				break;
			}
			$this->swap($inspected, $found);
		}

		return $this;
	}

	public function swap(int $indexFrom, int $indexTo): void
	{
		$this->assignment += ($indexFrom - $indexTo);

		$buffer = $this->array[$indexFrom];
		for ($i = $indexFrom; $i > $indexTo; $i--)
		{
			$this->array[$i] = $this->array[$i - 1];
		}
		$this->array[$indexTo] = $buffer;
	}
}
