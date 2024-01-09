<?php

namespace Otus\ex10_AVL;

class NodeSplay extends NodeBinary
{
	protected int $size;

	public function getSize(): ?int
	{
		return $this->size ?? null;
	}

	public function calcSize(): static
	{
		$this->size = $this->getLeft()?->getSize() + $this->getRight()?->getSize() + 1;

		return $this;
	}

	public function calibrateNode(Node $node): ?static
	{
		if ($node instanceof NodeSplay)
		{
			return $node;
		}

		return null;
	}

	public function rotateRight(): static
	{
		if (!($q = $this->getLeft()))
		{
			return $this;
		}
		$this->setLeft($q->getRight());
		$q->setRight($this);

		$this->calcSize();
		$q->calcSize();

		return $q;
	}

	public function rotateLeft(): static
	{
		if (!($p = $this->getRight()))
		{
			return $this;
		}

		$this->setRight($p->getLeft());
		$p->setLeft($this);

		$this->calcSize();
		$p->calcSize();

		return $p;
	}

	protected static function appendIntoRoot(?NodeSplay $node, int $value): ?static
	{
		if (!$node)
		{
			return new static($value);
		}

		if ($value < $node->getValue())
		{
			$node->setLeft(
				self::appendIntoRoot($node->getLeft(), $value)
			);

			return $node->rotateRight();
		}
		else
		{
			$node->setRight(
				self::appendIntoRoot($node->getRight(), $value)
			);

			return $node->rotateLeft();
		}
	}

	public function append(Node $newNode): ?static
	{
		if ($this->getValue() === $newNode->getValue())
		{
			$newNode->setParent($this->getParent());
			$this->detectDuplicate();

			return $this;
		}

		if ($this->getValue() > $newNode->getValue())
		{
			if ($this->getLeft() === null)
			{
				$newNode->setParent($this);
				$this->setLeft($newNode);
			}
			else
			{
				$this->setLeft(
					$this->getLeft()->append($newNode)
				);
			}
			return $this->rotateRight();
		}
		else
		{
			if ($this->getRight() === null)
			{
				$newNode->setParent($this);
				$this->setRight($newNode);
			}
			else
			{
				$this->setRight(
					$this->getRight()->append($newNode)
				);
			}
			return $this->rotateLeft();
		}
	}
}
