<?php

namespace Fenric\Controllers;

/**
 * Import classes
 */
use Propel\Models\Poll;
use Propel\Models\PollQuery;
use Propel\Models\Map\PollTableMap;

use Propel\Models\PollVote;
use Propel\Models\PollVoteQuery;
use Propel\Models\Map\PollVoteTableMap;

use Propel\Models\PollVariant;
use Propel\Models\PollVariantQuery;
use Propel\Models\Map\PollVariantTableMap;

use Propel\Models\User;
use Propel\Models\UserQuery;
use Propel\Models\Map\UserTableMap;

use Propel\Runtime\Collection\ObjectCollection;
use Fenric\Controllers\Abstractable\Actionable;

/**
 * Api
 */
class Api extends Actionable
{

	/**
	 * Участие в опросе
	 */
	protected function actionVoteViaPOST() : void
	{
		$json['success'] = false;
		$json['message'] = null;

		if ($this->request->parameters->exists('id'))
		{
			if (is_array($this->request->post->get('variants')))
			{
				$variants = $this->request->post->get('variants');
				$variants = array_filter($variants, 'ctype_digit');
				$variants = array_slice($variants, 0, 100);
				$variants = array_unique($variants);

				if (count($variants) > 0)
				{
					$poll = PollQuery::create()->findOneById(
						$this->request->parameters->get('id')
					);

					if ($poll instanceof Poll)
					{
						if ($poll->isOpen())
						{
							if ($poll->isRespondentVotePrimary())
							{
								if (count($variants) === 1 || $poll->isMultiple())
								{
									$map = fenric('query')
										->select(PollVariantTableMap::COL_ID)
										->select(PollVariantTableMap::COL_POLL_ID)
										->from(PollVariantTableMap::TABLE_NAME)
										->where(PollVariantTableMap::COL_POLL_ID, '=', $poll->getId())
									->readPair();

									$variants = array_filter($variants, function($variant) use($map, $poll) : bool
									{
										return ($map[$variant] ?? null) == $poll->getId();
									});

									if (count($variants) > 0)
									{
										foreach ($variants as $variant)
										{
											$vote = new PollVote();

											$vote->setPollVariantId($variant);
											$vote->setRespondentUserAgent($this->request->environment->get('HTTP_USER_AGENT'));
											$vote->setRespondentRemoteAddress($this->request->environment->get('REMOTE_ADDR'));
											$vote->setRespondentSessionId(fenric('session')->getId());
											$vote->setRespondentVoteId($poll->getRespondentVoteId());
											$vote->setRespondentId($poll->getRespondentId());
											$vote->setVoteAt(new \DateTime('now'));

											$vote->save();
										}

										$json['html'] = $poll->render();
										$json['success'] = true;
									}
									else $json['message'] = 'Вы пытались отправить варианты ответов с другого опроса?';
								}
								else $json['message'] = 'Вы не можете передать несколько вариантов ответов в этом опросе.';
							}
							else $json['message'] = 'Вы не можете повторно принять участие в опросе.';
						}
						else $json['message'] = 'Вы не можете принять участие в закрытом опросе.';
					}
					else $json['message'] = 'Получен идентификатор неизвестного опроса.';
				}
				else $json['message'] = 'Получены некорректные варианты ответов опроса.';
			}
			else $json['message'] = 'Не получены варианты ответов опроса.';
		}
		else $json['message'] = 'Не получен идентификатор опроса.';

		$this->response->setJsonContent($json);
	}
}
