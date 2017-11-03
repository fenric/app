<?php

namespace Propel\Models;

use Propel\Models\Base\PollVariant as BasePollVariant;
use Propel\Models\Map\PollVariantTableMap;
use Propel\Models\Map\PollVoteTableMap;
use Propel\Runtime\Connection\ConnectionInterface;

/**
 * Skeleton subclass for representing a row from the 'fenric_poll_variant' table.
 *
 * You should add additional methods to this class to meet the application requirements.
 * This class will only be generated as long as it does not already exist in the output directory.
 */
class PollVariant extends BasePollVariant
{

	/**
	 * Получение общего количества голосов
	 */
	public function getCountVotes() : int
	{
		return fenric('query')
			->count(PollVoteTableMap::COL_ID)
			->from(PollVoteTableMap::TABLE_NAME)
			->where(PollVoteTableMap::COL_POLL_VARIANT_ID, '=', $this->getId())
		->readOne();
	}

	/**
	 * Code to be run before inserting to database
	 */
	public function preInsert(ConnectionInterface $connection = null)
	{
		$this->setSequence(fenric('query')
			->max(PollVariantTableMap::COL_SEQUENCE)
			->from(PollVariantTableMap::TABLE_NAME)
			->where(PollVariantTableMap::COL_POLL_ID, '=', $this->getPoll()->getId())
		->readOne() + 1);

		return true;
	}
}
