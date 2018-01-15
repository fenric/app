<?php

namespace Fenric\Controllers\Admin;

/**
 * Import classes
 */
use Fenric\Controllers\Abstractable\Abstractable;

/**
 * Desktop
 */
class Desktop extends Abstractable
{

	/**
	 * Доступ к контроллеру
	 */
	use Access;

	/**
	 * Рендеринг контроллера
	 */
	public function render() : void
	{
		$this->response->view('admin/desktop');
	}
}
