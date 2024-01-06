<?php

namespace Otus\ex24_StringSearch;

use Otus\Result;

class FiniteAutomataAlg extends AbstractScanAlg
{
	protected array $alphabet;
	protected array $offsetTable;

	public function getName(): string
	{
		return 'Finite Automata scan';
	}

	protected function getAlphabet(): array
	{
		if (!isset($this->alphabet))
		{
			$alphabet = str_split($this->pattern, 1);
			$this->alphabet = array_flip($alphabet);
			$this->iterate(strlen($this->pattern));
		}

		return $this->alphabet;
	}

	protected function getPrefix(int $length): string
	{
		return substr($this->pattern, 0, $length);
	}

	protected function getSuffix(string $line, int $length): string
	{
		return substr($line, 0 - $length);
	}

	protected function makeOffsetTable(): array
	{
		if (!isset($this->offsetTable))
		{
			$length = strlen($this->pattern);
			$alphabet = $this->getAlphabet();
			$result = array_fill(0, $length + 1, $alphabet);
			for ($q = 0; $q <= $length; $q++)
			{
				foreach ($result[$q] as $alphabetLetter => $value)
				{
					$k = $q + 1;
					$this->iterate();
					$line = $this->getPrefix($q) . $alphabetLetter;
					while($k > 0)
					{
						$patternPrefix = $this->getPrefix($k);
						$lineSuffix = $this->getSuffix($line, $k);
						$this->iterate();
						if ($patternPrefix === $lineSuffix)
						{
							break;
						}
						$k--;
					}
					$result[$q][$alphabetLetter] = $k;
				}
			}
			$this->offsetTable = $result;
		}

		return $this->offsetTable;
	}

	public function apply(): Result
	{
		$text = $this->text;
		$result = parent::apply();
		$textLength = strlen($this->text);
		$patternLength = strlen($this->pattern);
		$offsetTable = $this->makeOffsetTable();
		$this->iterations = 0;
		$q = 0;
		$foundIndex = null;
		for ($i = 0; $i < $textLength; $i++)
		{
			$q = (int)($offsetTable[$q][$text[$i]] ?? 0);
			$this->iterate();

			if ($q === $patternLength)
			{
				$foundIndex = $i - $patternLength + 1;
				break;
			}
		}

		$result->setData([$foundIndex]);
		$result->finalize();

		return $result;
	}
}
