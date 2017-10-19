<?php

namespace Fenric\Controllers\Admin;

/**
 * Import classes
 */
use DateTime;

use Propel\Models\Section;
use Propel\Models\SectionQuery;
use Propel\Models\Map\SectionTableMap;

use Propel\Models\SectionField;
use Propel\Models\SectionFieldQuery;
use Propel\Models\Map\SectionFieldTableMap;

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
		fenric()->callSharedService('event', [self::EVENT_PREPARE_ITEM])->subscribe(function(Section $section, array & $json)
		{
			$json['fields'] = [];

			if ($section->getSortableSectionFields()->count() > 0)
			{
				foreach ($section->getSortableSectionFields() as $i => $sfield)
				{
					$json['fields'][$i]['id'] = $sfield->getId();
					$json['fields'][$i]['parent']['id'] = $sfield->getField()->getId();

					$json['fields'][$i]['parent']['type'] = $sfield->getField()->getType();
					$json['fields'][$i]['parent']['name'] = $sfield->getField()->getName();

					$json['fields'][$i]['parent']['label'] = $sfield->getField()->getLabel();
					$json['fields'][$i]['parent']['tooltip'] = $sfield->getField()->getTooltip();

					$json['fields'][$i]['parent']['default_value'] = $sfield->getField()->getDefaultValue();

					$json['fields'][$i]['parent']['is_unique'] = $sfield->getField()->isUnique();
					$json['fields'][$i]['parent']['is_required'] = $sfield->getField()->isRequired();
					$json['fields'][$i]['parent']['is_searchable'] = $sfield->getField()->isSearchable();
				}
			}
		});

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
			$json['fields'] = $section->getCountFields();
			$json['publications'] = $section->getCountPublications();

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
	protected function actionUnloadViaGET() : void
	{
		$this->response->setJsonContent(
			fenric('query')
				->select(SectionTableMap::COL_ID)
				->select(SectionTableMap::COL_HEADER)
				->from(SectionTableMap::TABLE_NAME)
			->toArray()
		);
	}

	/**
	 * Прикрепление дополнительного поля к объекту
	 */
	protected function actionAttachFieldViaPOST() : void
	{
		parent::create(new SectionField(), [
			SectionFieldTableMap::COL_SECTION_ID => $this->request->parameters->get('id'),
			SectionFieldTableMap::COL_FIELD_ID => $this->request->getBody(),
		]);
	}

	/**
	 * Открепление дополнительного поля от объекта
	 */
	protected function actionDetachFieldViaDELETE() : void
	{
		parent::delete(SectionFieldQuery::create());
	}

	/**
	 * Сортировка дополнительных полей объекта
	 */
	protected function actionSortFieldsViaPATCH() : void
	{
		$sequence = 0;

		foreach ($this->request->post->all() as $id)
		{
			$update[SectionFieldTableMap::COL_SEQUENCE] = ++$sequence;

			fenric('query')
				->update(SectionFieldTableMap::TABLE_NAME, $update)
				->where(SectionFieldTableMap::COL_ID, '=', $id)
				->limit(1)
			->shutdown();
		}
	}
}
