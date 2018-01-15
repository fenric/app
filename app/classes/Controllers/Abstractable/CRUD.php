<?php

namespace Fenric\Controllers\Abstractable;

/**
 * Import classes
 */
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Map\TableMap;

/**
 * C.R.U.D. controller.
 */
abstract class CRUD extends Actionable
{

	/**
	 * Входные данные как есть
	 */
	protected $data;

	/**
	 * Имя параметра содержащего идентификатор целевого ресурса
	 */
	protected const ID_PARAMETER_NAME = 'id';

	/**
	 * Имя HTTP GET параметра содержащего номер текущей страницы
	 */
	protected const PAGE_QUERY_NAME = 'page';

	/**
	 * Имя HTTP GET параметра содержащего количество выгружаемых объектов
	 */
	protected const LIMIT_QUERY_NAME = 'limit';

	/**
	 * Количество выгружаемых объектов по умолчанию
	 */
	protected const DEFAULT_LIMIT = 25;

	/**
	 * Максимально возможное количество выгружаемых объектов
	 */
	protected const MAXIMUM_LIMIT = 100;

	/**
	 * Событие вызываемое перед валидацией элемента
	 */
	protected const EVENT_BEFORE_VALIDATE = 'http.controller.crud.event.before.validate';

	/**
	 * Событие вызываемое перед сохранением элемента
	 */
	protected const EVENT_BEFORE_SAVE = 'http.controller.crud.event.before.save';

	/**
	 * Событие вызываемое после сохранения элемента
	 */
	protected const EVENT_AFTER_SAVE = 'http.controller.crud.event.after.save';

	/**
	 * Событие вызываемое перед удалением элемента
	 */
	protected const EVENT_BEFORE_DELETE = 'http.controller.crud.event.before.delete';

	/**
	 * Событие вызываемое после удаления элемента
	 */
	protected const EVENT_AFTER_DELETE = 'http.controller.crud.event.after.delete';

	/**
	 * Событие для обработки элемента
	 */
	protected const EVENT_PREPARE_ITEM = 'http.controller.crud.event.prepare.item';

	/**
	 * Инициализация контроллера
	 */
	public function init() : void
	{
		parse_str($this->request->body(), $this->data);

		array_walk_recursive($this->data, function($value, $param) : void
		{
			$value = trim($value);

			$this->request->post->set($param, (strlen($value) > 0 ? $value : null));
		});
	}

	/**
	 * Создание целевого ресурса
	 */
	final protected function create(ActiveRecordInterface $model, array $data) : void
	{
		$output = ['success' => false, 'created' => null, 'errors' => []];

		foreach ($data as $col => $value)
		{
			$model->setByName($col, $value, TableMap::TYPE_COLNAME);
		}

		if (fenric()->callSharedService('event', [self::EVENT_BEFORE_VALIDATE])->run([$model]))
		{
			if (! method_exists($model, 'validate') || $model->validate())
			{
				try
				{
					fenric()->callSharedService('event', [self::EVENT_BEFORE_SAVE])->run([$model]);

					if ($model->save() > 0)
					{
						$output['success'] = true;
						$output['created']['id'] = $model->getId();

						fenric()->callSharedService('event', [self::EVENT_AFTER_SAVE])->run([$model, & $output]);
					}
				}

				catch (\Exception $failure)
				{
					$output['errors'][] = [$failure->getMessage(), '*'];

					if ($failure->getPrevious() instanceof \Exception)
					{
						$output['errors'][] = [$failure->getPrevious()->getMessage(), '*'];
					}
				}
			}

			else foreach ($model->getValidationFailures() as $failure)
			{
				$error = explode('|', $failure->getMessage())[0];

				$output['errors'][] = [$error, $failure->getPropertyPath()];
			}
		}

		$this->response->json($output);
	}

	/**
	 * Обновление целевого ресурса
	 */
	final protected function update(ModelCriteria $query, array $data) : void
	{
		if (! $this->request->parameters->exists(static::ID_PARAMETER_NAME)) {
			$this->response->status(\Fenric\Response::STATUS_400);
			return;
		}

		if (! ($model = $query->findPk($this->request->parameters->get(static::ID_PARAMETER_NAME)))) {
			$this->response->status(\Fenric\Response::STATUS_404);
			return;
		}

		$output = ['success' => false, 'errors' => []];

		foreach ($data as $col => $value)
		{
			$model->setByName($col, $value, TableMap::TYPE_COLNAME);
		}

		if (fenric()->callSharedService('event', [self::EVENT_BEFORE_VALIDATE])->run([$model]))
		{
			if (! method_exists($model, 'validate') || $model->validate())
			{
				try
				{
					fenric()->callSharedService('event', [self::EVENT_BEFORE_SAVE])->run([$model]);

					if ($model->save() > 0)
					{
						$output['success'] = true;

						fenric()->callSharedService('event', [self::EVENT_AFTER_SAVE])->run([$model, & $output]);
					}
				}

				catch (\Exception $failure)
				{
					$output['errors'][] = [$failure->getMessage(), '*'];

					if ($failure->getPrevious() instanceof \Exception)
					{
						$output['errors'][] = [$failure->getPrevious()->getMessage(), '*'];
					}
				}
			}

			else foreach ($model->getValidationFailures() as $failure)
			{
				$error = explode('|', $failure->getMessage())[0];

				$output['errors'][] = [$error, $failure->getPropertyPath()];
			}
		}

		$this->response->json($output);
	}

