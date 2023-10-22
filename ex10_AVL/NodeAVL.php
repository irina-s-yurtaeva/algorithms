<?php

namespace Otus\ex10_AVL;

class NodeAVL extends NodeBinary
{
	protected int $height;
	function __construct($value) {
	    parent::__construct($value);
		echo 'new node: ', $value."\n";
	}
	function calibrateNode(Node $node): ?static
	{
		if ($node instanceof NodeAVL)
		{
			return $node;
		}

		return null;
	}

	public function getHeight(): int
	{
		return $this->height;
	}

	protected function calcHeight(): static
	{
		$leftHeight = $this->getLeft()?->getHeight() ?? 0;
		$rightHeight = $this->getRight()?->getHeight() ?? 0;
		$newHeight = max($leftHeight, $rightHeight) + 1;
		if (!isset($this->height) || $this->height !== $newHeight)
		{
			$this->height = $newHeight;

			$this->getParent()?->calcHeight();
		}
		echo 'height with value '.$this->getValue().': ', $this->height."\n";
		return $this;
	}

	protected function balance(): void
	{
		$parent = $this->getParent();
		echo 'balance for value '.$this->getValue().' left: '.$this->getLeft()?->getHeight().' and right: '
			.$this->getRight()?->getHeight()."\n";
		if (!($parent instanceof Node))
		{
			return;
		}
		$leftHeight = $parent->getLeft() instanceof Node ? $parent->getLeft()->getHeight() : 0;
		$rightHeight = $parent->getRight() instanceof Node ? $parent->getRight()->getHeight() : 0;
		if ($leftHeight == $rightHeight)
		{
			echo 'for value '.$this->getValue().' left is equal right' . PHP_EOL;
			return;
		}
		if (abs($leftHeight - $rightHeight) > 1)
		{
			if ($parent->getLeft() === $this)
			{
				if ($this->getLeft()?->getHeight() >= $this->getRight()?->getHeight())
				{
					$this->rotateLeftLeft();
				}
				else
				{
					$this->rotateRightLeft();
				}
			}
			else
			{
				if ($this->getLeft()?->getHeight() < $this->getRight()?->getHeight())
				{
					$parent->rotateRightRight();
				}
				else
				{
					$parent->rotateLeftRight();
				}
			}
		}

		$parent->balance();
	}

	public function append(Node $newNode): static
	{
		$newNode = parent::append($newNode);
		$newNode->calcHeight();
		$newNode->balance();

		return $newNode;
	}

	public function remove(): ?static
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

	public function rotateLeftLeft()
	{
		$usedToBeParent = $this->getParent();
		$grand = $usedToBeParent->getParent();
		$leftParent = $grand && $grand->getLeft() === $usedToBeParent;

		$usedToBeParent->setLeft($this->getRight());
		$usedToBeParent->setParent($this);
		$this->setRight($usedToBeParent);
		$this->setParent($grand);
		if ($grand)
		{
			if ($leftParent)
			{
				$grand->setLeft($this);
			}
			else
			{
				$grand->setRight($this);
			}
		}
	}

	public function rotateRightLeft()
	{
		$this->getRight()->rotateRightRight();
		$this->rotateLeftLeft();
	}

	public function rotateRightRight()
	{
		$usedToBeParent = $this->getParent();
		$grand = $usedToBeParent->getParent();
		$leftParent = $grand && $grand->getLeft() === $usedToBeParent;

		$usedToBeParent->setRight($this->getLeft());
		$usedToBeParent->setParent($this);
		$this->setLeft($usedToBeParent);
		$this->setParent($grand);
		if ($grand)
		{
			if ($leftParent)
			{
				$grand->setLeft($this);
			}
			else
			{
				$grand->setRight($this);
			}
		}
	}

	public function rotateLeftRight()
	{

		$this->getLeft()->rotateLeftLeft();
		$this->rotateRightRight();
	}
}
