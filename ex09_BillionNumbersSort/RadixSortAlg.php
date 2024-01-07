<?php

namespace Otus\ex09_BillionNumbersSort;

class RadixSortAlg extends SortAlg
{
	public function getName(): string
	{
		return 'Radix sort';
	}

	public function sort(): void
	{
		$this->file->rewind();
		$maxNumber = 0;
		$k = 10;
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
			$C = array_fill(0, ($k - 1), null);
			$this->iterate(10);

			// Count Numbers
			reset($A);
			while ($number = current($A))
			{
				$numberAsAString = strrev(str_pad($number, $m, '0', STR_PAD_LEFT));
				$d = (int) $numberAsAString[$i];
				$C[$d]++;
				$this->iterate();
				$this->timer->check();
				next($A);
			}

			// Find indexes
			$count = 0;
			for ($j = 0; $j < $k; $j++)
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
				$numberAsAString = strrev(str_pad($number, $m, '0', STR_PAD_LEFT));
				$d = (int) $numberAsAString[$i];
				$B[$C[$d]] = $number;
				$C[$d]++;
				$this->iterate();
				next($A);
			}
			$A = $B;
		}
		$checker = 0;
		$this->statsFinalElementsCount = 0;
		reset($A);
		while ($number = current($A) && $number !== null)
		{
			if ($checker > $number)
			{
				throw new \ErrorException('Bad sort ' . $checker . ' > ' . $number);
			}
			$this->statsFinalElementsCount++;
			$checker = $number;
			next($A);
		}
	}
}
