<?php

namespace Otus\ex09_BillionNumbersSort;

use Otus\ex07_ExternalSort\TestFile;
use Otus\Result;

class BucketSortAlg extends SortAlg
{
	public function getName(): string
	{
		return 'Bucket sort';
	}

	public function sort(): void
	{
		$this->file->rewind();
		$maxNumber = 0;
		$bucketsCount = 0;
		while ([$number] = $this->file->getData(1))
		{
			$maxNumber = $maxNumber > $number ? $maxNumber : $number;
			$bucketsCount++;
			$this->iterate();
			$this->timer->check();
		}
		$maxNumber++;

		$buckets = array_fill(1, $bucketsCount, null);
		$this->file->rewind();
		while ([$number] = $this->file->getData(1))
		{
			$bucketNumber = (int) ($number * $bucketsCount / $maxNumber);
			if (!isset($buckets[$bucketNumber]))
			{
				$buckets[$bucketNumber] = new \SplDoublyLinkedList();
				$buckets[$bucketNumber]->unshift($number);
				$this->iterate();
			}
			else
			{
				$list = $buckets[$bucketNumber];
				unset($buckets[$bucketNumber]);
				$list->rewind();

				$buckets[$bucketNumber] = new \SplDoublyLinkedList();
				while (!$list->isEmpty() && ($fromTheList = $list->shift()))
				{
					$this->iterate();

					if ($number !== null || ($fromTheList < $number))
					{
						$buckets[$bucketNumber]->unshift($fromTheList);
					}
					else
					{
						$buckets[$bucketNumber]->unshift($number);
						$number = null;
						$buckets[$bucketNumber]->unshift($fromTheList);
					}
					$list->next();
				}
			}

			$this->timer->check();
		}
		$checkResult = 0;
		foreach ($buckets as $bucketNumber => $bucketList)
		{
			if (!($bucketList instanceof \SplDoublyLinkedList))
			{
				continue;
			}
			/** @var \SplDoublyLinkedList $bucketList */
			else if ($bucketList->isEmpty())
			{
				echo '$bucketNumber: ' . $bucketNumber . PHP_EOL;
			}
			else
			{
				while (!$bucketList->isEmpty() && ($number = $bucketList->shift()))
				{
					$this->iterate();
					if ($checkResult > $number)
					{
						throw new \ErrorException('Bad sort');
					}
				}
			}
		}
	}
}
