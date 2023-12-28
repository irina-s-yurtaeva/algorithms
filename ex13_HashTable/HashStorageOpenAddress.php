<?php

namespace Otus\ex13_HashTable;

abstract class HashStorageOpenAddress extends HashStorage
{

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
			$this->countOfElements++;
			break;
		}

		return $this;
	}

	public function hashKey($key): ?int
	{
		$i = 0;
		$hashKey = null;
		do
		{
			$tmpHashKey = $this->generateHashKey($key, $i++);
			if (array_key_exists($tmpHashKey, $this->storage)
				&& (
					$this->storage[$tmpHashKey] === null
					|| $this->storage[$tmpHashKey] instanceof HashTuple
						&& $this->storage[$tmpHashKey]->isActive() !== true
				)
			)
			{
				$hashKey = $tmpHashKey;
				break;
			}

			$this->collisions++;
		} while ($i < $this->size);

		return $hashKey;
	}

	protected function rehash(): void
	{
		$this->size *= 2;
		$oldStorage = $this->storage;
		$this->storage = array_fill(0, $this->size, null);
		$this->collisions = 0;
		$this->countOfElements = 0;
		while ($tuple = array_shift($oldStorage))
		{
			$this->add($tuple->getKey(), $tuple->getValue());
		}
	}

	abstract protected function generateHashKey(string $key, int $index): int;

	public function searchKey(int $key): ?int
	{
		$i = 0;
		$hashKey = null;
		do
		{
			$tmpHashKey = $this->generateHashKey($key, $i++);
			if (array_key_exists($tmpHashKey, $this->storage)
				&& $this->storage[$tmpHashKey] instanceof HashTuple)
			{
				if ($this->storage[$tmpHashKey]->isActive()
					&& $this->storage[$tmpHashKey]->getKey() === $key
				)
				{
					$hashKey = $tmpHashKey;
					break;
				}
			}

			break;
		} while ($i < $this->size);

		return $hashKey;
	}

	public function delete($key): static
	{
		if (($hashedKey = $this->searchKey($key))
			&& isset($this->storage[$hashedKey])
			&& $this->storage[$hashedKey] instanceof HashTuple
		)
		{
			$this->storage[$hashedKey]->inactivate();
		}

		return $this;
	}

	public function get($key): mixed
	{
		if (($hashedKey = $this->searchKey($key))
			&& isset($this->storage[$hashedKey])
			&& $this->storage[$hashedKey] instanceof HashTuple
		)
		{
			return $this->storage[$hashedKey]->getValue();
		}

		return null;
	}

}
