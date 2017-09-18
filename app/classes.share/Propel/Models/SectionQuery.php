<?php

namespace Propel\Models;

use Propel\Models\Base\SectionQuery as BaseSectionQuery;
use Propel\Models\Map\SectionTableMap;

/**
 * Skeleton subclass for performing query and update operations on the 'section' table.
 *
 * You should add additional methods to this class to meet the application requirements.
 * This class will only be generated as long as it does not already exist in the output directory.
 */
class SectionQuery extends BaseSectionQuery
{

	/**
	 * Проверка существования объекта по символьному коду
	 */
	public static function existsByCode(string $code) : bool
	{
		$query = fenric('query')
			->select(SectionTableMap::COL_ID)
			->from(SectionTableMap::TABLE_NAME)
			->where(SectionTableMap::COL_CODE, '=', $code);

		return $query->readOne() ? true : false;
	}
}
