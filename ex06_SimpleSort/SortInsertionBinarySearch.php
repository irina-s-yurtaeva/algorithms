<?php

namespace Otus\ex06_SimpleSort;

class SortInsertionBinarySearch extends SortInsertionWithAShift
{
	public function sort(): static
	{
		$maxI = $this->length;

		for ($i = 1; $i < $maxI; $i++)
		{
			$indexToswap =  $this->searchIndex($this->array[$i], 0, $i - 1);
			$this->swap($i, $indexToswap);
		}

		return $this;
	}

	protected function searchIndex($value, $fromIndex, $toIndex)
	{
		if ($toIndex <= $fromIndex)
		{
			return $value >= $this->array[$fromIndex] ? $fromIndex + 1 : $fromIndex;
		}
		$averageIndex = $fromIndex + ceil(($toIndex - $fromIndex) / 2);

		$this->comparison++;

		if ($value >= $this->array[$averageIndex])
		{
			return $this->searchIndex($value, $averageIndex, $toIndex);
		}

		return $this->searchIndex($value, $fromIndex, $averageIndex - 1);
	}

	public function compare($one, $two): bool
	{
		return $one > $two;
	}
}
