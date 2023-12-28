<?php

namespace Otus\ex13_HashTable;

class HashStorageChains extends HashStorage
{
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
		$this->countOfElements++;
		if (isset($this->storage[$hashedKey]))
		{
			$lastOne = $this->storage[$hashedKey];
			while ($next = $lastOne->getNext())
			{
				$lastOne = $next;
			}
			$this->collisions++;

			$lastOne->setNext($chain);
		}
		else
		{
			$this->storage[$hashedKey] = $chain;
		}

		return $this;
	}

	function get($key): mixed
	{
		$hashedKey = $this->hashKey($key);

		if (isset($this->storage[$hashedKey]))
		{
			$linkChain = $this->storage[$hashedKey];
			while ($linkChain && $linkChain->getKey() !== $key)
			{
				$linkChain = $linkChain->getNext();
			}

			if ($linkChain)
			{
				return $linkChain->getValue();
			}
		}

		return null;
	}

	public function hashKey(string $key): int
	{
		$intKey = preg_match("/\D+/", $key) === false ? intval($key) : $this->convertKeyIntoInt($key);

		return $intKey % $this->size;
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