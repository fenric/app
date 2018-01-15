<?php

namespace Fenric\Controllers;

/**
 * Import classes
 */
use Propel\Models\Comment;
use Propel\Models\CommentQuery;
use Propel\Models\Map\CommentTableMap;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Fenric\Controllers\Abstractable\CRUD;

/**
 * ApiComment
 */
class ApiComment extends CRUD
{

	/**
	 * Создание объекта
	 */
	protected function actionCreateViaPOST() : void
	{
		$comment = new Comment();

		$comment->setIsDeleted(false);
		$comment->setIsVerified(true);

		parent::create($comment, [
			CommentTableMap::COL_PARENT_ID => $this->request->post->get('parent_id'),
			CommentTableMap::COL_PUBLICATION_ID => $this->request->post->get('publication_id'),
			CommentTableMap::COL_PICTURE => $this->request->post->get('picture'),
			CommentTableMap::COL_CONTENT => $this->request->post->get('content'),
		]);
	}

	/**
	 * Обновление объекта
	 */
	protected function actionUpdateViaPATCH() : void
	{
		if (! fenric('user')->isLogged())
		{
			$this->response->status(\Fenric\Response::STATUS_401);

			return;
		}

		parent::update(CommentQuery::create(), [
			CommentTableMap::COL_PICTURE => $this->request->post->get('picture'),
			CommentTableMap::COL_CONTENT => $this->request->post->get('content'),
			CommentTableMap::COL_UPDATING_REASON => $this->request->post->get('updating_reason'),
		]);
	}

	/**
	 * Удаление объекта
	 */
	protected function actionDeleteViaDELETE() : void
	{
		if (! fenric('user')->isLogged())
		{
			$this->response->status(\Fenric\Response::STATUS_401);

			return;
		}

		parent::update(CommentQuery::create(), [
			CommentTableMap::COL_IS_DELETED => true,
			CommentTableMap::COL_DELETING_REASON => $this->request->post->get('deleting_reason'),
			CommentTableMap::COL_DELETED_AT => new \DateTime('now'),
			CommentTableMap::COL_DELETED_BY => fenric('user')->getId(),
		]);
	}

	/**
	 * Чтение объекта
	 */
	protected function actionReadViaGET() : void
	{
		parent::read(CommentQuery::create(), [
			CommentTableMap::COL_ID,
			CommentTableMap::COL_PICTURE,
			CommentTableMap::COL_CONTENT,
		]);
	}

