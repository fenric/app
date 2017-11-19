<?php

chdir(__DIR__);

spl_autoload_register(function(string $class) : bool
{
	if (is_file($file = sprintf('./%s.local.php', $class)))
	{
		require_once $file;

		return true;
	}

	if (is_file($file = sprintf('./%s.php', $class)))
	{
		require_once $file;

		return true;
	}

	if (is_file($file = sprintf('./%s.example.php', $class)))
	{
		require_once $file;

		return true;
	}

	return false;
});
