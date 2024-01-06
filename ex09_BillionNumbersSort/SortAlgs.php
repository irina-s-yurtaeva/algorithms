<?php

namespace Otus\ex09_BillionNumbersSort;

use Otus\ex07_ExternalSort\TestFile;
use Otus;

abstract class SortAlg extends Otus\Alg
{
	public function __construct(protected TestFile $file)
	{
	}
}
