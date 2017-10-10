<?php

namespace Fenric\Controllers\User;

/**
 * Import classes
 */
use Propel\Models\UserQuery;
use Fenric\Controllers\Abstractable\Abstractable;

/**
 * Profile
 */
class Profile extends Abstractable
{

	/**
	 * Предварительная инициализация контроллера
	 */
	public function preInit() : bool
	{
		if ($this->request->parameters->exists('id'))
		{
			if (! UserQuery::existsById($this->request->parameters->get('id')))
			{
				$this->response->setStatus(404);

				return false;
			}
		}
		else if (fenric('user')->isGuest())
		{
			$this->redirect('/user/login/');
		}

		return parent::preInit();
	}

	/**
	 * Рендеринг контроллера
	 */
	public function render() : void
	{
		$user = fenric('user');
		$view = fenric('view::user/profile');

		if ($this->request->parameters->exists('id'))
		{
			$user = UserQuery::create()->findPk(
				$this->request->parameters->get('id')
			);
		}

		$this->response->setContent($view->render([
			'user' => $user,
		]));
	}
}
