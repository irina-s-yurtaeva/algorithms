<?php

define('VERSION', '1.0.24');
define('DEFAULT_PIXEL', "\xE2\x96\x84");
define('RC', "\e[0m");
define('RCNL', RC . PHP_EOL);
define('CURRENT_FILE', array_shift($argv));

error_reporting(0);

if (PHP_MAJOR_VERSION < 7) {
	die('Minimum PHP v7.0' . PHP_EOL);
}

// --------------------------------------------------------
// Flags in use

$flags = [
	'-h' => [
		'value' => false,
		'value_required' => false,
		'description' => 'Show this help message',
		'callback' => null
	],
	'-v' => [
		'value' => false,
		'value_required' => false,
		'description' => 'Show version',
		'callback' => function () {
			echo colorHelp(sprintf("Paint (`%s`) v%s, (c) 2017-2018 <robopuff>\n", CURRENT_FILE, VERSION));
			return false;
		}
	],
	'-b' => [
		'value' => true,
		'value_required' => false,
		'description' => 'Resize to [VALUE] box, if no value provided then terminal height is used',
		'callback' => function (&$width, &$height, $value = null) {
			if ($value) {
				$height = $value;
			} else {
				$height = ((int)exec('tput lines'));
			}

			$width = $height;
		}
	],
	'-w' => [
		'value' => true,
		'value_required' => true,
		'description' => 'Set width',
		'callback' => function (&$width, $_, $value) {
			$width = $value;
		}
	],
	'-t' => [
		'value' => false,
		'value_required' => false,
		'description' => 'Test terminal color & font capabilities. It should show two lines of different color.',
		'callback' => function () {
			echo drawChar([255,80,105], [105, 80, 255]) . str_repeat(DEFAULT_PIXEL, 3) . RC .
				drawChar([105, 80, 255], [255,80,105]) . str_repeat(DEFAULT_PIXEL, 3) . RC .
				' ' . drawChar([105, 80, 255], [255, 80, 105]) . RC . drawChar([255, 80, 105], [105, 80, 255]) . RC .
				' ' . drawChar([105, 80, 255], [255, 80, 105]) . RC .
				' -' . DEFAULT_PIXEL . drawChar([255, 80, 105], [105, 80, 255]) . RC . DEFAULT_PIXEL . '-' .
				' ' . drawChar([255, 80, 105], [255, 80, 105]) . RC . DEFAULT_PIXEL . PHP_EOL;
			return false;
		}
	],
	'-x' => [
		'value' => true,
		'value_required' => true,
		'description' => 'Pixelate image before showing'
	],
	'-p' => [
		'value' => false,
		'value_required' => false,
		'description' => 'Draw palette of colours, good for terminal test',
		'callback' => function ($width, $height, $_, $context) {
			$source = imagecreatetruecolor(255, 255);

			for ($y = 0; $y < 255; $y++) {
				for ($x = 0; $x < 255 * 2; $x++) {
					$r = 255 - $x;
					$g = 255 - $y;
					$b = (($x + $y) / 2);
					imagesetpixel($source, $x, $y, imagecolorallocate($source, $r, $g, $b));
				}
			}
			drawImage($source, 255, 255, $width, $height, $context);
			return false;
		}
	],
	'-f' => [
		'value' => true,
		'value_required' => true,
		'description' => 'Draw image provided in [VALUE], can combine with `-b, -w` but `-f` must be provided last.' .
			' Can be skipped if <FILE> is provided.',
		'callback' => function ($width, $height, $value, $context) {
			$content = null;
			if (!$value) {
				throw new \Exception('Improper usage of `-f`, should be `-f`=[IMAGE]');
			}

			if (strpos($value, 'http') === 0 || strpos($value, 'ftp') === 0) {
				$curl = curl_init($value);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_HEADER, false);
				$content = curl_exec($curl);
				curl_close($curl);
			} elseif (!file_exists($value) || !is_readable($value)) {
				throw new \Exception("Cannot find file `{$value}`", 0x1f1);
			}

			if (!$content) {
				$content = file_get_contents($value);
			}

			$source = imagecreatefromstring($content);

			if (!$source) {
				throw new \Exception("Cannot read `{$value}` as image", 0x1f2);
			}

			$imW = imagesx($source);
			$imH = imagesy($source);
			imagefilter($source, IMG_FILTER_PIXELATE, 2, true);
			drawImage($source, $imW, $imH, $width, $height, $context);
			imagedestroy($source);
		}
	]
];

// --------------------------------------------------------
// Helper functions

// Draw single pixel with sub-pixel as lower block char
function drawChar(array $upper, array $lower = [], $char = DEFAULT_PIXEL, $clean = false) // •
{
	if (empty($upper) && empty($lower)) {
		return $char;
	}

	if ($upper == $lower) {
		return drawUpperPixel($upper) .' ' . ($clean ? RC : '');
	}

	return drawUpperPixel($upper) .
		drawLowerPixel(empty($lower) ? $upper : $lower, $char) .
		($clean ? RC : '');
};

