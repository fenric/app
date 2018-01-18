<?php

namespace Fenric\Controllers\User;

/**
 * Import classes
 */
use Propel\Models\User;
use Propel\Models\UserQuery;
use Fenric\Controllers\Abstractable\Abstractable;

/**
 * AuthenticationTokenCreateProcess
 */
class AuthenticationTokenCreateProcess extends Abstractable
{

	/**
	 * Предварительная инициализация контроллера
	 */
	public function preInit() : bool
	{
		$email = $this->request->post->get('email');

		if (fenric('user')->isGuest())
		{
			if (is_string($email))
			{
				return true;
			}
		}

		$this->response->status(
			\Fenric\Response::STATUS_400
		);

		return false;
	}

	/**
	 * Рендеринг контроллера
	 */
	public function render() : void
	{
		$users = UserQuery::create();

		$foundUser = $users->findOneByEmail(
			$this->request->post->get('email')
		);

		if ($foundUser instanceof User)
		{
			if ($foundUser->isRegistrationConfirmed())
			{
				if ($foundUser->isUnblocked())
				{
					$foundUser->setAuthenticationToken(
						$foundUser->generateCode()
					);
					$foundUser->setAuthenticationTokenAt(
						new \DateTime('now')
					);
					$foundUser->setAuthenticationTokenIp(
						$this->request->ip()
					);

					if ($foundUser->save())
					{
						$this->request->session->set('user.authentication.token.create.complete', true);

						fenric('event::model.user.token.create')->run([$foundUser]);
					}
					else $this->request->session->set('user.authentication.token.create.error',
						__('user', 'authentication.token.create.error.save')
					);
				}
				else $this->request->session->set('user.authentication.token.create.error',
					__('user', 'authentication.token.create.error.account.blocked')
				);
			}
			else $this->request->session->set('user.authentication.token.create.error',
				__('user', 'authentication.token.create.error.account.unverified')
			);
		}
		else $this->request->session->set('user.authentication.token.create.error',
			__('user', 'authentication.token.create.error.email.undefined')
		);

		$this->backward();
	}
}
