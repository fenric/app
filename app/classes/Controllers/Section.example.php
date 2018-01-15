<?php

namespace Fenric\Controllers;

/**
 * Import classes
 */
use DateTime;

use Propel\Models\Map\PublicationTableMap;
use Propel\Models\Map\PublicationFieldTableMap;
use Propel\Models\Map\PublicationTagTableMap;
use Propel\Models\Map\TagTableMap;

use Propel\Models\PublicationQuery;
use Propel\Models\SectionQuery;
use Propel\Models\TagQuery;

use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\ObjectCollection;

use Fenric\Controllers\Abstractable\Abstractable;

/**
 * Section
 */
class Section extends Abstractable
{

	/**
	 * Предварительная инициализация контроллера
	 */
	public function preInit() : bool
	{
		if (! SectionQuery::existsByCode($this->request->parameters->get('section')))
		{
			$this->response->status(\Fenric\Response::STATUS_404);

			return false;
		}

		if ($this->request->parameters->exists('tag'))
		{
			if (! TagQuery::existsByCode($this->request->parameters->get('tag')))
			{
				$this->response->status(\Fenric\Response::STATUS_404);

				return false;
			}
		}

		if ($this->request->query->exists('tags'))
		{
			if (! is_array($this->request->query->get('tags')))
			{
				$this->response->status(\Fenric\Response::STATUS_400);

				return false;
			}
		}

		if ($this->request->query->exists('q'))
		{
			if (! is_string($this->request->query->get('q')))
			{
				$this->response->status(\Fenric\Response::STATUS_400);

				return false;
			}
		}

		if ($this->request->query->exists('page'))
		{
			if (! ctype_digit($this->request->query->get('page')))
			{
				$this->response->status(\Fenric\Response::STATUS_400);

				return false;
			}
		}

		if ($this->request->query->exists('limit'))
		{
			if (! ctype_digit($this->request->query->get('limit')))
			{
				$this->response->status(\Fenric\Response::STATUS_400);

				return false;
			}
		}

		return true;
	}

