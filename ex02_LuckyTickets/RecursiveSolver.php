<?php
namespace Otus\LuckyTickets;

class RecursiveSolver
{
	private int $result = 0;

	private function recursion($leftCapacity, int $firstPartSum = 0, int $secondPartSum = 0): void
	{
		if ($leftCapacity <= 0)
		{
			if ($firstPartSum === $secondPartSum)
			{
				$this->result++;
			}
			return;
		}

		for ($firstPart = 0; $firstPart < 10; $firstPart++)
		{
			for ($secondPart = 0; $secondPart < 10; $secondPart++)
			{
				$this->recursion($leftCapacity - 1, $firstPartSum + $firstPart, $secondPartSum + $secondPart);
			}
		}
	}

	public function calculate(int $capacity): int
	{
		$this->result = 0;
		$this->recursion($capacity);
		return $this->result;
	}
}