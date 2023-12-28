<?php

namespace Otus\ex13_HashTable;

class HashStorageOpenAddressSquare extends HashStorageOpenAddress
{
	public function getName(): string
	{
		return 'Square open address';
	}

	protected function generateHashKey(string $key, int $index): int
	{
		$intKey = preg_match("/\D+/", $key) === false ? intval($key) : $this->convertKeyIntoInt($key);

		return ($intKey + ($index + $index * $index) / 2) % $this->size;
	}
}
