<?php

namespace Fenric\Controllers\Assets;

/**
 * Import classes
 */
use Fenric\Controller;

/**
 * FenricJs
 */
class FenricJs extends Controller
{

	/**
	 * Рендеринг контроллера
	 */
	public function render() : void
	{
		$this->response->setHeader('Content-Type: application/javascript; charset=UTF-8');
		$this->response->setContent(fenric('view::assets/fenric.js')->render());
	}
}
