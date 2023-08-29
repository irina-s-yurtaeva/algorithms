<?php

namespace Otus\AlgebraicAlgs;

class PrimeSolverEratosthenes extends PrimeSolver
{
	public function getPrimesCount(int $number): float
	{
		if ($number <= 1)
		{
			return 0;
		}

		if ($number == 2)
		{
			return 1;
		}

		$checkedResult = [2, 3];
		$result = [];
		$sqrt = sqrt($number);

		for ($ii = 5; $ii <= $number; $ii += 2)
		{
			if (
				$ii % 3 !== 0
				&& ($ii <= 5 || $ii % 5 !== 0)
				&& ($ii <= 7 || $ii % 7 !== 0)
				&& ($ii <= 11 || $ii % 11 !== 0)
				&& ($ii <= 13 || $ii % 13 != 0)
			)
			{
				$result[] = $ii;
				$this->checkTimer();
			}
		}

		while (!empty($result))
		{
			$this->checkTimer();

			$checkedResult[] = array_shift($result);

			$divider = end($checkedResult);
			if (!$divider || $divider > $sqrt)
			{
				break;
			}

			$newResult = [];
			foreach ($result as $value)
			{
				if ($value % $divider !== 0)
				{
					$newResult[] = $value;
				}
			}
			$result = $newResult;
			unset($newResult);
		}

		return count($checkedResult) + count($result);
	}
}

