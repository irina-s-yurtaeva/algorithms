<?php
namespace Otus\ex05_Bitboard;

class BitboardKing
{
	protected const WITHOUT_A = 9151031864016699134;
	protected const WITHOUT_H = 9187201950435737471;

	protected const WITHOUT_AB = 9006351518340545788;
	protected const WITHOUT_GH = 4557430888798830399;

	private static array $bitHash;

	public function getName(): string
	{
		return "The King";
	}

	public function calculate(int $position): ?array
	{
		if ($this->isRestrictedByPHP($position))
		{
			return null;
		}

		$bitboardPosition = /*1 << */$position;
		$possiblePosition = $this->findPossiblePositions($bitboardPosition);

		return [$possiblePosition, $this->countBits($possiblePosition)];
	}

	protected function isRestrictedByPHP(int $position)
	{
		return in_array($position, [54, 55, 62, 63]);
	}

	protected function findPossiblePositions(int $position): int
	{
		$position = 1 << $position;
		$adaptedPositionOnA = ($position & self::WITHOUT_A);
		$adaptedPositionOnH = ($position & self::WITHOUT_H);
		$possiblePosition =
			$adaptedPositionOnA << 7 | $position << 8 | $adaptedPositionOnH << 9 |
			$adaptedPositionOnA >> 1 | /* $position  */ $adaptedPositionOnH << 1 |
			$adaptedPositionOnA >> 9 | $position >> 8 | $adaptedPositionOnH >> 7
		;

		return $possiblePosition;
	}

	protected function countBits($possiblePosition): int
	{
		return self::countBitsByMinusAndConjunction($possiblePosition);
	}

	protected static function countBitsByMinusAndConjunction($possiblePosition): int
	{
		$numberOfBits = 0;
		$bitsCount = $possiblePosition;
		while ($bitsCount > 0)
		{
			$numberOfBits++;
			$bitsCount &= ($bitsCount - 1);
		}

		return $numberOfBits;
	}

	private static function initHash(): void
	{
		if (isset(self::$bitHash))
		{
			return;
		}

		for ($i = 0; $i < 256; $i++)
		{
			self::$bitHash[$i] = self::countBitsByMinusAndConjunction($i);
		}
	}

	protected static function countBitsByShifting($possiblePosition): int
	{
		$numberOfBits = 0;

		while ($possiblePosition > 0)
		{
			$numberOfBits += $possiblePosition & 1;
			$possiblePosition = ($possiblePosition >> 1);
		}

		return $numberOfBits;
	}

	protected static function countBitsByHash($possiblePosition): int
	{
		self::initHash();

		$numberOfBits = 0;

		while ($possiblePosition > 0)
		{
			$numberOfBits += self::$bitHash[$possiblePosition & 255];
			$possiblePosition = ($possiblePosition >> 8);
		}

		return $numberOfBits;
	}
}

