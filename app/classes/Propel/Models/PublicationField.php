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
						if (strlen($value) > 0) {
							$this->setBoolValue($value);
						}
						break;

					case 'number' :
						if (strlen($value) > 0) {
							$this->setNumberValue(
								$this->normalizeNumberValue($value)
							);
						}
						break;

					case 'year' :
						if (strlen($value) > 0) {
							$this->setDatetimeValue(
								sprintf('%d-01-01 00:00:00', $value)
							);
						}
						break;

					case 'date' :
						if (strlen($value) > 0) {
							$this->setDatetimeValue(
								(new \DateTime($value))->format('Y-m-d 00:00:00')
							);
						}
						break;

					case 'datetime' :
						if (strlen($value) > 0) {
							$this->setDatetimeValue(
								(new \DateTime($value))->format('Y-m-d H:i:00')
							);
						}
						break;

					case 'time' :
						if (strlen($value) > 0) {
							$this->setDatetimeValue(
								(new \DateTime($value))->format('1970-01-01 H:i:00')
							);
						}
						break;

					case 'text' :
					case 'html' :
						if (strlen($value) > 0) {
							$this->setTextValue($value);
						}
						break;

					default :
						if (strlen($value) > 0) {
							$this->setStringValue($value);
						}
						break;
				}
			}
		}
	}

	/**
	 * Получение значения
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