// Draw background color (upper pixel)
function drawUpperPixel(array $color)
{
	$color = implode(';', $color);
	return "\e[48;2;{$color}m";
}

// Draw foreground color (lower pixel)
function drawLowerPixel(array $color = [], $char = DEFAULT_PIXEL)
{
	if (empty($color)) {
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
				echo drawUpperPixel($upper);
			}

			if ($lastLower == $lower) {
				$drawLower = [];
			}

			echo drawLowerPixel($drawLower);

			$lastLower = $lower;
			$lastUpper = $upper;
		}
		echo RCNL;
	}

	imagedestroy($thumb);
}

// Show an error
function showError($error)
{
	echo drawChar([200, 20, 70], [255,255,255], str_repeat(' ', 50)) . "\n";
	echo ' Error occurred' . str_repeat(' ', 50 - 15) . "\n";
	echo str_repeat(' ', 50) . RCNL . PHP_EOL;
	echo '  ' . colorHelp($error)  . "\n\n";
}

// Add color content
function colorHelp($content)
{
	return preg_replace_callback_array([
		'/\[(.*?)\]/' => function ($matches) {
			return drawChar([45, 35, 8], [255, 247, 97], $matches[0], true);
		},
		'/\`(.*?)\`/' => function ($matches) {
			return drawChar([35, 13, 14], [255, 100, 108], " {$matches[1]} ", true);
		},
		'/\<(.*?)\>/' => function ($matches) {
			return drawChar([10, 38, 13], [102, 245, 119], $matches[0], true);
		}
	], $content);
}

// Show help message
function helpMessage($flags)
{
	echo drawLowerPixel([200, 20, 70], '');
	echo <<<ASCII
      :::::::::     :::    :::::::::::::::    :::::::::::::: 
     :+:    :+:  :+: :+:      :+:    :+:+:   :+:    :+:     
    +:+    +: ++:+   +:+     +:+    :+:+:+  +:+    +:+      
   +#++:++#+ +#++:++#++:    +#+    +#+ +:+ +#+    +#+       
  +#+       +#+     +#+    +#+    +#+  +#+#+#    +#+        
 #+#       #+#     #+#    #+#    #+#   #+#+#    #+#         
###       ###     #################    ####    ###   v
ASCII;
	echo VERSION . RCNL . PHP_EOL;

	$help = sprintf("Usage `%s` [PARAMS] <FILE>\n", CURRENT_FILE);
	foreach ($flags as $flag => $options) {
		$flagHelp = $flag;

		if ($options['value']) {
			if ($options['value_required']) {
				$flagHelp .= "=[VALUE]";
			} else {
				$flagHelp .= ", {$flag}=[VALUE]";
			}
		}

		$help .= "   {$flagHelp}\n      {$options['description']}\n";
	}

	echo colorHelp($help) . PHP_EOL;

	$flags['-v']['callback']();
	return false;
}

$flags['-h']['callback'] = function () use ($flags) {
	return helpMessage($flags);
};

// --------------------------------------------------------
// Terminal operations

$termWidth = (int)exec('tput cols') - 1;
$termHeight = 0;

$file = end($argv);
if ($file[0] != '-' && (file_exists($file) || strpos($file, 'http') === 0)) {
	array_pop($argv);
	$argv[] = "-f={$file}";
}

$context = [];
$callbacks   = [];
foreach (array_unique($argv) as $aid => $arg) {
	$key = $arg;
	$value = null;

	$pos = strpos($arg, '=');

	if ($pos > 0) {
		$key = substr($arg, 0, $pos);
		$value = substr($arg, $pos + 1);
	}

	if (isset($flags[$key])) {
		$context[$key] = $value;

		if (null !== $value && $flags[$key]['value'] === false) {
			showError("Param `{$key}` does not have a value");
			die();
		}

		if (isset($flags[$key]['callback'])) {
			$callbacks[] = [
				$flags[$key]['callback'],
				$value
			];
		}
	} else {
		showError("Param `{$key}` not found.");
		die();
	}
}

if (empty($callbacks)) {
	if (!empty($context)) {
		showError(sprintf(
			'Provided flags `%s` cannot be used by themselves as they don\'t provide any action.',
			implode(', ', array_keys($context))
		));
		die();
	}

	helpMessage($flags);
	die();
}

foreach ($callbacks as $vars) {
	[$callback, $value] = $vars;
	try {
		if ($callback($termWidth, $termHeight, $value, $context) === false) {
			break;
		}
	} catch (Throwable $e) {
		showError(sprintf('%s: %s', $e->getCode(), $e->getMessage()));
		die();
	}
}

__halt_compiler();
