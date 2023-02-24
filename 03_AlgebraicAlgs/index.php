<?php
namespace Otus\AlgebraicAlgs;

include_once __DIR__ . '/../Autoload.php';

use Otus\Tester;
use Otus\TestResult;

$tester = new Tester($argv[1] ?? __DIR__ . '/TestData/3.Power');
$powerTestData = $tester->getData();
$timelimitSeconds = 1;
$headColumnSize = 25;
$otherColumnSize = 15;

//region Power
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
		try
		{
			/**
			 * @var TestResult $result
			 */
			$result = $solver->calculate(($data[0] ?? 1), ($data[1] ?? 0));

			$outInfo = 'error';

//			$resultInString = substr($result->getResult(), 0, 9);
//			$answer = substr($answer, 0, 9);
//			if ($resultInString === $answer)
			if (round($result->getResult(), 6) === round($answer, 6))
			{
				$outInfo = round($result->getExecutionTime() * 1000);
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