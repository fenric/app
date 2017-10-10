<?php

namespace Propel\Models;

use Propel\Models\Base\PublicationField as BasePublicationField;
use Propel\Models\Map\PublicationFieldTableMap;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;

/**
 * Skeleton subclass for representing a row from the 'publication_field' table.
 *
 * You should add additional methods to this class to meet the application requirements.
 * This class will only be generated as long as it does not already exist in the output directory.
 */
class PublicationField extends BasePublicationField
{

	/**
	 * Установка значения
	 *
	 * @param   mixed   $value
	 *
	 * @access  public
	 * @return  void
	 */
	public function setValue($value)
	{
		if ($this->getSectionField())
		{
			if ($this->getSectionField()->getField())
			{
				switch ($this->getSectionField()->getField()->getType())
				{
					case 'flag' :
						$this->setBoolValue($value);
						break;

					case 'number' :
						$this->setNumberValue(
							$this->normalizeNumberValue($value)
						);
						break;

					case 'year' :
						$this->setDatetimeValue(
							sprintf('%d-01-01 00:00:00', $value)
						);
						break;

					case 'date' :
						$this->setDatetimeValue(
							(new \DateTime($value))->format('Y-m-d 00:00:00')
						);
						break;

					case 'datetime' :
						$this->setDatetimeValue(
							(new \DateTime($value))->format('Y-m-d H:i:00')
						);
						break;

					case 'time' :
						$this->setDatetimeValue(
							(new \DateTime($value))->format('1970-01-01 H:i:00')
						);
						break;

					case 'text' :
					case 'html' :
						$this->setTextValue($value);
						break;

					default :
						$this->setStringValue($value);
						break;
				}
			}
		}
	}

	/**
	 * Получение значения
	 *
	 * @access  public
	 * @return  mixed
	 */
	public function getValue()
	{
		if ($this->getSectionField())
		{
			if ($this->getSectionField()->getField())
			{
				switch ($this->getSectionField()->getField()->getType())
				{
					case 'flag' :
						return $this->getBoolValue();
						break;

					case 'number' :
						return $this->normalizeNumberValue($this->getNumberValue());
						break;

					case 'year' :
					case 'date' :
					case 'datetime' :
					case 'time' :
						return $this->getDatetimeValue();
						break;

					case 'text' :
					case 'html' :
						return $this->getTextValue();
						break;

					default :
						return $this->getStringValue();
						break;
				}
			}
		}
	}

	/**
	 * Нормализация числового значения
	 */
	protected function normalizeNumberValue($value)
	{
		if (strlen($value) > 0)
		{
			return strtr(round($value, 30), ',', '.');
		}
	}
}
