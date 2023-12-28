<?php

namespace Otus\ex13_HashTable;

class HashStorageOpenAddressLinear extends HashStorageOpenAddress
{
	public function getName(): string
	{
		return 'Linear open address';
	}

	protected function generateHashKey(string $key, int $index): int
	{
		$intKey = !preg_match("/\D+/", $key) ? intval($key) : $this->convertKeyIntoInt($key);

		return ($intKey + $index) % $this->size;
	}
}
