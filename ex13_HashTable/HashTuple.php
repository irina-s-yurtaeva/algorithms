<?php

namespace Otus\ex13_HashTable;

class HashTuple
{
	private bool $active = true;

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

	public function inactivate(): static
	{
		$this->active = false;

		return $this;
	}

	public function isActive(): bool
	{
		return $this->active;
	}
}