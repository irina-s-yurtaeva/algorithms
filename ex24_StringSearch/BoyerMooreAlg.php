<?php

namespace Otus\ex24_StringSearch;

use Otus\Alg;
use Otus\Result;

class BoyerMooreAlg extends AbstractScanAlg
{
	protected string $patternPrefix = '';

	public function __construct(protected string $text, protected string $pattern)
	{
		parent::__construct($text, $pattern);
		$this->patternPrefix = '';
	}

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

	public function makeOffsetTableForSuffixes(): array
	{
		$result = [];
		$patternLength = strlen($this->pattern);
		$this->patternPrefix = $this->findPrefix();

		for ($i = $patternLength; $i > 0; $i--)
		{
			$result[substr($this->pattern, $i - 1)] = $this->findSuffixFor($i);
		}

		return $result;
	}

	private function findPrefix(): string
	{
		$patternLength = strlen($this->pattern);
		$prefix = '';

		for ($i = 1; $i < $patternLength / 2; $i++)
		{
			$finishSymbols = substr($this->pattern, 0 - $i);
			$startSymbols = substr($this->pattern, 0, $i);
			if ($startSymbols === $finishSymbols)
			{
				$prefix = $startSymbols;
			}
		}

		return $prefix;
	}

	private function findSuffixFor(int $i): int
	{
		$sample = substr($this->pattern, $i - 1);
		$sampleLength = strlen($sample);
		$patternLength = strlen($this->pattern);
		$theSymbolPositionBeforeTheSample = $i - 1;
		$prefixLength = strlen($this->patternPrefix);

		$result = $patternLength - $prefixLength;

		for ($j = $theSymbolPositionBeforeTheSample - $sampleLength; $j >= 0; $j--)
		{
			$hypotheticalSuffix = substr($this->pattern, $j, $sampleLength);

			if ($hypotheticalSuffix === $sample)
			{
				$hypotheticalSuffixPositionFromTheEndOfThePattern = $patternLength - $j;
				$result = $hypotheticalSuffixPositionFromTheEndOfThePattern - $sampleLength;
				break;
			}
		}


		return $result;
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
