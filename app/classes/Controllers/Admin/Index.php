<?php

namespace Fenric\Controllers\Admin;

/**
 * Import classes
 */
use Fenric\Controllers\Abstractable\Abstractable;

/**
 * Index
 */
class Index extends Abstractable
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
		$this->response->setContent(
			fenric('view::admin/desktop')->render()
		);
	}
}
