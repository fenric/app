<?php

namespace Fenric\Controllers\Admin;

/**
 * Import classes
 */
use Propel\Models\Parameter;
use Propel\Models\ParameterQuery;
use Propel\Models\Map\ParameterTableMap;
use Propel\Runtime\ActiveQuery\Criteria;
use Fenric\Controllers\Abstractable\CRUD;

/**
 * ApiParameter
 */
class ApiParameter extends CRUD
{

	/**
	 * Доступ к контроллеру
	 */
	use Access;

	/**
	 * Сохранение объектов
	 */
	protected function actionSaveViaPOST() : void
	{
		foreach ($this->request->post->all() as $code => $value)
		{
			$query = ParameterQuery::create();

			$parameter = $query->findOneByCode($code);

			if (! ($parameter instanceof Parameter))
			{
				$parameter = new Parameter();
				$parameter->setCode($code);
			}

			$parameter->setValue($value);
			$parameter->save();
		}

		$this->response->setJsonContent([
			'success' => true,
			'message' => null,
		]);
	}

	/**
	 * Создание объекта
	 */
	protected function actionCreateViaPOST() : void
	{
		parent::create(new Parameter(), [
			ParameterTableMap::COL_CODE => $this->request->post->get('code'),
			ParameterTableMap::COL_VALUE => $this->request->post->get('value'),
		]);
	}

	/**
	 * Обновление объекта
	 */
	protected function actionUpdateViaPATCH() : void
	{
		parent::update(ParameterQuery::create(), [
			ParameterTableMap::COL_CODE => $this->request->post->get('code'),
			ParameterTableMap::COL_VALUE => $this->request->post->get('value'),
		]);
	}

	/**
	 * Удаление объекта
	 */
	protected function actionDeleteViaDELETE() : void
	{
		parent::delete(ParameterQuery::create());
	}

	/**
	 * Чтение объекта
	 */
	protected function actionReadViaGET() : void
	{
		parent::read(ParameterQuery::create(), [
			ParameterTableMap::COL_ID,
			ParameterTableMap::COL_CODE,
			ParameterTableMap::COL_VALUE,
		]);
	}

	/**
	 * Выгрузка объектов
	 */
	protected function actionAllViaGET() : void
	{
		$query = ParameterQuery::create();
		$query->orderById(Criteria::ASC);

		$columns = [
			ParameterTableMap::COL_ID,
			ParameterTableMap::COL_CODE,
			ParameterTableMap::COL_VALUE,
		];

		parent::all($query, $columns, [
			'limit' => PHP_INT_MAX,
		]);
	}
}
