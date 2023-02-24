<?php

namespace Otus\AlgebraicAlgs;

class PrimeSolverSimple2 extends PrimeSolver
{
	private array $primes = [];

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

		for ($ii = 0; $this->primes[$ii] <= $maxDivider; $ii++)
		{
			if (($number % $this->primes[$ii]) === 0)
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

		$this->primes = [2];

		for ($ii = 3; $ii <= $number; $ii += 2)
		{
			if ($this->isPrime($ii))
			{
				$this->primes[] = $ii;
				$count++;
			}
			$this->checkTimer();
		}
		return $count;
	}
}

