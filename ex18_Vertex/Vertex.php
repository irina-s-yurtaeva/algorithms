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


	public function __construct(mixed $id, ?int $weight = null)
	{
		$this->id = $id;
		$this->weight = null;
	}

	public function getId(): mixed
	{
		return $this->id;
	}

	public function putIncomingEdge(Edge $edge)
	{
		$this->incoming[] = $edge;
	}

	public function putOutgoingEdge(Edge $edge)
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
}
