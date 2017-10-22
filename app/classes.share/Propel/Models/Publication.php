<?php

namespace Propel\Models;

use DateTime;

use Propel\Models\Base\Publication as BasePublication;

use Propel\Models\Map\FieldTableMap;
use Propel\Models\Map\SectionTableMap;
use Propel\Models\Map\SectionFieldTableMap;
use Propel\Models\Map\PublicationTableMap;
use Propel\Models\Map\PublicationFieldTableMap;
use Propel\Models\Map\PublicationPhotoTableMap;
use Propel\Models\Map\PublicationRelationTableMap;

use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;

use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * Skeleton subclass for representing a row from the 'publication' table.
 *
 * You should add additional methods to this class to meet the application requirements.
 * This class will only be generated as long as it does not already exist in the output directory.
 */
class Publication extends BasePublication
{

	/**
	 * {@description}
	 */
	const MAX_ATTACHED_TAGS = 50;
	const MAX_ATTACHED_RELATIONS = 50;

	/**
	 * Setter for the isNew attribute
	 *
	 * This method will be called by Propel-generated children and objects
	 *
	 * @param   bool   $state
	 *
	 * @access  public
	 * @return  void
	 */
	public function setNew($state)
	{
		parent::setNew($state);

		// Only for the loaded object...
		$this->isNew() or $this->loadVirtualColumns();
	}

	/**
	 * Инициализация виртуальных полей
	 */
	public function initVirtualColumns() : void
	{
		if ($this->getSection() instanceof ActiveRecordInterface)
		{
			if ($this->getSection()->getSectionFields() instanceof ObjectCollection)
			{
				if ($this->getSection()->getSectionFields()->count() > 0)
				{
					foreach ($this->getSection()->getSectionFields() as $sfield)
					{
						if ($sfield->getField() instanceof ActiveRecordInterface)
						{
							$this->setVirtualColumn(
								$sfield->getField()->getName(),
								$sfield->getField()->getDefaultValue()
							);
						}
					}
				}
			}
		}
	}

	/**
	 * Загрузка виртуальных полей
	 */
	public function loadVirtualColumns() : void
	{
		$this->initVirtualColumns();

		if ($this->getPublicationFields() instanceof ObjectCollection)
		{
			if ($this->getPublicationFields()->count() > 0)
			{
				foreach ($this->getPublicationFields() as $pfield)
				{
					if ($pfield->getSectionField() instanceof ActiveRecordInterface)
					{
						if ($pfield->getSectionField()->getField() instanceof ActiveRecordInterface)
						{
							$this->setVirtualColumn(
								$pfield->getSectionField()->getField()->getName(),
								$pfield->getValue()
							);
						}
					}
				}
			}
		}
	}

	/**
	 * Получение адреса публикации
	 */
	public function getUri() : string
	{
		return sprintf('/%s/%s.html', $this->getSection()->getCode(), $this->getCode());
	}

	/**
	 * Форматирование сниппетов в анонсе публикации
	 */
	public function getSnippetableAnons() : string
	{
		return snippetable(parent::getAnons());
	}

	/**
	 * Форматирование сниппетов в содержимом публикации
	 */
	public function getSnippetableContent() : string
	{
		return snippetable(parent::getContent());
	}

	/**
	 * Получение обложки публикации (не путать с основной фотографией)
	 */
	public function getCover() : string
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
	public function getDisplayedSortablePhotosWithoutCoverWhenPictureDoesNotExist() : ObjectCollection
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
	public function getPrevPublication() : ?self
	{
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

			if ($publication instanceof self)
			{
				return $publication;
			}
		}

