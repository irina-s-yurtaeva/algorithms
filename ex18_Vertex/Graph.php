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
}