<?php

namespace Fenric\Controllers\User;

/**
 * Import classes
 */
use Fenric\Controllers\Abstractable\Abstractable;

/**
 * Registration
 */
class Registration extends Abstractable
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
		if (! fenric('config::user')->get('registration.enabled', false)) {
			$this->response->setContent(
				fenric('view::user/registration.disabled')->render()
			);
			return;
		}

		if (fenric('session')->remove('user.registration.complete')) {
			$this->response->setContent(
				fenric('view::user/registration.complete')->render()
			);
			return;
		}

		$this->response->setContent(
			fenric('view::user/registration', [
				'registrationEmail' => fenric('session')->remove('user.registration.email'),
				'registrationUsername' => fenric('session')->remove('user.registration.username'),
				'registrationErrors' => fenric('session')->remove('user.registration.errors'),
			])->render()
		);
	}
}
