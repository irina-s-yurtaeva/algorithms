<?php

namespace Otus\ex35_ProbabilisticAlgorithms;

use Otus\PaintUtils;
use Otus\Result;

class BloomFilter extends \Otus\Alg
{
	public const CODE = 'bloom';
	protected string $rawPath;
	protected string $hashPath;
	protected $hashFile;
	protected int $M;
	protected float $collisionProbability = 0.001;
	protected int $positive = 0;
	protected int $negative = 0;

	protected PaintUtils $painter;

	public function __construct()
	{
		$this->painter = new PaintUtils();
		$this->rawPath = __DIR__ . '/raw.txt';
		$this->hashPath = __DIR__ . '/bloomHash.txt';
	}

	public function getName(): string
	{
		return 'Burton Howard Bloom (1970)';
	}

	public function setRawFilePath(string $path)
	{
		$this->rawPath = $path;
	}

	public function apply(): Result
	{
		$result = parent::apply();

		echo 'Вероятностная структура данных, позволяющая проверять принадлежность элемента к множеству. ' . PHP_EOL
			. ($this->rawPath === __DIR__ . '/raw.txt' ?  'Для проверки этой задачи будет использована книга Астрид Линдгрен "Пеппи длинный чулок". ' . PHP_EOL
			. 'По этой книге будет создан файл хешей слов, с которым в дальнейшем и будем работать. ' . PHP_EOL : '')
		;

		if (!file_exists($this->rawPath))
		{
			echo 'Файл для построения хешей не существует. Пожалуйста, введите путь к файлу. ' . PHP_EOL;
			return $result;
		}

		if (!file_exists($this->hashPath))
		{
			echo 'Началась генерация хэшей. ';
			$hashGeneratingResult = $this->generateHashes(
				$this->rawPath,
				$this->hashPath,
				$this->collisionProbability
			);
			$hashGeneratingResult->finalize();
			echo 'Через ' . $hashGeneratingResult->getTimeUsage() . ' генерация закончилась. ' . PHP_EOL;
		}

		$this->M = filesize($this->hashPath);

		$this->resetStat();

		echo 'Отсутствующие слова в тексте: ' . PHP_EOL;
		foreach (['bluff','cheater','hate','war','humanity',
			'racism','hurt','nuke','gloomy','facebook',
			'geeksforgeeks','twitter'] as $word)
		{
			$this->workWithWord($word, true);
		}
		echo 'True negative: ' . $this->negative. ', false positive: ' . $this->positive . PHP_EOL;

		$this->resetStat();
		echo 'Существующие в тексте слова: ' . PHP_EOL;
		$words = self::getSomeWordsFromFile($this->rawPath, 12);
		echo '$words: ' . implode(', ', $words) . PHP_EOL;
		foreach ($words as $word)
		{
			$this->workWithWord($word, true);
		}
		echo 'True negative: ' . $this->negative. ', true positive: ' . $this->positive . PHP_EOL;

		$this->releaseHashFile();
		return $result;
	}

	protected function resetStat()
	{
		$this->positive = 0;
		$this->negative = 0;
	}

	protected function hasWord(string $word): bool
	{
		return static::checkHashes($this->getFileHashResource(), $word);
	}

	protected function getFileHashResource()
	{
		if (!isset($this->hashFile))
		{
			$this->hashFile = fopen($this->hashPath, 'r');
		}

		return $this->hashFile;
	}

	protected function releaseHashFile(): void
	{
		if (isset($this->hashFile))
		{
			fflush($this->hashFile);
			@flock($this->hashFile, LOCK_UN);
			@fclose($this->hashFile);
		}
	}

	protected function workWithWord(string $word): void
	{
		if ($this->hasWord($word))
		{
			$this->positive++;
		}
		else
		{
			$this->negative++;
		}
	}

	static protected function measureTableSize(string $file): int
	{
		return round(filesize($file)
			/ 5.28  // 5.28 - average word length in Russian
			/ 2 // 2 byte for one letter
			* 0.3 // words frequency
		);
	}

	static protected function generateHashes(string $file, string $outFile, float $p, int $k = 3, string $hashAlg = 'crc32'): Result
	{
		$result = new Result();
		// Estimate Size: M = - N * log(p, 2) / log(2);
		$N = self::measureTableSize($file);
		$M = ceil( - $N * log($p, 2) / log(2));
		$string = str_repeat('0', $M);
		file_put_contents($outFile, $string);

		$fdst = fopen($outFile, 'cb');

		foreach (static::getLines($file) as $line)
		{
			$rawWords = array_map(fn($v) => trim($v, ' ,-.:;!?'), explode(' ', $line));

			foreach ($rawWords as $word)
			{
				$word = trim($word);
				if (empty($word))
				{
					continue;
				}
				for ($i = 0; $i < $k; $i++)
				{
					$hash = hexdec(hash($hashAlg, $i . $word)) % $M;
					fseek($fdst, $hash, SEEK_SET);
					fwrite($fdst, 1);
				}
			}
		}
		fflush($fdst);
		@flock($fdst, LOCK_UN);
		@fclose($fdst);
		$result->finalize()->setData([$M]);
		return $result;
	}

	protected static function getSomeWordsFromFile(string $path, int $amount = 10): array
	{
		$words = [];
		$f = fopen($path, 'r');
		$stat = fstat($f);
		$size = $stat['size'];

		while (fseek($f, rand(0, $size - 50)) >= 0 && ($line = fgets($f)))
		{
			$rawWords = array_map(fn($v) => trim($v, ' ,-.:;!?'), explode(' ', $line));
			$rawWords = array_filter($rawWords, fn($v) => !empty($v));
			array_shift($rawWords);

			foreach ($rawWords as $word)
			{
				$word = trim($word);
				if (empty($word) || in_array($word, $words))
				{
					continue;
				}
				$words[] = $word;
			}

			if (count($words) > $amount)
			{
				break;
			}
		}

		fclose($f);

		return $words;
	}

	protected static function checkHashes($fileSource, string $word, int $k = 3, string $hashAlg = 'crc32'): bool
	{
		$word = trim($word);
		if (empty($word))
		{
			return true;
		}

		$stat = fstat($fileSource);
		$M = $stat['size'];

		$result = false;
		for ($i = 0; $i < $k; $i++)
		{
			$hash = hexdec(hash($hashAlg, $i . $word)) % $M;
			fseek($fileSource, $hash, SEEK_SET);
			$res = fread($fileSource, 1);
			if ($res === '0')
			{
				$result = false;
				break;
			}
			else
			{
				$result = true;
			}
		}

		return $result;
	}

	static protected function getLines(string $file)
	{
		$f = fopen($file, 'r');
		try {
			while ($line = fgets($f)) {
				yield $line;
			}
		} finally {
			fclose($f);
		}
	}
}
