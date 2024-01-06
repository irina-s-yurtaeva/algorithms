<?php

namespace Otus\ex09_BillionNumbersSort;

use Otus\ex07_ExternalSort\TestFile;
use Otus\Result;

class BucketSortAlg extends SortAlg
{
	public function getName(): string
	{
		return 'Bucket sort';
	}

	public function apply(): Result
	{
		$result = parent::apply();

		$result->finalize();

		return $result;
	}
}
