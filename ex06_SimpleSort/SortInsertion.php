<?php

namespace Otus\ex06_SimpleSort;

class SortInsertion extends SortAlgs
{
	public function run(): static
	{
		$maxI = $this->length;

		for ($i = 1; $i < $maxI; $i++)
		{
			$inspected = $i;
			for ($j = $i - 1; $j >= 0; $j--)
			{
				if ($this->needToSwap($j, $inspected))
				{
					$this->swap($inspected, $j);
					$inspected = $j;
				}
				else
				{
					break;
				}
			}
		}

		return $this;
	}
}
