<?php

namespace Fenric\Controllers\Services;

/**
 * Import classes
 */
use Fenric\Controllers\Abstractable\Abstractable;

/**
 * RobotsTxt
 */
class RobotsTxt extends Abstractable
{

	/**
	 * Рендеринг контроллера
	 */
	public function render() : void
	{
		$header = 'Content-type: text/plain; charset=UTF-8';

		$content = fenric('parameter::robots.txt') ?: 'User-Agent: *';

		$this->response->setHeader($header)->setContent($content);
	}
}
