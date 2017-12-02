<?php

namespace Fenric\Controllers\Admin;

/**
 * Import classes
 */
use Propel\Models\Snippet;
use Propel\Models\SnippetQuery;
use Propel\Models\Map\SnippetTableMap;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Fenric\Controllers\Abstractable\CRUD;

/**
 * ApiSnippet
 */
class ApiSnippet extends CRUD
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
			if (strlen($this->request->post->get('title')) > 0) {
				$this->request->post->set('code', sluggable(
					$this->request->post->get('title')
				));
			}
		}

		parent::create(new Snippet(), [
			SnippetTableMap::COL_CODE => $this->request->post->get('code'),
			SnippetTableMap::COL_TITLE => $this->request->post->get('title'),
			SnippetTableMap::COL_VALUE => $this->request->post->get('value'),
		]);
	}

	/**
	 * Обновление объекта
	 */
	protected function actionUpdateViaPATCH() : void
	{
		parent::update(SnippetQuery::create(), [
			SnippetTableMap::COL_CODE => $this->request->post->get('code'),
			SnippetTableMap::COL_TITLE => $this->request->post->get('title'),
			SnippetTableMap::COL_VALUE => $this->request->post->get('value'),
		]);
	}

	/**
	 * Удаление объекта
	 */
	protected function actionDeleteViaDELETE() : void
	{
		parent::delete(SnippetQuery::create());
	}

	/**
	 * Чтение объекта
	 */
	protected function actionReadViaGET() : void
	{
		fenric()->callSharedService('event', [self::EVENT_PREPARE_ITEM])->subscribe(function(Snippet $snippet, array & $json)
		{
			$json['parsed_value'] = $snippet->getParsedValue();
		});

		parent::read(SnippetQuery::create(), [
			SnippetTableMap::COL_ID,
			SnippetTableMap::COL_CODE,
			SnippetTableMap::COL_TITLE,
			SnippetTableMap::COL_VALUE,
		]);
	}

	/**
	 * Выгрузка объектов
	 */
	protected function actionAllViaGET() : void
	{
		fenric()->callSharedService('event', [self::EVENT_PREPARE_ITEM])->subscribe(function(Snippet $snippet, array & $json)
		{
			if ($snippet->getUserRelatedByCreatedBy() instanceof ActiveRecordInterface)
			{
				$json['creator'] = [];
				$json['creator']['id'] = $snippet->getUserRelatedByCreatedBy()->getId();
				$json['creator']['username'] = $snippet->getUserRelatedByCreatedBy()->getUsername();
			}

			if ($snippet->getUserRelatedByUpdatedBy() instanceof ActiveRecordInterface)
			{
				$json['updater'] = [];
				$json['updater']['id'] = $snippet->getUserRelatedByUpdatedBy()->getId();
				$json['updater']['username'] = $snippet->getUserRelatedByUpdatedBy()->getUsername();
			}
		});

		$query = SnippetQuery::create();
		$query->orderById(Criteria::DESC);

		if ($this->request->query->exists('q'))
		{
			$q = searchable($this->request->query->get('q'), 32, '%');

			$query->_or()->filterById(sprintf('%%%s%%', $q), Criteria::LIKE);
			$query->_or()->filterByCode(sprintf('%%%s%%', $q), Criteria::LIKE);
			$query->_or()->filterByTitle(sprintf('%%%s%%', $q), Criteria::LIKE);
		}

		parent::all($query, [
			SnippetTableMap::COL_ID,
			SnippetTableMap::COL_CODE,
			SnippetTableMap::COL_TITLE,
			SnippetTableMap::COL_CREATED_AT,
			SnippetTableMap::COL_UPDATED_AT,
		]);
	}
}
