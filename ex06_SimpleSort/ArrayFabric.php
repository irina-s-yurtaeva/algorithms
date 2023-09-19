<?php

namespace Otus\ex06_SimpleSort;

class ArrayFabric
{
	public static function createShuffle(int $size): array
	{
		$res = range(0, $size - 1);
		shuffle($res);
		return $res;
	}
}