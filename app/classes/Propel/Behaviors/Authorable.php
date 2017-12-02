<?php

namespace Fenric\Propel\Behaviors;

/**
* Import classes
*/
use Propel\Generator\Model\Behavior;

/**
* Authorable
*/
class Authorable extends Behavior
{

	/**
	 * {description}
	 *
	 * @var    string
	 * @access private
 	 */
	private $template = <<<'EOD'
	if (! $this->isColumnModified(%s)) {
		if (fenric()->existsSharedService('user')) {
			if (fenric('user')->isLogged()) {
				$this->set%s(fenric('user')->getId());
			}
		}
	}
EOD;

	/**
	 * {description}
	 *
	 * @var    array
	 * @access protected
 	 */
	protected $parameters =
	[
		'create_enable' => 'true',
		'create_column' => 'created_by',

		'update_enable' => 'true',
		'update_column' => 'updated_by',
	];

	/**
	 * Add code in ObjectBuilder::preInsert
	 *
	 * @return string
	 */
	public function preInsert($builder)
	{
		$source = '';

		if ($this->booleanValue($this->getParameter('create_enable')))
		{
			$source .= sprintf($this->template, sprintf('%sTableMap::%s', $this->getColumnForParameter('create_column')->getTable()->getPhpName(), $this->getColumnForParameter('create_column')->getConstantName()), $this->getColumnForParameter('create_column')->getPhpName());
		}

		if ($this->booleanValue($this->getParameter('update_enable')))
		{
			$source .= sprintf($this->template, sprintf('%sTableMap::%s', $this->getColumnForParameter('update_column')->getTable()->getPhpName(), $this->getColumnForParameter('update_column')->getConstantName()), $this->getColumnForParameter('update_column')->getPhpName());
		}

		return $source;
	}

	/**
	 * Add code in ObjectBuilder::preUpdate
	 *
	 * @return string
	 */
	public function preUpdate($builder)
	{
		$source = '';

		if ($this->booleanValue($this->getParameter('update_enable')))
		{
			$source .= sprintf($this->template, sprintf('%sTableMap::%s', $this->getColumnForParameter('update_column')->getTable()->getPhpName(), $this->getColumnForParameter('update_column')->getConstantName()), $this->getColumnForParameter('update_column')->getPhpName());
		}

		return $source;
	}
}
