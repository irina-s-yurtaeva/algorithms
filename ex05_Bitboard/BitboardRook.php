<?php
namespace Otus\ex05_Bitboard;

class BitboardRook extends BitboardKing
{
	private const VERTICAL_LINE = 72340172838076673;
	private const HORIZONTAL_lINE = 255;

	public function getName(): string
	{
		return "The Rook";
	}

	protected function isRestrictedByPHP(int $position)
	{
		return $position % 8 === 7 || $position >= 56;
	}

	protected function findPossiblePositions(int $position): int
	{
		$y = round($position / 8, 0, PHP_ROUND_HALF_DOWN);
		$x = $position % 8;

		$possiblePosition = (self::VERTICAL_LINE << $x) ^ (self::HORIZONTAL_lINE << ($y * 8));

		return $possiblePosition;
	}

	protected function countBits($possiblePosition): int
	{
		return self::countBitsByShifting($possiblePosition);
	}
}

