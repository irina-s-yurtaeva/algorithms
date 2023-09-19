<?php

namespace Otus\ex06_SimpleSort;

interface ISortArray
{
	public function sort(): static;

	public function showInfo(): static;

	public function swap(int $indexFrom, int $indexTo): void;
}
