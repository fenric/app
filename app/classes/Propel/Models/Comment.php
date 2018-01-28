<?php

namespace Propel\Models;

use Propel\Models\Base\Comment as BaseComment;

use Propel\Models\Map\CommentTableMap;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Connection\ConnectionInterface;

use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * Skeleton subclass for representing a row from the 'fenric_comment' table.
 *
 * You should add additional methods to this class to meet the application requirements.
 * This class will only be generated as long as it does not already exist in the output directory.
 */
class Comment extends BaseComment
{

	/**
	 * Является ли комментарий моим?
	 */
	public function isMy() : bool
	{
		if (fenric('user')->isLogged())
		{
			if (strcmp(fenric('user')->getId(), $this->getCreatedBy()) === 0)
			{
				return true;
			}
		}

		return false;
	}

	/**
	 * Получение количества ответов у комментария
	 */
	public function getCountChildren() : int
	{
		return fenric('query')
			->count(CommentTableMap::COL_ID)
			->from(CommentTableMap::TABLE_NAME)
			->where(CommentTableMap::COL_PARENT_ID, '=', $this->getId())
		->readOne();
	}

	/**
	 * Code to be run before deleting the object in database
	 *
	 * @param   ConnectionInterface   $connection
	 *
	 * @access  public
	 * @return  bool
	 */
	public function preDelete(ConnectionInterface $connection = null)
	{
		if ($this->getPicture())
		{
			if (is_file(\Fenric\Upload::path($this->getPicture())))
			{
				if (is_readable(\Fenric\Upload::path($this->getPicture())))
				{
					unlink(\Fenric\Upload::path($this->getPicture()));
				}
			}
		}

		return true;
	}

	/**
	 * Configure validators constraints.
	 *
	 * The Validator object uses this method to perform object validation
	 *
	 * @param   ClassMetadata   $metadata
	 *
	 * @access  public
	 * @return  void
	 */
	public static function loadValidatorMetadata(ClassMetadata $metadata)
	{
		$metadata->addConstraint(new Callback(function(ActiveRecordInterface $root, ExecutionContextInterface $context)
		{
			if (! fenric('user')->isLogged())
			{
				$context->buildViolation('Для того, чтобы оставлять комментарии, необходимо войти.')->atPath('*')->addViolation();

				return false;
			}

			if (! $root->isNew() && ! $root->isMy())
			{
				if (! fenric('user')->isAdministrator() && ! fenric('user')->isModerator())
				{
					$context->buildViolation('Нельзя изменять чужие комментарии.')->atPath('*')->addViolation();

					return false;
				}
			}

			if (! ($root->getPublication() instanceof ActiveRecordInterface))
			{
				$context->buildViolation('Не удалось найти публикацию за которой вы пытаетесь закрепить комментарий, возможно она была удалена.')->atPath('*')->addViolation();

				return false;
			}

			if ($root->getParent() instanceof ActiveRecordInterface)
			{
				if (! ($root->getParent()->getPublication() instanceof ActiveRecordInterface))
				{
					$context->buildViolation('Не удалось найти публикацию за которой закреплен комментарий на который вы пытаетесь ответить, возможно она была удалена.')->atPath('*')->addViolation();

					return false;
				}

				if (! ($root->getParent()->getPublication()->equals($root->getPublication())))
				{
					$context->buildViolation('Нельзя ответить на комментарий который закреплен за другой публикацией.')->atPath('*')->addViolation();

					return false;
				}

				if ($root->getParent()->getIsDeleted())
				{
					$context->buildViolation('Нельзя ответить на удаленный комментарий.')->atPath('*')->addViolation();

					return false;
				}
			}
		}));
	}
}
