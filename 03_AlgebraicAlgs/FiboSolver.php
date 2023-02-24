<?php

namespace Otus\AlgebraicAlgs;

abstract class FiboSolver extends \Otus\Solver
{
	abstract public function getFibo(int $fibo): float;

	public function prepareResult(mixed $inputData): mixed
	{
		[$fiboToFind] = $inputData;
		if ($fiboToFind < 0)
		{
			return false;
		}
		return $this->getFibo($fiboToFind);
	}
}

