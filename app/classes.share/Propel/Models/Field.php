<?php

namespace Propel\Models;

use Propel\Models\Base\Field as BaseField;

use Propel\Models\Publication;
use Propel\Models\PublicationQuery;
use Propel\Models\Map\PublicationTableMap;

use Propel\Models\PublicationField;
use Propel\Models\PublicationFieldQuery;
use Propel\Models\Map\PublicationFieldTableMap;

use Propel\Models\Section;
use Propel\Models\SectionQuery;
use Propel\Models\Map\SectionTableMap;

use Propel\Models\SectionField;
use Propel\Models\SectionFieldQuery;
use Propel\Models\Map\SectionFieldTableMap;

use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;

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
	 */
	public function getNameWithPrefix(string $prefix) : string
	{
		return $prefix . $this->getName();
	}

	/**
	 * {@description}
	 */
	public function getNameWithPostfix(string $postfix) : string
	{
		return $this->getName() . $postfix;
	}

	/**
	 * {@description}
	 */
	public function isUnique()
	{
		if (parent::isUnique())
		{
			if ($this->isUniqueness())
			{
				return true;
			}
		}

		return false;
	}

	/**
	 * {@description}
	 */
	public function isSearchable()
	{
		if (parent::isSearchable())
		{
			if ($this->isSearchness())
			{
				return true;
			}
		}

		return false;
	}

	/**
	 * {@description}
	 */
	public function isFlag() : bool
	{
		return 0 === strcmp($this->getType(), 'flag');
	}

	/**
	 * {@description}
	 */
	public function isNumber() : bool
	{
		return 0 === strcmp($this->getType(), 'number');
	}

	/**
	 * {@description}
	 */
	public function isString() : bool
	{
		return 0 === strcmp($this->getType(), 'string');
	}

	/**
	 * {@description}
	 */
	public function isText() : bool
	{
		return 0 === strcmp($this->getType(), 'text');
	}

	/**
	 * {@description}
	 */
	public function isHtml() : bool
	{
		return 0 === strcmp($this->getType(), 'html');
	}

	/**
	 * {@description}
	 */
	public function isYear() : bool
	{
		return 0 === strcmp($this->getType(), 'year');
	}

	/**
	 * {@description}
	 */
	public function isDate() : bool
	{
		return 0 === strcmp($this->getType(), 'date');
	}

	/**
	 * {@description}
	 */
	public function isDateTime() : bool
	{
		return 0 === strcmp($this->getType(), 'datetime');
	}

	/**
	 * {@description}
	 */
	public function isTime() : bool
	{
		return 0 === strcmp($this->getType(), 'time');
	}

	/**
	 * {@description}
	 */
	public function isIp() : bool
	{
		return 0 === strcmp($this->getType(), 'ip');
	}

	/**
	 * {@description}
	 */
	public function isUrl() : bool
	{
		return 0 === strcmp($this->getType(), 'url');
	}

	/**
	 * {@description}
	 */
	public function isEmail() : bool
	{
		return 0 === strcmp($this->getType(), 'email');
	}

	/**
	 * {@description}
	 */
	public function isImage() : bool
	{
		return 0 === strcmp($this->getType(), 'image');
	}

	/**
	 * {@description}
	 */
	public function isSearchness() : bool
	{
		$types = ['flag', 'number', 'string', 'year', 'date', 'datetime', 'time', 'ip', 'url', 'email'];

		return in_array($this->getType(), $types, true);
	}

	/**
	 * {@description}
	 */
	public function isUniqueness() : bool
	{
		$types = ['number', 'string', 'year', 'date', 'datetime', 'time', 'ip', 'url', 'email'];

		return in_array($this->getType(), $types, true);
	}

	/**
	 * {@description}
	 */
	public function isStringable() : bool
	{
		$types = ['string', 'ip', 'url', 'email'];

		return in_array($this->getType(), $types, true);
	}

	/**
	 * {@description}
	 */
	public function isTimestampable() : bool
	{
		$types = ['year', 'date', 'datetime', 'time'];

		return in_array($this->getType(), $types, true);
	}

	/**
	 * {@description}
	 */
	public function isValidFlag($value) : bool
	{
		if (in_array($value, ['0', '1']))
		{
			return true;
		}

		return false;
	}

	/**
	 * {@description}
	 */
	public function isValidNumber($value) : bool
	{
		if (is_numeric($value))
		{
			return true;
		}

		return false;
	}

	/**
	 * {@description}
	 */
	public function isValidYear($value) : bool
	{
		$regexp = '/^(?<year>[0-9]{4})$/';

		if (preg_match($regexp, $value, $matches))
		{
			if (checkdate(1, 1, $matches['year']))
			{
				return true;
			}
		}

		return false;
	}

	/**
	 * {@description}
	 */
	public function isValidDate($value) : bool
	{
		$regexp = '/^(?<year>[0-9]{4})-(?<month>[0-9]{2})-(?<day>[0-9]{2})$/';

		if (preg_match($regexp, $value, $matches))
		{
			if (checkdate($matches['month'], $matches['day'], $matches['year']))
			{
				return true;
			}
		}

		return false;
	}

	/**
	 * {@description}
	 */
	public function isValidDateTime($value) : bool
	{
		$regexp = '/^(?<year>[0-9]{4})-(?<month>[0-9]{2})-(?<day>[0-9]{2})\040(?<hour>[0-9]{2}):(?<minute>[0-9]{2})$/';

		if (preg_match($regexp, $value, $matches))
		{
			if (checkdate($matches['month'], $matches['day'], $matches['year']))
			{
				if ($matches['hour'] >= 0 && $matches['hour'] <= 23)
				{
					if ($matches['minute'] >= 0 && $matches['minute'] <= 59)
					{
						return true;
					}
				}
			}
		}

		return false;
	}

	/**
	 * {@description}
	 */
	public function isValidTime($value) : bool
	{
		$regexp = '/^(?<hour>[0-9]{2}):(?<minute>[0-9]{2})$/';

		if (preg_match($regexp, $value, $matches))
		{
			if ($matches['hour'] >= 0 && $matches['hour'] <= 23)
			{
				if ($matches['minute'] >= 0 && $matches['minute'] <= 59)
				{
					return true;
				}
			}
		}

		return false;
	}

	/**
	 * {@description}
	 */
	public function isValidIp($value) : bool
	{
		if (filter_var($value, FILTER_VALIDATE_IP))
		{
			return true;
		}

		return false;
	}

	/**
	 * {@description}
	 */
	public function isValidUrl($value) : bool
	{
		if (filter_var($value, FILTER_VALIDATE_URL))
		{
			return true;
		}

		return false;
	}

	/**
	 * {@description}
	 */
	public function isValidEmail($value) : bool
	{
		if (filter_var($value, FILTER_VALIDATE_EMAIL))
		{
			return true;
		}

		return false;
	}

	/**
	 * {@description}
	 */
	public function isValidByRegex($value) : bool
	{
		if (! (strlen($this->getValidationRegex()) === 0))
		{
			if (! preg_match($this->getValidationRegex(), $value))
			{
				return false;
			}
		}

		return true;
	}

	/**
	 * {@description}
	 *
	 * @throws  \RuntimeException
	 */
	public function isValidValue($value) : bool
	{
		if ($value instanceof \DateTime)
		{
			if ($this->isTimestampable())
			{
				return true;
			}

			$error = 'Invalid value.';

			throw new \RuntimeException(
				$this->getValidationError() ?: $error
			);
		}

		if (strlen($value) > 0)
		{
			if ($this->isFlag())
			{
				if (! $this->isValidFlag($value))
				{
					$error = 'Invalid flag.';

					throw new \RuntimeException(
						$this->getValidationError() ?: $error
					);
				}
			}
			if ($this->isNumber())
			{
				if (! $this->isValidNumber($value))
				{
					$error = 'Invalid number.';

					throw new \RuntimeException(
						$this->getValidationError() ?: $error
					);
				}
			}
			if ($this->isYear())
			{
				if (! $this->isValidYear($value))
				{
					$error = 'Invalid year.';

					throw new \RuntimeException(
						$this->getValidationError() ?: $error
					);
				}
			}
			if ($this->isDate())
			{
				if (! $this->isValidDate($value))
				{
					$error = 'Invalid date.';

					throw new \RuntimeException(
						$this->getValidationError() ?: $error
					);
				}
			}
			if ($this->isDateTime())
			{
				if (! $this->isValidDateTime($value))
				{
					$error = 'Invalid datetime.';

					throw new \RuntimeException(
						$this->getValidationError() ?: $error
					);
				}
			}
			if ($this->isTime())
			{
				if (! $this->isValidTime($value))
				{
					$error = 'Invalid time.';

					throw new \RuntimeException(
						$this->getValidationError() ?: $error
					);
				}
			}
			if ($this->isIp())
			{
				if (! $this->isValidIp($value))
				{
					$error = 'Invalid IP.';

					throw new \RuntimeException(
						$this->getValidationError() ?: $error
					);
				}
			}
			if ($this->isUrl())
			{
				if (! $this->isValidUrl($value))
				{
					$error = 'Invalid URL.';

					throw new \RuntimeException(
						$this->getValidationError() ?: $error
					);
				}
			}
			if ($this->isEmail())
			{
				if (! $this->isValidEmail($value))
				{
					$error = 'Invalid email.';

					throw new \RuntimeException(
						$this->getValidationError() ?: $error
					);
				}
			}

			if (! $this->isValidByRegex($value))
			{
				$error = 'Is not valid.';

				throw new \RuntimeException(
					$this->getValidationError() ?: $error
				);
			}
		}

		if (strlen($value) === 0)
		{
			if ($this->isRequired())
			{
				$error = 'Is empty.';

				throw new \RuntimeException(
					$this->getValidationError() ?: $error
				);
			}
		}

		return true;
	}

	/**
	 * {@description}
	 *
	 * @throws  \RuntimeException
	 */
	public function isValidPublicationValue(Publication $p) : bool
	{
		if ($p->hasVirtualColumn($this->getName()))
		{
			$v = $p->getVirtualColumn($this->getName());

			if ($this->isValidValue($v))
			{
				if (strlen($v) > 0 && $this->isUnique())
				{
					$q = fenric('query');
					$c = $this->getPublicationValueColumn();

					$q->count(PublicationFieldTableMap::COL_ID);
					$q->from(PublicationFieldTableMap::TABLE_NAME);

					$q->inner()->join(SectionFieldTableMap::TABLE_NAME);
					$q->on(SectionFieldTableMap::COL_ID, '=', PublicationFieldTableMap::COL_SECTION_FIELD_ID);

					$q->inner()->join(SectionTableMap::TABLE_NAME);
					$q->on(SectionTableMap::COL_ID, '=', SectionFieldTableMap::COL_SECTION_ID);

					$q->where(SectionTableMap::COL_ID, '=', $p->getSection()->getId());
					$q->where($c, 'is not', null);

					$p->isNew() or $q->where(PublicationFieldTableMap::COL_PUBLICATION_ID, '<>', $p->getId());

					if ($this->isNumber())
					{
						$q->where($c, '=', $v);
					}

					if ($this->isStringable())
					{
						$q->where($c, '=', $v);
					}

					if ($this->isYear())
					{
						$q->where(function() use($c) : string
						{
							return sprintf('DATE_FORMAT(%s, "%%Y")', $c);

						}, '=', $v);
					}

					if ($this->isDate())
					{
						$q->where(function() use($c) : string
						{
							return sprintf('DATE_FORMAT(%s, "%%Y-%%m-%%d")', $c);

						}, '=', (new DateTime($v))->format('Y-m-d'));
					}

					if ($this->isDateTime())
					{
						$q->where(function() use($c) : string
						{
							return sprintf('DATE_FORMAT(%s, "%%Y-%%m-%%d %%H:%%i")', $c);

						}, '=', (new DateTime($v))->format('Y-m-d H:i'));
					}

					if ($this->isTime())
					{
						$q->where(function() use($c) : string
						{
							return sprintf('DATE_FORMAT(%s, "%%H:%%i")', $c);

						}, '=', (new DateTime($v))->format('H:i'));
					}

					if ($q->readOne() > 0)
					{
						throw new \RuntimeException('Is not unique.');
					}
				}
			}
		}

		return true;
	}

	/**
	 * {@description}
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
	{}
}
