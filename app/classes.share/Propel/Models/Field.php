<?php

namespace Propel\Models;

use Propel\Models\Base\Field as BaseField;
use Propel\Models\Map\PublicationFieldTableMap;

/**
 * Skeleton subclass for representing a row from the 'field' table.
 *
 * You should add additional methods to this class to meet the application requirements.
 * This class will only be generated as long as it does not already exist in the output directory.
 */
class Field extends BaseField
{

	/**
	 * {@description}
	 *
	 * @access  public
	 * @return  bool
	 */
	public function isFlag() : bool
	{
		return 0 === strcmp($this->getType(), 'flag');
	}

	/**
	 * {@description}
	 *
	 * @access  public
	 * @return  bool
	 */
	public function isNumber() : bool
	{
		return 0 === strcmp($this->getType(), 'number');
	}

	/**
	 * {@description}
	 *
	 * @access  public
	 * @return  bool
	 */
	public function isString() : bool
	{
		return 0 === strcmp($this->getType(), 'string');
	}

	/**
	 * {@description}
	 *
	 * @access  public
	 * @return  bool
	 */
	public function isText() : bool
	{
		return 0 === strcmp($this->getType(), 'text');
	}

	/**
	 * {@description}
	 *
	 * @access  public
	 * @return  bool
	 */
	public function isHtml() : bool
	{
		return 0 === strcmp($this->getType(), 'html');
	}

	/**
	 * {@description}
	 *
	 * @access  public
	 * @return  bool
	 */
	public function isYear() : bool
	{
		return 0 === strcmp($this->getType(), 'year');
	}

	/**
	 * {@description}
	 *
	 * @access  public
	 * @return  bool
	 */
	public function isDate() : bool
	{
		return 0 === strcmp($this->getType(), 'date');
	}

	/**
	 * {@description}
	 *
	 * @access  public
	 * @return  bool
	 */
	public function isDateTime() : bool
	{
		return 0 === strcmp($this->getType(), 'datetime');
	}

	/**
	 * {@description}
	 *
	 * @access  public
	 * @return  bool
	 */
	public function isTime() : bool
	{
		return 0 === strcmp($this->getType(), 'time');
	}

	/**
	 * {@description}
	 *
	 * @access  public
	 * @return  bool
	 */
	public function isIp() : bool
	{
		return 0 === strcmp($this->getType(), 'ip');
	}

	/**
	 * {@description}
	 *
	 * @access  public
	 * @return  bool
	 */
	public function isUrl() : bool
	{
		return 0 === strcmp($this->getType(), 'url');
	}

	/**
	 * {@description}
	 *
	 * @access  public
	 * @return  bool
	 */
	public function isEmail() : bool
	{
		return 0 === strcmp($this->getType(), 'email');
	}

	/**
	 * {@description}
	 *
	 * @access  public
	 * @return  bool
	 */
	public function isImage() : bool
	{
		return 0 === strcmp($this->getType(), 'image');
	}

	/**
	 * {@description}
	 *
	 * @access  public
	 * @return  bool
	 */
	public function isSearchable() : bool
	{
		$types = ['flag', 'number', 'string', 'year', 'date', 'datetime', 'time', 'ip', 'url', 'email'];

		return in_array($this->getType(), $types, true);
	}

	/**
	 * {@description}
	 *
	 * @access  public
	 * @return  bool
	 */
	public function isTimestamp() : bool
	{
		$types = ['year', 'date', 'datetime', 'time'];

		return in_array($this->getType(), $types, true);
	}

	/**
	 * {@description}
	 *
	 * @access  public
	 * @return  string
	 */
	public function getPublicationValueColumn() : string
	{
		switch ($this->getType())
		{
			case 'flag' :
				return PublicationFieldTableMap::COL_BOOL_VALUE;
				break;

			case 'number' :
				return PublicationFieldTableMap::COL_NUMBER_VALUE;
				break;

			case 'year' :
			case 'date' :
			case 'datetime' :
			case 'time' :
				return PublicationFieldTableMap::COL_DATETIME_VALUE;
				break;

			case 'text' :
			case 'html' :
				return PublicationFieldTableMap::COL_TEXT_VALUE;
				break;

			default :
				return PublicationFieldTableMap::COL_STRING_VALUE;
				break;
		}
	}
}
