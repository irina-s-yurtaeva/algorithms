<?php
namespace Otus\ex05_Bitboard;

class BitboardKnight extends BitboardKing
{
	public function getName(): string
	{
		return "The Knight";
	}

	protected function isRestrictedByPHP(int $position)
	{
		return in_array($position, [53, 46, 63]);
	}

	protected function findPossiblePositions(int $position): int
	{
		$possiblePosition  =
			self::WITHOUT_GH & ($position <<  6 | $position >> 10)
			| self::WITHOUT_H & ($position << 15 | $position >> 17)
			| self::WITHOUT_A  & ($position << 17 | $position >> 15)
			| self::WITHOUT_AB & ($position << 10 | $position >>  6);

		return $possiblePosition;
	}

	protected function countBits($possiblePosition): int
	{
		return self::countBitsByHash($possiblePosition);
	}
}

