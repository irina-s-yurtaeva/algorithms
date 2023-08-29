<?php

namespace Otus\AlgebraicAlgs;

abstract class PowerSolver extends \Otus\Solver
{
	abstract protected function makeCalculations(float $base, int $power): float;

	protected function prepareResult(mixed $inputData): mixed
	{
		[$base, $power] = [$inputData[0] ?? 0, $inputData[1] ?? 0];

		if ($power < 0)
		{
			return false;
		}

		if ($power === 0)
		{
			return 1;
		}
		return $this->makeCalculations($base, $power);
	}
}

