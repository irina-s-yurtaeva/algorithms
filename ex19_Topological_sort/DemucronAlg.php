<?php

namespace Otus\ex19_Topological_sort;

use Otus\Alg;
use Otus\ex18_Vertex\Graph;
use Otus\Result;

class DemucronAlg extends Alg
{
	protected Graph $graph;

	public function __construct(Graph $graph)
	{
		$this->graph = $graph;
	}

	public function getName(): string
	{
		return 'Demucron`s topological sort';
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
		$adjMatrix = $this->getGraph()->getPathMatrix();
		$adjSumMatrix = array_fill_keys(array_keys($adjMatrix), null);
		foreach ($adjSumMatrix as $vertexId => $adjVertecies)
		{
			$adjSumMatrix[$vertexId] = array_sum(array_column($adjMatrix, $vertexId));
		}
		$resultData = [];
		while (count($adjSumMatrix) > 0)
		{
			$vs = array_filter($adjSumMatrix, fn($v) => $v === 0);
			if (empty($vs))
			{
				break;
			}
			$resultData[] = array_keys($vs);
			$adjSumMatrix = array_diff_key($adjSumMatrix, $vs);
			foreach ($adjSumMatrix as $v => &$sum)
			{
				foreach ($vs as $deletedV => $someV)
				{
					$sum -= $adjMatrix[$deletedV][$v];
				}
			}
		}
		$result->setData($resultData);
		$result->finalize();
		return $result;
	}

	public function getStats(): string
	{
		return '';
	}
}