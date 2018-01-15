<?php

namespace Fenric\Controllers\User;

/**
 * Import classes
 */
use Propel\Models\User;
use Fenric\Controllers\Abstractable\Abstractable;

/**
 * RegistrationProcess
 */
class RegistrationProcess extends Abstractable
{

	/**
	 * Предварительная инициализация контроллера
	 */
	public function preInit() : bool
	{
		if (fenric('config::user')->get('registration.enabled', false)) {
			if (fenric('user')->isGuest()) {
				if (is_string($this->request->post->get('email'))) {
					if (is_string($this->request->post->get('username'))) {
						if (is_string($this->request->post->get('password'))) {
							if (is_string($this->request->post->get('password_confirmation'))) {
								return true;
							}
						}
					}
				}
			}
		}

		$this->response->status(\Fenric\Response::STATUS_400);
		return false;
	}

	/**
	 * Рендеринг контроллера
	 */
	public function render() : void
	{
		$user = new User();

		$user->setEmail(
			$this->request->post->get('email')
		);
		$user->setUsername(
			$this->request->post->get('username')
		);
		$user->setPassword(
			$this->request->post->get('password')
		);
		$user->setVirtualColumn('password_confirmation',
			$this->request->post->get('password_confirmation')
		);

		$errors = [];

		if ($user->validate())
		{
			if ($this->request->post->exists('agreement'))
			{
				if ($user->save())
				{
					$this->request->session->set('user.registration.complete', true);

					$this->backward();
				}
				else $errors['*'][] = __('user', 'registration.error.save');
			}
			else $errors['agreement'][] = __('user', 'registration.error.rules');
		}
		else foreach ($user->getValidationFailures() as $failure)
		{
			$errors[$failure->getPropertyPath()][] = $failure->getMessage();
		}

		$this->request->session->set('user.registration.email',
			$this->request->post->get('email')
		);

		$this->request->session->set('user.registration.username',
			$this->request->post->get('username')
		);

		$this->request->session->set('user.registration.errors', $errors);

		$this->backward();
	}
}
