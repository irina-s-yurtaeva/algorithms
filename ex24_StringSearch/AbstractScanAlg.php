<?php

namespace Otus\ex24_StringSearch;

use Otus\Alg;
use Otus\Result;

abstract class AbstractScanAlg extends Alg
{
	public function __construct(protected string $text, protected string $pattern)
	{
	}
}
