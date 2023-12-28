<?php

namespace Otus\ex13_HashTable;

abstract class HashStorage
{
	protected int $collisions = 0;
	protected int $countOfElements = 0;
	protected int $size = 10;

	abstract function getName(): string;

	abstract function add($key, $value): static;

	abstract function get($key): mixed;

	abstract function delete($key): static;

	abstract function hashKey(string $key): ?int;

	protected function convertKeyIntoInt(string $key): int
	{
		$tokens = str_split($key);
		$result = 0;
		while ($token = array_shift($tokens))
		{
			$power = count($tokens);

			$result += ord($token) * ( 10 ** $power );
		}

		return $result;
	}


	public function getStatistic(): string
	{
		return implode(' ', [
			'count:', $this->countOfElements,
			'collisions:', $this->collisions,
			'size:', $this->size,
		]);
	}
}
