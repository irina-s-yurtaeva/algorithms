<?php

namespace Otus\AlgebraicAlgs;

class PrimeSolverSimple extends PrimeSolver
{
	private function isPrime($number): bool
	{
		$result = true;
		if ($number <= 2)
		{
			return true;
		}
		if ($number % 2 === 0)
		{
			return false;
		}

		$maxDivider = sqrt($number);

		for ($ii = 3; $ii <= $maxDivider; $ii += 2)
		{
			if (($number % $ii) === 0)
			{
				$result = false;
				break;
			}
		}

		return $result;
	}

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

		$count = 1;

		for ($ii = 3; $ii <= $number; $ii += 2)
		{
			if ($this->isPrime($ii))
			{
				$count++;
			}
			$this->checkTimer();
		}
		return $count;
	}
}

