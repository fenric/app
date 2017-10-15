<?php

namespace Propel\Models;

use Propel\Models\Map\UserTableMap;
use Propel\Models\Base\UserQuery as BaseUserQuery;

/**
 * Skeleton subclass for performing query and update operations on the 'user' table.
 *
 * You should add additional methods to this class to meet the application requirements.
 * This class will only be generated as long as it does not already exist in the output directory.
 */
class UserQuery extends BaseUserQuery
{

	/**
	 * Проверка существования учетной записи по идентификатору
	 */
	public static function existsById(int $id) : bool
	{
		return fenric('query')
			->select(UserTableMap::COL_ID)
			->from(UserTableMap::TABLE_NAME)
			->where(UserTableMap::COL_ID, '=', $id)
		->readOne() ? true : false;
	}

	/**
	 * Проверка существования учетной записи по подтверждающему регистрацию коду
	 */
	public static function existsByRegistrationConfirmationCode(string $value) : bool
	{
		return fenric('query')
			->select(UserTableMap::COL_ID)
			->from(UserTableMap::TABLE_NAME)
			->where(UserTableMap::COL_REGISTRATION_CONFIRMATION_CODE, '=', $value)
		->readOne() ? true : false;
	}

	/**
	 * Проверка существования учетной записи по аутентификационному токену
	 */
	public static function existsByAuthenticationToken(string $value) : bool
	{
		return fenric('query')
			->select(UserTableMap::COL_ID)
			->from(UserTableMap::TABLE_NAME)
			->where(UserTableMap::COL_AUTHENTICATION_TOKEN, '=', $value)
		->readOne() ? true : false;
	}
}
