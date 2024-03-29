<?php

namespace Otus\ex18_Vertex;

class Edge implements Visitable
{
	protected ?int $weight = null;
	/**
	 * endpoint
	 * One of the two vertices joined by a given edge, or one of
	 * the first or last vertex of a walk, trail or path. The
	 * first endpoint of a given directed edge is called the tail
	 * and the second endpoint is called the head.
	 * @var Vertex
	 */
	protected Vertex $tail;
	protected Vertex $head;
	protected array $extraProps = [];

	public function __construct(Vertex $vertexFrom, Vertex $vertexTo, ?int $weight = null)
	{
		$this->tail = $vertexFrom;
		$vertexFrom->addOutgoingEdge($this);
		$this->head = $vertexTo;
		$vertexTo->addIncomingEdge($this);

		$this->weight = $weight;
	}

	public function getId(): string
	{
		return $this->getTail()->getId() . $this->getHead()->getId();
	}

	public function getSortedId(): string
	{
		$id = [$this->getTail()->getId(), $this->getHead()->getId()];
		sort($id);
		return implode('', $id);
	}

	public function getTail(): Vertex
	{
		return $this->tail;
	}

	public function getHead(): Vertex
	{
		return $this->head;
	}

	public function getWeight(): ?int
	{
		return $this->weight;
	}

	public function setWeight(?int $weight): static
	{
		$this->weight = $weight;

		return $this;
	}

	public function accept(Visitor $visitor): void
	{
		$visitor->visit($this);
	}

	public function __toString()
	{
		return 'Edge [' . $this->getTail()->getId() . '->' . $this->getHead()->getId() . ' weight: ' . $this->weight . ']';
	}


	public function __set(string $name, $value): void
	{
		$this->extraProps[$name] = $value;
	}

	public function __get(string $name): mixed
	{
		return $this->extraProps[$name];
	}

}
