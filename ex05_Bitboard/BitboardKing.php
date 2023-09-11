<?php
namespace Otus\ex05_Bitboard;

class BitboardKing
{
	protected const WITHOUT_A = 9151031864016699134;
	protected const WITHOUT_H = 9187201950435737471;

	function calculate(int $position): ?array
	{
		if (in_array($position, [54, 55, 62, 63]))
		{
			return null;
		}

		$kingPosition = 1 << $position;
		$adaptedPositionOnA = ($kingPosition & self::WITHOUT_A);
		$adaptedPositionOnH = ($kingPosition & self::WITHOUT_H);
		$possiblePosition =
			$adaptedPositionOnA << 7 | $kingPosition << 8 | $adaptedPositionOnH << 9 |
			$adaptedPositionOnA >> 1 | /* $kingPosition  */ $adaptedPositionOnH << 1 |
			$adaptedPositionOnA >> 9 | $kingPosition >> 8 | $adaptedPositionOnH >> 7
		;
		$numberOfBits = 0;
		$bitsCount = $possiblePosition;
		do
		{
			$numberOfBits++;
			$bitsCount &= ($bitsCount - 1);
		} while ($bitsCount > 0);
		return [$possiblePosition, $numberOfBits];
	}
}

