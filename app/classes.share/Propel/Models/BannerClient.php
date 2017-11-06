<?php

namespace Propel\Models;

use Propel\Models\Base\BannerClient as BaseBannerClient;

use Propel\Models\Banner;
use Propel\Models\BannerQuery;
use Propel\Models\Map\BannerTableMap;

/**
 * Skeleton subclass for representing a row from the 'fenric_banner_client' table.
 *
 * You should add additional methods to this class to meet the application requirements.
 * This class will only be generated as long as it does not already exist in the output directory.
 */
class BannerClient extends BaseBannerClient
{

	/**
	 * Получение количества объектов у клиента
	 */
	public function getCountBanners() : int
	{
		return fenric('query')
			->count(BannerTableMap::COL_ID)
			->from(BannerTableMap::TABLE_NAME)
			->where(BannerTableMap::COL_BANNER_CLIENT_ID, '=', $this->getId())
		->readOne();
	}
}
