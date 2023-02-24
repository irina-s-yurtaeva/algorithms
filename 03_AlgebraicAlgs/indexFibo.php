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

$tester = new Tester($argv[1] ?? __DIR__ . '/TestData/4.Fibo');
$powerTestData = $tester->getData();

echo "Fibonacci with max time execution {$timelimitSeconds} seconds: \n";
$header = [str_pad('', $headColumnSize), ...array_map(function($testSet) use ($otherColumnSize) {
	$task = $testSet[0];
	$result = substr(trim($task[0]), 0, $otherColumnSize);
	return str_pad($result, $otherColumnSize, ' ', STR_PAD_LEFT);
}, $powerTestData)];
echo implode('', $header)."\n";
$errored = [];
foreach ([
	new FiboSolverRecursion($timelimitSeconds),
	new FiboSolverLoop($timelimitSeconds),
	new FiboSolverMatrix($timelimitSeconds),
] as $solver
)
{
	/**
	 * @var FiboSolver $solver
	 */
	echo str_pad($solver->getTitle() . ": ", $headColumnSize);
	foreach ($powerTestData as [$data, $answer])
	{
		$answer = reset($answer);
		$answer = trim($answer);
		try
		{
			/**
			 * @var TestResult $result
			 */
			$result = $solver->solve($data);

			$outInfo = 'error';
			$r = (string) $result->getResult();
			if (strpos($r, $answer) == 0)
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
if (!empty($errored))
	print_r($errored);
//endregion