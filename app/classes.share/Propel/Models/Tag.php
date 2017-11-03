<?php

namespace Propel\Models;

use Propel\Models\Base\Tag as BaseTag;
use Propel\Models\Map\PublicationTagTableMap;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;

/**
 * Skeleton subclass for representing a row from the 'tag' table.
 *
 * You should add additional methods to this class to meet the application requirements.
 * This class will only be generated as long as it does not already exist in the output directory.
 */
class Tag extends BaseTag
{

	/**
	 * Получение адреса тега
	 */
	public function getUri() : string
	{
		return sprintf('/tags/%s/', $this->getCode());
	}

	/**
	 * Получение количества связанных с объектом публикаций
	 */
	public function getCountPublications() : int
	{
		return fenric('query')
			->count(PublicationTagTableMap::COL_ID)
			->from(PublicationTagTableMap::TABLE_NAME)
			->where(PublicationTagTableMap::COL_TAG_ID, '=', $this->getId())
		->readOne();
	}

	/**
	 * Форматирование сниппетов в содержимом объекта
	 */
	public function getSnippetableContent(ConnectionInterface $connection = null)
	{
		return snippetable(parent::getContent($connection));
	}

	/**
	 * Выгрузка связанных с тегом публикаций
	 */
	public function getPublications(Criteria $criteria = null, ConnectionInterface $connection = null) : ObjectCollection
	{
		$criteria = $criteria ?: new Criteria();

		$collection = new ObjectCollection();

		if ($this->getPublicationTags($criteria, $connection) instanceof ObjectCollection)
		{
			if ($this->getPublicationTags($criteria, $connection)->count() > 0)
			{
				foreach ($this->getPublicationTags($criteria, $connection) as $ptag)
				{
					if ($ptag->getPublication() instanceof ActiveRecordInterface)
					{
						$collection->push($ptag->getPublication());
					}
				}
			}
		}

		return $collection;
	}
}
