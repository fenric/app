<?php

namespace Propel\Models;

use DateTime;
use Propel\Models\Base\PublicationQuery as BasePublicationQuery;
use Propel\Models\Map\FieldTableMap;
use Propel\Models\Map\PublicationTableMap;
use Propel\Models\Map\PublicationFieldTableMap;
use Propel\Models\Map\PublicationTagTableMap;
use Propel\Models\Map\SectionTableMap;
use Propel\Models\Map\SectionFieldTableMap;
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
	 * Режимы фильтрации публикаций для поиска
	 */
	const SEARCH_FILTER_MAX = -1;
	const SEARCH_FILTER_TAGS = 0x2;
	const SEARCH_FILTER_FIELDS = 0x4;
	const SEARCH_FILTER_DISPLAY = 0x8;

	/**
	 * Проверка существования объекта по символьному коду
	 */
	public static function existsByCode(string $code) : bool
	{
		return fenric('query')
			->select(PublicationTableMap::COL_ID)
			->from(PublicationTableMap::TABLE_NAME)
			->where(PublicationTableMap::COL_CODE, '=', $code)
		->readOne() ? true : false;
	}

	/**
	 * Проверка вложенности объекта по символьным кодам раздела и публикации
	 */
	public static function checkNestingByCode(string $pcode, string $scode) : bool
	{
		return fenric('query')
			->select(PublicationTableMap::COL_ID)
			->from(PublicationTableMap::TABLE_NAME)
			->inner()->join(SectionTableMap::TABLE_NAME)
			->on(PublicationTableMap::COL_SECTION_ID, '=', SectionTableMap::COL_ID)
			->where(PublicationTableMap::COL_CODE, '=', $pcode)
			->where(SectionTableMap::COL_CODE, '=', $scode)
		->readOne() ? true : false;
	}

	/**
	 * Проверка модифицированности объекта по символьному коду
	 */
	public static function checkModifiedByCode(string $code, int $timestamp) : bool
	{
		$datetime = new DateTime(fenric('query')
			->select(PublicationTableMap::COL_UPDATED_AT)
			->from(PublicationTableMap::TABLE_NAME)
			->where(PublicationTableMap::COL_CODE, '=', $code)
		->readOne());

		return $datetime->getTimestamp() > $timestamp;
	}

	/**
	 * Поиск объектов
	 */
	public static function search(string $searchQuery, int $searchFilter = self::SEARCH_FILTER_MAX, int $maxWords = 8, int $minWordLength = 2, int $maxWordLength = 32) : ?self
	{
		if (strlen($searchQuery) > 0)
		{
			$searchWords = explode(' ', $searchQuery);

			$searchWords = array_map(function($searchWord) use($maxWordLength) : string
			{
				return searchable($searchWord, $maxWordLength, '%');

			}, $searchWords);

			$searchWords = array_filter($searchWords, function($searchWord) use($minWordLength) : bool
			{
				return mb_strlen($searchWord, 'UTF-8') >= $minWordLength;
			});

			if (count($searchWords) > 0)
			{
				$searchWords = array_unique($searchWords);

				$searchWords = array_slice($searchWords, 0, $maxWords);

				$tagsSubquery = fenric('query')->distinct(true)
				->select(PublicationTagTableMap::COL_PUBLICATION_ID)
				->from(PublicationTagTableMap::TABLE_NAME)
				->inner()->join(TagTableMap::TABLE_NAME)
				->on(PublicationTagTableMap::COL_TAG_ID, '=', TagTableMap::COL_ID);

				$fieldsSubquery = fenric('query')->distinct(true)
				->select(PublicationFieldTableMap::COL_PUBLICATION_ID)
				->from(PublicationFieldTableMap::TABLE_NAME)
				->inner()->join(SectionFieldTableMap::TABLE_NAME)
				->on(SectionFieldTableMap::COL_ID, '=', PublicationFieldTableMap::COL_SECTION_FIELD_ID)
				->inner()->join(FieldTableMap::TABLE_NAME)
				->on(FieldTableMap::COL_ID, '=', SectionFieldTableMap::COL_FIELD_ID)
				->where(FieldTableMap::COL_IS_SEARCHABLE, '=', true)
				->where(FieldTableMap::COL_TYPE, '=', function() : string
				{
					return sprintf("'%s'", 'string');
				})
				->and_open();

				$publications = PublicationQuery::create();

				foreach ($searchWords as $searchWord)
				{
					$tagsSubquery->where(TagTableMap::COL_CODE, 'like', function() use($searchWord) : string
					{
						return sprintf("'%%%s%%'", $searchWord);

					})->or_();

					$tagsSubquery->where(TagTableMap::COL_HEADER, 'like', function() use($searchWord) : string
					{
						return sprintf("'%%%s%%'", $searchWord);

					})->or_();

					$fieldsSubquery->where(PublicationFieldTableMap::COL_STRING_VALUE, 'like', function() use($searchWord) : string
					{
						return sprintf("'%%%s%%'", $searchWord);

					})->or_();

					$publications->_or()->filterByCode(sprintf('%%%s%%', $searchWord), Criteria::LIKE);
					$publications->_or()->filterByHeader(sprintf('%%%s%%', $searchWord), Criteria::LIKE);
				}

				if ($searchFilter & self::SEARCH_FILTER_TAGS)
				{
					$publications->_or()->filterById(sprintf('%s IN (%s)', PublicationTableMap::COL_ID, $tagsSubquery->getSql()), Criteria::CUSTOM);
				}

				if ($searchFilter & self::SEARCH_FILTER_FIELDS)
				{
					$publications->_or()->filterById(sprintf('%s IN (%s)', PublicationTableMap::COL_ID, $fieldsSubquery->getSql()), Criteria::CUSTOM);
				}

				if ($searchFilter & self::SEARCH_FILTER_DISPLAY)
				{
					$publications->filterByShowAt(null)->_or()->filterByShowAt(new DateTime('now'), Criteria::LESS_EQUAL);
					$publications->filterByHideAt(null)->_or()->filterByHideAt(new DateTime('now'), Criteria::GREATER_EQUAL);
				}

				return $publications;
			}
		}

		return null;
	}
}