	/**
	 * Удаление целевого ресурса
	 */
	final protected function delete(ModelCriteria $query) : void
	{
		if (! $this->request->parameters->exists(static::ID_PARAMETER_NAME)) {
			$this->response->status(\Fenric\Response::STATUS_400);
			return;
		}

		if (! ($model = $query->findPk($this->request->parameters->get(static::ID_PARAMETER_NAME)))) {
			$this->response->status(\Fenric\Response::STATUS_404);
			return;
		}

		fenric()->callSharedService('event', [
			self::EVENT_BEFORE_DELETE
		])->run([$model]);

		$model->delete();

		if (! $model->isDeleted()) {
			$this->response->status(\Fenric\Response::STATUS_503);
			return;
		}

		$this->response->status(\Fenric\Response::STATUS_200);

		fenric()->callSharedService('event', [
			self::EVENT_AFTER_DELETE
		])->run([$model]);
	}

	/**
	 * Выгрузка целевого ресурса
	 */
	final protected function read(ModelCriteria $query, array $cols) : void
	{
		if (! $this->request->parameters->exists(static::ID_PARAMETER_NAME)) {
			$this->response->status(\Fenric\Response::STATUS_400);
			return;
		}

		if (! ($model = $query->findPk($this->request->parameters->get(static::ID_PARAMETER_NAME)))) {
			$this->response->status(\Fenric\Response::STATUS_404);
			return;
		}

		$output = [];

		foreach ($cols as $col)
		{
			$f = ltrim(strrchr($col, '.'), '.');

			$output[$f] = $model->getByName($col, TableMap::TYPE_COLNAME);
		}

		fenric()->callSharedService('event', [
			self::EVENT_PREPARE_ITEM
		])->run([$model, & $output]);

		array_walk_recursive($output, function(& $value)
		{
			if ($value instanceof \DateTime) {
				$value = $value->format(\DateTime::W3C);
			}
			if ($value instanceof ActiveRecordInterface) {
				$value = $value->toArray(TableMap::TYPE_FIELDNAME, false);
			}
		});

		$this->response->json($output);
	}

	/**
	 * Выгрузка целевых ресурсов
	 */
	final protected function all(ModelCriteria $query, array $cols, array $options = []) : void
	{
		$page = 1;

		$limit = $options['limit'] ?? static::DEFAULT_LIMIT;

		if ($this->request->query->exists(static::PAGE_QUERY_NAME)) {
			if (ctype_digit($this->request->query->get(static::PAGE_QUERY_NAME))) {
				if ($this->request->query->get(static::PAGE_QUERY_NAME) >= 1) {
					if ($this->request->query->get(static::PAGE_QUERY_NAME) <= PHP_INT_MAX) {
						$page = $this->request->query->get(static::PAGE_QUERY_NAME);
					}
				}
			}
		}

		if ($this->request->query->exists(static::LIMIT_QUERY_NAME)) {
			if (ctype_digit($this->request->query->get(static::LIMIT_QUERY_NAME))) {
				if ($this->request->query->get(static::LIMIT_QUERY_NAME) >= 1) {
					if ($this->request->query->get(static::LIMIT_QUERY_NAME) <= static::MAXIMUM_LIMIT) {
						$limit = $this->request->query->get(static::LIMIT_QUERY_NAME);
					}
				}
			}
		}

		$output = [];

		$paginate = $query->paginate($page, $limit);

		$output['count'] = $paginate->getNbResults();

		if ($output['pagination']['have'] = $paginate->haveToPaginate())
		{
			$output['pagination']['links']['first'] = $paginate->getFirstPage();
			$output['pagination']['links']['previous'] = $paginate->getPreviousPage();
			$output['pagination']['links']['start'] = min($paginate->getLinks());
			$output['pagination']['links']['current'] = $paginate->getPage();
			$output['pagination']['links']['end'] = max($paginate->getLinks());
			$output['pagination']['links']['next'] = $paginate->getNextPage();
			$output['pagination']['links']['last'] = $paginate->getLastPage();
		}

		foreach ($paginate as $i => $model)
		{
			foreach ($cols as $col)
			{
				$f = ltrim(strrchr($col, '.'), '.');

				$output['items'][$i][$f] = $model->getByName($col, TableMap::TYPE_COLNAME);
			}

			fenric()->callSharedService('event', [
				self::EVENT_PREPARE_ITEM
			])->run([$model, & $output['items'][$i]]);

			array_walk_recursive($output['items'][$i], function(& $value)
			{
				if ($value instanceof \DateTime) {
					$value = $value->format(\DateTime::W3C);
				}
				if ($value instanceof ActiveRecordInterface) {
					$value = $value->toArray(TableMap::TYPE_FIELDNAME, false);
				}
			});
		}

		$this->response->json($output);
	}
}
