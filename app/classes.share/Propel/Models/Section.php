<?php

namespace Propel\Models;

use Propel\Models\Base\Section as BaseSection;
use Propel\Models\SectionFieldQuery;

use Propel\Models\Map\SectionFieldTableMap;
use Propel\Models\Map\PublicationTableMap;

use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;

/**
 * Skeleton subclass for representing a row from the 'section' table.
 *
 * You should add additional methods to this class to meet the application requirements.
 * This class will only be generated as long as it does not already exist in the output directory.
 */
class Section extends BaseSection
{

	/**
	 * Получение адреса раздела
	 */
	public function getUri() : string
	{
		return sprintf('/%s/', $this->getCode());
	}

	/**
	 * Получение количества дополнительных полей в разделе
	 */
	public function getCountFields() : int
	{
		return fenric('query')
			->count(SectionFieldTableMap::COL_ID)
			->from(SectionFieldTableMap::TABLE_NAME)
			->where(SectionFieldTableMap::COL_SECTION_ID, '=', $this->getId())
		->readOne();
	}

	/**
	 * Получение количества публикаций в разделе
	 */
	public function getCountPublications() : int
	{
		return fenric('query')
			->count(PublicationTableMap::COL_ID)
			->from(PublicationTableMap::TABLE_NAME)
			->where(PublicationTableMap::COL_SECTION_ID, '=', $this->getId())
		->readOne();
	}

	/**
	 * Форматирование сниппетов в содержимом раздела
	 */
	public function getSnippetableContent(ConnectionInterface $connection = null)
	{
		return snippetable(parent::getContent($connection));
	}

	/**
	 * Получение отсортированной коллекции с дополнительными полями раздела
	 */
	public function getSortableSectionFields() : ObjectCollection
	{
		$query = SectionFieldQuery::create();

		$query->filterBySectionId($this->getId());

		$query->orderBySequence(Criteria::ASC);

		return $query->find();
	}
}
