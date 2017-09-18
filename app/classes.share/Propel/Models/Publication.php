<?php

namespace Propel\Models;

use DateTime;
use Propel\Models\Base\Publication as BasePublication;
use Propel\Models\Map\PublicationTableMap;
use Propel\Models\Map\PublicationPhotoTableMap;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;

/**
 * Skeleton subclass for representing a row from the 'publication' table.
 *
 * You should add additional methods to this class to meet the application requirements.
 * This class will only be generated as long as it does not already exist in the output directory.
 */
class Publication extends BasePublication
{

	/**
	 * Получение адреса публикации
	 */
	public function getUri() : string
	{
		return sprintf('/%s/%s/', $this->getSection()->getCode(), $this->getCode());
	}

	/**
	 * Форматирование сниппетов в анонсе публикации
	 */
	public function getSnippetableAnons()
	{
		return snippetable(parent::getAnons());
	}

	/**
	 * Форматирование сниппетов в содержимом публикации
	 */
	public function getSnippetableContent(ConnectionInterface $connection = null)
	{
		return snippetable(parent::getContent($connection));
	}

	/**
	 * Получение обложки публикации (не путать с основной фотографией)
	 */
	public function getCover()
	{
		return fenric('query')
			->select(PublicationPhotoTableMap::COL_FILE)
			->from(PublicationPhotoTableMap::TABLE_NAME)
			->where(PublicationPhotoTableMap::COL_PUBLICATION_ID, '=', $this->getId())
			->where(PublicationPhotoTableMap::COL_DISPLAY, '=', true)
			->order(PublicationPhotoTableMap::COL_SEQUENCE)->asc()
		->readOne();
	}

	/**
	 * Получение количества фотографий у публикации
	 */
	public function getCountPhotos() : int
	{
		return fenric('query')
			->count(PublicationPhotoTableMap::COL_ID)
			->from(PublicationPhotoTableMap::TABLE_NAME)
			->where(PublicationPhotoTableMap::COL_PUBLICATION_ID, '=', $this->getId())
			->where(PublicationPhotoTableMap::COL_DISPLAY, '=', true)
		->readOne();
	}

	/**
	 * Получение отсортированной коллекции с фотографиями публикации
	 */
	public function getSortablePhotos() : ObjectCollection
	{
		$query = PublicationPhotoQuery::create();

		$query->filterByPublicationId($this->getId());

		$query->orderBySequence(Criteria::ASC);

		return $query->find();
	}

	/**
	 * Получение отсортированной коллекции с отображаемыми фотографиями публикации
	 */
	public function getDisplayableSortablePhotos() : ObjectCollection
	{
		$query = PublicationPhotoQuery::create();

		$query->filterByPublicationId($this->getId());
		$query->filterByDisplay(true);

		$query->orderBySequence(Criteria::ASC);

		return $query->find();
	}

	/**
	 * Получение отсортированной коллекции с отображаемыми фотографиями публикации без обложки (первой фотографии)
	 */
	public function getDisplayableSortablePhotosWithoutCover() : ObjectCollection
	{
		$query = PublicationPhotoQuery::create();

		$query->filterByPublicationId($this->getId());
		$query->filterByDisplay(true);

		$query->orderBySequence(Criteria::ASC);
		$query->offset(1);

		return $query->find();
	}

	/**
	 * Получение отсортированной коллекции с отображаемыми фотографиями публикации без обложки (первой фотографии) если не существует основной фотографии
	 */
	public function getDisplayedSortablePhotosWithoutCoverWhenIsNotExistsPicture() : ObjectCollection
	{
		$query = PublicationPhotoQuery::create();

		$query->filterByPublicationId($this->getId());
		$query->filterByDisplay(true);

		$query->orderBySequence(Criteria::ASC);

		if (strlen($this->getPicture()) === 0)
		{
			$query->offset(1);
		}

		return $query->find();
	}

