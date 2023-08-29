<?php

namespace Otus\AlgebraicAlgs;

class FiboSolverMatrix extends FiboSolver
{
	public function getFibo(int $fibo): float
	{
		if ($fibo <= 1)
		{
			return $fibo;
		}

		$result = [[1, 1], [1, 0]];
		$storage = [[1, 1], [1, 0]];
		$power = $fibo - 1;

		if ($power > 1)
		{
			while($power > 0)
			{
				if ($power % 2 != 0)
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
				$power >>= 1;
			}
		}
		return $result[0][1];
	}
}

