<?php

namespace Otus\AlgebraicAlgs;

class FiboSolverMatrix extends FiboSolver
{
	public function getFibo(int $fibo): float
	{
		$result = [[1, 1], [1, 0]];
		$storage = [[1, 1], [1, 0]];
		$power = $fibo;

		while ($power > 0)
		{
			$this->checkTimer();
			$power = $power >> 1;
			$storage = [
				[
					$storage[0][0] * $storage[0][0] + $storage[0][1] * $storage[1][0],
					$storage[0][0] * $storage[0][1] + $storage[0][1] * $storage[1][1],
				],
				[
					$storage[1][0] * $storage[0][0] + $storage[1][1] * $storage[1][0],
					$storage[1][0] * $storage[0][1] + $storage[1][1] * $storage[1][1],
				]
			];
			if ($power % 2 >= 1)
			{
				$result = [
					[
						$result[0][0] * $storage[0][0] + $result[0][1] * $storage[1][0],
						$result[0][0] * $storage[0][1] + $result[0][1] * $storage[1][1],
					],
					[
						$result[1][0] * $storage[0][0] + $result[1][1] * $storage[1][0],
						$result[1][0] * $storage[0][1] + $result[1][1] * $storage[1][1],
					]
				];
			}
		}
		return round($result[0][1], 11);
	}
}

