<?php

namespace Fenric\Controllers\Admin;

/**
 * Import classes
 */
use DateTime;

use Propel\Models\Publication;
use Propel\Models\PublicationQuery;
use Propel\Models\Map\PublicationTableMap;

use Propel\Models\PublicationField;
use Propel\Models\PublicationFieldQuery;
use Propel\Models\Map\PublicationFieldTableMap;

use Propel\Models\PublicationPhoto;
use Propel\Models\PublicationPhotoQuery;
use Propel\Models\Map\PublicationPhotoTableMap;

use Propel\Models\PublicationRelation;
use Propel\Models\PublicationRelationQuery;
use Propel\Models\Map\PublicationRelationTableMap;

use Propel\Models\PublicationTag;
use Propel\Models\PublicationTagQuery;
use Propel\Models\Map\PublicationTagTableMap;

use Propel\Models\Section;
use Propel\Models\SectionQuery;
use Propel\Models\Map\SectionTableMap;

use Propel\Models\Tag;
use Propel\Models\TagQuery;
use Propel\Models\Map\TagTableMap;

use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\ObjectCollection;
use Fenric\Controllers\Abstractable\CRUD;

/**
 * ApiPublication
 */
class ApiPublication extends CRUD
{

	/**
	 * Доступ к контроллеру
	 */
	use Access;

	/**
	 * Инициализация контроллера
	 */
	public function init() : void
	{
		parent::init();

		fenric()->callSharedService('event', [self::EVENT_BEFORE_SAVE])->subscribe(function(ActiveRecordInterface $model) : void
		{
			// It's the controller works with a few models...
			if ($model instanceof Publication)
			{
				$model->attachTags($this->data['tags'] ?? []);

				$model->attachRelations($this->data['relations'] ?? []);
			}
		});

		fenric()->callSharedService('event', [self::EVENT_BEFORE_VALIDATE])->subscribe(function(ActiveRecordInterface $model) : void
		{
			// It's the controller works with a few models...
			if ($model instanceof Publication)
			{
				// Initial model virtual columns...
				$model->initVirtualColumns();

				$prefix = 'field_';

				foreach ($this->request->post->all() as $key => $value)
				{
					if (0 === strpos($key, $prefix))
					{
						$name = substr($key, strlen($prefix));

						$model->setVirtualColumn($name, $value);
					}
				}
			}
		});
	}

	/**
	 * Создание объекта
	 */
	protected function actionCreateViaPOST() : void
	{
		if (strlen($this->request->post->get('code')) === 0) {
			if (strlen($this->request->post->get('header')) > 0) {
				$this->request->post->set('code', sluggable(
					$this->request->post->get('header')
				));
			}
		}

		parent::create(new Publication(), [
			PublicationTableMap::COL_SECTION_ID => $this->request->post->get('section_id'),
			PublicationTableMap::COL_CODE => $this->request->post->get('code'),
			PublicationTableMap::COL_HEADER => $this->request->post->get('header'),
			PublicationTableMap::COL_PICTURE => $this->request->post->get('picture'),
			PublicationTableMap::COL_PICTURE_SIGNATURE => $this->request->post->get('picture_signature'),
			PublicationTableMap::COL_ANONS => $this->request->post->get('anons'),
			PublicationTableMap::COL_CONTENT => $this->request->post->get('content'),
			PublicationTableMap::COL_META_TITLE => $this->request->post->get('meta_title'),
			PublicationTableMap::COL_META_AUTHOR => $this->request->post->get('meta_author'),
			PublicationTableMap::COL_META_KEYWORDS => $this->request->post->get('meta_keywords'),
			PublicationTableMap::COL_META_DESCRIPTION => $this->request->post->get('meta_description'),
			PublicationTableMap::COL_META_CANONICAL => $this->request->post->get('meta_canonical'),
			PublicationTableMap::COL_META_ROBOTS => $this->request->post->get('meta_robots'),
			PublicationTableMap::COL_SHOW_AT => $this->request->post->get('show_at'),
			PublicationTableMap::COL_HIDE_AT => $this->request->post->get('hide_at'),
		]);
	}

