<?php

namespace Propel\Models;

use Propel\Models\Base\PollQuery as BasePollQuery;
use Propel\Models\Map\PollTableMap;

/**
 * Skeleton subclass for performing query and update operations on the 'fenric_poll' table.
 *
 * You should add additional methods to this class to meet the application requirements.
 * This class will only be generated as long as it does not already exist in the output directory.
 */
class PollQuery extends BasePollQuery
{

	/**
	 * Получение случайного символьного кода
	 */
	public static function getRandomCode() : ?string
	{
		return fenric('query')
			->select(PollTableMap::COL_CODE)
			->from(PollTableMap::TABLE_NAME)
			->rand()
		->readOne();
	}
}
