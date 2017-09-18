<?php

namespace Propel\Models;

use DateTime;
use Propel\Models\Base\PublicationQuery as BasePublicationQuery;
use Propel\Models\Map\PublicationTableMap;
use Propel\Models\Map\PublicationTagTableMap;
use Propel\Models\Map\SectionTableMap;
use Propel\Models\Map\TagTableMap;
use Propel\Runtime\ActiveQuery\Criteria;

/**
 * Skeleton subclass for performing query and update operations on the 'publication' table.
 *
 * You should add additional methods to this class to meet the application requirements.
 * This class will only be generated as long as it does not already exist in the output directory.
 */
class PublicationQuery extends BasePublicationQuery
{

	/**
	 * Проверка существования объекта по символьному коду
	 */
	public static function existsByCode(string $publicationCode) : bool
	{
		$query = fenric('query')
			->select(PublicationTableMap::COL_ID)
			->from(PublicationTableMap::TABLE_NAME)
			->where(PublicationTableMap::COL_CODE, '=', $publicationCode);

		return $query->readOne() ? true : false;
	}

	/**
	 * Проверка вложенности объекта по символьным кодам раздела и публикации
	 */
	public static function checkNestingByCode(string $publicationCode, string $sectionCode) : bool
	{
		$query = fenric('query')
			->select(PublicationTableMap::COL_ID)
			->from(PublicationTableMap::TABLE_NAME)
			->inner()->join(SectionTableMap::TABLE_NAME)
			->on(PublicationTableMap::COL_SECTION_ID, '=', SectionTableMap::COL_ID)
			->where(PublicationTableMap::COL_CODE, '=', $publicationCode)
			->where(SectionTableMap::COL_CODE, '=', $sectionCode);

		return $query->readOne() ? true : false;
	}

	/**
	 * Проверка модифицированности объекта по символьному коду
	 */
	public static function checkModifiedByCode(string $publicationCode, int $timestamp) : bool
	{
		$datetime = new DateTime(fenric('query')
			->select(PublicationTableMap::COL_UPDATED_AT)
			->from(PublicationTableMap::TABLE_NAME)
			->where(PublicationTableMap::COL_CODE, '=', $publicationCode)
		->readOne());

		return $datetime->getTimestamp() > $timestamp;
	}

	/**
	 * Поиск объектов
	 */
	public static function search(string $searchQuery, int $maxWords = 16, int $maxWordLength = 32) : ?self
	{
		$words = explode(' ', $searchQuery);

		$words = array_map(function($word) use($maxWordLength) : string
		{
			return searchable($word, $maxWordLength, '%');

		}, $words);

		if ($words = array_filter($words))
		{
			$words = array_unique($words);

			$query = PublicationQuery::create();

			$subquery = fenric('query');
			$subquery->select(PublicationTagTableMap::COL_PUBLICATION_ID);
			$subquery->from(PublicationTagTableMap::TABLE_NAME);
			$subquery->inner->join(TagTableMap::TABLE_NAME);
			$subquery->on(PublicationTagTableMap::COL_TAG_ID, '=', TagTableMap::COL_ID);

			foreach ($words as $i => $word)
			{
				if ($i === $maxWords - 1) {
					break;
				}

				$query->_or()->filterByHeader(sprintf('%%%s%%', $word), Criteria::LIKE);

				$subquery->or->where(TagTableMap::COL_HEADER, 'like', function() use($word)
				{
					return sprintf("'%%%s%%'", $word);
				});
			}

			$query->_or()->filterById(sprintf('publication.id IN (%s)', $subquery->getSql()), Criteria::CUSTOM);

			$query->filterByShowAt(null)->_or()->filterByShowAt(new DateTime('now'), Criteria::LESS_EQUAL);
			$query->filterByHideAt(null)->_or()->filterByHideAt(new DateTime('now'), Criteria::GREATER_EQUAL);

			return $query;
		}

		return null;
	}
}
