<?php

namespace Otus\ex10_AVL;

class NodeBinary extends Node
{
	public function append(Node $newNode): ?static
	{
		$newNode = $this->calibrateNode($newNode);

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
				$this->getLeft()->append($newNode);
			}
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
				$this->getRight()->append($newNode);
			}
		}

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
}