	/**
	 * Выгрузка объектов
	 */
	protected function actionAllViaGET() : void
	{
		fenric()->callSharedService('event', [self::EVENT_PREPARE_ITEM])->subscribe(function(Comment $comment, array & $json)
		{
			$plural = '{n, plural, one{# день тому назад} few{# дня тому назад} many{# дней тому назад} other{# дней тому назад}}';

			$json['children'] = $comment->getCountChildren();

			if ($comment->getIsDeleted())
			{
				$json['picture'] = null;
				$json['content'] = null;
			}

			if ($comment->getCreatedAt() instanceof \DateTime)
			{
				$json['created_at'] = msgfmt_format_message('ru_RU', $plural, [
					'n' => (new \DateTime('now'))->diff($comment->getCreatedAt())->d,
				]);

				if ($comment->getCreatedAt()->format('Ymd') === (new \DateTime('now'))->format('Ymd'))
				{
					$json['created_at'] = sprintf('сегодня в %s', $comment->getCreatedAt()->format('H:i'));
				}
				else if ($comment->getCreatedAt()->format('Ymd') === (new \DateTime('1 day ago'))->format('Ymd'))
				{
					$json['created_at'] = sprintf('вчера в %s', $comment->getCreatedAt()->format('H:i'));
				}
				else if ($comment->getCreatedAt()->format('Ymd') === (new \DateTime('2 days ago'))->format('Ymd'))
				{
					$json['created_at'] = sprintf('позавчера в %s', $comment->getCreatedAt()->format('H:i'));
				}
			}

			if ($comment->getUpdatedAt() instanceof \DateTime)
			{
				$json['updated_at'] = msgfmt_format_message('ru_RU', $plural, [
					'n' => (new \DateTime('now'))->diff($comment->getUpdatedAt())->d,
				]);

				if ($comment->getUpdatedAt()->format('Ymd') === (new \DateTime('now'))->format('Ymd'))
				{
					$json['updated_at'] = sprintf('сегодня в %s', $comment->getUpdatedAt()->format('H:i'));
				}
				else if ($comment->getUpdatedAt()->format('Ymd') === (new \DateTime('1 day ago'))->format('Ymd'))
				{
					$json['updated_at'] = sprintf('вчера в %s', $comment->getUpdatedAt()->format('H:i'));
				}
				else if ($comment->getUpdatedAt()->format('Ymd') === (new \DateTime('2 days ago'))->format('Ymd'))
				{
					$json['updated_at'] = sprintf('позавчера в %s', $comment->getUpdatedAt()->format('H:i'));
				}
			}

			if ($comment->getDeletedAt() instanceof \DateTime)
			{
				$json['deleted_at'] = msgfmt_format_message('ru_RU', $plural, [
					'n' => (new \DateTime('now'))->diff($comment->getDeletedAt())->d,
				]);

				if ($comment->getDeletedAt()->format('Ymd') === (new \DateTime('now'))->format('Ymd'))
				{
					$json['deleted_at'] = sprintf('сегодня в %s', $comment->getDeletedAt()->format('H:i'));
				}
				else if ($comment->getDeletedAt()->format('Ymd') === (new \DateTime('1 day ago'))->format('Ymd'))
				{
					$json['deleted_at'] = sprintf('вчера в %s', $comment->getDeletedAt()->format('H:i'));
				}
				else if ($comment->getDeletedAt()->format('Ymd') === (new \DateTime('2 days ago'))->format('Ymd'))
				{
					$json['deleted_at'] = sprintf('позавчера в %s', $comment->getDeletedAt()->format('H:i'));
				}
			}

			if ($comment->getUserRelatedByCreatedBy() instanceof ActiveRecordInterface)
			{
				$json['creator'] = [];
				$json['creator']['id'] = $comment->getUserRelatedByCreatedBy()->getId();
				$json['creator']['photo'] = $comment->getUserRelatedByCreatedBy()->getPhoto();
				$json['creator']['username'] = $comment->getUserRelatedByCreatedBy()->getUsername();
				$json['creator']['name'] = $comment->getUserRelatedByCreatedBy()->getName();
			}

			if ($comment->getUserRelatedByUpdatedBy() instanceof ActiveRecordInterface)
			{
				$json['updater'] = [];
				$json['updater']['id'] = $comment->getUserRelatedByUpdatedBy()->getId();
				$json['updater']['username'] = $comment->getUserRelatedByUpdatedBy()->getUsername();
				$json['updater']['name'] = $comment->getUserRelatedByUpdatedBy()->getName();
			}

			if ($comment->getUserRelatedByDeletedBy() instanceof ActiveRecordInterface)
			{
				$json['deleter'] = [];
				$json['deleter']['id'] = $comment->getUserRelatedByDeletedBy()->getId();
				$json['deleter']['username'] = $comment->getUserRelatedByDeletedBy()->getUsername();
				$json['deleter']['name'] = $comment->getUserRelatedByDeletedBy()->getName();
			}
		});

		$query = CommentQuery::create();

		$query->filterByPublicationId(
			$this->request->parameters->get('id')
		);

		$query->orderById(Criteria::ASC);

		$fields[] = CommentTableMap::COL_ID;
		$fields[] = CommentTableMap::COL_PARENT_ID;
		$fields[] = CommentTableMap::COL_PICTURE;
		$fields[] = CommentTableMap::COL_CONTENT;
		$fields[] = CommentTableMap::COL_IS_DELETED;
		$fields[] = CommentTableMap::COL_IS_VERIFIED;
		$fields[] = CommentTableMap::COL_UPDATING_REASON;
		$fields[] = CommentTableMap::COL_DELETING_REASON;
		$fields[] = CommentTableMap::COL_CREATED_AT;
		$fields[] = CommentTableMap::COL_UPDATED_AT;
		$fields[] = CommentTableMap::COL_DELETED_AT;

		$options['limit'] = PHP_INT_MAX;

		parent::all($query, $fields, $options);
	}
}