	/**
	 * Обновление объекта
	 */
	protected function actionUpdateViaPATCH() : void
	{
		parent::update(PublicationQuery::create(), [
			PublicationTableMap::COL_SECTION_ID => $this->request->post->get('section_id'),
			PublicationTableMap::COL_CODE => $this->request->post->get('code'),
			PublicationTableMap::COL_HEADER => $this->request->post->get('header'),
			PublicationTableMap::COL_PICTURE => $this->request->post->get('picture'),
			PublicationTableMap::COL_PICTURE_SIGNATURE => $this->request->post->get('picture_signature'),
			PublicationTableMap::COL_ANONS => $this->request->post->get('anons'),
			PublicationTableMap::COL_CONTENT => $this->request->post->get('content'),
			PublicationTableMap::COL_META_TITLE => $this->request->post->get('meta_title'),
			PublicationTableMap::COL_META_AUTHOR => $this->request->post->get('meta_author'),
			PublicationTableMap::COL_META_KEYWORDS => $this->request->post->get('meta_keywords'),
			PublicationTableMap::COL_META_DESCRIPTION => $this->request->post->get('meta_description'),
			PublicationTableMap::COL_META_CANONICAL => $this->request->post->get('meta_canonical'),
			PublicationTableMap::COL_META_ROBOTS => $this->request->post->get('meta_robots'),
			PublicationTableMap::COL_SHOW_AT => $this->request->post->get('show_at'),
			PublicationTableMap::COL_HIDE_AT => $this->request->post->get('hide_at'),
		]);
	}

	/**
	 * Удаление объекта
	 */
	protected function actionDeleteViaDELETE() : void
	{
		parent::delete(PublicationQuery::create());
	}

	/**
	 * Чтение объекта
	 */
	protected function actionReadViaGET() : void
	{
		fenric()->callSharedService('event', [self::EVENT_PREPARE_ITEM])->subscribe(function(Publication $publication, array & $json)
		{
			$json['fields'] = $publication->getVirtualColumns();

			$json['photos'] = $json['relations'] = $json['tags'] = [];

			if ($publication->getSortablePhotos() instanceof ObjectCollection)
			{
				if ($publication->getSortablePhotos()->count() > 0)
				{
					$i = 0;

					foreach ($publication->getSortablePhotos() as $photo)
					{
						$json['photos'][$i]['id'] = $photo->getId();
						$json['photos'][$i]['file'] = $photo->getFile();
						$json['photos'][$i]['display'] = $photo->isDisplay();

						$i++;
					}
				}
			}

			if ($publication->getRelations() instanceof ObjectCollection)
			{
				if ($publication->getRelations()->count() > 0)
				{
					$i = 0;

					foreach ($publication->getRelations() as $relation)
					{
						$json['relations'][$i]['id'] = $relation->getId();
						$json['relations'][$i]['header'] = $relation->getHeader();

						$i++;
					}
				}
			}

			if ($publication->getPublicationTags() instanceof ObjectCollection)
			{
				if ($publication->getPublicationTags()->count() > 0)
				{
					$i = 0;

					foreach ($publication->getPublicationTags() as $ptag)
					{
						if (!! ($ptag->getTag() instanceof ActiveRecordInterface))
						{
							$json['tags'][$i] = $ptag->getTag()->getId();

							$i++;
						}
					}
				}
			}
		});

		parent::read(PublicationQuery::create(), [
			PublicationTableMap::COL_ID,
			PublicationTableMap::COL_SECTION_ID,
			PublicationTableMap::COL_CODE,
			PublicationTableMap::COL_HEADER,
			PublicationTableMap::COL_PICTURE,
			PublicationTableMap::COL_PICTURE_SIGNATURE,
			PublicationTableMap::COL_ANONS,
			PublicationTableMap::COL_CONTENT,
			PublicationTableMap::COL_META_TITLE,
			PublicationTableMap::COL_META_AUTHOR,
			PublicationTableMap::COL_META_KEYWORDS,
			PublicationTableMap::COL_META_DESCRIPTION,
			PublicationTableMap::COL_META_CANONICAL,
			PublicationTableMap::COL_META_ROBOTS,
			PublicationTableMap::COL_SHOW_AT,
			PublicationTableMap::COL_HIDE_AT,
		]);
	}

