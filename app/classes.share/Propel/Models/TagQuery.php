<?php

namespace Propel\Models;

use Propel\Models\Base\TagQuery as BaseTagQuery;
use Propel\Models\Map\TagTableMap;

/**
 * Skeleton subclass for performing query and update operations on the 'tag' table.
 *
 * You should add additional methods to this class to meet the application requirements.
 * This class will only be generated as long as it does not already exist in the output directory.
 */
class TagQuery extends BaseTagQuery
{

	/**
	 * Проверка существования объекта по символьному коду
	 */
	public static function existsByCode(string $code) : bool
	{
		$query = fenric('query')
			->select(TagTableMap::COL_ID)
			->from(TagTableMap::TABLE_NAME)
			->where(TagTableMap::COL_CODE, '=', $code);

		return $query->readOne() ? true : false;
	}
}
