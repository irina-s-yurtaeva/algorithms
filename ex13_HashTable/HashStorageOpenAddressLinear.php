<?php

namespace Otus\ex13_HashTable;

class HashStorageOpenAddressLinear extends HashStorageOpenAddress
{
	public function getName(): string
	{
		return 'Linear open address';
	}

	protected function generateHashKey(int $key, int $index): int
	{
		return ($key + $index) % $this->size;
	}
}
