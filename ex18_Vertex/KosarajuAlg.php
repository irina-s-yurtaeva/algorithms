<?php

namespace Otus\ex18_Vertex;

use Otus\Result;

class KosarajuAlg
{
	protected Graph $graph;

	public function __construct(Graph $graph)
	{
		$this->graph = $graph;
	}

	/**
	 * @return Graph
	 */
	public function getGraph(): Graph
	{
		return $this->graph;
	}

	public function apply(): Result
	{
		$result = new Result();

		$inverseOrdersearcher = new VisitorInverseDFSearcher();
		foreach ($this->getGraph()->get)
		$vertices = ->visit(->get)


	}

}