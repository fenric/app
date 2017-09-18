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
		if (fenric('user')->isGuest()) {
			if (is_string($this->request->post->get('email'))) {
				return true;
			}
		}

		$this->response->setStatus(400);
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
						$this->request->environment->get('REMOTE_ADDR', '127.0.0.1')
					);

					if ($foundUser->save())
					{
						fenric('session')->set('user.authentication.token.create.complete', true);
						fenric('event::user.authentication.token.created')->run([$foundUser]);
					}
					else fenric('session')->set('user.authentication.token.create.error',
						fenric()->t('user', 'authentication.token.create.error.save')
					);
				}
				else fenric('session')->set('user.authentication.token.create.error',
					fenric()->t('user', 'authentication.token.create.error.account.blocked')
				);
			}
			else fenric('session')->set('user.authentication.token.create.error',
				fenric()->t('user', 'authentication.token.create.error.account.unverified')
			);
		}
		else fenric('session')->set('user.authentication.token.create.error',
			fenric()->t('user', 'authentication.token.create.error.email.undefined')
		);

		$this->backward();
	}
}
