<?php

namespace Otus\ex16_PrefixTrie;

class PrefixTrieNode
{
	protected string $key;
	protected ?array $value;
	protected array $children = [];
	protected self $parent;

	public function __construct(string $key)
	{
		$this->key = $key;
	}

	public function getChildren(): array
	{
		return $this->children;
	}

	public function hasChildren(): bool
	{
		return !empty($this->children);
	}

	public function addChild(self $node): static
	{
		$this->children[] = $node;
		$node->setParent($this);

		return $this;
	}

	public function removeChild(self $node): static
	{
		$this->children[] = $node;
		$node->unsetParent();

		return $this;
	}

	public function setParent(self $parent): static
	{
		$this->parent = $parent;

		return $this;
	}

	public function unsetParent(): static
	{
		unset($this->parent);

		return $this;
	}

	public function getParent(): ?static
	{
		return $this->parent ?? null;
	}

	public function getKey(): string
	{
		return $this->key;
	}

	public function setValue(string $value): static
	{
		if (!isset($this->value))
		{
			$this->value = [];
		}
		$this->value[] = $value;

		return $this;
	}

	public function unsetValue(): static
	{
		unset($this->value);

		return $this;
	}

	public function getValue(): ?array
	{
		return $this->value ?? null;
	}

	public function getWord(): string
	{
		$output = [];
		$node = $this;
		while ($node instanceof static)
		{
			array_unshift($output, $node->getKey());
			$node = $node->getParent();
		}

		return implode('', $output);
	}
}
