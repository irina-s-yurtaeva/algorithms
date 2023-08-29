<?php
namespace Otus\AlgebraicAlgs;
/**
 * @var int $timelimitSeconds;
 * @var int $headColumnSize;
 * @var int $otherColumnSize;
 */
use Otus\Tester;
use Otus\TestResult;

$tester = new Tester($argv[1] ?? __DIR__ . '/TestData/5.Primes');
$powerTestData = $tester->getData();

echo "Primes with max time execution {$timelimitSeconds} seconds: \n";
$header = [str_pad('', $headColumnSize), ...array_map(function($testSet) use ($otherColumnSize) {
	$task = $testSet[0];
	$result = substr(trim($task[0]), 0, $otherColumnSize);
	return str_pad($result, $otherColumnSize, ' ', STR_PAD_LEFT);
}, $powerTestData)];
echo implode('', $header)."\n";
$errored = [];
foreach ([
	new PrimeSolverSimple($timelimitSeconds),
	new PrimeSolverSimple2($timelimitSeconds),
	new PrimeSolverEratosthenes($timelimitSeconds),
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
			$d = trim($data[0]);
//			echo "\n$d -> $r == $answer\n";
			if (strpos($r, $answer) === 0)
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
