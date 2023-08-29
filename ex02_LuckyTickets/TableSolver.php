<?php
namespace Otus\LuckyTickets;

class TableSolver
{
	private function makeANextTable(array $currentTable): array
	{
		$resultTable = array_fill(0, count($currentTable) + 9, 0);
		foreach ($resultTable as $index => &$value)
		{
			$startIndex = $index - 9;
			$length = 10;
			if ($startIndex < 0)
			{
				$length += $startIndex;
				$startIndex = 0;
			}

			$res = array_slice($currentTable, $startIndex, $length);
			$value = array_sum($res);
		}
		unset($value);

		return $resultTable;
	}

	function calculate(int $capacity = 1): int
	{
		$luckyTicketsSum = array_fill(0, 10, 1);
		for ($i = 0; $i < $capacity - 1; $i++)
		{
			$luckyTicketsSum = $this->makeANextTable($luckyTicketsSum);
		}

		return array_sum(array_map(fn($value): int => $value * $value, $luckyTicketsSum));
	}
}

