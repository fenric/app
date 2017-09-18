<?php

namespace Fenric\Controllers\User;

/**
 * Import classes
 */
use Fenric\Controllers\Abstractable\Abstractable;

/**
 * SignOut
 */
class SignOut extends Abstractable
{

	/**
	 * Рендеринг контроллера
	 */
	public function render() : void
	{
		fenric('user')->signOut();

		if ($this->request->isAjax()) {
			return;
		}

		$this->backward();
	}
}
