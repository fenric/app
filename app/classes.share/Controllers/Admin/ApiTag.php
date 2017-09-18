<?php

namespace Fenric\Controllers\Admin;

/**
 * Import classes
 */
use Propel\Models\Tag;
use Propel\Models\TagQuery;
use Propel\Models\Map\TagTableMap;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Fenric\Controllers\Abstractable\CRUD;

/**
 * ApiTag
 */
class ApiTag extends CRUD
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

		parent::create(new Tag(), [
			TagTableMap::COL_CODE => $this->request->post->get('code'),
			TagTableMap::COL_HEADER => $this->request->post->get('header'),
			TagTableMap::COL_CONTENT => $this->request->post->get('content'),
			TagTableMap::COL_META_TITLE => $this->request->post->get('meta_title'),
			TagTableMap::COL_META_AUTHOR => $this->request->post->get('meta_author'),
			TagTableMap::COL_META_KEYWORDS => $this->request->post->get('meta_keywords'),
			TagTableMap::COL_META_DESCRIPTION => $this->request->post->get('meta_description'),
			TagTableMap::COL_META_CANONICAL => $this->request->post->get('meta_canonical'),
			TagTableMap::COL_META_ROBOTS => $this->request->post->get('meta_robots'),
		]);
	}

	/**
	 * Обновление объекта
	 */
	protected function actionUpdateViaPATCH() : void
	{
		parent::update(TagQuery::create(), [
			TagTableMap::COL_CODE => $this->request->post->get('code'),
			TagTableMap::COL_HEADER => $this->request->post->get('header'),
			TagTableMap::COL_CONTENT => $this->request->post->get('content'),
			TagTableMap::COL_META_TITLE => $this->request->post->get('meta_title'),
			TagTableMap::COL_META_AUTHOR => $this->request->post->get('meta_author'),
			TagTableMap::COL_META_KEYWORDS => $this->request->post->get('meta_keywords'),
			TagTableMap::COL_META_DESCRIPTION => $this->request->post->get('meta_description'),
			TagTableMap::COL_META_CANONICAL => $this->request->post->get('meta_canonical'),
			TagTableMap::COL_META_ROBOTS => $this->request->post->get('meta_robots'),
		]);
	}

	/**
	 * Удаление объекта
	 */
	protected function actionDeleteViaDELETE() : void
	{
		parent::delete(TagQuery::create());
	}

	/**
	 * Чтение объекта
	 */
	protected function actionReadViaGET() : void
	{
		parent::read(TagQuery::create(), [
			TagTableMap::COL_ID,
			TagTableMap::COL_CODE,
			TagTableMap::COL_HEADER,
			TagTableMap::COL_CONTENT,
			TagTableMap::COL_META_TITLE,
			TagTableMap::COL_META_AUTHOR,
			TagTableMap::COL_META_KEYWORDS,
			TagTableMap::COL_META_DESCRIPTION,
			TagTableMap::COL_META_CANONICAL,
			TagTableMap::COL_META_ROBOTS,
		]);
	}

	/**
	 * Выгрузка объектов
	 */
	protected function actionAllViaGET() : void
	{
		fenric()->callSharedService('event', [self::EVENT_PREPARE_ITEM])->subscribe(function(Tag $tag, array & $json)
		{
			$json['uri'] = $tag->getUri();
			$json['publications'] = $tag->getCountPublications();

			if ($tag->getUserRelatedByCreatedBy() instanceof ActiveRecordInterface)
			{
				$json['creator'] = [];
				$json['creator']['id'] = $tag->getUserRelatedByCreatedBy()->getId();
				$json['creator']['username'] = $tag->getUserRelatedByCreatedBy()->getUsername();
			}

			if ($tag->getUserRelatedByUpdatedBy() instanceof ActiveRecordInterface)
			{
				$json['updater'] = [];
				$json['updater']['id'] = $tag->getUserRelatedByUpdatedBy()->getId();
				$json['updater']['username'] = $tag->getUserRelatedByUpdatedBy()->getUsername();
			}
		});

		$query = TagQuery::create();
		$query->orderById(Criteria::DESC);

		parent::all($query, [
			TagTableMap::COL_ID,
			TagTableMap::COL_CODE,
			TagTableMap::COL_HEADER,
			TagTableMap::COL_META_TITLE,
			TagTableMap::COL_META_AUTHOR,
			TagTableMap::COL_META_KEYWORDS,
			TagTableMap::COL_META_DESCRIPTION,
			TagTableMap::COL_META_CANONICAL,
			TagTableMap::COL_META_ROBOTS,
			TagTableMap::COL_CREATED_AT,
			TagTableMap::COL_UPDATED_AT,
		]);
	}

	/**
	 * Простая выгрузка объектов
	 */
	protected function actionUnloadViaGet()
	{
		$this->response->setJsonContent(
			fenric('query')
				->select(TagTableMap::COL_ID)
				->select(TagTableMap::COL_HEADER)
				->from(TagTableMap::TABLE_NAME)
				->toArray()
		);
	}
}
