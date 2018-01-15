<?php

namespace Fenric\Controllers\User;

/**
 * Import classes
 */
use DateTime;
use Propel\Models\User;
use Propel\Models\UserQuery;
use Fenric\Controllers\Abstractable\Abstractable;

/**
 * RegistrationConfirm
 */
class RegistrationConfirm extends Abstractable
{

	/**
	 * Предварительная инициализация контроллера
	 */
	public function preInit() : bool
	{
		if (UserQuery::existsByRegistrationConfirmationCode(
			$this->request->parameters->get('code')
		)) {
			return parent::preInit();
		}

		$this->response->status(\Fenric\Response::STATUS_404);
		return false;
	}

	/**
	 * Рендеринг контроллера
	 */
	public function render() : void
	{
		$users = UserQuery::create();

		$foundUser = $users->findOneByRegistrationConfirmationCode(
			$this->request->parameters->get('code')
		);

		if ($foundUser instanceof User)
		{
			$foundUser->setRegistrationConfirmed(true);
			$foundUser->setRegistrationConfirmedAt(new DateTime('now'));
			$foundUser->setRegistrationConfirmedIp(
				$this->request->environment->get('REMOTE_ADDR', '127.0.0.1')
			);
			$foundUser->getRegistrationConfirmationCode();
			$foundUser->setRegistrationConfirmationCode(null);

			if ($foundUser->save())
			{
				$this->request->session->set('user.registration.confirm', true);

				$this->redirect('/user/');
			}
			else $error = __('user', 'registration.confirm.error.save');
		}
		else $error = __('user', 'registration.confirm.error.unknown.code');

		$this->response->content(
			fenric('view::user/registration.confirm', [
				'error' => $error ?? null
			])->render()
		);
	}
}
