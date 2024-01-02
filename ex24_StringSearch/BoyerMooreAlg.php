<?php

namespace Otus\ex24_StringSearch;

use Otus\Alg;
use Otus\Result;

class BoyerMooreAlg extends ScanAlg
{
	public function getName(): string
	{
		return 'Boyer Moore scan';
	}

	protected function makeOffsetTableForLastLetter(): array
	{
		$length = strlen($this->pattern);
		$result = [];
		$lastLetter = $this->pattern[$length - 1];
		for ($i = $length - 2; $i > 0; $i--)
		{
			$letter = $this->pattern[$i];
			if ($letter === $lastLetter)
			{
				unset($lastLetter);
			}
			if (!isset($result[$letter]))
			{
				$result[$letter] = $length - $i - 1;
			}
		}
		if (isset($lastLetter))
		{
			$result[$lastLetter] = $length - 1;
		}

		return $result;
	}

	protected function makeOffsetTableForSuffixes(): array
	{
		$result = [];
		$patternLength = strlen($this->pattern);
		$lastPrefixPosition = $patternLength - 1;

		for ($i = $patternLength - 1; $i >= 0; $i--)
		{
			if ($this->isPrefix($i + 1))
			{
				$lastPrefixPosition = $i + 1;
			}
			$result[$patternLength - $i] = $lastPrefixPosition - $i + $patternLength - 1;
		}

		for ($i = 0; $i < $patternLength - 1; $i++)
		{
			$len = $this->suffixLength($i);

			$result[$len] = $patternLength - 1 - $i + $len;
		}

		return $result;
	}

	private function isPrefix(int $length): bool
	{
		$j = 0;
		$patternLength = strlen($this->pattern);

		for ($i = $length; $i < $patternLength; $i++)
		{
			if ($this->pattern[$i] !== $this->pattern[$j])
			{
				return false;
			}
			$j++;
		}

		return true;
	}

	private function suffixLength(int $p): int
	{
		$len = 0;
		$i = $p;
		$j = strlen($this->pattern) - 1;
		while ($i >= 0 && $this->pattern[$i] === $this->pattern[$j])
		{
			$len++;
			$i--;
			$j--;
		}

		return $len;
	}

	public function apply(): Result
	{
		$result = parent::apply();
		$lastLetterOffsetTable = $this->makeOffsetTableForLastLetter();
		$goodSuffixOffsetTable = $this->makeOffsetTableForSuffixes();

		$searchDiapason = strlen($this->text) - strlen($this->pattern);
		$patternLength = strlen($this->pattern);
		$found = false;

		$t = 0;
		while ($t <= $searchDiapason)
		{
			$m = $patternLength - 1;
			$found = true;
			while (0 <= $m)
			{
				$this->iterate();
				if ($this->text[ $t + $m ] !== $this->pattern[ $m ])
				{
					$found = false;
					break;
				}
				$m--;
			}
			if ($found)
			{
				break;
			}
			else
			{
				$badLetter = $this->text[ $t + $m ];
				$lastLetter = $this->text[ $t + $patternLength - 1 ];

				$suffixLength = $patternLength - $m;
				$goodSuffixOffset = $goodSuffixOffsetTable[$suffixLength] ?? 0;
				$badSuffixOffset = max(
					!isset($lastLetterOffsetTable[$badLetter]) ? $m : 0,
					$lastLetterOffsetTable[$lastLetter] ?? 0
				);

				$t += max($badSuffixOffset, $goodSuffixOffset, 1);
			}
		}

		$result->setData([$found === true ? $t : null]);
		$result->finalize();

		return $result;
	}
}
