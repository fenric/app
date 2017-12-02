<?php

namespace Propel\Models;

use Propel\Models\Base\Banner as BaseBanner;

/**
 * Skeleton subclass for representing a row from the 'fenric_banner' table.
 *
 * You should add additional methods to this class to meet the application requirements.
 * This class will only be generated as long as it does not already exist in the output directory.
 */
class Banner extends BaseBanner
{

	/**
	 * Активен ли баннер
	 */
	public function isActived() : bool
	{
		if ($this->getShowStart() instanceof \DateTime)
		{
			if ($this->getShowStart() > new \DateTime('now'))
			{
				return false;
			}
		}

		if ($this->getShowEnd() instanceof \DateTime)
		{
			if ($this->getShowEnd() < new \DateTime('now'))
			{
				return false;
			}
		}

		if ($this->getShowsLimit() > 0)
		{
			if ($this->getShowsLimit() < $this->getShows())
			{
				return false;
			}
		}

		if ($this->getClicksLimit() > 0)
		{
			if ($this->getClicksLimit() < $this->getClicks())
			{
				return false;
			}
		}

		return true;
	}
}
