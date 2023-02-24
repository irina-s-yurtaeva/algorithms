<?php

namespace Otus\AlgebraicAlgs;

class PowerSolverByLoop extends PowerSolver
{
	protected function makeCalculations(float $base, int $power): float
	{
		$result = $base;
		for ($ii = 1; $ii < $power; $ii++)
		{
			$this->checkTimer();
			$result *= $base;
		}

		return round($result, 11);
	}
}

