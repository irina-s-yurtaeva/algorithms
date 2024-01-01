<?php

namespace Otus\ex24_StringSearch;

use Otus\Alg;
use Otus\Result;

class FullScanAlg extends ScanAlg
{
	public function getName(): string
	{
		return 'Brute-force scan';
	}

	public function apply(): Result
	{
		$result = parent::apply();

		$t = 0;
		$searchDiapason = strlen($this->text) - strlen($this->pattern);

		$found = false;
		while ($t <= $searchDiapason)
		{
			$m = 0;
			$found = true;
			while ($m < strlen($this->pattern))
			{
				$this->iterate();
				if ($this->text[ $t + $m ] !== $this->pattern[ $m ])
				{
					$found = false;
					break;
				}
				$m++;
			}

			if ($found === true)
			{
				break;
			}

			$t++;
		}

		$result->setData([$found === true ? $t : null]);
		$result->finalize();

		return $result;
	}
}
