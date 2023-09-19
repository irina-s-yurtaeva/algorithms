<?php

namespace Otus\ex06_SimpleSort;

class SortBubbleEnhanced extends SortAlgs
{
	public function sort(): static
	{
		$maxI = $this->length;

		for ($i = 1; $i < $maxI - 1; $i++)
		{
			$isThereAbySwaps = false;
			for ($j = 0; $j < $i; $j++)
			{
				if ($this->needToSwap($this->array[$j], $this->array[$j + 1]))
				{
					$this->swap($j, $j + 1);
					$isThereAbySwaps = true;
				}
			}
			if ($isThereAbySwaps === false)
			{
				break;
			}
		}
		return $this;
	}

	public function compare($one, $two): bool
	{
		return $one > $two;
	}
}
