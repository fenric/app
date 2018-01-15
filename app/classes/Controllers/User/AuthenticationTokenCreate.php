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
		if ($this->request->session->remove('user.authentication.token.create.complete')) {
			$this->response->view('user/authentication.token.create.complete');
			return;
		}

		$this->response->view('user/authentication.token.create', [
			'error' => $this->request->session->remove('user.authentication.token.create.error'),
		]);
	}
}
