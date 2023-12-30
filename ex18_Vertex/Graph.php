<?php

namespace Otus\ex18_Vertex;

use Otus\Timer;

class Graph
{
	protected array $vertecies = [];
	protected array $edges = [];
	protected array $extraProps = [];


	public function addVertex(Vertex $v): static
	{
		$this->vertecies[$v->getId()] = $v;

		return $this;
	}

	public function hasVertex(int|string|Vertex $id): bool
	{
		if ($id instanceof Vertex)
		{
			$id = $id->getId();
		}
		return isset($this->vertecies[$id]);
	}

	public function getVertex(int|string|Vertex $id): ?Vertex
	{
		if ($id instanceof Vertex)
		{
			$id = $id->getId();
		}
		return $this->vertecies[$id] ?? null;
	}

	public function getVertices(): array
	{
		return $this->vertecies;
	}

	public function addEdge(Edge $edge): static
	{
		$this->edges[] = $edge;

		return $this;
	}

	public function getEdges(): array
	{
		return $this->edges;
	}

	public function getPathMatrix(): array
	{
		$vertices = $this->getVertices();
		uasort($vertices, fn($v1, $v2) => $v1->getId() > $v2->getId() ? 1: 0);
		$matrix = [];
		$row = [];
		/* @var Vertex $vertex */
		foreach ($vertices as $vertex)
		{
			$row[$vertex->getId()] = null;
		}

		foreach ($vertices as $vertex)
		{
			$matrix[$vertex->getId()] = $row;
			$matrix[$vertex->getId()][$vertex->getId()] = 0;
			foreach ($vertex->getOutgoingEdges() as $edge)
			{
				$matrix[$vertex->getId()][$edge->getHead()->getId()] = $edge->getWeight();
			}
		}

		return $matrix;
	}

	public static function initFromEdgeData(array $data): static
	{
		$graph = new static();
		foreach ($data as $edgeData)
		{
			[$tail, $head, $weight] = $edgeData;
			$vs = [];
			foreach ([$tail, $head] as $vId)
			{
				if (($v = $graph->getVertex($vId)) === null)
				{
					$v = new Vertex($vId);
					$graph->addVertex($v);
				}
				$vs[] = $v;
			}
			$graph->addEdge(new Edge($vs[0], $vs[1], $weight));
		}

		return $graph;
	}


	public function __set(string $name, $value): void
	{
		$this->extraProps[$name] = $value;
	}

	public function __get(string $name): mixed
	{
		return $this->extraProps[$name];
	}

	public function __clone()
	{
		$vertecies = $this->vertecies;
		$this->vertecies = [];
		foreach ($vertecies as $id => $v)
		{
			$this->vertecies[$id] = new Vertex($id);
		}
		$edges = $this->edges;
		$this->edges = [];
		foreach ($edges as $edge)
		{
			$tail = $this->vertecies[$edge->getTail()->getId()];
			$head = $this->vertecies[$edge->getHead()->getId()];
			$this->addEdge(new Edge($tail, $head, $edge->getWeight()));
		}
	}
}
