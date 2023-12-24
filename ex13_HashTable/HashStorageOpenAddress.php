<?php

namespace Otus\ex13_HashTable;

abstract class HashStorageOpenAddress extends HashStorage
{
	protected int $size = 10;
	/*@var HashTuple[] $storage */
	protected array $storage = [];

	public function __construct()
	{
		$this->storage = array_fill(0, $this->size, null);
	}

	public function getName(): string
	{
		return 'Open address';
	}

	public function add($key, $value): static
	{
		while(true)
		{
			$hashedKey = $this->hashKey($key);
			if ($hashedKey === null)
			{
				$this->rehash();
				continue;
			}

			$this->storage[$hashedKey] = new HashTuple($key, $value);
			break;
		}

		return $this;
	}


	protected function rehash(): void
	{
		$this->size *= 2;
		$oldStorage = $this->storage;
		$this->storage = array_fill(0, $this->size, null);
		while ($tuple = array_shift($oldStorage))
		{
			$this->add($tuple->getKey(), $tuple->getValue());
		}
	}

	abstract protected function generateHashKey(int $key, int $index): int;
}
