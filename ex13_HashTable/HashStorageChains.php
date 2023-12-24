<?php

namespace Otus\ex13_HashTable;

class HashStorageChains extends HashStorage
{
	private int $size = 10;
	/*@var HashChain[] $storage */
	private array $storage = [];

	public function getName(): string
	{
		return 'Chains storage';
	}

	public function add($key, $value): static
	{
		$hashedKey = $this->hashKey($key);
		$chain = new HashChain($key, $value);
		if (isset($this->storage[$hashedKey]))
		{
			$lastOne = $this->storage[$hashedKey];
			while ($next = $lastOne->getNext())
			{
				$lastOne = $next;
			}
			$lastOne->setNext($chain);
		}
		else
		{
			$this->storage[$hashedKey] = $chain;
		}

		return $this;
	}

	public function hashKey(int $key): int
	{
		return $key % $this->size;
	}

	public function delete($key): static
	{
		$hashedKey = $this->hashKey($key);

		if (isset($this->storage[$hashedKey]))
		{
			$linkChain = $this->storage[$hashedKey];
			$prev = null;
			while ($linkChain && $linkChain->getKey() !== $key)
			{
				$prev = $linkChain;
				$linkChain = $linkChain->getNext();
			}

			if ($linkChain)
			{
				$next = $linkChain->getNext();
				if ($prev instanceof HashChain)
				{
					$prev->setNext($next);
				}
				else
				{
					$this->storage[$hashedKey] = $next;
				}
			}
		}

		return $this;
	}
}