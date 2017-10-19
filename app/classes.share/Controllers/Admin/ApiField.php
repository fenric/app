<?php

namespace Fenric\Controllers\Admin;

/**
 * Import classes
 */
use Propel\Models\Field;
use Propel\Models\FieldQuery;
use Propel\Models\Map\FieldTableMap;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Fenric\Controllers\Abstractable\CRUD;

/**
 * ApiField
 */
class ApiField extends CRUD
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
		if (strlen($this->request->post->get('name')) === 0) {
			if (strlen($this->request->post->get('label')) > 0) {
				$this->request->post->set('name', sluggable(
					$this->request->post->get('label'), '_'
				));
			}
		}

		parent::create(new Field(), [
			FieldTableMap::COL_TYPE => $this->request->post->get('type'),
			FieldTableMap::COL_NAME => $this->request->post->get('name'),
			FieldTableMap::COL_LABEL => $this->request->post->get('label'),
			FieldTableMap::COL_TOOLTIP => $this->request->post->get('tooltip'),
			FieldTableMap::COL_DEFAULT_VALUE => $this->request->post->get('default_value'),
			FieldTableMap::COL_VALIDATION_REGEX => $this->request->post->get('validation_regex'),
			FieldTableMap::COL_VALIDATION_ERROR => $this->request->post->get('validation_error'),
			FieldTableMap::COL_IS_UNIQUE => $this->request->post->get('is_unique'),
			FieldTableMap::COL_IS_REQUIRED => $this->request->post->get('is_required'),
			FieldTableMap::COL_IS_SEARCHABLE => $this->request->post->get('is_searchable'),
		]);
	}

	/**
	 * Обновление объекта
	 */
	protected function actionUpdateViaPATCH() : void
	{
		parent::update(FieldQuery::create(), [
			FieldTableMap::COL_TYPE => $this->request->post->get('type'),
			FieldTableMap::COL_NAME => $this->request->post->get('name'),
			FieldTableMap::COL_LABEL => $this->request->post->get('label'),
			FieldTableMap::COL_TOOLTIP => $this->request->post->get('tooltip'),
			FieldTableMap::COL_DEFAULT_VALUE => $this->request->post->get('default_value'),
			FieldTableMap::COL_VALIDATION_REGEX => $this->request->post->get('validation_regex'),
			FieldTableMap::COL_VALIDATION_ERROR => $this->request->post->get('validation_error'),
			FieldTableMap::COL_IS_UNIQUE => $this->request->post->get('is_unique'),
			FieldTableMap::COL_IS_REQUIRED => $this->request->post->get('is_required'),
			FieldTableMap::COL_IS_SEARCHABLE => $this->request->post->get('is_searchable'),
		]);
	}

	/**
	 * Удаление объекта
	 */
	protected function actionDeleteViaDELETE() : void
	{
		parent::delete(FieldQuery::create());
	}

	/**
	 * Чтение объекта
	 */
	protected function actionReadViaGET() : void
	{
		parent::read(FieldQuery::create(), [
			FieldTableMap::COL_ID,
			FieldTableMap::COL_TYPE,
			FieldTableMap::COL_NAME,
			FieldTableMap::COL_LABEL,
			FieldTableMap::COL_TOOLTIP,
			FieldTableMap::COL_DEFAULT_VALUE,
			FieldTableMap::COL_VALIDATION_REGEX,
			FieldTableMap::COL_VALIDATION_ERROR,
			FieldTableMap::COL_IS_UNIQUE,
			FieldTableMap::COL_IS_REQUIRED,
			FieldTableMap::COL_IS_SEARCHABLE,
		]);
	}

	/**
	 * Выгрузка объектов
	 */
	protected function actionAllViaGET() : void
	{
		fenric()->callSharedService('event', [self::EVENT_PREPARE_ITEM])->subscribe(function(Field $field, array & $json)
		{
			if ($field->getUserRelatedByCreatedBy() instanceof ActiveRecordInterface)
			{
				$json['creator'] = [];
				$json['creator']['id'] = $field->getUserRelatedByCreatedBy()->getId();
				$json['creator']['username'] = $field->getUserRelatedByCreatedBy()->getUsername();
			}

			if ($field->getUserRelatedByUpdatedBy() instanceof ActiveRecordInterface)
			{
				$json['updater'] = [];
				$json['updater']['id'] = $field->getUserRelatedByUpdatedBy()->getId();
				$json['updater']['username'] = $field->getUserRelatedByUpdatedBy()->getUsername();
			}
		});

		$query = FieldQuery::create();
		$query->orderById(Criteria::DESC);

		parent::all($query, [
			FieldTableMap::COL_ID,
			FieldTableMap::COL_TYPE,
			FieldTableMap::COL_LABEL,
			FieldTableMap::COL_IS_UNIQUE,
			FieldTableMap::COL_IS_REQUIRED,
			FieldTableMap::COL_IS_SEARCHABLE,
			FieldTableMap::COL_CREATED_AT,
			FieldTableMap::COL_UPDATED_AT,
		]);
	}

	/**
	 * Простая выгрузка объектов
	 */
	protected function actionUnloadViaGET() : void
	{
		$this->response->setJsonContent(
			fenric('query')
				->select(FieldTableMap::COL_ID)
				->select(FieldTableMap::COL_TYPE)
				->select(FieldTableMap::COL_LABEL)
				->from(FieldTableMap::TABLE_NAME)
			->toArray()
		);
	}
}
