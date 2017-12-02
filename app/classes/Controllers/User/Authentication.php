<?php

namespace Fenric\Controllers\User;

/**
 * Import classes
 */
use Fenric\Controllers\Abstractable\Abstractable;

/**
 * Authentication
 */
class Authentication extends Abstractable
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
		if (! fenric('config::user')->get('authentication.enabled', false)) {
			$this->response->setContent(
				fenric('view::user/authentication.disabled')->render()
			);
			return;
		}

		$this->response->setContent(
			fenric('view::user/authentication', [
				'authenticationError' => fenric('session')->remove('user.authentication.error'),
				'authenticationUsername' => fenric('session')->remove('user.authentication.username'),
				'registrationConfirm' => fenric('session')->remove('user.registration.confirm'),
			])->render()
		);
	}
}
