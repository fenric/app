<?php

namespace Fenric\Controllers;

/**
 * Import classes
 */
use Fenric\Controllers\Abstractable\Abstractable;

/**
 * Home
 */
class Home extends Abstractable
{

	/**
	 * Рендеринг контроллера
	 */
	public function render() : void
	{
		$this->response->view('home');
	}
}
