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

		$inverseOrderSearcher = new VisitorDFSearcher(false);
		$firstDFS = [];
		foreach ($this->getGraph()->getVertices() as $v)
		{
			$firstDFS = array_merge($firstDFS, $inverseOrderSearcher->calc($v));
		}
		$firstDFS = array_reverse($firstDFS);

		$forwardOrderSearcher = new VisitorDFSearcher();
		$stronglyConnectedSubGraphs = [];
		foreach ($firstDFS as $v)
		{
			$subGraph = $forwardOrderSearcher->calc($v);
			if (!empty($subGraph))
			{
				$stronglyConnectedSubGraphs[] = $subGraph;
			}
		}
		$result->setData($stronglyConnectedSubGraphs);

		return $result;
	}

}