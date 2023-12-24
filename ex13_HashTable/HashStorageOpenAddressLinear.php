<?php

namespace Otus\ex13_HashTable;

class HashStorageOpenAddressLinear extends HashStorageOpenAddress
{
	public function getName(): string
	{
		return 'Linear open address';
	}

	public function hashKey(int $key): ?int
	{
		$i = 0;
		$hashKey = null;
		do
		{
			$tmpHashKey = $this->generateHashKey($key, $i++);
			if (array_key_exists($tmpHashKey, $this->storage) && $this->storage[$tmpHashKey] === null)
			{
				$hashKey = $tmpHashKey;
				break;
			}
		} while ($i < $this->size);

		return $hashKey;
	}

	protected function generateHashKey(int $key, int $index): int
	{
		return ($key + $index) % $this->size;
	}
}
