<?php

namespace Propel\Models;

use Propel\Models\Base\BannerGroup as BaseBannerGroup;

use Propel\Models\Banner;
use Propel\Models\BannerQuery;
use Propel\Models\Map\BannerTableMap;

/**
 * Skeleton subclass for representing a row from the 'fenric_banner_group' table.
 *
 * You should add additional methods to this class to meet the application requirements.
 * This class will only be generated as long as it does not already exist in the output directory.
 */
class BannerGroup extends BaseBannerGroup
{

	/**
	 * Получение количества объектов в группе
	 */
	public function getCountBanners() : int
	{
		return fenric('query')
			->count(BannerTableMap::COL_ID)
			->from(BannerTableMap::TABLE_NAME)
			->where(BannerTableMap::COL_BANNER_GROUP_ID, '=', $this->getId())
		->readOne();
	}

	/**
	 * Рендеринг группы
	 */
	public function render(bool $showed = true) : ?string
	{
		$banner = BannerQuery::create()->findPk(fenric('query')

			->select(BannerTableMap::COL_ID)
			->from(BannerTableMap::TABLE_NAME)
			->where(BannerTableMap::COL_BANNER_GROUP_ID, '=', $this->getId())

			->and_open()
				->where(BannerTableMap::COL_SHOW_START, 'is', null)
					->or_()->where(BannerTableMap::COL_SHOW_START, '<=', new \DateTime('now'))

			->close_and_open()
				->where(BannerTableMap::COL_SHOW_END, 'is', null)
					->or_()->where(BannerTableMap::COL_SHOW_END, '>=', new \DateTime('now'))

			->close_and_open()
				->where(BannerTableMap::COL_SHOWS_LIMIT, 'is', null)
					->or_()->where(BannerTableMap::COL_SHOWS, '<', function() {
						return BannerTableMap::COL_SHOWS_LIMIT;
					})

			->close_and_open()
				->where(BannerTableMap::COL_CLICKS_LIMIT, 'is', null)
					->or_()->where(BannerTableMap::COL_CLICKS, '<', function() {
						return BannerTableMap::COL_CLICKS_LIMIT;
					})

			// ->order('shows')
			// ->asc()

			->rand()

		->readOne());

		if ($banner instanceof Banner)
		{
			if ($showed)
			{
				$banner->setShows(
					$banner->getShows() + 1
				);

				$banner->save();
			}

			return fenric('view::partials/banner', [
				'group' => $this,
				'banner' => $banner,
			])->render();
		}

		return null;
	}
}
