<?php

namespace Otus\AlgebraicAlgs;

abstract class PrimeSolver extends \Otus\Solver
{
	abstract public function getPrimesCount(int $number): float;

	public function prepareResult(mixed $inputData): mixed
	{
		[$number] = $inputData;
		if ($number < 0)
		{
			return false;
		}
		return $this->getPrimesCount($number);
	}
}

