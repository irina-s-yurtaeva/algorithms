<?php

namespace Otus\ex06_SimpleSort;

class SortBubble extends SortAlgs
{
	public function run(): static
	{
		$maxI = $this->length - 1;

		for ($i = $maxI; $i > 0; $i--)
		{
			for ($j = 0; $j < $maxI; $j++)
			{
				if ($this->needToSwap($j, $j + 1))
				{
					$this->swap($j, $j + 1);
				}
			}
		}

		return $this;
	}
}
