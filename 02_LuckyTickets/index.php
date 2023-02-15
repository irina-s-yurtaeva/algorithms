<?php
namespace Otus\LuckyTickets;

include_once __DIR__ . '/../Autoload.php';

use Otus\Tester;
$tester = new Tester($argv[1] ?? __DIR__ . '/1.Tickets');
$solver = new RecursiveSolver();
foreach ($tester->getData() as $digitCapacity => $rightAnswer)
{
	echo 'The digit capacity: ' . $digitCapacity
		. ' my answer: ' . $solver->calculate($digitCapacity)
		. ' right answer: ' . $rightAnswer . "\n";
}
