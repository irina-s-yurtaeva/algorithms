<?php
namespace Otus\ex05_Bitboard;

include_once __DIR__ . '/../Autoload.php';

use Otus\Tester;

foreach ([
//	[__DIR__ . '/1.Bitboard - King', BitboardKing::class],
	[__DIR__ . '/2.Bitboard - Knight', BitboardKnight::class],
] as $set)
{
	$tester = new Tester($set[0]);
	$chessPredictor = new $set[1]();
	echo $chessPredictor->getName() . ": \n";
	foreach ($tester->getData() as [[$position], [$countOnes, $rightAnswer]])
	{
		$result = $chessPredictor->calculate((int) $position);
		echo 'For the position: ' . str_pad($position, 3);
		if ($result === null)
		{
			echo " php does not allow 63 bits\n";
		}
		else if ($result[0] == $rightAnswer && $result[1] == $countOnes)
		{
			echo ' we have right answer: ' . str_pad( $result[0], 19)
				. ' bits: ' . str_pad( $result[1], 2) . "\n"
			;
		}
		else
		{
			echo ' we have wrong answer: ' . str_pad( $result[0], 19)
				. ' and right is: '. str_pad( $rightAnswer, 19)
				. ' and bits: ' . str_pad( $result[1], 2)
				. ' bits: ' . str_pad( $countOnes, 2) . "\n"
			;
		}
	}
	echo "\n";
}

