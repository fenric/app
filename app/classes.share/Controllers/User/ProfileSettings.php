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
		$this->response->setContent(
			fenric('view::user/profile.settings', [
				'email' => fenric('session')->remove('user.settings.email'),
				'firstname' => fenric('session')->remove('user.settings.firstname'),
				'lastname' => fenric('session')->remove('user.settings.lastname'),
				'gender' => fenric('session')->remove('user.settings.gender'),
				'birthday' => fenric('session')->remove('user.settings.birthday'),
				'about' => fenric('session')->remove('user.settings.about'),
				'errors' => fenric('session')->remove('user.settings.errors'),
			])->render()
		);
	}
}
