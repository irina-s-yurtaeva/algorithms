<?php
namespace Otus\ex05_Bitboard;

include_once __DIR__ . '/../Autoload.php';

use Otus\Tester;

$tester = new Tester($argv[1] ?? __DIR__ . '/1.Bitboard - King');
$kingPredictor = new BitboardKing();
echo "King: \n";

foreach ($tester->getData() as [[$position], [$numberOnes, $rightAnswer]])
{
	$result = $kingPredictor->calculate((int) $position);
	if ($result === null)
	{
		echo 'For the position: ' . str_pad($position, 3) . " php does not allow 63 bits\n";
	}
	else
	{
		echo 'For the position: ' . str_pad($position, 3) . ' we have got: '
			. str_pad( $result[0], 19) . ' and right answer is: ' . str_pad($rightAnswer, 20)
			. ' bits: ' . str_pad( $result[1], 2) . ' = '. $numberOnes. "\n"
		;
	}

}
