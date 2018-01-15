<?php

namespace Fenric\Controllers\User;

/**
 * Import classes
 */
use Fenric\Controllers\Abstractable\Abstractable;

/**
 * ProfileSettings
 */
class ProfileSettings extends Abstractable
{

	/**
	 * Предварительная инициализация контроллера
	 */
	public function preInit() : bool
	{
		if (fenric('user')->isGuest()) {
			$this->redirect('/user/');
		}

		return parent::preInit();
	}

	/**
	 * Рендеринг контроллера
	 */
	public function render() : void
	{
		$this->response->content(
			fenric('view::user/profile.settings', [
				'email' => $this->request->session->remove('user.settings.email'),
				'firstname' => $this->request->session->remove('user.settings.firstname'),
				'lastname' => $this->request->session->remove('user.settings.lastname'),
				'gender' => $this->request->session->remove('user.settings.gender'),
				'birthday' => $this->request->session->remove('user.settings.birthday'),
				'about' => $this->request->session->remove('user.settings.about'),
				'errors' => $this->request->session->remove('user.settings.errors'),
			])->render()
		);
	}
}