	/**
	 * Рендеринг контроллера
	 */
	public function render() : void
	{
		$tag = null;
		$page = 1;
		$limit = 25;

		$section = SectionQuery::create()->findOneByCode(
			$this->request->parameters->get('section')
		);

		if ($this->request->parameters->exists('tag'))
		{
			$tag = TagQuery::create()->findOneByCode(
				$this->request->parameters->get('tag')
			);
		}

		if ($this->request->query->exists('page'))
		{
			if ($this->request->query->get('page') >= 1)
			{
				if ($this->request->query->get('page') <= PHP_INT_MAX)
				{
					$page = $this->request->query->get('page');
				}
			}
		}

		if ($this->request->query->exists('limit'))
		{
			if ($this->request->query->get('limit') >= 1)
			{
				if ($this->request->query->get('limit') <= 100)
				{
					$limit = $this->request->query->get('limit');
				}
			}
		}

		$publications = PublicationQuery::create();

		if ($this->request->query->exists('q'))
		{
			$publications = PublicationQuery::search($this->request->query->get('q'),
				PublicationQuery::SEARCH_FILTER_MAX ^ PublicationQuery::SEARCH_FILTER_DISPLAY
			) ?: $publications;
		}

		$publications->innerJoinSection();
		$publications->filterBySection($section);

		$publications->filterByShowAt(null)->_or()
			->filterByShowAt(new DateTime('now'), Criteria::LESS_EQUAL);

		$publications->filterByHideAt(null)->_or()
			->filterByHideAt(new DateTime('now'), Criteria::GREATER_EQUAL);

		$publications->orderByCreatedAt(Criteria::DESC);

		if ($tag instanceof ActiveRecordInterface)
		{
			$publications->filterById(sprintf('%s IN (%s)', PublicationTableMap::COL_ID, fenric('query')
				->distinct(true)
				->select(PublicationTagTableMap::COL_PUBLICATION_ID)
				->from(PublicationTagTableMap::TABLE_NAME)
				->where(PublicationTagTableMap::COL_TAG_ID, '=', $tag->getId())
			->getSql()), Criteria::CUSTOM);
		}

		if ($this->request->query->exists('tags'))
		{
			$tags = array_filter($this->request->query->get('tags'), function($tag) : bool
			{
				return ctype_digit($tag);
			});

			if (count($tags) > 0)
			{
				$publications->filterById(sprintf('%s IN (%s)', PublicationTableMap::COL_ID, fenric('query')
					->distinct(true)
					->select(PublicationTagTableMap::COL_PUBLICATION_ID)
					->from(PublicationTagTableMap::TABLE_NAME)
					->where(PublicationTagTableMap::COL_TAG_ID, 'IN', $tags)
				->getSql()), Criteria::CUSTOM);
			}
		}

		if ($section->getSectionFields() instanceof ObjectCollection)
		{
			if ($section->getSectionFields()->count() > 0)
			{
				foreach ($section->getSectionFields() as $sfield)
				{
					if ($sfield->getField() instanceof ActiveRecordInterface)
					{
						if ($sfield->getField()->isSearchable())
						{
							if ($this->request->query->exists($sfield->getField()->getName()))
							{
								if (is_array($this->request->query->get($sfield->getField()->getName())))
								{
									if (count($this->request->query->get($sfield->getField()->getName())) > 0)
									{
										if ($sfield->getField()->isNumber()) {
											$values = array_filter($this->request->query->get($sfield->getField()->getName()), function($value) use($sfield) : bool {
												return $sfield->getField()->isValidNumber($value);
											});
										}
										if ($sfield->getField()->isYear()) {
											$values = array_filter($this->request->query->get($sfield->getField()->getName()), function($value) use($sfield) : bool {
												return $sfield->getField()->isValidYear($value);
											});
										}
										if ($sfield->getField()->isDate()) {
											$values = array_filter($this->request->query->get($sfield->getField()->getName()), function($value) use($sfield) : bool {
												return $sfield->getField()->isValidDate($value);
											});
										}
										if ($sfield->getField()->isDateTime()) {
											$values = array_filter($this->request->query->get($sfield->getField()->getName()), function($value) use($sfield) : bool {
												return $sfield->getField()->isValidDateTime($value);
											});
										}
										if ($sfield->getField()->isTime()) {
											$values = array_filter($this->request->query->get($sfield->getField()->getName()), function($value) use($sfield) : bool {
												return $sfield->getField()->isValidTime($value);
											});
										}
										if ($sfield->getField()->isIp()) {
											$values = array_filter($this->request->query->get($sfield->getField()->getName()), function($value) use($sfield) : bool {
												return $sfield->getField()->isValidIp($value);
											});
										}
										if ($sfield->getField()->isEmail()) {
											$values = array_filter($this->request->query->get($sfield->getField()->getName()), function($value) use($sfield) : bool {
												return $sfield->getField()->isValidEmail($value);
											});
										}
										if ($sfield->getField()->isString()) {
											$values = array_filter($this->request->query->get($sfield->getField()->getName()), function($value) use($sfield) : bool {
												return strlen(trim($value)) > 0 && $sfield->getField()->isValidByRegex($value);
											});
										}

										$values = array_slice($values, 0, 16);

										if (isset($values))
										{
											if (count($values) > 0)
											{
												$publications->filterById(sprintf('%s IN (%s)', PublicationTableMap::COL_ID, fenric('query')->distinct(true)
													->select(PublicationFieldTableMap::COL_PUBLICATION_ID)
													->from(PublicationFieldTableMap::TABLE_NAME)
													->where(PublicationFieldTableMap::COL_SECTION_FIELD_ID, '=', $sfield->getId())
													->where($sfield->getField()->getPublicationValueColumn(), 'IN', array_map(function($value) : \Closure {
														return function(\Fenric\Query $q) use($value) : string {
															return $q->getPdo()->quote($value);
														};
													}, $values))
												->getSql()), Criteria::CUSTOM);
											}
										}
									}

									continue;
								}
							}

							if ($this->request->query->exists($sfield->getField()->getName()))
							{
								if (is_string($this->request->query->get($sfield->getField()->getName())))
								{
									if (strlen(trim($this->request->query->get($sfield->getField()->getName()))) > 0)
									{
										if ($sfield->getField()->isFlag())
										{
											if ($sfield->getField()->isValidFlag($this->request->query->get($sfield->getField()->getName())))
											{
												if (strcmp($this->request->query->get($sfield->getField()->getName()), '1') === 0)
												{
													$publications->filterById(sprintf('%s IN (%s)', PublicationTableMap::COL_ID, fenric('query')->distinct(true)
														->select(PublicationFieldTableMap::COL_PUBLICATION_ID)
														->from(PublicationFieldTableMap::TABLE_NAME)
														->where(PublicationFieldTableMap::COL_SECTION_FIELD_ID, '=', $sfield->getId())
														->where($sfield->getField()->getPublicationValueColumn(), '=', true)
													->getSql()), Criteria::CUSTOM);
												}
											}
										}
										if ($sfield->getField()->isNumber())
										{
											if ($sfield->getField()->isValidNumber($this->request->query->get($sfield->getField()->getName())))
											{
												$publications->filterById(sprintf('%s IN (%s)', PublicationTableMap::COL_ID, fenric('query')->distinct(true)
													->select(PublicationFieldTableMap::COL_PUBLICATION_ID)
													->from(PublicationFieldTableMap::TABLE_NAME)
													->where(PublicationFieldTableMap::COL_SECTION_FIELD_ID, '=', $sfield->getId())
													->where($sfield->getField()->getPublicationValueColumn(), '=', function(\Fenric\Query $q) use($sfield) : string {
														return $q->getPdo()->quote($this->request->query->get($sfield->getField()->getName()));
													})
												->getSql()), Criteria::CUSTOM);
											}
										}
										if ($sfield->getField()->isYear())
										{
											if ($sfield->getField()->isValidYear($this->request->query->get($sfield->getField()->getName())))
											{
												$publications->filterById(sprintf('%s IN (%s)', PublicationTableMap::COL_ID, fenric('query')->distinct(true)
													->select(PublicationFieldTableMap::COL_PUBLICATION_ID)
													->from(PublicationFieldTableMap::TABLE_NAME)
													->where(PublicationFieldTableMap::COL_SECTION_FIELD_ID, '=', $sfield->getId())
													->where(function() use($sfield) : string {
														return sprintf('DATE_FORMAT(%s, "%%Y")', $sfield->getField()->getPublicationValueColumn());
													}, '=', function(\Fenric\Query $q) use($sfield) : string {
														return $q->getPdo()->quote($this->request->query->get($sfield->getField()->getName()));
													})
												->getSql()), Criteria::CUSTOM);
											}
										}
										if ($sfield->getField()->isDate())
										{
											if ($sfield->getField()->isValidDate($this->request->query->get($sfield->getField()->getName())))
											{
												$publications->filterById(sprintf('%s IN (%s)', PublicationTableMap::COL_ID, fenric('query')->distinct(true)
													->select(PublicationFieldTableMap::COL_PUBLICATION_ID)
													->from(PublicationFieldTableMap::TABLE_NAME)
													->where(PublicationFieldTableMap::COL_SECTION_FIELD_ID, '=', $sfield->getId())
													->where(function() use($sfield) : string {
														return sprintf('DATE_FORMAT(%s, "%%Y-%%m-%%d")', $sfield->getField()->getPublicationValueColumn());
													}, '=', function(\Fenric\Query $q) use($sfield) : string {
														return $q->getPdo()->quote($this->request->query->get($sfield->getField()->getName()));
													})
												->getSql()), Criteria::CUSTOM);
											}
										}
										if ($sfield->getField()->isDateTime())
										{
											if ($sfield->getField()->isValidDateTime($this->request->query->get($sfield->getField()->getName())))
											{
												$publications->filterById(sprintf('%s IN (%s)', PublicationTableMap::COL_ID, fenric('query')->distinct(true)
													->select(PublicationFieldTableMap::COL_PUBLICATION_ID)
													->from(PublicationFieldTableMap::TABLE_NAME)
													->where(PublicationFieldTableMap::COL_SECTION_FIELD_ID, '=', $sfield->getId())
													->where(function() use($sfield) : string {
														return sprintf('DATE_FORMAT(%s, "%%Y-%%m-%%d %%H:%%i")', $sfield->getField()->getPublicationValueColumn());
													}, '=', function(\Fenric\Query $q) use($sfield) : string {
														return $q->getPdo()->quote($this->request->query->get($sfield->getField()->getName()));
													})
												->getSql()), Criteria::CUSTOM);
											}
										}
										if ($sfield->getField()->isTime())
										{
											if ($sfield->getField()->isValidTime($this->request->query->get($sfield->getField()->getName())))
											{
												$publications->filterById(sprintf('%s IN (%s)', PublicationTableMap::COL_ID, fenric('query')->distinct(true)
													->select(PublicationFieldTableMap::COL_PUBLICATION_ID)
													->from(PublicationFieldTableMap::TABLE_NAME)
													->where(PublicationFieldTableMap::COL_SECTION_FIELD_ID, '=', $sfield->getId())
													->where(function() use($sfield) : string {
														return sprintf('DATE_FORMAT(%s, "%%H:%%i")', $sfield->getField()->getPublicationValueColumn());
													}, '=', function(\Fenric\Query $q) use($sfield) : string {
														return $q->getPdo()->quote($this->request->query->get($sfield->getField()->getName()));
													})
												->getSql()), Criteria::CUSTOM);
											}
										}
										if ($sfield->getField()->isIp())
										{
											if ($sfield->getField()->isValidIp($this->request->query->get($sfield->getField()->getName())))
											{
												$publications->filterById(sprintf('%s IN (%s)', PublicationTableMap::COL_ID, fenric('query')->distinct(true)
													->select(PublicationFieldTableMap::COL_PUBLICATION_ID)
													->from(PublicationFieldTableMap::TABLE_NAME)
													->where(PublicationFieldTableMap::COL_SECTION_FIELD_ID, '=', $sfield->getId())
													->where($sfield->getField()->getPublicationValueColumn(), '=', function(\Fenric\Query $q) use($sfield) : string {
														return $q->getPdo()->quote($this->request->query->get($sfield->getField()->getName()));
													})
												->getSql()), Criteria::CUSTOM);
											}
										}
										if ($sfield->getField()->isEmail())
										{
											if ($sfield->getField()->isValidEmail($this->request->query->get($sfield->getField()->getName())))
											{
												$publications->filterById(sprintf('%s IN (%s)', PublicationTableMap::COL_ID, fenric('query')->distinct(true)
													->select(PublicationFieldTableMap::COL_PUBLICATION_ID)
													->from(PublicationFieldTableMap::TABLE_NAME)
													->where(PublicationFieldTableMap::COL_SECTION_FIELD_ID, '=', $sfield->getId())
													->where($sfield->getField()->getPublicationValueColumn(), '=', function(\Fenric\Query $q) use($sfield) : string {
														return $q->getPdo()->quote($this->request->query->get($sfield->getField()->getName()));
													})
												->getSql()), Criteria::CUSTOM);
											}
										}
										if ($sfield->getField()->isString())
										{
											if (strlen($sfield->getField()->getValidationRegex()) > 0)
											{
												if ($sfield->getField()->isValidByRegex($this->request->query->get($sfield->getField()->getName())))
												{
													$publications->filterById(sprintf('%s IN (%s)', PublicationTableMap::COL_ID, fenric('query')->distinct(true)
														->select(PublicationFieldTableMap::COL_PUBLICATION_ID)
														->from(PublicationFieldTableMap::TABLE_NAME)
														->where(PublicationFieldTableMap::COL_SECTION_FIELD_ID, '=', $sfield->getId())
														->where($sfield->getField()->getPublicationValueColumn(), '=', function(\Fenric\Query $q) use($sfield) : string {
															return $q->getPdo()->quote($this->request->query->get($sfield->getField()->getName()));
														})
													->getSql()), Criteria::CUSTOM);
												}
											}

											if (strlen($sfield->getField()->getValidationRegex()) === 0)
											{
												if (strlen($value = searchable($this->request->query->get($sfield->getField()->getName()), 64, '%')) > 0)
												{
													$publications->filterById(sprintf('%s IN (%s)', PublicationTableMap::COL_ID, fenric('query')->distinct(true)
														->select(PublicationFieldTableMap::COL_PUBLICATION_ID)
														->from(PublicationFieldTableMap::TABLE_NAME)
														->where(PublicationFieldTableMap::COL_SECTION_FIELD_ID, '=', $sfield->getId())
														->where($sfield->getField()->getPublicationValueColumn(), 'LIKE', function(\Fenric\Query $q) use($value) : string {
															return $q->getPdo()->quote(sprintf('%%%s%%', $value));
														})
													->getSql()), Criteria::CUSTOM);
												}
											}
										}
									}

									continue;
								}
							}

							if ($this->request->query->exists($sfield->getField()->getNameWithPostfix('_min')))
							{
								if (is_string($this->request->query->get($sfield->getField()->getNameWithPostfix('_min'))))
								{
									if (strlen(trim($this->request->query->exists($sfield->getField()->getNameWithPostfix('_min')))) > 0)
									{
										if ($sfield->getField()->isNumber())
										{
											if ($sfield->getField()->isValidNumber($this->request->query->get($sfield->getField()->getNameWithPostfix('_min'))))
											{
												$publications->filterById(sprintf('%s IN (%s)', PublicationTableMap::COL_ID, fenric('query')->distinct(true)
													->select(PublicationFieldTableMap::COL_PUBLICATION_ID)
													->from(PublicationFieldTableMap::TABLE_NAME)
													->where(PublicationFieldTableMap::COL_SECTION_FIELD_ID, '=', $sfield->getId())
													->where($sfield->getField()->getPublicationValueColumn(), '>=', function(\Fenric\Query $q) use($sfield) : string {
														return $q->getPdo()->quote($this->request->query->get($sfield->getField()->getNameWithPostfix('_min')));
													})
												->getSql()), Criteria::CUSTOM);
											}
										}
										if ($sfield->getField()->isYear())
										{
											if ($sfield->getField()->isValidYear($this->request->query->get($sfield->getField()->getNameWithPostfix('_min'))))
											{
												$publications->filterById(sprintf('%s IN (%s)', PublicationTableMap::COL_ID, fenric('query')->distinct(true)
													->select(PublicationFieldTableMap::COL_PUBLICATION_ID)
													->from(PublicationFieldTableMap::TABLE_NAME)
													->where(PublicationFieldTableMap::COL_SECTION_FIELD_ID, '=', $sfield->getId())
													->where(function() use($sfield) : string {
														return sprintf('DATE_FORMAT(%s, "%%Y")', $sfield->getField()->getPublicationValueColumn());
													}, '>=', function(\Fenric\Query $q) use($sfield) : string {
														return $q->getPdo()->quote($this->request->query->get($sfield->getField()->getNameWithPostfix('_min')));
													})
												->getSql()), Criteria::CUSTOM);
											}
										}
										if ($sfield->getField()->isDate())
										{
											if ($sfield->getField()->isValidDate($this->request->query->get($sfield->getField()->getNameWithPostfix('_min'))))
											{
												$publications->filterById(sprintf('%s IN (%s)', PublicationTableMap::COL_ID, fenric('query')->distinct(true)
													->select(PublicationFieldTableMap::COL_PUBLICATION_ID)
													->from(PublicationFieldTableMap::TABLE_NAME)
													->where(PublicationFieldTableMap::COL_SECTION_FIELD_ID, '=', $sfield->getId())
													->where(function() use($sfield) : string {
														return sprintf('DATE_FORMAT(%s, "%%Y-%%m-%%d")', $sfield->getField()->getPublicationValueColumn());
													}, '>=', function(\Fenric\Query $q) use($sfield) : string {
														return $q->getPdo()->quote($this->request->query->get($sfield->getField()->getNameWithPostfix('_min')));
													})
												->getSql()), Criteria::CUSTOM);
											}
										}
										if ($sfield->getField()->isDateTime())
										{
											if ($sfield->getField()->isValidDateTime($this->request->query->get($sfield->getField()->getNameWithPostfix('_min'))))
											{
												$publications->filterById(sprintf('%s IN (%s)', PublicationTableMap::COL_ID, fenric('query')->distinct(true)
													->select(PublicationFieldTableMap::COL_PUBLICATION_ID)
													->from(PublicationFieldTableMap::TABLE_NAME)
													->where(PublicationFieldTableMap::COL_SECTION_FIELD_ID, '=', $sfield->getId())
													->where(function() use($sfield) : string {
														return sprintf('DATE_FORMAT(%s, "%%Y-%%m-%%d %%H:%%i")', $sfield->getField()->getPublicationValueColumn());
													}, '>=', function(\Fenric\Query $q) use($sfield) : string {
														return $q->getPdo()->quote($this->request->query->get($sfield->getField()->getNameWithPostfix('_min')));
													})
												->getSql()), Criteria::CUSTOM);
											}
										}
										if ($sfield->getField()->isTime())
										{
											if ($sfield->getField()->isValidTime($this->request->query->get($sfield->getField()->getNameWithPostfix('_min'))))
											{
												$publications->filterById(sprintf('%s IN (%s)', PublicationTableMap::COL_ID, fenric('query')->distinct(true)
													->select(PublicationFieldTableMap::COL_PUBLICATION_ID)
													->from(PublicationFieldTableMap::TABLE_NAME)
													->where(PublicationFieldTableMap::COL_SECTION_FIELD_ID, '=', $sfield->getId())
													->where(function() use($sfield) : string {
														return sprintf('DATE_FORMAT(%s, "%%H:%%i")', $sfield->getField()->getPublicationValueColumn());
													}, '>=', function(\Fenric\Query $q) use($sfield) : string {
														return $q->getPdo()->quote($this->request->query->get($sfield->getField()->getNameWithPostfix('_min')));
													})
												->getSql()), Criteria::CUSTOM);
											}
										}
									}
								}
							}

							if ($this->request->query->exists($sfield->getField()->getNameWithPostfix('_max')))
							{
								if (is_string($this->request->query->get($sfield->getField()->getNameWithPostfix('_max'))))
								{
									if (strlen(trim($this->request->query->exists($sfield->getField()->getNameWithPostfix('_max')))) > 0)
									{
										if ($sfield->getField()->isNumber())
										{
											if ($sfield->getField()->isValidNumber($this->request->query->get($sfield->getField()->getNameWithPostfix('_max'))))
											{
												$publications->filterById(sprintf('%s IN (%s)', PublicationTableMap::COL_ID, fenric('query')->distinct(true)
													->select(PublicationFieldTableMap::COL_PUBLICATION_ID)
													->from(PublicationFieldTableMap::TABLE_NAME)
													->where(PublicationFieldTableMap::COL_SECTION_FIELD_ID, '=', $sfield->getId())
													->where($sfield->getField()->getPublicationValueColumn(), '<=', function(\Fenric\Query $q) use($sfield) : string {
														return $q->getPdo()->quote($this->request->query->get($sfield->getField()->getNameWithPostfix('_max')));
													})
												->getSql()), Criteria::CUSTOM);
											}
										}
										if ($sfield->getField()->isYear())
										{
											if ($sfield->getField()->isValidYear($this->request->query->get($sfield->getField()->getNameWithPostfix('_max'))))
											{
												$publications->filterById(sprintf('%s IN (%s)', PublicationTableMap::COL_ID, fenric('query')->distinct(true)
													->select(PublicationFieldTableMap::COL_PUBLICATION_ID)
													->from(PublicationFieldTableMap::TABLE_NAME)
													->where(PublicationFieldTableMap::COL_SECTION_FIELD_ID, '=', $sfield->getId())
													->where(function() use($sfield) : string {
														return sprintf('DATE_FORMAT(%s, "%%Y")', $sfield->getField()->getPublicationValueColumn());
													}, '<=', function(\Fenric\Query $q) use($sfield) : string {
														return $q->getPdo()->quote($this->request->query->get($sfield->getField()->getNameWithPostfix('_max')));
													})
												->getSql()), Criteria::CUSTOM);
											}
										}
										if ($sfield->getField()->isDate())
										{
											if ($sfield->getField()->isValidDate($this->request->query->get($sfield->getField()->getNameWithPostfix('_max'))))
											{
												$publications->filterById(sprintf('%s IN (%s)', PublicationTableMap::COL_ID, fenric('query')->distinct(true)
													->select(PublicationFieldTableMap::COL_PUBLICATION_ID)
													->from(PublicationFieldTableMap::TABLE_NAME)
													->where(PublicationFieldTableMap::COL_SECTION_FIELD_ID, '=', $sfield->getId())
													->where(function() use($sfield) : string {
														return sprintf('DATE_FORMAT(%s, "%%Y-%%m-%%d")', $sfield->getField()->getPublicationValueColumn());
													}, '<=', function(\Fenric\Query $q) use($sfield) : string {
														return $q->getPdo()->quote($this->request->query->get($sfield->getField()->getNameWithPostfix('_max')));
													})
												->getSql()), Criteria::CUSTOM);
											}
										}
										if ($sfield->getField()->isDateTime())
										{
											if ($sfield->getField()->isValidDateTime($this->request->query->get($sfield->getField()->getNameWithPostfix('_max'))))
											{
												$publications->filterById(sprintf('%s IN (%s)', PublicationTableMap::COL_ID, fenric('query')->distinct(true)
													->select(PublicationFieldTableMap::COL_PUBLICATION_ID)
													->from(PublicationFieldTableMap::TABLE_NAME)
													->where(PublicationFieldTableMap::COL_SECTION_FIELD_ID, '=', $sfield->getId())
													->where(function() use($sfield) : string {
														return sprintf('DATE_FORMAT(%s, "%%Y-%%m-%%d %%H:%%i")', $sfield->getField()->getPublicationValueColumn());
													}, '<=', function(\Fenric\Query $q) use($sfield) : string {
														return $q->getPdo()->quote($this->request->query->get($sfield->getField()->getNameWithPostfix('_max')));
													})
												->getSql()), Criteria::CUSTOM);
											}
										}
										if ($sfield->getField()->isTime())
										{
											if ($sfield->getField()->isValidTime($this->request->query->get($sfield->getField()->getNameWithPostfix('_max'))))
											{
												$publications->filterById(sprintf('%s IN (%s)', PublicationTableMap::COL_ID, fenric('query')->distinct(true)
													->select(PublicationFieldTableMap::COL_PUBLICATION_ID)
													->from(PublicationFieldTableMap::TABLE_NAME)
													->where(PublicationFieldTableMap::COL_SECTION_FIELD_ID, '=', $sfield->getId())
													->where(function() use($sfield) : string {
														return sprintf('DATE_FORMAT(%s, "%%H:%%i")', $sfield->getField()->getPublicationValueColumn());
													}, '<=', function(\Fenric\Query $q) use($sfield) : string {
														return $q->getPdo()->quote($this->request->query->get($sfield->getField()->getNameWithPostfix('_max')));
													})
												->getSql()), Criteria::CUSTOM);
											}
										}
									}
								}
							}
						}
					}
				}
			}
		}

		$view = fenric('view::section');

		if (fenric(sprintf('view::sections/%s/section', $section->getCode()))->exists())
		{
			$view = fenric(sprintf('view::sections/%s/section', $section->getCode()));
		}

		$this->response->content($view->render([
			'tag' => $tag,
			'section' => $section,
			'publications' => $publications->paginate($page, $limit),
		]));
	}
}
