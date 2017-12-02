<?php

namespace Fenric\Controllers\User;

/**
 * Import classes
 */
use Fenric\Controllers\Abstractable\Abstractable;

/**
 * AuthenticationTokenCreate
 */
class AuthenticationTokenCreate extends Abstractable
{

	/**
	 * Предварительная инициализация контроллера
	 */
	public function preInit() : bool
	{
		if (fenric('user')->isLogged()) {
			$this->redirect('/user/');
		}

		return parent::preInit();
	}

	/**
	 * Рендеринг контроллера
	 */
	public function render() : void
	{
		if (fenric('session')->remove('user.authentication.token.create.complete')) {
			$this->response->setContent(
				fenric('view::user/authentication.token.create.complete')->render()
			);
			return;
		}

		$this->response->setContent(
			fenric('view::user/authentication.token.create', [
				'error' => fenric('session')->remove('user.authentication.token.create.error'),
			])->render()
		);
	}
}