		return null;
	}

	/**
	 * Получение следующей публикации
	 */
	public function getNextPublication() : ?self
	{
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

			if ($publication instanceof self)
			{
				return $publication;
			}
		}

		return null;
	}

	/**
	 * Проверка существования предыдущей или следующей публикации
	 */
	public function existsNearestPublication() : bool
	{
		if (! ($this->getPrevPublication() instanceof self))
		{
			if (! ($this->getNextPublication() instanceof self))
			{
				return false;
			}
		}

		return true;
	}

	/**
	 * Получение связанных публикаций
	 */
	public function getRelations() : ObjectCollection
	{
		return PublicationQuery::create()->findPks(fenric('query')
			->select(PublicationRelationTableMap::COL_RELATION_ID)
			->from(PublicationRelationTableMap::TABLE_NAME)
			->where(PublicationRelationTableMap::COL_PUBLICATION_ID, '=', $this->getId())
		->readCol());
	}

	/**
	 * Прикрепление тегов к публикации
	 */
	public function attachTags(array $ids) : void
	{
		$ids = array_slice(array_unique(array_filter($ids, function($id) : bool
		{
			return ctype_digit($id);

		})), 0, self::MAX_ATTACHED_TAGS);

		if ($this->getPublicationTags() instanceof ObjectCollection)
		{
			foreach ($this->getPublicationTags() as $ptag)
			{
				if (($i = array_search($ptag->getTagId(), $ids)) === false)
				{
					$ptag->delete();

					continue;
				}

				unset($ids[$i]);
			}
		}

		if (count($ids) > 0)
		{
			$tags = TagQuery::create()->findPks($ids);

			if ($tags instanceof ObjectCollection)
			{
				foreach ($tags as $tag)
				{
					$ptag = new PublicationTag();

					$ptag->setPublication($this);
					$ptag->setTag($tag);

					$this->addPublicationTag($ptag);
				}
			}
		}
	}

	/**
	 * Прикрепление связей к публикации
	 */
	public function attachRelations(array $ids) : void
	{
		$ids = array_slice(array_unique(array_filter($ids, function($id) : bool
		{
			return ctype_digit($id);

		})), 0, self::MAX_ATTACHED_RELATIONS);

		if ($this->getPublicationRelations() instanceof ObjectCollection)
		{
			foreach ($this->getPublicationRelations() as $relation)
			{
				if (($i = array_search($relation->getRelationId(), $ids)) === false)
				{
					$relation->delete();

					continue;
				}

				unset($ids[$i]);
			}
		}

		if (count($ids) > 0)
		{
			$publications = PublicationQuery::create()->findPks($ids);

			if ($publications instanceof ObjectCollection)
			{
				foreach ($publications as $publication)
				{
					if ($publication->getId() <> $this->getId())
					{
						$relation = new PublicationRelation();

						$relation->setPublication($this);
						$relation->setRelationId($publication->getId());

						$this->addPublicationRelation($relation);
					}
				}
			}
		}
	}

	/**
	 * Code to be run before inserting to database
	 *
	 * @param   ConnectionInterface   $connection
	 *
	 * @access  public
	 * @return  bool
	 */
	public function preInsert(ConnectionInterface $connection = null)
	{
		if ($this->getSection() instanceof ActiveRecordInterface)
		{
			if ($this->getSection()->getSectionFields() instanceof ObjectCollection)
			{
				if ($this->getSection()->getSectionFields()->count() > 0)
				{
					foreach ($this->getSection()->getSectionFields() as $sfield)
					{
						if ($sfield->getField() instanceof ActiveRecordInterface)
						{
							$pfield = new PublicationField();

							$pfield->setPublication($this);
							$pfield->setSectionField($sfield);

							$pfield->setValue(
								$this->hasVirtualColumn(
									$sfield->getField()->getName()
								) ?
								$this->getVirtualColumn(
									$sfield->getField()->getName()
								) :
								$sfield->getField()->getDefaultValue()
							);

							$this->addPublicationField($pfield);
						}
					}
				}
			}
		}

		return true;
	}

	/**
	 * Code to be run before updating the object in database
	 *
	 * @param   ConnectionInterface   $connection
	 *
	 * @access  public
	 * @return  bool
	 */
	public function preUpdate(ConnectionInterface $con = null)
	{
		if ($this->getPublicationFields() instanceof ObjectCollection)
		{
			if ($this->getPublicationFields()->count() > 0)
			{
				foreach ($this->getPublicationFields() as $pfield)
				{
					if ($pfield->getSectionField() instanceof ActiveRecordInterface)
					{
						if ($pfield->getSectionField()->getField() instanceof ActiveRecordInterface)
						{
							if ($this->hasVirtualColumn($pfield->getSectionField()->getField()->getName()))
							{
								$pfield->setValue($this->getVirtualColumn($pfield->getSectionField()->getField()->getName()));
							}
						}
					}
				}
			}
		}

		if ($this->getSection() instanceof ActiveRecordInterface)
		{
			if ($this->getSection()->getSectionFields() instanceof ObjectCollection)
			{
				if ($this->getSection()->getSectionFields()->count() > 0)
				{
					foreach ($this->getSection()->getSectionFields() as $sfield)
					{
						if ($sfield->getField() instanceof ActiveRecordInterface)
						{
							$uniqueness = fenric('query');

							$uniqueness->count(PublicationFieldTableMap::COL_ID);
							$uniqueness->from(PublicationFieldTableMap::TABLE_NAME);

							$uniqueness->where(PublicationFieldTableMap::COL_PUBLICATION_ID, '=', $this->getId());
							$uniqueness->where(PublicationFieldTableMap::COL_SECTION_FIELD_ID, '=', $sfield->getId());

							if ($uniqueness->readOne() > 0)
							{
								continue;
							}

							$pfield = new PublicationField();

							$pfield->setPublication($this);
							$pfield->setSectionField($sfield);

							$pfield->setValue(
								$this->hasVirtualColumn(
									$sfield->getField()->getName()
								) ?
								$this->getVirtualColumn(
									$sfield->getField()->getName()
								) :
								$sfield->getField()->getDefaultValue()
							);

							$this->addPublicationField($pfield);
						}
					}
				}
			}
		}

		return true;
	}

	/**
	 * Configure validators constraints.
	 *
	 * The Validator object uses this method to perform object validation
	 *
	 * @param   ClassMetadata   $metadata
	 *
	 * @access  public
	 * @return  void
	 */
	public static function loadValidatorMetadata(ClassMetadata $metadata)
	{
		$metadata->addConstraint(new Callback(function($root, ExecutionContextInterface $context)
		{
			if ($context->getRoot()->getSection() instanceof ActiveRecordInterface)
			{
				if ($context->getRoot()->getSection()->getSectionFields() instanceof ObjectCollection)
				{
					if ($context->getRoot()->getSection()->getSectionFields()->count() > 0)
					{
						foreach ($context->getRoot()->getSection()->getSectionFields() as $sfield)
						{
							if ($sfield->getField() instanceof ActiveRecordInterface)
							{
								if ($context->getRoot()->hasVirtualColumn($sfield->getField()->getName()))
								{
									try
									{
										$sfield->getField()->isValidPublicationValue($context->getRoot());
									}
									catch (\RuntimeException $e)
									{
										$context->buildViolation($e->getMessage())->atPath(
											sprintf('field:%s', $sfield->getField()->getName())
										)->addViolation();
									}
								}
							}
						}
					}
				}
			}
		}));
	}
}
