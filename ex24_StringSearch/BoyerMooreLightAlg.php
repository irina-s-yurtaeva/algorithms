<?php

namespace Otus\ex24_StringSearch;

use Otus\Alg;
use Otus\Result;

class BoyerMooreLightAlg extends ScanAlg
{
	public function getName(): string
	{
		return 'Boyer Moore Horspool scan';
	}

	protected function makeOffsetTable(): array
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

	public function apply(): Result
	{
		$result = parent::apply();

		$offsetTable = $this->makeOffsetTable();
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
				$lastLetter = $this->text[ $t + $patternLength - 1 ];
				$stepOffset = null;

				foreach ($offsetTable as $letter => $offset)
				{
					$this->iterate();
					if ($lastLetter === $letter)
					{
						$stepOffset = $offset;
						break;
					}
				}
				if ($stepOffset === null)
				{
					$stepOffset = $patternLength - 1;
				}
				$t += $stepOffset;
			}
		}

		$result->setData([$found === true ? $t : null]);
		$result->finalize();

		return $result;
	}
}
