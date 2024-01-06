<?php

namespace Otus\ex24_StringSearch;

use Otus\Result;

class FiniteAutomataWithFastPrefixAlg extends AbstractScanAlg
{
	protected array $offsetFastTable;

	public function getName(): string
	{
		return 'Finite automata with fast prefix function';
	}

	protected function getPrefixFast()
	{
		if (!isset($this->offsetFastTable))
		{
			$pi = [0, 0];
			for ($q = 1; $q <= strlen($this->pattern); $q++)
			{
				$length = $pi[$q];
				while ($length > 0 && $this->pattern[$length] !== $this->pattern[$q])
				{
					$length = $pi[$length];

				}
				if ($this->pattern[$length] === $this->pattern[$length])
				{
					$length++;
				}

				$pi[$q + 1] = $length;
			}

			$this->offsetFastTable = $pi;
		}

		return $this->offsetFastTable;
	}

	public function apply(): Result
	{
		$result = parent::apply();
		$textLength = strlen($this->text);
		$patternLength = strlen($this->pattern);
		$offsetFastTable = $this->getPrefixFast();
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
					$q = (int)($offsetFastTable[$q - 1] ?? 0);
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
