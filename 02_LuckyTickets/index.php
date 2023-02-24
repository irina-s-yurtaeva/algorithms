<?php
namespace Otus\LuckyTickets;

include_once __DIR__ . '/../Autoload.php';

use Otus\TesterInt;

$tester = new TesterInt($argv[1] ?? __DIR__ . '/1.Tickets');
$testData = $tester->getData();
echo 'The first algorithm with simple loop and 6 digits. my answer: '
	. LoopSolverForSix::calculate()
	. ' right answer: ' . ($testData[3]) . "\n";
echo 'The second algorithm with simple loop and 6 digits. my answer: '
	. LoopSolverForSix2::calculate()
	. ' right answer: ' . ($testData[3]) . "\n";

$solver = new RecursiveSolver();

echo "The third algorithm with recursion till 4 capacity:\n";
foreach ($tester->getData() as $digitCapacity => $rightAnswer)
{
	echo 'The digit capacity: ' . $digitCapacity . ' my answer: ' . $solver->calculate($digitCapacity)
		. ' right answer: ' . $rightAnswer . "\n";
	if ($digitCapacity > 2)
	{
		break; // Too long
	}
}
echo "\nThe fourth algorithm with table sum:\n";

$fourthSolver = new TableSolver();

foreach ($tester->getData() as $digitCapacity => $rightAnswer)
{
	echo 'The digit capacity: ' . $digitCapacity.' my answer: ' . $fourthSolver->calculate($digitCapacity)
		. ' right answer: ' . $rightAnswer . "\n";
}
