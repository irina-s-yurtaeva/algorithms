<?php

namespace Otus\ex10_AVL;

class TreeBinary extends Tree
{
	public const CODE = 'Binary';

	protected function makeABinaryTree(): ?Node
	{
		if (empty($this->array))
		{
			return null;
		}

		$this->root = new Node(reset($this->array));
		while (($value = next($this->array)) !== false)
		{
			$this->checkTime();
			$this->root->append(new Node($value));
		}

		return $this->root;
	}

	public function insert(int $value): Node
	{
		return $this->root->append(new Node($value));
	}
}
