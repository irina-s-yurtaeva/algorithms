<?php
namespace Otus\LuckyTickets;

include_once __DIR__ . '/../Autoload.php';

use Otus\Tester;

$tester = new Tester($argv[1] ?? __DIR__ . '/1.Tickets');
$testData = $tester->getData();
echo 'The first algorithm with simple loop and 6 digits. my answer: '
	. LoopSolverForSix::calculate()
	. ' right answer: ' . ($testData[3]) . "\n";
echo 'The second algorithm with simple loop and 6 digits. my answer: '
	. LoopSolverForSix2::calculate()
	. ' right answer: ' . ($testData[3]) . "\n";

$solver = new RecursiveSolver();

foreach ($tester->getData() as $digitCapacity => $rightAnswer)
{
	echo 'The digit capacity: ' . $digitCapacity
		. ' my answer: ' . $solver->calculate($digitCapacity)
		. ' right answer: ' . $rightAnswer . "\n";
}
