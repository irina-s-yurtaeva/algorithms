<?php

namespace Otus\ex13_HashTable;

class HashStorageOpenAddressSquare extends HashStorageOpenAddress
{
	public function getName(): string
	{
		return 'Square open address';
	}

	protected function generateHashKey(int $key, int $index): int
	{
		return ($key + ($index + $index * $index) / 2) % $this->size;
	}
}
