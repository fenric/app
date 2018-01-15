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
			$this->response->view('user/authentication.disabled');
			return;
		}

		$this->response->view('user/authentication', [
			'authenticationError' => $this->request->session->remove('user.authentication.error'),
			'authenticationUsername' => $this->request->session->remove('user.authentication.username'),
			'registrationConfirm' => $this->request->session->remove('user.registration.confirm'),
		]);
	}
}
