<?php

namespace Fenric\Controllers\Admin;

/**
 * Import classes
 */
use Propel\Models\Section;
use Propel\Models\SectionQuery;
use Propel\Models\Map\SectionTableMap;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Fenric\Controllers\Abstractable\CRUD;

/**
 * ApiSection
 */
class ApiSection extends CRUD
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

		parent::create(new Section(), [
			SectionTableMap::COL_CODE => $this->request->post->get('code'),
			SectionTableMap::COL_HEADER => $this->request->post->get('header'),
			SectionTableMap::COL_PICTURE => $this->request->post->get('picture'),
			SectionTableMap::COL_CONTENT => $this->request->post->get('content'),
			SectionTableMap::COL_META_TITLE => $this->request->post->get('meta_title'),
			SectionTableMap::COL_META_AUTHOR => $this->request->post->get('meta_author'),
			SectionTableMap::COL_META_KEYWORDS => $this->request->post->get('meta_keywords'),
			SectionTableMap::COL_META_DESCRIPTION => $this->request->post->get('meta_description'),
			SectionTableMap::COL_META_CANONICAL => $this->request->post->get('meta_canonical'),
			SectionTableMap::COL_META_ROBOTS => $this->request->post->get('meta_robots'),
		]);
	}

	/**
	 * Обновление объекта
	 */
	protected function actionUpdateViaPATCH() : void
	{
		parent::update(SectionQuery::create(), [
			SectionTableMap::COL_CODE => $this->request->post->get('code'),
			SectionTableMap::COL_HEADER => $this->request->post->get('header'),
			SectionTableMap::COL_PICTURE => $this->request->post->get('picture'),
			SectionTableMap::COL_CONTENT => $this->request->post->get('content'),
			SectionTableMap::COL_META_TITLE => $this->request->post->get('meta_title'),
			SectionTableMap::COL_META_AUTHOR => $this->request->post->get('meta_author'),
			SectionTableMap::COL_META_KEYWORDS => $this->request->post->get('meta_keywords'),
			SectionTableMap::COL_META_DESCRIPTION => $this->request->post->get('meta_description'),
			SectionTableMap::COL_META_CANONICAL => $this->request->post->get('meta_canonical'),
			SectionTableMap::COL_META_ROBOTS => $this->request->post->get('meta_robots'),
		]);
	}

	/**
	 * Удаление объекта
	 */
	protected function actionDeleteViaDELETE() : void
	{
		parent::delete(SectionQuery::create());
	}

	/**
	 * Чтение объекта
	 */
	protected function actionReadViaGET() : void
	{
		parent::read(SectionQuery::create(), [
			SectionTableMap::COL_ID,
			SectionTableMap::COL_CODE,
			SectionTableMap::COL_HEADER,
			SectionTableMap::COL_PICTURE,
			SectionTableMap::COL_CONTENT,
			SectionTableMap::COL_META_TITLE,
			SectionTableMap::COL_META_AUTHOR,
			SectionTableMap::COL_META_KEYWORDS,
			SectionTableMap::COL_META_DESCRIPTION,
			SectionTableMap::COL_META_CANONICAL,
			SectionTableMap::COL_META_ROBOTS,
		]);
	}

	/**
	 * Выгрузка объектов
	 */
	protected function actionAllViaGET() : void
	{
		fenric()->callSharedService('event', [self::EVENT_PREPARE_ITEM])->subscribe(function(Section $section, array & $json)
		{
			$json['uri'] = $section->getUri();
			$json['publications'] = $section->getCountPublications();

			if ($section->getSectionRelatedByParentId() instanceof ActiveRecordInterface)
			{
				$json['parent'] = [];
				$json['creator']['id'] = $section->getSectionRelatedByParentId()->getId();
				$json['creator']['username'] = $section->getSectionRelatedByParentId()->getHeader();
			}

			if ($section->getUserRelatedByCreatedBy() instanceof ActiveRecordInterface)
			{
				$json['creator'] = [];
				$json['creator']['id'] = $section->getUserRelatedByCreatedBy()->getId();
				$json['creator']['username'] = $section->getUserRelatedByCreatedBy()->getUsername();
			}

			if ($section->getUserRelatedByUpdatedBy() instanceof ActiveRecordInterface)
			{
				$json['updater'] = [];
				$json['updater']['id'] = $section->getUserRelatedByUpdatedBy()->getId();
				$json['updater']['username'] = $section->getUserRelatedByUpdatedBy()->getUsername();
			}
		});

		$query = SectionQuery::create();
		$query->orderById(Criteria::DESC);

		parent::all($query, [
			SectionTableMap::COL_ID,
			SectionTableMap::COL_CODE,
			SectionTableMap::COL_HEADER,
			SectionTableMap::COL_PICTURE,
			SectionTableMap::COL_META_TITLE,
			SectionTableMap::COL_META_AUTHOR,
			SectionTableMap::COL_META_KEYWORDS,
			SectionTableMap::COL_META_DESCRIPTION,
			SectionTableMap::COL_META_CANONICAL,
			SectionTableMap::COL_META_ROBOTS,
			SectionTableMap::COL_CREATED_AT,
			SectionTableMap::COL_UPDATED_AT,
		]);
	}

	/**
	 * Простая выгрузка объектов
	 */
	protected function actionUnloadViaGet()
	{
		$this->response->setJsonContent(
			fenric('query')
				->select(SectionTableMap::COL_ID)
				->select(SectionTableMap::COL_HEADER)
				->from(SectionTableMap::TABLE_NAME)
				->toArray()
		);
	}
}
