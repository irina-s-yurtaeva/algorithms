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

	public static function createSorted(int $size): array
	{
		return range(0, $size - 1);
	}
}