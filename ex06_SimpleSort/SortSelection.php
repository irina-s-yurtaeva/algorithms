<?php

namespace Otus\ex06_SimpleSort;

class SortSelection extends SortAlgs
{
	public function run(): static
	{
		$maxI = $this->length;

		for ($i = $maxI - 1; $i > 0; $i--)
		{
			$max = $i;
			for ($j = $i - 1; $j >= 0; $j--)
			{
				if ($this->needToSwap($j, $max))
				{
					$max = $j;
				}
			}
			if ($i != $max)
			{
				$this->swap($max, $i);
			}
		}

		return $this;
	}
}