	/**
	 * Выгрузка объектов
	 */
	protected function actionAllViaGET() : void
	{
		fenric()->callSharedService('event', [self::EVENT_PREPARE_ITEM])->subscribe(function(Publication $publication, array & $json)
		{
			$json['uri'] = $publication->getUri();
			$json['cover'] = $publication->getCover();
			$json['photos'] = $publication->getCountPhotos();

			$json['enabled'] = true;
			$json['disabled'] = false;

			if ($publication->getShowAt() instanceof DateTime)
			{
				if ($publication->getShowAt() > new DateTime('now'))
				{
					$json['enabled'] = false;
					$json['disabled'] = true;
				}
			}

			if ($publication->getHideAt() instanceof DateTime)
			{
				if ($publication->getHideAt() < new DateTime('now'))
				{
					$json['enabled'] = false;
					$json['disabled'] = true;
				}
			}

			if ($publication->getSection() instanceof ActiveRecordInterface)
			{
				$json['section'] = [];
				$json['section']['id'] = $publication->getSection()->getId();
				$json['section']['code'] = $publication->getSection()->getCode();
				$json['section']['header'] = $publication->getSection()->getHeader();
				$json['section']['uri'] = $publication->getSection()->getUri();
			}

			if ($publication->getUserRelatedByCreatedBy() instanceof ActiveRecordInterface)
			{
				$json['creator'] = [];
				$json['creator']['id'] = $publication->getUserRelatedByCreatedBy()->getId();
				$json['creator']['username'] = $publication->getUserRelatedByCreatedBy()->getUsername();
			}

			if ($publication->getUserRelatedByUpdatedBy() instanceof ActiveRecordInterface)
			{
				$json['updater'] = [];
				$json['updater']['id'] = $publication->getUserRelatedByUpdatedBy()->getId();
				$json['updater']['username'] = $publication->getUserRelatedByUpdatedBy()->getUsername();
			}

			if ($publication->getPublicationTags() instanceof ObjectCollection)
			{
				if ($publication->getPublicationTags()->count())
				{
					$i = 0;
					$json['tags'] = [];

					foreach ($publication->getPublicationTags() as $ptag)
					{
						if (!! ($ptag->getTag() instanceof ActiveRecordInterface))
						{
							$json['tags'][$i] = [];
							$json['tags'][$i]['id'] = $ptag->getTag()->getId();
							$json['tags'][$i]['code'] = $ptag->getTag()->getCode();
							$json['tags'][$i]['header'] = $ptag->getTag()->getHeader();
							$i++;
						}
					}
				}
			}
		});

		$query = PublicationQuery::create();

		if (trim($q = $this->request->query->get('q')))
		{
			$mode = PublicationQuery::SEARCH_FILTER_MAX;
			$mode ^= PublicationQuery::SEARCH_FILTER_DISPLAY;

			$query = PublicationQuery::search($q, $mode) ?: $query;
		}

		$query->orderById(Criteria::DESC);

		parent::all($query, [
			PublicationTableMap::COL_ID,
			PublicationTableMap::COL_CODE,
			PublicationTableMap::COL_HEADER,
			PublicationTableMap::COL_PICTURE,
			PublicationTableMap::COL_META_TITLE,
			PublicationTableMap::COL_META_AUTHOR,
			PublicationTableMap::COL_META_KEYWORDS,
			PublicationTableMap::COL_META_DESCRIPTION,
			PublicationTableMap::COL_META_CANONICAL,
			PublicationTableMap::COL_META_ROBOTS,
			PublicationTableMap::COL_CREATED_AT,
			PublicationTableMap::COL_UPDATED_AT,
			PublicationTableMap::COL_SHOW_AT,
			PublicationTableMap::COL_HIDE_AT,
			PublicationTableMap::COL_HITS,
		]);
	}

	/**
	 * Простой поиск объектов
	 */
	protected function actionSearchViaGET() : void
	{
		$found = [];

		if (trim($q = $this->request->query->get('q')))
		{
			$mode = PublicationQuery::SEARCH_FILTER_MAX;
			$mode ^= PublicationQuery::SEARCH_FILTER_DISPLAY;

			if ($query = PublicationQuery::search($q, $mode))
			{
				$query->orderById(Criteria::DESC);
				$query->limit(50);

				foreach ($query->find() as $i => $p)
				{
					$found[$i]['id'] = $p->getId();
					$found[$i]['code'] = $p->getCode();
					$found[$i]['header'] = $p->getHeader();
				}
			}
		}

		$this->response->setJsonContent($found);
	}

	/**
	 * Создание фотографии объекта
	 */
	protected function actionCreatePhotoViaPOST() : void
	{
		parent::create(new PublicationPhoto(), [
			PublicationPhotoTableMap::COL_PUBLICATION_ID => $this->request->parameters->get('id'),
			PublicationPhotoTableMap::COL_FILE => $this->request->post->get('file'),
		]);
	}

	/**
	 * Удаление фотографии объекта
	 */
	protected function actionDeletePhotoViaDELETE() : void
	{
		parent::delete(PublicationPhotoQuery::create());
	}

	/**
	 * Включение фотографии объекта
	 */
	protected function actionShowPhotoViaPATCH() : void
	{
		parent::update(PublicationPhotoQuery::create(), [
			PublicationPhotoTableMap::COL_DISPLAY => true,
		]);
	}

	/**
	 * Выключение фотографии объекта
	 */
	protected function actionHidePhotoViaPATCH() : void
	{
		parent::update(PublicationPhotoQuery::create(), [
			PublicationPhotoTableMap::COL_DISPLAY => false,
		]);
	}

	/**
	 * Сортировка фотографий объекта
	 */
	protected function actionSortPhotosViaPATCH() : void
	{
		$sequence = 0;

		foreach ($this->request->post->all() as $id)
		{
			$update[PublicationPhotoTableMap::COL_SEQUENCE] = ++$sequence;

			fenric('query')
				->update(PublicationPhotoTableMap::TABLE_NAME, $update)
				->where(PublicationPhotoTableMap::COL_ID, '=', $id)
				->limit(1)
			->shutdown();
		}
	}
}
