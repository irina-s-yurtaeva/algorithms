<?php

namespace Otus\ex06_SimpleSort;

class SortBubble extends SortAlgs
{
	public function sort(): static
	{
		$maxI = $this->length - 1;

		for ($i = $maxI; $i > 0; $i--)
		{
			for ($j = 0; $j < $maxI; $j++)
			{
				if ($this->needToSwap($this->array[$j], $this->array[$j + 1]))
				{
					$this->swap($j, $j + 1);
				}
			}
		}
		return $this;
	}

	public function compare($one, $two): bool
	{
		return $one > $two;
	}
}
