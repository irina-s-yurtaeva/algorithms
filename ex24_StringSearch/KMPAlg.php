<?php

namespace Otus\ex24_StringSearch;

use Otus\Result;

class KMPAlg extends FiniteAutomataWithFastPrefixAlg
{
	public function getName(): string
	{
		return 'Knuth Morris Pratt scan 1977';
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
		$text = $this->text;
		for ($i = 0; $i < $textLength; $i++)
		{
			$this->iterate();
			while ($q > 0 && $text[$i] !== $this->pattern[$q])
			{
				$q = ($offsetFastTable[$q - 1] ?? 0);
				$this->iterate();
			};

			if ($text[$i] === $this->pattern[$q])
			{
				$q++;
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
