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

	public function __construct(Vertex $vertexFrom, Vertex $vertexTo)
	{
		$this->tail = $vertexFrom;
		$this->head = $vertexTo;
	}

	public function getTail(): Vertex
	{
		return $this->tail;
	}

	public function getHead(): Vertex
	{
		return $this->head;
	}

	public function accept(Visitor $visitor): void
	{
		$visitor->visit($this);
	}
}
