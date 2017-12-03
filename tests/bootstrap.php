<?php

putenv('ENVIRONMENT=test');

spl_autoload_register(function(string $class) : bool
{
	$file = __DIR__ . DIRECTORY_SEPARATOR . $class . '.php';

	if (file_exists($file))
	{
		require_once $file;

		return true;
	}

	return false;
});
