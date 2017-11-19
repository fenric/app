<?php

chdir(__DIR__);

spl_autoload_register(function(string $class) : bool
{
	if (file_exists($file = sprintf('./%s.local.php', $class)))
	{
		require_once $file;

		return true;
	}

	if (file_exists($file = sprintf('./%s.php', $class)))
	{
		require_once $file;

		return true;
	}

	return false;
});
