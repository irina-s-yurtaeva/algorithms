<?php

namespace Otus\ex18_Vertex;

class Vertex implements Visitable
{
	protected mixed $id;

	protected ?int $weight;
	/** @var Edge[] */
	protected array $outgoing = [];

	/** @var Edge[] */
	protected array $incoming = [];

	protected array $extraProps = [];


	public function __construct(mixed $id, ?int $weight = null)
	{
		$this->id = $id;
		$this->weight = null;
	}

	public function getId(): mixed
	{
		return $this->id;
	}

	public function addIncomingEdge(Edge $edge)
	{
		$this->incoming[] = $edge;
	}

	public function addOutgoingEdge(Edge $edge)
	{
		$this->outgoing[] = $edge;
	}

	/**
	 * @return Edge[]
	 */
	public function getOutgoingEdges(): array
	{
		return $this->outgoing;
	}

	/**
	 * @return Edge[]
	 */
	public function getIncomingEdges(): array
	{
		return $this->incoming;
	}

	public function accept(Visitor $visitor): void
	{
		$visitor->visit($this);
	}

	public function __toString()
	{
		return 'Vertex: ' . $this->getId();
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
