<?php

namespace Propel\Models;

use Propel\Models\Base\SectionField as BaseSectionField;

use Propel\Models\Map\SectionFieldTableMap;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Connection\ConnectionInterface;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Skeleton subclass for representing a row from the 'section_field' table.
 *
 * You should add additional methods to this class to meet the application requirements.
 * This class will only be generated as long as it does not already exist in the output directory.
 */
class SectionField extends BaseSectionField
{

	/**
	 * Code to be run before inserting to database
	 *
	 * @param   ConnectionInterface   $connection
	 *
	 * @access  public
	 * @return  bool
	 */
	public function preInsert(ConnectionInterface $connection = null)
	{
		$this->setSequence(fenric('query')
			->max(SectionFieldTableMap::COL_SEQUENCE)
			->from(SectionFieldTableMap::TABLE_NAME)
			->where(SectionFieldTableMap::COL_SECTION_ID, '=', $this->getSection()->getId())
		->readOne() + 1);

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
		$metadata->addConstraint(new Callback(function($root, ExecutionContextInterface $context)
		{
			if ($root->getField() instanceof ActiveRecordInterface)
			{
				if ($root->getSection() instanceof ActiveRecordInterface)
				{
					$query = fenric('query')

					->select(SectionFieldTableMap::COL_ID)
					->from(SectionFieldTableMap::TABLE_NAME)

					->where(SectionFieldTableMap::COL_FIELD_ID, '=', $root->getField()->getId())
					->where(SectionFieldTableMap::COL_SECTION_ID, '=', $root->getSection()->getId());

					$root->isNew() or $query->where(SectionFieldTableMap::COL_ID, '!=', $root->getId());

					if ($query->readOne())
					{
						$context->buildViolation('Дополнительное поле уже привязано к разделу.')->atPath('*')->addViolation();

						return false;
					}
				}
			}
		}));
	}
}
