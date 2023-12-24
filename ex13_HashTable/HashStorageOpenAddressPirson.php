<?php

namespace Otus\ex13_HashTable;

class HashStorageOpenAddressPirson extends HashStorageOpenAddress
{
	private const ASCII_TABLE = [48, 49, 50, 51, 52, 53, 54, 55, 56, 57];

	public function getName(): string
	{
		return 'Pirson open address';
	}

	protected function generateHashKey(int $key, int $index): int
	{
		$result = $index;
		$tokens = str_split((string) $key);

		while ($token = array_shift($tokens))
		{
			$result = ($result ^ self::ASCII_TABLE[(int) $token]);
		}

		return $result % $this->size;
	}
}
