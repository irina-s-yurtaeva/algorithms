<?php
namespace Otus\AlgebraicAlgs;

use Otus\AlgebraicAlgs\PowerSolver;

class PowerSolverByLoop2 extends PowerSolver
{
	protected function makeCalculations(float $base, int $power): float
	{
		$power1 = ceil($power / 2) + $power % 2;
		$power2 = $power - $power1;

		$result1 = 1;
		$result2 = 1;

		while ($power1 > 0)
		{
			$this->checkTimer();
			$result1 *= $base;
			if ($power2 > 0)
			{
				$result2 *= $base;
			}
			$power1--;
			$power2--;
		}

		return round($result1 * $result2, 11);
	}
}