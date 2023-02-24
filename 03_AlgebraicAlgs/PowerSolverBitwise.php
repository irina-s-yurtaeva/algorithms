<?php
namespace Otus\AlgebraicAlgs;

use Otus\AlgebraicAlgs\PowerSolver;

class PowerSolverBitwise extends PowerSolver
{
	protected function makeCalculations(float $base, int $power): float
	{
		$result = 1;
		$storage = $base;
		while ($power > 0)
		{
			$this->checkTimer();
			$power = $power >> 1;
			$storage *= $storage;
			if ($power % 2 >= 1)
			{
				$result *= $storage;
			}
		}
		return round($result, 11);
	}
}