	/**
	 * Получение предыдущей публикации
	 */
	public function getPreviousPublication() : ?self
	{
		if (! $this->hasVirtualColumn('previousPublication'))
		{
			$this->setVirtualColumn('previousPublication', null);

			$query = fenric('query')

			->select(PublicationTableMap::COL_ID)
			->from(PublicationTableMap::TABLE_NAME)

			->where(PublicationTableMap::COL_SECTION_ID, '=', $this->getSectionId())
			->where(PublicationTableMap::COL_ID, '<', $this->getId())

			->and_open()
				->where(PublicationTableMap::COL_SHOW_AT, 'is', null)
					->or_()->where(PublicationTableMap::COL_SHOW_AT, '<=', new DateTime('now'))

			->close_and_open()
				->where(PublicationTableMap::COL_HIDE_AT, 'is', null)
					->or_()->where(PublicationTableMap::COL_HIDE_AT, '>=', new DateTime('now'))

			->order(PublicationTableMap::COL_ID)->desc()
			->limit(1);

			if ($id = $query->readOne())
			{
				$publication = PublicationQuery::create()->findPk($id);

				if ($publication instanceof Publication)
				{
					$this->setVirtualColumn('previousPublication', $publication);
				}
			}
		}

		return $this->getVirtualColumn('previousPublication');
	}

	/**
	 * Получение следующей публикации
	 */
	public function getNextPublication() : ?self
	{
		if (! $this->hasVirtualColumn('nextPublication'))
		{
			$this->setVirtualColumn('nextPublication', null);

			$query = fenric('query')

			->select(PublicationTableMap::COL_ID)
			->from(PublicationTableMap::TABLE_NAME)

			->where(PublicationTableMap::COL_SECTION_ID, '=', $this->getSectionId())
			->where(PublicationTableMap::COL_ID, '>', $this->getId())

			->and_open()
				->where(PublicationTableMap::COL_SHOW_AT, 'is', null)
					->or_()->where(PublicationTableMap::COL_SHOW_AT, '<=', new DateTime('now'))

			->close_and_open()
				->where(PublicationTableMap::COL_HIDE_AT, 'is', null)
					->or_()->where(PublicationTableMap::COL_HIDE_AT, '>=', new DateTime('now'))

			->order(PublicationTableMap::COL_ID)->asc()
			->limit(1);

			if ($id = $query->readOne())
			{
				$publication = PublicationQuery::create()->findPk($id);

				if ($publication instanceof Publication)
				{
					$this->setVirtualColumn('nextPublication', $publication);
				}
			}
		}

		return $this->getVirtualColumn('nextPublication');
	}

	/**
	 * Проверка существования предыдущей или следующей публикации
	 */
	public function existsPreviousOrNextPublication() : bool
	{
		if ($this->getPreviousPublication() instanceof self)
		{
			return true;
		}

		if ($this->getNextPublication() instanceof self)
		{
			return true;
		}

		return false;
	}

	/**
	 * Прикрепление тегов к публикации
	 */
	public function attachTags(array $tagsIds) : void
	{
		if (count($tagsIds) > 0)
		{
			if ($this->getPublicationTags() instanceof ObjectCollection)
			{
				foreach ($this->getPublicationTags() as $publicationTag)
				{
					$foundIndex = array_search($publicationTag->getTagId(), $tagsIds);

					if ($foundIndex === false)
					{
						$publicationTag->delete();

						continue;
					}

					unset($tagsIds[$foundIndex]);
				}
			}

			if (count($tagsIds) > 0)
			{
				$tags = TagQuery::create()->findPks($tagsIds);

				if ($tags instanceof ObjectCollection)
				{
					foreach ($tags as $tag)
					{
						$publicationTag = new PublicationTag();

						$publicationTag->setPublication($this);
						$publicationTag->setTag($tag);

						$this->addPublicationTag($publicationTag);
					}
				}
			}
		}
	}

	/**
	 * Регистрация уникального «хита»
	 */
	public function registerHit() : void
	{
		$hits = fenric('session')->get('publication.hits');

		if (empty($hits[$this->getId()]))
		{
			$hits[$this->getId()] = time();

			fenric('session')->set('publication.hits', $hits);

			$updating[PublicationTableMap::COL_HITS] = $this->getHits() + 1;

			fenric('query')
				->update(PublicationTableMap::TABLE_NAME, $updating)
				->where(PublicationTableMap::COL_ID, '=', $this->getId())
				->limit(1)
			->shutdown();
		}
	}
}
