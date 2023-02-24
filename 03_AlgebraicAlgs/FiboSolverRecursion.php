<?php

namespace Otus\AlgebraicAlgs;

class FiboSolverRecursion extends FiboSolver
{
	private function recursion(int $fibo): float
	{
		if ($fibo <= 1)
		{
			return $fibo;
		}
		$this->checkTimer();
		return $this->recursion($fibo - 1) + $this->recursion($fibo - 2);
	}

	public function getFibo(int $fibo): float
	{
		return $this->recursion($fibo);
	}
}

