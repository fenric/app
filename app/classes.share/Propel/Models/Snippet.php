<?php

namespace Propel\Models;

use Propel\Models\Base\Snippet as BaseSnippet;
use Propel\Runtime\Connection\ConnectionInterface;

/**
 * Skeleton subclass for representing a row from the 'snippet' table.
 *
 * You should add additional methods to this class to meet the application requirements.
 * This class will only be generated as long as it does not already exist in the output directory.
 */
class Snippet extends BaseSnippet
{

	/**
	 * Получение распарсенного значения
	 */
	public function getParsedValue(ConnectionInterface $connection = null) : string
	{
		$expression = '/<\?php(?<php>.*?)\?>/is';

		return preg_replace_callback($expression, function($match)
		{
			$code = trim($match['php']);

			if (strlen($code) > 0)
			{
				try
				{
					ob_start();

					(function() use($code)
					{
						eval($code);

					})->call($this->getSandbox());

					return ob_get_clean();
				}

				catch (\Throwable $e)
				{
					ob_end_clean();

					return $e->getMessage();
				}
			}

		}, $this->getValue($connection));
	}

	/**
	 * Песочница для исполняемого кода сниппета
	 */
	private function getSandbox()
	{
		static $scope;

		if (empty($scope))
		{
			$scope = new class
			{};

			$scope->id = $this->getId();
			$scope->code = $this->getCode();
			$scope->title = $this->getTitle();
		}

		return $scope;
	}
}
