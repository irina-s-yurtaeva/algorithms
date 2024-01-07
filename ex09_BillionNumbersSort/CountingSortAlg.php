<?php

namespace Otus\ex09_BillionNumbersSort;

class CountingSortAlg extends SortAlg
{
	public function getName(): string
	{
		return 'Counting sort';
	}

	public function sort(): void
	{
		$this->file->rewind();
		$maxNumber = 0;
		$A = [];
		while ([$number] = $this->file->getData(1))
		{
			$maxNumber = max($maxNumber, $number);
			$A[] = $number;
			$this->iterate();
			$this->timer->check();
		}

		$m = strlen($maxNumber);
		for ($i = 0; $i < $m; $i++)
		{
			$C = array_fill(0, $maxNumber, 0);
			$this->iterate($maxNumber);

			// Count Numbers
			reset($A);
			while ($number = current($A))
			{
				$C[$number]++;
				$this->iterate();
				$this->timer->check();
				next($A);
			}

			// Find indexes
			$count = 0;
			for ($j = 0; $j <= $maxNumber; $j++)
			{
				$this->iterate();
				$count += $C[$j];
				$C[$j] = $count - $C[$j];
			}

			// Spread Numbers
			reset($A);
			$B = array_fill(0, count($A) - 1, null);
			while ($number = current($A))
			{
				$B[$C[$number]] = $number;
				$C[$number]++;
				$this->iterate();
				next($A);
			}

			unset($A);
			$A = $B;
			unset($B);
		}
		$checker = 0;
		reset($A);
		$this->statsFinalElementsCount = 0;
		while ($number = current($A))
		{
			if ($checker > $number)
			{
				throw new \ErrorException('Bad sort');
			}
			$this->statsFinalElementsCount++;
			$checker = $number;
			next($A);
		}
	}
}
