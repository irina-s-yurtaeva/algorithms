<?php

namespace Otus\ex06_SimpleSort;

class SortBubbleEnhanced extends SortAlgs
{
	public function sort(): static
	{
		$maxI = $this->length - 1;

		for ($i = $maxI; $i > 0; $i--)
		{
			$isThereAnySwaps = false;
			for ($j = 0; $j < $maxI; $j++)
			{
				if ($this->needToSwap($j, $j + 1))
				{
					$this->swap($j, $j + 1);
					$isThereAnySwaps = true;
				}
			}
			if ($isThereAnySwaps === false)
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
