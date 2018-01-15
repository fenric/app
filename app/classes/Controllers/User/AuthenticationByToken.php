<?php

namespace Fenric\Controllers\User;

/**
 * Import classes
 */
use Propel\Models\User;
use Propel\Models\UserQuery;
use Fenric\Controllers\Abstractable\Abstractable;

/**
 * AuthenticationByToken
 */
class AuthenticationByToken extends Abstractable
{

	/**
	 * Предварительная инициализация контроллера
	 */
	public function preInit() : bool
	{
		if (UserQuery::existsByAuthenticationToken(
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

		$foundUser = $users->findOneByAuthenticationToken(
			$this->request->parameters->get('code')
		);

		if ($foundUser instanceof User)
		{
			if ($foundUser->isRegistrationConfirmed())
			{
				if ($foundUser->isUnblocked())
				{
					if ($foundUser->getAuthenticationTokenAt() > new \DateTime('1 day ago'))
					{
						if (strcmp($foundUser->getAuthenticationTokenIp(), $this->request->environment->get('REMOTE_ADDR', '127.0.0.1')) === 0)
						{
							$foundUser->getAuthenticationToken();
							$foundUser->setAuthenticationToken(null);
							$foundUser->setAuthenticationTokenAt(null);
							$foundUser->setAuthenticationTokenIp(null);

							if (fenric('user')->signInBy($foundUser))
							{
								$this->redirect('/user/');
							}
							else $this->request->session->set('user.authentication.token.create.error',
								__('user', 'authentication.by.token.error.save')
							);
						}
						else $this->request->session->set('user.authentication.token.create.error',
							__('user', 'authentication.by.token.error.ip.token')
						);
					}
					else $this->request->session->set('user.authentication.token.create.error',
						__('user', 'authentication.by.token.error.date.token')
					);
				}
				else $this->request->session->set('user.authentication.token.create.error',
					__('user', 'authentication.by.token.error.account.blocked')
				);
			}
			else $this->request->session->set('user.authentication.token.create.error',
				__('user', 'authentication.by.token.error.account.unverified')
			);
		}
		else $this->request->session->set('user.authentication.token.create.error',
			__('user', 'authentication.by.token.error.unknown.token')
		);

		$this->redirect('/user/login/token/create/');
	}
}
