<?php

namespace Otus\ex06_SimpleSort;

class SortBubble2 extends SortAlgs
{
	public function sort(): static
	{
		$maxI = $this->length;

		for ($i = 1; $i < $maxI - 1; $i++)
		{
			for ($j = 0; $j < $i; $j++)
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
