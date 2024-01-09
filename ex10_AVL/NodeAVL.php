<?php

namespace Otus\ex10_AVL;

class NodeAVL extends NodeBinary
{
	protected int $height;

	public function calibrateNode(Node $node): ?static
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
		$leftHeight = $this->getLeft()?->getHeight();
		$rightHeight = $this->getRight()?->getHeight();

		$newHeight = max($leftHeight, $rightHeight) + 1;
		if (!isset($this->height) || $this->height !== $newHeight)
		{
			$this->height = $newHeight;

			$this->getParent()?->calcHeight();
		}

		return $this;
	}

	protected function balance($debug = false): void
	{
		$parent = $this->getParent();

		if (!($parent instanceof Node))
		{
			return;
		}

		$leftHeight = $this->getLeft()?->getHeight() ?? 0;
		$rightHeight = $this->getRight()?->getHeight() ?? 0;

		$abs = abs($leftHeight - $rightHeight);
		if ($abs <= 1)
		{
//			if ($leftHeight == $rightHeight)
//				echo 'node: ' . $this->getValue().' left is equal to right' . PHP_EOL;
//			else
//				echo 'node: ' . $this->getValue().' balancing is no needed: ' . $abs . PHP_EOL;
		}
		else if ($leftHeight > $rightHeight)
		{
			// правое вращение
			$workingNode = $this->getLeft();

			//Малое правое вращение
			if ($workingNode->getLeft()?->getHeight() >= $workingNode->getRight()?->getHeight())
			{
				$parent = $workingNode->rotateRight();
			}
			else
			{
				//Большое правое вращение
				$parent = $workingNode->getRight()->rotateLeft()->rotateRight();
			}
		}
		else
		{
			//левое вращение
			$workingNode = $this->getRight();

			//Малое левое вращение
			if ($workingNode->getLeft()?->getHeight() <= $workingNode->getRight()?->getHeight())
			{
				$parent = $workingNode->rotateLeft();
			}
			else
			{
				//Большое левое вращение
				$parent = $workingNode->getLeft()->rotateRight()->rotateLeft();
			}
		}

		$parent->balance();
	}

	public function onAppended(): static
	{
		$this->calcHeight();
		if (in_array($this->value, [16, 6]))
		{
			xdebug_break();
		}
		$this->balance(true);

		return $this;
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

	public function rotateRight(): static
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
		$usedToBeParent->calcHeight();

		return $this;
	}

	public function rotateLeft(): static
	{
		$usedToBeParent = $this->getParent(); //4
		$grand = $usedToBeParent->getParent(); //7
		$leftParent = $grand?->getLeft() === $usedToBeParent;

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
		$usedToBeParent->calcHeight();

		return $this;
	}
}
