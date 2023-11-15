<?php
namespace Otus;

error_reporting(0);

if (PHP_MAJOR_VERSION < 7) {
	die('Minimum PHP v7.0' . PHP_EOL);
}

class PaintUtils
{
	public const DEFAULT_PIXEL = "\xE2\x96\x84";
	public const RESET_COLOR = "\e[0m";
	public const CLEAR_SCREEN = "\e[2J";
	public const HOME = "\e[H";
	public const CURSOR = "\e[6n";
	public const RESET_COLOR_AND_NEW_LINE = "\e[0m" . PHP_EOL;

	public int $termWidth = 100;
	protected int $termHeigh = 0;

	public function __construct()
	{
		$this->termWidth = (int)exec('tput cols') - 1;
		$this->termHeigh = (int)exec('tput lines') - 1;
	}

	public function getCursorPosition()
	{
		// Как это  сделать?
		//		echo "\e[6n";
		//		$cursor = fgets(STDIN);
		//		$cursor = file_get_contents('php://output');
		$cursor = exec('tput u7');
		echo '1'.PHP_EOL;
		var_dump($cursor);
		echo '2'.PHP_EOL;
		preg_match('/\[(\d*);(\d*)/', $cursor, $matches);
		var_dump($matches);
		return;
		//		$cursor = trim(trim($cursor, "-e \e["), 'R;');
		//		echo $cursor.PHP_EOL;
	}

	public function gotoxy($x, $y)
	{
		return sprintf("\e[%d;%dH", $y, $x);
	}

	public function visible_cursor()
	{
		return sprintf("\e[?251");
	}

	// Draw single pixel with sub-pixel as lower block char
	public function drawChar(array $upper, array $lower = [], $char = self::DEFAULT_PIXEL, $clean = true)
	{
		if (empty($upper) && empty($lower))
		{
			return $char;
		}

		if ($upper == $lower)
		{
			return $this->drawUpperPixel($upper) .' ' . ($clean ? self::RESET_COLOR : '');
		}

		return $this->drawUpperPixel($upper) .
			$this->drawLowerPixel(empty($lower) ? $upper : $lower, $char) .
			($clean ? self::RESET_COLOR : '');
	}


	// Draw background color (upper pixel)
	function drawUpperPixel(array $color)
	{
		$color = implode(';', $color);
		return "\e[48;2;{$color}m";
	}


	// Draw foreground color (lower pixel)
	public function colorFont(array $color = []): string
	{
		return $this->drawLowerPixel($color, '');
	}

	public function resetColor(): string
	{
		return self::RESET_COLOR;
	}

	// Draw foreground color (lower pixel)
	function drawLowerPixel(array $color = [], $char = self::DEFAULT_PIXEL)
	{
		if (empty($color))
		{
			return $char;
		}

		$color = implode(';', $color);
		return "\e[38;2;{$color}m{$char}";
	}

	// Draw image pixel by pixel (with resize)
	function drawImage($source, $imW, $imH, $width, $height, $flags = [])
	{
		$r = $imW / $imH;

		if ($height > 0) {
			if ($width > $height) {
				$height = $width / $r;
			} else {
				$width = $height * $r;
			}
		} else {
			$height = $width / $r;
		}

		if ($width > $imW) {
			$width  = $imW;
			$height = $imH;
		}

		$thumb = imagecreatetruecolor($width, $height);
		imagecopyresampled($thumb, $source, 0, 0, 0, 0, $width, $height, $imW, $imH);

		if (isset($flags['-x'])) {
			imagefilter($thumb, IMG_FILTER_PIXELATE, (int)$flags['-x'], true);
		}

		for ($y = 0; $y < imagesy($thumb) - 1; $y++) {
			if ($y % 2 != 0) {
				continue;
			}

			$lastUpper = [];
			$lastLower = [];

			for ($x = 0; $x < imagesx($thumb) - 1; $x++) {
				$c1 = imagecolorat($thumb, $x, $y);
				$c2 = imagecolorat($thumb, $x, $y + 1);

				$upper = [
					($c1 >> 16) & 0xFF,
					($c1 >> 8) & 0xFF,
					($c1) & 0xFF,
				];

				$lower = $drawLower = [
					($c2 >> 16) & 0xFF,
					($c2 >> 8) & 0xFF,
					($c2) & 0xFF,
				];

				if ($lastUpper != $upper) {
					echo $this->drawUpperPixel($upper);
				}

				if ($lastLower == $lower) {
					$drawLower = [];
				}

				echo $this->drawLowerPixel($drawLower);

				$lastLower = $lower;
				$lastUpper = $upper;
			}
			echo self::RESET_COLOR_AND_NEW_LINE;
		}

		imagedestroy($thumb);
	}

	function showError($error)
	{
		echo $this->drawChar([200, 20, 70], [255,255,255], str_repeat(' ', 50), false) . "\n";
		echo ' Error occurred' . str_repeat(' ', 50 - 15) . "\n";
		echo str_repeat(' ', 50) . self::RESET_COLOR_AND_NEW_LINE . PHP_EOL;
		echo '  ' . colorHelp($error)  . "\n\n";
	}

	// Add color content
	function colorHelp($content)
	{
		return preg_replace_callback_array([
			'/\[(.*?)\]/' => function ($matches) {
				return $this->drawChar([45, 35, 8], [255, 247, 97], $matches[0], true);
			},
			'/\`(.*?)\`/' => function ($matches) {
				return $this->drawChar([35, 13, 14], [255, 100, 108], " {$matches[1]} ", true);
			},
			'/\<(.*?)\>/' => function ($matches) {
				return $this->drawChar([10, 38, 13], [102, 245, 119], $matches[0], true);
			}
		], $content);
	}

	// Show help message
	public function helpMessage()
	{
		echo $this->drawLowerPixel([200, 20, 70], '');
		echo <<<ASCII
      :::::::::     :::    :::::::::::::::    :::::::::::::: 
     :+:    :+:  :+: :+:      :+:    :+:+:   :+:    :+:     
    +:+    +: ++:+   +:+     +:+    :+:+:+  +:+    +:+      
   +#++:++#+ +#++:++#++:    +#+    +#+ +:+ +#+    +#+       
  +#+       +#+     +#+    +#+    +#+  +#+#+#    +#+        
 #+#       #+#     #+#    #+#    #+#   #+#+#    #+#         
###       ###     #################    ####    ###   v
ASCII;
		echo self::RESET_COLOR . PHP_EOL;

		$help = sprintf("Usage `%s` [PARAMS] <FILE>\n", __FILE__);
		echo $this->drawLowerPixel([255, 20, 70], '');
		echo "Normal \e[4mUnderlined \e[24mNormal" . PHP_EOL;
		echo $this->drawLowerPixel([20, 255, 70], '');
		echo "Normal ". chr(27)."[4mUnderlined ". chr(27)."[24mNormal" . PHP_EOL;
		echo $this->drawLowerPixel([20, 70, 255], '');

		echo $this->colorHelp($help) . PHP_EOL;
	}
}