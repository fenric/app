<?php

namespace Propel\Models;

use Propel\Models\Base\Tag as BaseTag;
use Propel\Models\Map\PublicationTagTableMap;
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
}
