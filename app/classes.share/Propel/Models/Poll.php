<?php

namespace Propel\Models;

use Propel\Models\Base\Poll as BasePoll;

use Propel\Models\PollVariant;
use Propel\Models\PollVariantQuery;
use Propel\Models\Map\PollVariantTableMap;

use Propel\Models\PollVote;
use Propel\Models\PollVoteQuery;
use Propel\Models\Map\PollVoteTableMap;

use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\Collection\ObjectCollection;

/**
 * Skeleton subclass for representing a row from the 'fenric_poll' table.
 *
 * You should add additional methods to this class to meet the application requirements.
 * This class will only be generated as long as it does not already exist in the output directory.
 */
class Poll extends BasePoll
{

	/**
	 * Является ли опрос открытым
	 */
	public function isOpen() : bool
	{
		if ($this->getOpenAt() instanceof \DateTime)
		{
			if ($this->getOpenAt() > new \DateTime('now'))
			{
				return false;
			}
		}

		if ($this->getCloseAt() instanceof \DateTime)
		{
			if ($this->getCloseAt() < new \DateTime('now'))
			{
				return false;
			}
		}

		return true;
	}

	/**
	 * Получение количества вариантов ответов
	 */
	public function getCountVariants() : int
	{
		return fenric('query')
			->count(PollVariantTableMap::COL_ID)
			->from(PollVariantTableMap::TABLE_NAME)
			->where(PollVariantTableMap::COL_POLL_ID, '=', $this->getId())
		->readOne();
	}

	/**
	 * Получение общего количества голосов
	 */
	public function getCountVotes() : int
	{
		return fenric('query')
			->count(PollVoteTableMap::COL_ID)
			->from(PollVoteTableMap::TABLE_NAME)
			->inner()->join(PollVariantTableMap::TABLE_NAME)
			->on(PollVariantTableMap::COL_ID, '=', PollVoteTableMap::COL_POLL_VARIANT_ID)
			->where(PollVariantTableMap::COL_POLL_ID, '=', $this->getId())
		->readOne();
	}

	/**
	 * Получение отсортированной коллекции с вариантами ответов
	 */
	public function getSortedVariants() : ObjectCollection
	{
		$query = PollVariantQuery::create();

		$query->filterByPollId($this->getId());

		$query->orderBySequence(Criteria::ASC);

		return $query->find();
	}

	/**
	 * Получение уникального идентификатора респондента
	 */
	public function getRespondentId() : string
	{
		$env = fenric('request')->environment;

		return hash('md5', $env->get('REMOTE_ADDR') . $env->get('HTTP_USER_AGENT'));
	}

	/**
	 * Получение уникального идентификатора голоса респондента
	 */
	public function getRespondentVoteId() : string
	{
		$env = fenric('request')->environment;

		return hash('md5', $this->getId() . $env->get('REMOTE_ADDR') . $env->get('HTTP_USER_AGENT'));
	}

	/**
	 * Является ли участие в опросе первичным для респондента
	 */
	public function isRespondentVotePrimary() : bool
	{
		return ! fenric('query')
			->count(PollVoteTableMap::COL_ID)
			->from(PollVoteTableMap::TABLE_NAME)
			->where(PollVoteTableMap::COL_RESPONDENT_VOTE_ID, '=', $this->getRespondentVoteId())
		->readOne();
	}

	/**
	 * Рендеринг опроса
	 */
	public function render() : ?string
	{
		$variants = $this->getSortedVariants();

		if ($variants instanceof ObjectCollection)
		{
			if ($variants->count() > 0)
			{
				if ($this->isOpen())
				{
					if ($this->isRespondentVotePrimary())
					{
						return fenric('view::poll/form', [
							'poll' => $this,
							'variants' => $variants,
						])->render();
					}
				}
			}

			return fenric('view::poll/chart', [
				'poll' => $this,
				'variants' => $variants,
			])->render();
		}

		return null;
	}
}
