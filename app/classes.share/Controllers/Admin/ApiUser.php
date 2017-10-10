<?php

namespace Fenric\Controllers\Admin;

/**
 * Import classes
 */
use Propel\Models\User;
use Propel\Models\UserQuery;
use Propel\Models\Map\UserTableMap;
use Propel\Runtime\ActiveQuery\Criteria;
use Fenric\Controllers\Abstractable\CRUD;

/**
 * ApiUser
 */
class ApiUser extends CRUD
{

	/**
	 * Доступ к контроллеру
	 */
	use Access;

	/**
	 * Создание объекта
	 */
	protected function actionCreateViaPOST() : void
	{
		parent::create(new User(), [
			UserTableMap::COL_ROLE => $this->request->post->get('role'),
			UserTableMap::COL_EMAIL => $this->request->post->get('email'),
			UserTableMap::COL_USERNAME => $this->request->post->get('username'),
			UserTableMap::COL_PASSWORD => $this->request->post->get('password'),
			UserTableMap::COL_PHOTO => $this->request->post->get('photo'),
			UserTableMap::COL_FIRSTNAME => $this->request->post->get('firstname'),
			UserTableMap::COL_LASTNAME => $this->request->post->get('lastname'),
			UserTableMap::COL_GENDER => $this->request->post->get('gender'),
			UserTableMap::COL_BIRTHDAY => $this->request->post->get('birthday'),
			UserTableMap::COL_ABOUT => $this->request->post->get('about'),
			UserTableMap::COL_BAN_FROM => $this->request->post->get('ban_from'),
			UserTableMap::COL_BAN_UNTIL => $this->request->post->get('ban_until'),
			UserTableMap::COL_BAN_REASON => $this->request->post->get('ban_reason'),
		]);
	}

	/**
	 * Обновление объекта
	 */
	protected function actionUpdateViaPATCH() : void
	{
		fenric()->callSharedService('event', [self::EVENT_BEFORE_VALIDATE])->subscribe(function(User $user)
		{
			// Load password.
			$user->getPassword();

			if (strlen($this->request->post->get('password')) > 0) {
				$user->setPassword($this->request->post->get('password'));
			}
		});

		parent::update(UserQuery::create(), [
			UserTableMap::COL_ROLE => $this->request->post->get('role'),
			UserTableMap::COL_EMAIL => $this->request->post->get('email'),
			UserTableMap::COL_USERNAME => $this->request->post->get('username'),
			UserTableMap::COL_PHOTO => $this->request->post->get('photo'),
			UserTableMap::COL_FIRSTNAME => $this->request->post->get('firstname'),
			UserTableMap::COL_LASTNAME => $this->request->post->get('lastname'),
			UserTableMap::COL_GENDER => $this->request->post->get('gender'),
			UserTableMap::COL_BIRTHDAY => $this->request->post->get('birthday'),
			UserTableMap::COL_ABOUT => $this->request->post->get('about'),
			UserTableMap::COL_BAN_FROM => $this->request->post->get('ban_from'),
			UserTableMap::COL_BAN_UNTIL => $this->request->post->get('ban_until'),
			UserTableMap::COL_BAN_REASON => $this->request->post->get('ban_reason'),
		]);
	}

	/**
	 * Удаление объекта
	 */
	protected function actionDeleteViaDELETE() : void
	{
		$p = $this->request->parameters;

		$id = $p->get(self::ID_PARAMETER_NAME);

		// Предотвращение удаления своей учетной записи
		if (strcmp(fenric('user')->getId(), $id) === 0) {
			return;
		}

		parent::delete(UserQuery::create());
	}

	/**
	 * Чтение объекта
	 */
	protected function actionReadViaGET() : void
	{
		parent::read(UserQuery::create(), [
			UserTableMap::COL_ID,
			UserTableMap::COL_ROLE,
			UserTableMap::COL_EMAIL,
			UserTableMap::COL_USERNAME,

			UserTableMap::COL_PHOTO,
			UserTableMap::COL_FIRSTNAME,
			UserTableMap::COL_LASTNAME,
			UserTableMap::COL_GENDER,
			UserTableMap::COL_BIRTHDAY,
			UserTableMap::COL_ABOUT,

			UserTableMap::COL_BAN_FROM,
			UserTableMap::COL_BAN_UNTIL,
			UserTableMap::COL_BAN_REASON,
		]);
	}

	/**
	 * Выгрузка объектов
	 */
	protected function actionAllViaGET() : void
	{
		fenric()->callSharedService('event', [self::EVENT_PREPARE_ITEM])->subscribe(function(User $user, array & $json)
		{
			$json['uri'] = $user->getUri();

			$json['online'] = $user->isOnline();
			$json['offline'] = $user->isOffline();

			$json['blocked'] = $user->isBlocked();
			$json['unblocked'] = $user->isUnblocked();

			if ($user->getAge() instanceof \DateInterval) {
				$json['age'] = $user->getAge()->y;
			}
		});

		$query = UserQuery::create();
		$query->orderById(Criteria::DESC);

		parent::all($query, [
			UserTableMap::COL_ID,
			UserTableMap::COL_ROLE,
			UserTableMap::COL_EMAIL,
			UserTableMap::COL_USERNAME,

			UserTableMap::COL_PHOTO,
			UserTableMap::COL_FIRSTNAME,
			UserTableMap::COL_LASTNAME,
			UserTableMap::COL_GENDER,
			UserTableMap::COL_BIRTHDAY,

			UserTableMap::COL_REGISTRATION_AT,
			UserTableMap::COL_REGISTRATION_IP,

			UserTableMap::COL_REGISTRATION_CONFIRMED,
			UserTableMap::COL_REGISTRATION_CONFIRMED_AT,
			UserTableMap::COL_REGISTRATION_CONFIRMED_IP,

			UserTableMap::COL_AUTHENTICATION_AT,
			UserTableMap::COL_AUTHENTICATION_IP,

			UserTableMap::COL_TRACK_AT,
			UserTableMap::COL_TRACK_IP,
			UserTableMap::COL_TRACK_URL,

			UserTableMap::COL_BAN_FROM,
			UserTableMap::COL_BAN_UNTIL,
			UserTableMap::COL_BAN_REASON,
		]);
	}

	/**
	 * Простая выгрузка объектов
	 */
	protected function actionUnloadViaGET() : void
	{
		$this->response->setJsonContent(
			fenric('query')
				->select(UserTableMap::COL_ID)
				->select(UserTableMap::COL_USERNAME)
				->from(UserTableMap::TABLE_NAME)
				->toArray()
		);
	}
}
