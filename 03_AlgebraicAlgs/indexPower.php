<?php
namespace Otus\AlgebraicAlgs;
/**
 * @var int $timelimitSeconds;
 * @var int $headColumnSize;
 * @var int $otherColumnSize;
 * @var array $powerTestData;
 */
//region Power

use Otus\Tester;
use Otus\TestResult;

$tester = new Tester($argv[1] ?? __DIR__ . '/TestData/3.Power');
$powerTestData = $tester->getData();

echo "Exponentiation with max time execution {$timelimitSeconds} seconds: \n";
$header = [str_pad('', $headColumnSize), ...array_map(function($testSet) use ($otherColumnSize) {
	$task = $testSet[0];
	$result = substr($task[0].'^'.$task[1], 0, $otherColumnSize);
	return str_pad($result, $otherColumnSize, ' ', STR_PAD_LEFT);
}, $powerTestData)];
echo implode('', $header)."\n";

foreach ([
	new PowerSolverByLoop($timelimitSeconds),
	new PowerSolverByLoop2($timelimitSeconds),
	new PowerSolverBitwise($timelimitSeconds),
] as $solver
)
{
	echo str_pad($solver->getTitle() . ": ", $headColumnSize);
	foreach ($powerTestData as [$data, $answer])
	{
		$answer = reset($answer);
		try
		{
			/**
			 * @var TestResult $result
			 */
			$result = $solver->solve($data);

			$outInfo = 'error';

			//			$resultInString = substr($result->getResult(), 0, 9);
			//			$answer = substr($answer, 0, 9);
			//			if ($resultInString === $answer)
			if (round($result->getResult(), 6) === round($answer, 6))
			{
				$outInfo = round($result->getExecutionTime() * 1000000);
			}
		}
		catch (\Exception $e)
		{
			$outInfo = $e->getMessage();

			if ($e->getCode() === 504)
			{
				$outInfo = 'timeout';
			}
		}
		echo str_pad($outInfo, $otherColumnSize, ' ', STR_PAD_LEFT);
	}
	echo "\n";
}
//endregion