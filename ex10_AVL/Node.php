<?php

namespace Otus\ex10_AVL;

class Node
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

	public function getValue(): int
	{
		return $this->value;
	}

	public function getParent(): ?Node
	{
		return $this->Parent;
	}

	public function setParent(?Node $node): Node
	{
		$this->Parent = $node;

		return $this;
	}

	public function getLeft(): ?Node
	{
		return $this->Left;
	}

	public function setLeft(?Node $node): Node
	{
		$this->Left = $node;

		return $this;
	}

	public function getRight(): ?Node
	{
		return $this->Right;
	}

	public function setRight(?Node $node): Node
	{
		$this->Right = $node;

		return $this;
	}

	public function detectDuplicate(): void
	{
		$this->duplicatesCount++;
	}

	public function append(Node $newNode): Node
	{
		if ($this->getValue() === $newNode->getValue())
		{
			$newNode->Parent = $this->Parent;
			$this->detectDuplicate();

			return $this;
		}

		if ($this->getValue() > $newNode->getValue())
		{
			if ($this->Left === null)
			{
				$newNode->Parent = $this;
				$this->Left = $newNode;
			}
			else
			{
				$this->Left->append($newNode);
			}
		}
		else
		{
			if ($this->Right === null)
			{
				$newNode->Parent = $this;
				$this->Right = $newNode;
			}
			else
			{
				$this->Right->append($newNode);
			}
		}

		return $newNode;
	}

	public function remove(): ?Node
	{
		$parent = $this->getParent();

		$result = null;

		if ($this->getParent() !== null)
		{
			if ($this->getParent()->getLeft() === $this)
			{
				$this->getParent()->setLeft(null);
			}
			else
			{
				$this->getParent()->setRight(null);
			}

			if ($this->getLeft() !== null)
			{
				$parent->append($this->getLeft());
				$result = $this->getLeft();
			}

			if ($this->getRight())
			{
				$parent->append($this->getRight());
				$result = $this->getRight();
			}

			$this->Parent = null;
		}
		else
		{
			if ($this->getLeft() !== null)
			{
				$result = $this->getLeft();
				if ($this->getRight())
				{
					$result->append($this->getRight());
				}
			}
			else
			{
				$result = $this->getRight();
			}
		}
		
		return $result;
	}

	public function accept(Visitor $visitor): void
	{
		$visitor->visit($this);
	}
}
