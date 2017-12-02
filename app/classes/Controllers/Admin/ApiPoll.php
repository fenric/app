<?php

namespace Fenric\Controllers\Admin;

/**
 * Import classes
 */
use Propel\Models\Poll;
use Propel\Models\PollQuery;
use Propel\Models\Map\PollTableMap;

use Propel\Models\PollVariant;
use Propel\Models\PollVariantQuery;
use Propel\Models\Map\PollVariantTableMap;

use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\ObjectCollection;

use Fenric\Controllers\Abstractable\CRUD;

/**
 * ApiPoll
 */
class ApiPoll extends CRUD
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
		fenric()->callSharedService('event', [self::EVENT_AFTER_SAVE])->subscribe(function(Poll $poll) : void
		{
			$variants = $this->request->post->get('variants');

			if (strlen($variants) > 0)
			{
				$variants = explode("\n", $variants);
				$variants = array_map('trim', $variants);

				$variants = array_filter($variants);
				$variants = array_unique($variants);

				if (count($variants) > 0)
				{
					foreach ($variants as $title)
					{
						$variant = new PollVariant();
						$variant->setPoll($poll);
						$variant->setTitle($title);
						$variant->save();
					}
				}
			}
		});

		if (strlen($this->request->post->get('code')) === 0) {
			if (strlen($this->request->post->get('title')) > 0) {
				$this->request->post->set('code', sluggable(
					$this->request->post->get('title')
				));
			}
		}

		parent::create(new Poll(), [
			PollTableMap::COL_CODE => $this->request->post->get('code'),
			PollTableMap::COL_TITLE => $this->request->post->get('title'),
			PollTableMap::COL_MULTIPLE => $this->request->post->get('multiple'),
			PollTableMap::COL_OPEN_AT => $this->request->post->get('open_at'),
			PollTableMap::COL_CLOSE_AT => $this->request->post->get('close_at'),
		]);
	}

	/**
	 * Обновление объекта
	 */
	protected function actionUpdateViaPATCH() : void
	{
		parent::update(PollQuery::create(), [
			PollTableMap::COL_CODE => $this->request->post->get('code'),
			PollTableMap::COL_TITLE => $this->request->post->get('title'),
			PollTableMap::COL_MULTIPLE => $this->request->post->get('multiple'),
			PollTableMap::COL_OPEN_AT => $this->request->post->get('open_at'),
			PollTableMap::COL_CLOSE_AT => $this->request->post->get('close_at'),
		]);
	}

	/**
	 * Удаление объекта
	 */
	protected function actionDeleteViaDELETE() : void
	{
		parent::delete(PollQuery::create());
	}

	/**
	 * Чтение объекта
	 */
	protected function actionReadViaGET() : void
	{
		fenric()->callSharedService('event', [self::EVENT_PREPARE_ITEM])->subscribe(function(Poll $poll, array & $json)
		{
			$json['variants'] = [];

			if ($poll->getSortedVariants() instanceof ObjectCollection)
			{
				if ($poll->getSortedVariants()->count() > 0)
				{
					$i = 0;

					foreach ($poll->getSortedVariants() as $variant)
					{
						$json['variants'][$i]['id'] = $variant->getId();
						$json['variants'][$i]['title'] = $variant->getTitle();

						if ($variant->getUserRelatedByCreatedBy() instanceof ActiveRecordInterface)
						{
							$json['variants'][$i]['creator'] = [];
							$json['variants'][$i]['creator']['id'] = $variant->getUserRelatedByCreatedBy()->getId();
							$json['variants'][$i]['creator']['username'] = $variant->getUserRelatedByCreatedBy()->getUsername();
						}

						if ($variant->getUserRelatedByUpdatedBy() instanceof ActiveRecordInterface)
						{
							$json['variants'][$i]['updater'] = [];
							$json['variants'][$i]['updater']['id'] = $variant->getUserRelatedByUpdatedBy()->getId();
							$json['variants'][$i]['updater']['username'] = $variant->getUserRelatedByUpdatedBy()->getUsername();
						}

						$json['variants'][$i]['votes'] = $variant->getCountVotes();
						$json['variants'][$i]['progress'] = 0;

						if ($poll->getCountVotes() > 0)
						{
							if ($variant->getCountVotes() > 0)
							{
								$json['variants'][$i]['progress'] = floor(
									$variant->getCountVotes() * 100 / $poll->getCountVotes()
								);
							}
						}

						$i++;
					}
				}
			}
		});

		parent::read(PollQuery::create(), [
			PollTableMap::COL_ID,
			PollTableMap::COL_CODE,
			PollTableMap::COL_TITLE,
			PollTableMap::COL_MULTIPLE,
			PollTableMap::COL_OPEN_AT,
			PollTableMap::COL_CLOSE_AT,
		]);
	}

	/**
	 * Выгрузка объектов
	 */
	protected function actionAllViaGET() : void
	{
		fenric()->callSharedService('event', [self::EVENT_PREPARE_ITEM])->subscribe(function(Poll $poll, array & $json)
		{
			$json['opened'] = $poll->isOpen();
			$json['variants'] = $poll->getCountVariants();
			$json['votes'] = $poll->getCountVotes();

			if ($poll->getUserRelatedByCreatedBy() instanceof ActiveRecordInterface)
			{
				$json['creator'] = [];
				$json['creator']['id'] = $poll->getUserRelatedByCreatedBy()->getId();
				$json['creator']['username'] = $poll->getUserRelatedByCreatedBy()->getUsername();
			}

			if ($poll->getUserRelatedByUpdatedBy() instanceof ActiveRecordInterface)
			{
				$json['updater'] = [];
				$json['updater']['id'] = $poll->getUserRelatedByUpdatedBy()->getId();
				$json['updater']['username'] = $poll->getUserRelatedByUpdatedBy()->getUsername();
			}
		});

		$query = PollQuery::create();
		$query->orderById(Criteria::DESC);

		if ($this->request->query->exists('q'))
		{
			$q = searchable($this->request->query->get('q'), 32, '%');

			$query->_or()->filterById(sprintf('%%%s%%', $q), Criteria::LIKE);
			$query->_or()->filterByCode(sprintf('%%%s%%', $q), Criteria::LIKE);
			$query->_or()->filterByTitle(sprintf('%%%s%%', $q), Criteria::LIKE);
		}

		parent::all($query, [
			PollTableMap::COL_ID,
			PollTableMap::COL_CODE,
			PollTableMap::COL_TITLE,
			PollTableMap::COL_MULTIPLE,
			PollTableMap::COL_OPEN_AT,
			PollTableMap::COL_CLOSE_AT,
			PollTableMap::COL_CREATED_AT,
			PollTableMap::COL_UPDATED_AT,
		]);
	}

	/**
	 * {@description}
	 */
	protected function actionCreateVariantViaPOST() : void
	{
		parent::create(new PollVariant(), [
			PollVariantTableMap::COL_POLL_ID => $this->request->parameters->get('id'),
			PollVariantTableMap::COL_TITLE => $this->request->post->get('title'),
		]);
	}

	/**
	 * {@description}
	 */
	protected function actionUpdateVariantViaPATCH() : void
	{
		parent::update(PollVariantQuery::create(), [
			PollVariantTableMap::COL_TITLE => $this->request->post->get('title'),
		]);
	}

	/**
	 * {@description}
	 */
	protected function actionDeleteVariantViaDELETE() : void
	{
		parent::delete(PollVariantQuery::create());
	}

	/**
	 * {@description}
	 */
	protected function actionSortVariantsViaPATCH() : void
	{
		$sequence = 0;

		foreach ($this->request->post->all() as $id)
		{
			$update[PollVariantTableMap::COL_SEQUENCE] = ++$sequence;

			fenric('query')
				->update(PollVariantTableMap::TABLE_NAME, $update)
				->where(PollVariantTableMap::COL_ID, '=', $id)
				->limit(1)
			->shutdown();
		}
	}
}
