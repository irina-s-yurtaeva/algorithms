<?php

namespace Otus\ex13_HashTable;

class HashTuple
{
	public function __construct(private mixed $key, private mixed $value)
	{
	}

	public function getKey(): mixed
	{
		return $this->key;
	}

	public function getValue(): mixed
	{
		return $this->value;
	}
}