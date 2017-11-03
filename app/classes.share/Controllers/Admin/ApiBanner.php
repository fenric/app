<?php

namespace Fenric\Controllers\Admin;

/**
 * Import classes
 */
use Propel\Models\Banner;
use Propel\Models\BannerQuery;
use Propel\Models\Map\BannerTableMap;

use Propel\Models\BannerGroup;
use Propel\Models\BannerGroupQuery;
use Propel\Models\Map\BannerGroupTableMap;

use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Fenric\Controllers\Abstractable\CRUD;

/**
 * ApiBanner
 */
class ApiBanner extends CRUD
{

	/**
	 * Доступ к контроллеру
	 */
	use Access;

	/**
	 * Создание группы
	 */
	protected function actionCreateGroupViaPOST() : void
	{
		if (strlen($this->request->post->get('code')) === 0) {
			if (strlen($this->request->post->get('title')) > 0) {
				$this->request->post->set('code', sluggable(
					$this->request->post->get('title')
				));
			}
		}

		parent::create(new BannerGroup(), [
			BannerGroupTableMap::COL_CODE => $this->request->post->get('code'),
			BannerGroupTableMap::COL_TITLE => $this->request->post->get('title'),
		]);
	}

	/**
	 * Обновление группы
	 */
	protected function actionUpdateGroupViaPATCH() : void
	{
		parent::update(BannerGroupQuery::create(), [
			BannerGroupTableMap::COL_CODE => $this->request->post->get('code'),
			BannerGroupTableMap::COL_TITLE => $this->request->post->get('title'),
		]);
	}

	/**
	 * Удаление группы
	 */
	protected function actionDeleteGroupViaDELETE() : void
	{
		parent::delete(BannerGroupQuery::create());
	}

	/**
	 * Чтение группы
	 */
	protected function actionReadGroupViaGET() : void
	{
		parent::read(BannerGroupQuery::create(), [
			BannerGroupTableMap::COL_ID,
			BannerGroupTableMap::COL_CODE,
			BannerGroupTableMap::COL_TITLE,
		]);
	}

	/**
	 * Выгрузка групп
	 */
	protected function actionAllGroupsViaGET() : void
	{
		fenric()->callSharedService('event', [self::EVENT_PREPARE_ITEM])->subscribe(function(BannerGroup $group, array & $json)
		{
			$json['banners'] = $group->getCountBanners();

			if ($group->getUserRelatedByCreatedBy() instanceof ActiveRecordInterface)
			{
				$json['creator'] = [];
				$json['creator']['id'] = $group->getUserRelatedByCreatedBy()->getId();
				$json['creator']['username'] = $group->getUserRelatedByCreatedBy()->getUsername();
			}

			if ($group->getUserRelatedByUpdatedBy() instanceof ActiveRecordInterface)
			{
				$json['updater'] = [];
				$json['updater']['id'] = $group->getUserRelatedByUpdatedBy()->getId();
				$json['updater']['username'] = $group->getUserRelatedByUpdatedBy()->getUsername();
			}
		});

		$query = BannerGroupQuery::create();
		$query->orderById(Criteria::DESC);

		if ($this->request->query->exists('q'))
		{
			$q = searchable($this->request->query->get('q'), 32, '%');

			$query->_or()->filterById(sprintf('%%%s%%', $q), Criteria::LIKE);
			$query->_or()->filterByCode(sprintf('%%%s%%', $q), Criteria::LIKE);
			$query->_or()->filterByTitle(sprintf('%%%s%%', $q), Criteria::LIKE);
		}

		parent::all($query, [
			BannerGroupTableMap::COL_ID,
			BannerGroupTableMap::COL_CODE,
			BannerGroupTableMap::COL_TITLE,
			BannerGroupTableMap::COL_CREATED_AT,
			BannerGroupTableMap::COL_UPDATED_AT,
		]);
	}

	/**
	 * Простая выгрузка групп
	 */
	protected function actionUnloadGroupsViaGET() : void
	{
		$this->response->setJsonContent(
			fenric('query')
				->select(BannerGroupTableMap::COL_ID)
				->select(BannerGroupTableMap::COL_TITLE)
				->from(BannerGroupTableMap::TABLE_NAME)
			->toArray()
		);
	}

	/**
	 * Создание баннера
	 */
	protected function actionCreateBannerViaPOST() : void
	{
		parent::create(new Banner(), [
			BannerTableMap::COL_BANNER_GROUP_ID => $this->request->post->get('banner_group_id'),
			BannerTableMap::COL_TITLE => $this->request->post->get('title'),
			BannerTableMap::COL_DESCRIPTION => $this->request->post->get('description'),
			BannerTableMap::COL_PICTURE => $this->request->post->get('picture'),
			BannerTableMap::COL_PICTURE_ALT => $this->request->post->get('picture_alt'),
			BannerTableMap::COL_PICTURE_TITLE => $this->request->post->get('picture_title'),
			BannerTableMap::COL_HYPERLINK_URL => $this->request->post->get('hyperlink_url'),
			BannerTableMap::COL_HYPERLINK_TITLE => $this->request->post->get('hyperlink_title'),
			BannerTableMap::COL_HYPERLINK_TARGET => $this->request->post->get('hyperlink_target'),
			BannerTableMap::COL_SHOW_START => $this->request->post->get('show_start'),
			BannerTableMap::COL_SHOW_END => $this->request->post->get('show_end'),
			BannerTableMap::COL_SHOWS_LIMIT => $this->request->post->get('shows_limit'),
			BannerTableMap::COL_CLICKS_LIMIT => $this->request->post->get('clicks_limit'),
		]);
	}

