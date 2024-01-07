<?php

namespace Otus\ex09_BillionNumbersSort;

class ListSortElement
{
	protected int $value;
	protected ?ListSortElement $next = null;

	public function __construct(int $value, ?ListSortElement $next = null)
	{
		$this->value = $value;
		$this->next = $next;
	}

	public function setNext(?ListSortElement $next = null): static
	{
		$this->next = $next;

		return $this;
	}

	public function getValue(): int
	{
		return $this->value;
	}

	public function setValue(int $value): static
	{
		$this->value = $value;

		return $this;
	}

	public function getNext(): ?ListSortElement
	{
		return $this->next;
	}
}
