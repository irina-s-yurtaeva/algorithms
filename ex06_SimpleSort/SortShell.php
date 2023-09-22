<?php

namespace Otus\ex06_SimpleSort;

class SortShell extends SortAlgs
{
	public int $partsCount = 2;

	public function run(): static
	{
		$length = $this->length;

		for (
			$gap = ceil($length / 2);
			$gap >= 1;
			$gap = ceil(($gap > 1 ? $gap : 0) / 2)
		)
		{
			for ($j = $gap; $j < $length; $j++)
			{
				for ($i = $j; $i >= $gap; $i -= $gap)
				{
					if ($this->needToSwap($i - $gap, $i))
					{
						$this->swap($i, $i - $gap);
						continue;
					}
					break;
				}
			}
		}

		return $this;
	}
}
