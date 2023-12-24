<?php

namespace Otus\ex13_HashTable;

use mysql_xdevapi\Statement;

class HashChain
{
	private ?HashChain $prev = null;
	private ?HashChain $next = null;

	private mixed $key;
	private mixed $value;

	public function __construct(mixed $key, mixed $value)
	{
		$this->key = $key;
		$this->value = $value;
	}

	public function setNext(?HashChain $hashChain): static
	{
		$this->next = $hashChain;

		return $this;
	}

	public function setPrev(?HashChain $hashChain): static
	{
		$this->prev = $hashChain;

		return $this;
	}

	public function getNext(): ?static
	{
		return $this->next;
	}

	public function getPrev(): ?static
	{
		return $this->prev;
	}

	public function getKey(): mixed
	{
		return $this->key;
	}
}