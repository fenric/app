<?php

namespace Fenric;

/**
 * Import classes
 */
use DateTime;
use RuntimeException;
use BadMethodCallException;
use Propel\Models\User as Model;
use Propel\Models\UserQuery as Query;
use Propel\Models\Map\UserTableMap as TableMap;

/**
 * User
 */
class User
{

	/**
	 * Модель учетной записи
	 */
	private $model;

	/**
	 * Конструктор класса
	 */
	public function __construct()
	{
		if (fenric('session')->isStarted())
		{
			if ($uid = fenric('session')->get('user.id'))
			{
				if ($model = Query::create()->findPk($uid))
				{
					if ($model->isUnblocked())
					{
						$this->model = $model;

						fenric('query')->update(TableMap::TABLE_NAME, [
							TableMap::COL_TRACK_AT => new DateTime('now'),
							TableMap::COL_TRACK_IP => mb_substr(ip(), 0, 255, 'UTF-8'),
							TableMap::COL_TRACK_URL => mb_substr(url(), 0, 255, 'UTF-8'),
						])
						->where(TableMap::COL_ID, '=', $this->model->getId())
						->limit(1)
						->shutdown();

						return;
					}
				}

				fenric('session')->remove('user.id');
			}
		}
	}

	/**
	 * Авторизация учетной записи
	 */
	public function signIn(string $username, string $password) : bool
	{
		$query = Query::create();

		$username = trim($username);
		$password = trim($password);

		if (fenric('session')->isStarted())
		{
			if (strlen($username) >= 2 && strlen($username) <= 48 && ctype_alnum($username))
			{
				if (strlen($password) >= 6 && strlen($password) <= 256)
				{
					if ($model = $query->findOneByUsername($username))
					{
						if ($model->getAuthenticationAttemptCount() < 10)
						{
							$model->registerUnsuccessfulLoginAttempt();

							if ($model->verifyPassword($password))
							{
								$model->resetUnsuccessfulLoginAttempts();

								if ($model->isRegistrationConfirmed())
								{
									if ($model->isUnblocked())
									{
										if ($this->signInBy($model))
										{
											return true;
										}
										else throw new RuntimeException(
											fenric()->t('user', 'authentication.error.save')
										);
									}
									else throw new RuntimeException(
										fenric()->t('user', 'authentication.error.account.blocked', [
											'from' => $model->getBanFrom()->format('d.m.Y H:i:s P'),
											'until' => $model->getBanUntil()->format('d.m.Y H:i:s P'),
											'reason' => $model->getBanReason(),
										])
									);
								}
								else throw new RuntimeException(
									fenric()->t('user', 'authentication.error.account.unverified')
								);
							}
							else throw new RuntimeException(
								fenric()->t('user', 'authentication.error.password.unverified')
							);
						}
						else throw new RuntimeException(
							fenric()->t('user', 'authentication.error.unsuccessful.attempts', [
								'maxAttempts' => 10,
							])
						);
					}
					else throw new RuntimeException(
						fenric()->t('user', 'authentication.error.username.undefined')
					);
				}
				else throw new RuntimeException(
					fenric()->t('user', 'authentication.error.password.incorrect', [
						'minLength' => 6,
						'maxLength' => 256,
					])
				);
			}
			else throw new RuntimeException(
				fenric()->t('user', 'authentication.error.username.incorrect', [
					'minLength' => 2,
					'maxLength' => 48,
				])
			);
		}
		else throw new RuntimeException(
			fenric()->t('user', 'authentication.error.session.unstarted')
		);

		return false;
	}

	/**
	 * Авторизация учетной записи по модели
	 */
	public function signInBy(Model $model) : bool
	{
		$model->setAuthenticationAt(new DateTime('now'));

		$model->setAuthenticationIp(ip());

		$model->setAuthenticationKey(fenric('session')->getId());

		$model->setAuthenticationAttemptCount(0);

		if ($model->save() > 0)
		{
			fenric('session')->set('user.id', $model->getId());

			$this->model = $model;

			return true;
		}

		return false;
	}

	/**
	 * Разавторизация учетной записи
	 */
	public function signOut() : void
	{
		if ($this->model instanceof Model)
		{
			// Lazy load columns, see schema...
			$this->model->getAuthenticationKey();
			$this->model->getAuthenticationToken();

			$this->model->setAuthenticationKey(null);
			$this->model->setAuthenticationToken(null);
			$this->model->setAuthenticationTokenAt(null);
			$this->model->setAuthenticationTokenIp(null);

			$this->model->save();
			$this->model = null;

			fenric('session')->remove('user.id');
			fenric('session')->restart();
		}
	}

	/**
	 * Является ли учетная запись авторизованной
	 */
	public function isLogged() : bool
	{
		if ($this->model instanceof Model)
		{
			if (strcmp($this->model->getAuthenticationKey(), fenric('session')->getId()) === 0)
			{
				return true;
			}
		}

		return false;
	}

	/**
	 * Является ли пользователь гостем
	 */
	public function isGuest() : bool
	{
		return ! $this->isLogged();
	}

	/**
	 * Работа с моделью учетной записи через экземпляр текущего класса
	 */
	public function __call(string $method, array $arguments)
	{
		if ($this->model instanceof Model)
		{
			return $this->model->{$method}(...$arguments);
		}

		throw new BadMethodCallException(
			sprintf('Call to undefined method %s::%s()', get_class($this), $method)
		);
	}
}
