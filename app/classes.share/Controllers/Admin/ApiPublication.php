<?php

namespace Fenric\Controllers\Admin;

/**
 * Import classes
 */
use DateTime;

use Propel\Models\Publication;
use Propel\Models\PublicationQuery;
use Propel\Models\Map\PublicationTableMap;

use Propel\Models\PublicationPhoto;
use Propel\Models\PublicationPhotoQuery;
use Propel\Models\Map\PublicationPhotoTableMap;

use Propel\Models\PublicationTag;
use Propel\Models\PublicationTagQuery;
use Propel\Models\Map\PublicationTagTableMap;

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

		fenric()->callSharedService('event', [self::EVENT_BEFORE_SAVE])->subscribe(function(Publication $publication) : void
		{
			$publication->attachTags($this->data['tags'] ?? []);
		});

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
		fenric()->callSharedService('event', [self::EVENT_BEFORE_SAVE])->subscribe(function(Publication $publication) : void
		{
			$publication->attachTags($this->data['tags'] ?? []);
		});

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
			$json['publication_tags'] = [];

			if ($publication->getPublicationTags() instanceof ObjectCollection)
			{
				foreach ($publication->getPublicationTags() as $publicationTag)
				{
					$json['publication_tags'][] = $publicationTag->getTagId();
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
				$json['tags'] = [];

				foreach ($publication->getPublicationTags() as $i => $publicationTag)
				{
					$json['tags'][$i]['id'] = $publicationTag->getTag()->getId();
					$json['tags'][$i]['code'] = $publicationTag->getTag()->getCode();
					$json['tags'][$i]['header'] = $publicationTag->getTag()->getHeader();
					$json['tags'][$i]['uri'] = $publicationTag->getTag()->getUri();
				}
			}
		});

		$query = PublicationQuery::create();
		$query->orderById(Criteria::DESC);

		if (ctype_digit($this->request->query->get('section'))) {
			$query->filterBySectionId($this->request->query->get('section'));
		}

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
	 * Включение фотографии объекта
	 */
	protected function actionEnablePhotoViaPATCH() : void
	{
		parent::update(PublicationPhotoQuery::create(), [
			PublicationPhotoTableMap::COL_DISPLAY => true,
		]);
	}

	/**
	 * Выключение фотографии объекта
	 */
	protected function actionDisablePhotoViaPATCH() : void
	{
		parent::update(PublicationPhotoQuery::create(), [
			PublicationPhotoTableMap::COL_DISPLAY => false,
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
	 * Выгрузка фотографий объекта
	 */
	protected function actionAllPhotosViaGET() : void
	{
		$query = PublicationPhotoQuery::create();
		$query->orderBySequence(Criteria::ASC);

		$query->filterByPublicationId(
			$this->request->parameters->get('id')
		);

		$columns = [
			PublicationPhotoTableMap::COL_ID,
			PublicationPhotoTableMap::COL_FILE,
			PublicationPhotoTableMap::COL_DISPLAY,
		];

		$options = [
			'limit' => PHP_INT_MAX,
		];

		parent::all($query, $columns, $options);
	}

	/**
	 * Сортировка фотографий объекта
	 */
	protected function actionSortPhotosViaPATCH() : void
	{
		$sequence = 0;

		foreach ($this->request->post->all() as $id)
		{
			$updating[PublicationPhotoTableMap::COL_SEQUENCE] = ++$sequence;

			fenric('query')
				->update(PublicationPhotoTableMap::TABLE_NAME, $updating)
				->where(PublicationPhotoTableMap::COL_ID, '=', $id)
				->limit(1)
				->shutdown();
		}
	}
}
