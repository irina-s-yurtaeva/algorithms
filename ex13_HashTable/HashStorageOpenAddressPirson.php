<?php

namespace Otus\ex13_HashTable;

class HashStorageOpenAddressPirson extends HashStorageOpenAddress
{
	public function getName(): string
	{
		return 'Pirson open address';
	}

	protected function generateHashKey(string $key, int $index): int
	{
		$result = $index;
		$tokens = str_split($key);

		while ($token = array_shift($tokens))
		{
			$result = ($result ^ ord($token));
		}

		return $result % $this->size;
	}
}
