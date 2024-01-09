<?php

namespace Otus\ex10_AVL;

abstract class Node
{
	protected int $value;
	protected ?Node $Left = null;
	protected ?Node $Right = null;
	protected ?Node $Parent = null;
	private int $duplicatesCount = 0;

	public function __construct(int $value)
	{
		$this->value = $value;
	}

	function calibrateNode(Node $node): ?static
	{
		if ($node instanceof Node)
		{
			return $node;
		}

		return null;
	}

	public function getValue(): int
	{
		return $this->value;
	}

	public function getParent(): ?static
	{
		return $this->Parent;
	}

	public function setParent(?Node $node): static
	{
		$this->Parent = $node;

		return $this;
	}

	public function getLeft(): ?static
	{
		return $this->Left;
	}

	public function setLeft(?Node $node): static
	{
		$this->Left = $node;

		return $this;
	}

	public function getRight(): ?static
	{
		return $this->Right;
	}

	public function setRight(?Node $node): static
	{
		$this->Right = $node;

		return $this;
	}

	public function detectDuplicate(): void
	{
		$this->duplicatesCount++;
	}

	abstract public function append(Node $newNode): ?static;

	public function onAppended(): static
	{
		return $this;
	}

	abstract public function remove(): ?static;

	public function accept(Visitor $visitor): void
	{
		$visitor->visit($this);
	}
}
