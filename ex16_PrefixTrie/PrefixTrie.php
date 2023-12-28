<?php

namespace Otus\ex16_PrefixTrie;

class PrefixTrie
{
	protected int $countOfElements = 0;
	protected array $collisions = [];
	protected PrefixTrieNode $root;

	public function __construct()
	{
		$this->root = new PrefixTrieNode('');
	}

	function getName(): string
	{
		return 'Prefix trie';
	}

	function add($key, $value): static
	{
		if (!empty($key))
		{
			$node = $this->root;
			$word = str_split($key);
			while ($letter = array_shift($word))
			{
				foreach ($node->getChildren() as $child)
				{
					if ($child->getKey() === $letter)
					{
						$node = $child;
						continue 2;
					}
				}
				$child = new PrefixTrieNode($letter);
				$node->addChild($child);
				$this->countOfElements++;

				$node = $child;
			}

			if (($rs = $node->getValue()) && is_array($rs))
			{
				$this->collisions[] = $value . ' for ' . $node->getWord() . ' and ' . reset($rs);
			}
			$node->setValue($value);
		}

		return $this;
	}

	public function get($key): mixed
	{
		return $this->getNode($key)?->getValue();
	}

	protected function getNode(string $key): ?PrefixTrieNode
	{
		$result = null;

		if (!empty($key))
		{
			$node = $this->root;
			$word = str_split($key);

			while ($letter = array_shift($word))
			{
				foreach ($node->getChildren() as $child)
				{
					if ($child->getKey() === $letter)
					{
						$result = $node = $child;

						continue 2;
					}
				}

				$result = null;
				break;
			}
		}

		return $result;
	}

	public function delete(string $key): static
	{
		if ($node = $this->getNode($key))
		{
			if ($node->hasChildren())
			{
				$node->unsetValue();
			}
			else
			{
				$node->getParent()->removeChild($node);
			}
		}

		return $this;
	}


	public function getStatistic(): string
	{
		return implode(' ', [
			'nodes:', $this->countOfElements,
			'collisions:', count($this->collisions),
			'rootNodes:', count($this->root->getChildren())
		]);
	}
}
