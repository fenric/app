<?php

namespace Fenric\Controllers\User;

/**
 * Import classes
 */
use Fenric\Controllers\Abstractable\Abstractable;

/**
 * ProfileSettingsSave
 */
class ProfileSettingsSave extends Abstractable
{

	/**
	 * Предварительная инициализация контроллера
	 */
	public function preInit() : bool
	{
		if (fenric('user')->isLogged())
		{
			if (is_string($this->request->post->get('email')) &&
				is_string($this->request->post->get('password')) &&
				is_string($this->request->post->get('password_confirmation')) &&
				is_string($this->request->post->get('firstname')) &&
				is_string($this->request->post->get('lastname')) &&
				is_string($this->request->post->get('gender')) &&
				is_string($this->request->post->get('birthday')) &&
				is_string($this->request->post->get('about'))
			) {
				return true;
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
		// Lazy load fields...
		fenric('user')->getPassword();
		fenric('user')->getAbout();
		fenric('user')->getParams();

		if ($this->request->post->get('email')) {
			fenric('user')->setEmail(
				$this->request->post->get('email')
			);
			$this->request->session->set('user.settings.email',
				$this->request->post->get('email')
			);
		}

		if ($this->request->post->get('password')) {
			fenric('user')->setPassword(
				$this->request->post->get('password')
			);
			fenric('user')->setVirtualColumn('password_confirmation',
				$this->request->post->get('password_confirmation')
			);
		}

		fenric('user')->setFirstname(
			$this->request->post->get('firstname')
		);
		$this->request->session->set('user.settings.firstname',
			$this->request->post->get('firstname')
		);

		fenric('user')->setLastname(
			$this->request->post->get('lastname')
		);
		$this->request->session->set('user.settings.lastname',
			$this->request->post->get('lastname')
		);

		fenric('user')->setGender(
			$this->request->post->get('gender')
		);
		$this->request->session->set('user.settings.gender',
			$this->request->post->get('gender')
		);

		fenric('user')->setBirthday(
			$this->request->post->get('birthday')
		);
		$this->request->session->set('user.settings.birthday',
			$this->request->post->get('birthday')
		);

		fenric('user')->setAbout(
			$this->request->post->get('about')
		);
		$this->request->session->set('user.settings.about',
			$this->request->post->get('about')
		);

		$errors = [];

		if (fenric('user')->validate())
		{
			fenric('user')->save();
		}
		else foreach (fenric('user')->getValidationFailures() as $failure)
		{
			$errors[$failure->getPropertyPath()][] = $failure->getMessage();
		}

		$this->request->session->set('user.settings.errors', $errors);

		$this->backward();
	}
}
