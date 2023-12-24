<?php

namespace Otus\ex13_HashTable;

abstract class HashStorage
{
	abstract function getName(): string;

	abstract function add($key, $value): static;

	abstract function delete($key): static;

	abstract function hashKey(int $key): ?int;

	function getStatistic(): string
	{
		return '';
	}
}
