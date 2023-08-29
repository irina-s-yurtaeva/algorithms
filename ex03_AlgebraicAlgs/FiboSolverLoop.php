<?php

namespace Otus\AlgebraicAlgs;

class FiboSolverLoop extends FiboSolver
{
	public function getFibo(int $fibo): float
	{
		if ($fibo <= 1)
		{
			return $fibo;
		}
		$previous = 0;
		$current = 1;
		$result = 0;
		while (--$fibo > 0)
		{
			$this->checkTimer();
			$result = $previous + $current;
			$previous = $current;
			$current = $result;
		}

		return $result;
	}
}

