<?php

namespace Otus\ex24_StringSearch;

use Otus\Result;

class FiniteAutomataWithPrefixAlg extends AbstractScanAlg
{
	protected array $alphabet;
	protected array $offsetSlowTable;

	public function getName(): string
	{
		return 'Finite automata with slow prefix function';
	}

	protected function getPrefixSlow()
	{
		if (!isset($this->offsetSlowTable))
		{
			$pi = [];
			for ($q = 0; $q <= strlen($this->pattern); $q++)
			{
				$line = $this->getPrefix($q);
				for ($i = 0; $i < $q; $i++)
				{
					$prefix = $this->getPrefix($i);
					$suffix = $this->getSuffix($line, $i);
					if ($prefix === $suffix)
					{
						$pi[$q] = $i;
					}
				}
			}

			$this->offsetSlowTable = $pi;
		}

		return $this->offsetSlowTable;
	}

	protected function getPrefix(int $length): string
	{
		return substr($this->pattern, 0, $length);
	}

	protected function getSuffix(string $line, int $length): string
	{
		return substr($line, 0 - $length);
	}

	public function apply(): Result
	{
		$result = parent::apply();
		$textLength = strlen($this->text);
		$patternLength = strlen($this->pattern);
		$offsetSlowTable = $this->getPrefixSlow();
		$this->iterations = 0;
		$q = 0;
		$foundIndex = null;
		for ($i = 0; $i < $textLength; $i++)
		{
			$textPart = substr($this->pattern, 0, $q) . $this->text[$i];
			$patternPart = substr($this->pattern, 0, $q + 1);

			$this->iterate();
			if ($textPart === $patternPart)
			{
				$q++;
			}
			else
			{
				do {
					$q = (int)($offsetSlowTable[$q - 1] ?? 0);
					$textPart = substr($this->pattern, 0, $q) . $this->text[$i];
					$patternPart = substr($this->pattern, 0, $q + 1);
					$this->iterate();
				} while ($q > 0 && $textPart !== $patternPart);
			}

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
