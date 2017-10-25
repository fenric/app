<?php

namespace Propel\Models;

use Propel\Models\Base\PublicationPhoto as BasePublicationPhoto;
use Propel\Models\Map\PublicationPhotoTableMap;
use Propel\Runtime\Connection\ConnectionInterface;

/**
 * Skeleton subclass for representing a row from the 'publication_photo' table.
 *
 * You should add additional methods to this class to meet the application requirements.
 * This class will only be generated as long as it does not already exist in the output directory.
 */
class PublicationPhoto extends BasePublicationPhoto
{

	/**
	 * Получение абсолютного пути фотографии
	 */
	public function getPath() : string
	{
		return \Fenric\Upload::path($this->getFile());
	}

	/**
	 * Code to be run before inserting to database
	 */
	public function preInsert(ConnectionInterface $connection = null)
	{
		$this->setSequence(fenric('query')
			->max(PublicationPhotoTableMap::COL_SEQUENCE)
			->from(PublicationPhotoTableMap::TABLE_NAME)
			->where(PublicationPhotoTableMap::COL_PUBLICATION_ID, '=', $this->getPublication()->getId())
		->readOne() + 1);

		return true;
	}

	/**
	 * Code to be run before deleting the object in database
	 */
	public function preDelete(ConnectionInterface $connection = null)
	{
		if (is_file($this->getPath()))
		{
			if (is_readable($this->getPath()))
			{
				unlink($this->getPath());
			}
		}

		return true;
	}
}
