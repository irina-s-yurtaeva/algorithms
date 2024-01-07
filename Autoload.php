<?php

spl_autoload_register(function($className) {
	$pathParts = explode('\\', $className);
	if (
		array_shift($pathParts) === 'Otus'
		&&
		(
			($paths = glob(__DIR__ . '/' . implode('/', $pathParts) . '.php'))
			||
			($paths = glob(__DIR__ . '/*' . implode('/*', $pathParts) . '.php'))
		)
	)
	{
		foreach ($paths as $path)
		{
			include_once $path;
		}
	}
});
