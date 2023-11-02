<?php

namespace Otus\ex18_Vertex;

use Otus\Timer;

class Graph
{
	protected $vertecies = [];
	protected $edges = [];

	public function addVertex(Vertex $v): static
	{
		$this[$v->getId()] = $v;

		return $this;
	}

	public function hasVertex(mixed $id): bool
	{
		return isset($this->vertecies[$id]);
	}

	public function getVertex(mixed $id): ?Vertex
	{
		return isset($this->vertecies[$id]) ? $this->vertecies[$id] : null;
	}

	public function addEdge(): bool
	{

	}



	public static function initFromEdgeData(array $data)
	{
		$graph = new static();
		foreach ($data as $edgeData)
		{
			foreach ($edgeData as $key => $vId)
			{
				if (!($v = $graph->getVertex($vId)))
				{
					$v = new Vertex($vId);
					$graph->addVertex($v);
				}
				$edgeData[$key] = $v;
			}
			$graph->addEdge(new Edge($edgeData[0], $edgeData[1]));
		}
	}

}