	/**
	 * Обновление баннера
	 */
	protected function actionUpdateBannerViaPATCH() : void
	{
		parent::update(BannerQuery::create(), [
			BannerTableMap::COL_BANNER_GROUP_ID => $this->request->post->get('banner_group_id'),
			BannerTableMap::COL_TITLE => $this->request->post->get('title'),
			BannerTableMap::COL_DESCRIPTION => $this->request->post->get('description'),
			BannerTableMap::COL_PICTURE => $this->request->post->get('picture'),
			BannerTableMap::COL_PICTURE_ALT => $this->request->post->get('picture_alt'),
			BannerTableMap::COL_PICTURE_TITLE => $this->request->post->get('picture_title'),
			BannerTableMap::COL_HYPERLINK_URL => $this->request->post->get('hyperlink_url'),
			BannerTableMap::COL_HYPERLINK_TITLE => $this->request->post->get('hyperlink_title'),
			BannerTableMap::COL_HYPERLINK_TARGET => $this->request->post->get('hyperlink_target'),
			BannerTableMap::COL_SHOW_START => $this->request->post->get('show_start'),
			BannerTableMap::COL_SHOW_END => $this->request->post->get('show_end'),
			BannerTableMap::COL_SHOWS_LIMIT => $this->request->post->get('shows_limit'),
			BannerTableMap::COL_CLICKS_LIMIT => $this->request->post->get('clicks_limit'),
		]);
	}

	/**
	 * Удаление баннера
	 */
	protected function actionDeleteBannerViaDELETE() : void
	{
		parent::delete(BannerQuery::create());
	}

	/**
	 * Чтение баннера
	 */
	protected function actionReadBannerViaGET() : void
	{
		parent::read(BannerQuery::create(), [
			BannerTableMap::COL_ID,
			BannerTableMap::COL_BANNER_GROUP_ID,
			BannerTableMap::COL_TITLE,
			BannerTableMap::COL_DESCRIPTION,
			BannerTableMap::COL_PICTURE,
			BannerTableMap::COL_PICTURE_ALT,
			BannerTableMap::COL_PICTURE_TITLE,
			BannerTableMap::COL_HYPERLINK_URL,
			BannerTableMap::COL_HYPERLINK_TITLE,
			BannerTableMap::COL_HYPERLINK_TARGET,
			BannerTableMap::COL_SHOW_START,
			BannerTableMap::COL_SHOW_END,
			BannerTableMap::COL_SHOWS_LIMIT,
			BannerTableMap::COL_CLICKS_LIMIT,
		]);
	}

	/**
	 * Выгрузка баннеров
	 */
	protected function actionAllBannersViaGET() : void
	{
		fenric()->callSharedService('event', [self::EVENT_PREPARE_ITEM])->subscribe(function(Banner $banner, array & $json)
		{
			$json['actived'] = $banner->isActived();

			if ($banner->getBannerGroup() instanceof ActiveRecordInterface)
			{
				$json['group'] = [];
				$json['group']['id'] = $banner->getBannerGroup()->getId();
				$json['group']['code'] = $banner->getBannerGroup()->getCode();
				$json['group']['title'] = $banner->getBannerGroup()->getTitle();
			}

			if ($banner->getUserRelatedByCreatedBy() instanceof ActiveRecordInterface)
			{
				$json['creator'] = [];
				$json['creator']['id'] = $banner->getUserRelatedByCreatedBy()->getId();
				$json['creator']['username'] = $banner->getUserRelatedByCreatedBy()->getUsername();
			}

			if ($banner->getUserRelatedByUpdatedBy() instanceof ActiveRecordInterface)
			{
				$json['updater'] = [];
				$json['updater']['id'] = $banner->getUserRelatedByUpdatedBy()->getId();
				$json['updater']['username'] = $banner->getUserRelatedByUpdatedBy()->getUsername();
			}
		});

		$query = BannerQuery::create();
		$query->orderById(Criteria::DESC);

		if ($this->request->query->exists('q'))
		{
			$q = searchable($this->request->query->get('q'), 32, '%');

			$query->_or()->filterById(sprintf('%%%s%%', $q), Criteria::LIKE);
			$query->_or()->filterByTitle(sprintf('%%%s%%', $q), Criteria::LIKE);
		}

		parent::all($query, [
			BannerTableMap::COL_ID,
			BannerTableMap::COL_TITLE,
			BannerTableMap::COL_DESCRIPTION,
			BannerTableMap::COL_PICTURE,
			BannerTableMap::COL_SHOWS,
			BannerTableMap::COL_SHOWS_LIMIT,
			BannerTableMap::COL_CLICKS,
			BannerTableMap::COL_CLICKS_LIMIT,
			BannerTableMap::COL_CREATED_AT,
			BannerTableMap::COL_UPDATED_AT,
		]);
	}
}
