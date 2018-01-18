<?php

namespace Propel\Models\Base;

use \DateTime;
use \Exception;
use \PDO;
use Propel\Models\Field as ChildField;
use Propel\Models\FieldQuery as ChildFieldQuery;
use Propel\Models\SectionField as ChildSectionField;
use Propel\Models\SectionFieldQuery as ChildSectionFieldQuery;
use Propel\Models\User as ChildUser;
use Propel\Models\UserQuery as ChildUserQuery;
use Propel\Models\Map\FieldTableMap;
use Propel\Models\Map\SectionFieldTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;
use Propel\Runtime\Validator\Constraints\Unique;
use Symfony\Component\Translation\IdentityTranslator;
use Symfony\Component\Validator\ConstraintValidatorFactory;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Context\ExecutionContextFactory;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Mapping\Factory\LazyLoadingMetadataFactory;
use Symfony\Component\Validator\Mapping\Loader\StaticMethodLoader;
use Symfony\Component\Validator\Validator\RecursiveValidator;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Base class that represents a row from the 'fenric_field' table.
 *
 *
 *
 * @package    propel.generator.Propel.Models.Base
 */
abstract class Field implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Propel\\Models\\Map\\FieldTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id field.
     *
     * @var        int
     */
    protected $id;

    /**
     * The value for the type field.
     *
     * @var        string
     */
    protected $type;

    /**
     * The value for the name field.
     *
     * @var        string
     */
    protected $name;

    /**
     * The value for the label field.
     *
     * @var        string
     */
    protected $label;

    /**
     * The value for the tooltip field.
     *
     * @var        string
     */
    protected $tooltip;

    /**
     * The value for the default_value field.
     *
     * @var        string
     */
    protected $default_value;

    /**
     * The value for the validation_regex field.
     *
     * @var        string
     */
    protected $validation_regex;

    /**
     * The value for the validation_error field.
     *
     * @var        string
     */
    protected $validation_error;

    /**
     * The value for the is_unique field.
     *
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $is_unique;

    /**
     * The value for the is_required field.
     *
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $is_required;

    /**
     * The value for the is_searchable field.
     *
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $is_searchable;

    /**
     * The value for the created_at field.
     *
     * @var        DateTime
     */
    protected $created_at;

    /**
     * The value for the created_by field.
     *
     * @var        int
     */
    protected $created_by;

    /**
     * The value for the updated_at field.
     *
     * @var        DateTime
     */
    protected $updated_at;

    /**
     * The value for the updated_by field.
     *
     * @var        int
     */
    protected $updated_by;

    /**
     * @var        ChildUser
     */
    protected $aUserRelatedByCreatedBy;

    /**
     * @var        ChildUser
     */
    protected $aUserRelatedByUpdatedBy;

    /**
     * @var        ObjectCollection|ChildSectionField[] Collection to store aggregation of ChildSectionField objects.
     */
    protected $collSectionFields;
    protected $collSectionFieldsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    // validate behavior

    /**
     * Flag to prevent endless validation loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInValidation = false;

    /**
     * ConstraintViolationList object
     *
     * @see     http://api.symfony.com/2.0/Symfony/Component/Validator/ConstraintViolationList.html
     * @var     ConstraintViolationList
     */
    protected $validationFailures;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSectionField[]
     */
    protected $sectionFieldsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->is_unique = false;
        $this->is_required = false;
        $this->is_searchable = false;
    }

    /**
     * Initializes internal state of Propel\Models\Base\Field object.
     * @see applyDefaults()
     */
    public function __construct()
    {
        $this->applyDefaultValues();
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>Field</code> instance.  If
     * <code>obj</code> is an instance of <code>Field</code>, delegates to
     * <code>equals(Field)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|Field The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));

        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }

        return $propertyNames;
    }

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [type] column value.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get the [name] column value.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the [label] column value.
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Get the [tooltip] column value.
     *
     * @return string
     */
    public function getTooltip()
    {
        return $this->tooltip;
    }

    /**
     * Get the [default_value] column value.
     *
     * @return string
     */
    public function getDefaultValue()
    {
        return $this->default_value;
    }

    /**
     * Get the [validation_regex] column value.
     *
     * @return string
     */
    public function getValidationRegex()
    {
        return $this->validation_regex;
    }

    /**
     * Get the [validation_error] column value.
     *
     * @return string
     */
    public function getValidationError()
    {
        return $this->validation_error;
    }

    /**
     * Get the [is_unique] column value.
     *
     * @return boolean
     */
    public function getIsUnique()
    {
        return $this->is_unique;
    }

    /**
     * Get the [is_unique] column value.
     *
     * @return boolean
     */
    public function isUnique()
    {
        return $this->getIsUnique();
    }

    /**
     * Get the [is_required] column value.
     *
     * @return boolean
     */
    public function getIsRequired()
    {
        return $this->is_required;
    }

    /**
     * Get the [is_required] column value.
     *
     * @return boolean
     */
    public function isRequired()
    {
        return $this->getIsRequired();
    }

    /**
     * Get the [is_searchable] column value.
     *
     * @return boolean
     */
    public function getIsSearchable()
    {
        return $this->is_searchable;
    }

    /**
     * Get the [is_searchable] column value.
     *
     * @return boolean
     */
    public function isSearchable()
    {
        return $this->getIsSearchable();
    }

    /**
     * Get the [optionally formatted] temporal [created_at] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getCreatedAt($format = NULL)
    {
        if ($format === null) {
            return $this->created_at;
        } else {
            return $this->created_at instanceof \DateTimeInterface ? $this->created_at->format($format) : null;
        }
    }

    /**
     * Get the [created_by] column value.
     *
     * @return int
     */
    public function getCreatedBy()
    {
        return $this->created_by;
    }

    /**
     * Get the [optionally formatted] temporal [updated_at] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getUpdatedAt($format = NULL)
    {
        if ($format === null) {
            return $this->updated_at;
        } else {
            return $this->updated_at instanceof \DateTimeInterface ? $this->updated_at->format($format) : null;
        }
    }

    /**
     * Get the [updated_by] column value.
     *
     * @return int
     */
    public function getUpdatedBy()
    {
        return $this->updated_by;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\Propel\Models\Field The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[FieldTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [type] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\Field The current object (for fluent API support)
     */
    public function setType($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->type !== $v) {
            $this->type = $v;
            $this->modifiedColumns[FieldTableMap::COL_TYPE] = true;
        }

        return $this;
    } // setType()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\Field The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[FieldTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [label] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\Field The current object (for fluent API support)
     */
    public function setLabel($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->label !== $v) {
            $this->label = $v;
            $this->modifiedColumns[FieldTableMap::COL_LABEL] = true;
        }

        return $this;
    } // setLabel()

    /**
     * Set the value of [tooltip] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\Field The current object (for fluent API support)
     */
    public function setTooltip($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->tooltip !== $v) {
            $this->tooltip = $v;
            $this->modifiedColumns[FieldTableMap::COL_TOOLTIP] = true;
        }

        return $this;
    } // setTooltip()

    /**
     * Set the value of [default_value] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\Field The current object (for fluent API support)
     */
    public function setDefaultValue($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->default_value !== $v) {
            $this->default_value = $v;
            $this->modifiedColumns[FieldTableMap::COL_DEFAULT_VALUE] = true;
        }

        return $this;
    } // setDefaultValue()

    /**
     * Set the value of [validation_regex] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\Field The current object (for fluent API support)
     */
    public function setValidationRegex($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->validation_regex !== $v) {
            $this->validation_regex = $v;
            $this->modifiedColumns[FieldTableMap::COL_VALIDATION_REGEX] = true;
        }

        return $this;
    } // setValidationRegex()

    /**
     * Set the value of [validation_error] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\Field The current object (for fluent API support)
     */
    public function setValidationError($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->validation_error !== $v) {
            $this->validation_error = $v;
            $this->modifiedColumns[FieldTableMap::COL_VALIDATION_ERROR] = true;
        }

        return $this;
    } // setValidationError()

    /**
     * Sets the value of the [is_unique] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\Propel\Models\Field The current object (for fluent API support)
     */
    public function setIsUnique($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->is_unique !== $v) {
            $this->is_unique = $v;
            $this->modifiedColumns[FieldTableMap::COL_IS_UNIQUE] = true;
        }

        return $this;
    } // setIsUnique()

    /**
     * Sets the value of the [is_required] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\Propel\Models\Field The current object (for fluent API support)
     */
    public function setIsRequired($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->is_required !== $v) {
            $this->is_required = $v;
            $this->modifiedColumns[FieldTableMap::COL_IS_REQUIRED] = true;
        }

        return $this;
    } // setIsRequired()

    /**
     * Sets the value of the [is_searchable] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\Propel\Models\Field The current object (for fluent API support)
     */
    public function setIsSearchable($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->is_searchable !== $v) {
            $this->is_searchable = $v;
            $this->modifiedColumns[FieldTableMap::COL_IS_SEARCHABLE] = true;
        }

        return $this;
    } // setIsSearchable()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Propel\Models\Field The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($this->created_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->created_at->format("Y-m-d H:i:s.u")) {
                $this->created_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[FieldTableMap::COL_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setCreatedAt()

    /**
     * Set the value of [created_by] column.
     *
     * @param int $v new value
     * @return $this|\Propel\Models\Field The current object (for fluent API support)
     */
    public function setCreatedBy($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->created_by !== $v) {
            $this->created_by = $v;
            $this->modifiedColumns[FieldTableMap::COL_CREATED_BY] = true;
        }

        if ($this->aUserRelatedByCreatedBy !== null && $this->aUserRelatedByCreatedBy->getId() !== $v) {
            $this->aUserRelatedByCreatedBy = null;
        }

        return $this;
    } // setCreatedBy()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Propel\Models\Field The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($this->updated_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->updated_at->format("Y-m-d H:i:s.u")) {
                $this->updated_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[FieldTableMap::COL_UPDATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setUpdatedAt()

    /**
     * Set the value of [updated_by] column.
     *
     * @param int $v new value
     * @return $this|\Propel\Models\Field The current object (for fluent API support)
     */
    public function setUpdatedBy($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->updated_by !== $v) {
            $this->updated_by = $v;
            $this->modifiedColumns[FieldTableMap::COL_UPDATED_BY] = true;
        }

        if ($this->aUserRelatedByUpdatedBy !== null && $this->aUserRelatedByUpdatedBy->getId() !== $v) {
            $this->aUserRelatedByUpdatedBy = null;
        }

        return $this;
    } // setUpdatedBy()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
            if ($this->is_unique !== false) {
                return false;
            }

            if ($this->is_required !== false) {
                return false;
            }

            if ($this->is_searchable !== false) {
                return false;
            }

        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : FieldTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : FieldTableMap::translateFieldName('Type', TableMap::TYPE_PHPNAME, $indexType)];
            $this->type = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : FieldTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : FieldTableMap::translateFieldName('Label', TableMap::TYPE_PHPNAME, $indexType)];
            $this->label = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : FieldTableMap::translateFieldName('Tooltip', TableMap::TYPE_PHPNAME, $indexType)];
            $this->tooltip = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : FieldTableMap::translateFieldName('DefaultValue', TableMap::TYPE_PHPNAME, $indexType)];
            $this->default_value = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : FieldTableMap::translateFieldName('ValidationRegex', TableMap::TYPE_PHPNAME, $indexType)];
            $this->validation_regex = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : FieldTableMap::translateFieldName('ValidationError', TableMap::TYPE_PHPNAME, $indexType)];
            $this->validation_error = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : FieldTableMap::translateFieldName('IsUnique', TableMap::TYPE_PHPNAME, $indexType)];
            $this->is_unique = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : FieldTableMap::translateFieldName('IsRequired', TableMap::TYPE_PHPNAME, $indexType)];
            $this->is_required = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : FieldTableMap::translateFieldName('IsSearchable', TableMap::TYPE_PHPNAME, $indexType)];
            $this->is_searchable = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : FieldTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : FieldTableMap::translateFieldName('CreatedBy', TableMap::TYPE_PHPNAME, $indexType)];
            $this->created_by = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : FieldTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 14 + $startcol : FieldTableMap::translateFieldName('UpdatedBy', TableMap::TYPE_PHPNAME, $indexType)];
            $this->updated_by = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 15; // 15 = FieldTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Propel\\Models\\Field'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
        if ($this->aUserRelatedByCreatedBy !== null && $this->created_by !== $this->aUserRelatedByCreatedBy->getId()) {
            $this->aUserRelatedByCreatedBy = null;
        }
        if ($this->aUserRelatedByUpdatedBy !== null && $this->updated_by !== $this->aUserRelatedByUpdatedBy->getId()) {
            $this->aUserRelatedByUpdatedBy = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(FieldTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildFieldQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aUserRelatedByCreatedBy = null;
            $this->aUserRelatedByUpdatedBy = null;
            $this->collSectionFields = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Field::setDeleted()
     * @see Field::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(FieldTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildFieldQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            // Fenric\Propel\Behaviors\Eventable behavior
            if (! fenric('event::model.field.pre.delete')->run([$this, \Propel\Runtime\Propel::getServiceContainer()->getWriteConnection(FieldTableMap::DATABASE_NAME)])) {
                return 0;
            }
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                // Fenric\Propel\Behaviors\Eventable behavior
                fenric('event::model.field.post.delete')->run([$this, \Propel\Runtime\Propel::getServiceContainer()->getWriteConnection(FieldTableMap::DATABASE_NAME)]);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($this->alreadyInSave) {
            return 0;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(FieldTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            // Fenric\Propel\Behaviors\Eventable behavior
            if (! fenric('event::model.field.pre.save')->run([$this, \Propel\Runtime\Propel::getServiceContainer()->getWriteConnection(FieldTableMap::DATABASE_NAME)])) {
                return 0;
            }
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // Fenric\Propel\Behaviors\Authorable behavior
                    if (! $this->isColumnModified(FieldTableMap::COL_CREATED_BY)) {
                        if (fenric()->existsSharedService('user')) {
                            if (fenric('user')->isLogged()) {
                                $this->setCreatedBy(fenric('user')->getId());
                            }
                        }
                    }	if (! $this->isColumnModified(FieldTableMap::COL_UPDATED_BY)) {
                        if (fenric()->existsSharedService('user')) {
                            if (fenric('user')->isLogged()) {
                                $this->setUpdatedBy(fenric('user')->getId());
                            }
                        }
                    }
                // Fenric\Propel\Behaviors\Timestampable behavior
                    if (! $this->isColumnModified(FieldTableMap::COL_CREATED_AT)) {
                        $this->setCreatedAt(new \DateTime('now'));
                    }	if (! $this->isColumnModified(FieldTableMap::COL_UPDATED_AT)) {
                        $this->setUpdatedAt(new \DateTime('now'));
                    }
                // Fenric\Propel\Behaviors\Eventable behavior
                if (! fenric('event::model.field.pre.insert')->run([$this, \Propel\Runtime\Propel::getServiceContainer()->getWriteConnection(FieldTableMap::DATABASE_NAME)])) {
                    return 0;
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // Fenric\Propel\Behaviors\Authorable behavior
                    if (! $this->isColumnModified(FieldTableMap::COL_UPDATED_BY)) {
                        if (fenric()->existsSharedService('user')) {
                            if (fenric('user')->isLogged()) {
                                $this->setUpdatedBy(fenric('user')->getId());
                            }
                        }
                    }
                // Fenric\Propel\Behaviors\Timestampable behavior
                    if (! $this->isColumnModified(FieldTableMap::COL_UPDATED_AT)) {
                        $this->setUpdatedAt(new \DateTime('now'));
                    }
                // Fenric\Propel\Behaviors\Eventable behavior
                if (! fenric('event::model.field.pre.update')->run([$this, \Propel\Runtime\Propel::getServiceContainer()->getWriteConnection(FieldTableMap::DATABASE_NAME)])) {
                    return 0;
                }
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                    // Fenric\Propel\Behaviors\Eventable behavior
                    fenric('event::model.field.post.insert')->run([$this, \Propel\Runtime\Propel::getServiceContainer()->getWriteConnection(FieldTableMap::DATABASE_NAME)]);
                } else {
                    $this->postUpdate($con);
                    // Fenric\Propel\Behaviors\Eventable behavior
                    fenric('event::model.field.post.update')->run([$this, \Propel\Runtime\Propel::getServiceContainer()->getWriteConnection(FieldTableMap::DATABASE_NAME)]);
                }
                $this->postSave($con);
                // Fenric\Propel\Behaviors\Eventable behavior
                fenric('event::model.field.post.save')->run([$this, \Propel\Runtime\Propel::getServiceContainer()->getWriteConnection(FieldTableMap::DATABASE_NAME)]);
                FieldTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aUserRelatedByCreatedBy !== null) {
                if ($this->aUserRelatedByCreatedBy->isModified() || $this->aUserRelatedByCreatedBy->isNew()) {
                    $affectedRows += $this->aUserRelatedByCreatedBy->save($con);
                }
                $this->setUserRelatedByCreatedBy($this->aUserRelatedByCreatedBy);
            }

            if ($this->aUserRelatedByUpdatedBy !== null) {
                if ($this->aUserRelatedByUpdatedBy->isModified() || $this->aUserRelatedByUpdatedBy->isNew()) {
                    $affectedRows += $this->aUserRelatedByUpdatedBy->save($con);
                }
                $this->setUserRelatedByUpdatedBy($this->aUserRelatedByUpdatedBy);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->sectionFieldsScheduledForDeletion !== null) {
                if (!$this->sectionFieldsScheduledForDeletion->isEmpty()) {
                    \Propel\Models\SectionFieldQuery::create()
                        ->filterByPrimaryKeys($this->sectionFieldsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->sectionFieldsScheduledForDeletion = null;
                }
            }

            if ($this->collSectionFields !== null) {
                foreach ($this->collSectionFields as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[FieldTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . FieldTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(FieldTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(FieldTableMap::COL_TYPE)) {
            $modifiedColumns[':p' . $index++]  = 'type';
        }
        if ($this->isColumnModified(FieldTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'name';
        }
        if ($this->isColumnModified(FieldTableMap::COL_LABEL)) {
            $modifiedColumns[':p' . $index++]  = 'label';
        }
        if ($this->isColumnModified(FieldTableMap::COL_TOOLTIP)) {
            $modifiedColumns[':p' . $index++]  = 'tooltip';
        }
        if ($this->isColumnModified(FieldTableMap::COL_DEFAULT_VALUE)) {
            $modifiedColumns[':p' . $index++]  = 'default_value';
        }
        if ($this->isColumnModified(FieldTableMap::COL_VALIDATION_REGEX)) {
            $modifiedColumns[':p' . $index++]  = 'validation_regex';
        }
        if ($this->isColumnModified(FieldTableMap::COL_VALIDATION_ERROR)) {
            $modifiedColumns[':p' . $index++]  = 'validation_error';
        }
        if ($this->isColumnModified(FieldTableMap::COL_IS_UNIQUE)) {
            $modifiedColumns[':p' . $index++]  = 'is_unique';
        }
        if ($this->isColumnModified(FieldTableMap::COL_IS_REQUIRED)) {
            $modifiedColumns[':p' . $index++]  = 'is_required';
        }
        if ($this->isColumnModified(FieldTableMap::COL_IS_SEARCHABLE)) {
            $modifiedColumns[':p' . $index++]  = 'is_searchable';
        }
        if ($this->isColumnModified(FieldTableMap::COL_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'created_at';
        }
        if ($this->isColumnModified(FieldTableMap::COL_CREATED_BY)) {
            $modifiedColumns[':p' . $index++]  = 'created_by';
        }
        if ($this->isColumnModified(FieldTableMap::COL_UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'updated_at';
        }
        if ($this->isColumnModified(FieldTableMap::COL_UPDATED_BY)) {
            $modifiedColumns[':p' . $index++]  = 'updated_by';
        }

        $sql = sprintf(
            'INSERT INTO fenric_field (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'type':
                        $stmt->bindValue($identifier, $this->type, PDO::PARAM_STR);
                        break;
                    case 'name':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case 'label':
                        $stmt->bindValue($identifier, $this->label, PDO::PARAM_STR);
                        break;
                    case 'tooltip':
                        $stmt->bindValue($identifier, $this->tooltip, PDO::PARAM_STR);
                        break;
                    case 'default_value':
                        $stmt->bindValue($identifier, $this->default_value, PDO::PARAM_STR);
                        break;
                    case 'validation_regex':
                        $stmt->bindValue($identifier, $this->validation_regex, PDO::PARAM_STR);
                        break;
                    case 'validation_error':
                        $stmt->bindValue($identifier, $this->validation_error, PDO::PARAM_STR);
                        break;
                    case 'is_unique':
                        $stmt->bindValue($identifier, (int) $this->is_unique, PDO::PARAM_INT);
                        break;
                    case 'is_required':
                        $stmt->bindValue($identifier, (int) $this->is_required, PDO::PARAM_INT);
                        break;
                    case 'is_searchable':
                        $stmt->bindValue($identifier, (int) $this->is_searchable, PDO::PARAM_INT);
                        break;
                    case 'created_at':
                        $stmt->bindValue($identifier, $this->created_at ? $this->created_at->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'created_by':
                        $stmt->bindValue($identifier, $this->created_by, PDO::PARAM_INT);
                        break;
                    case 'updated_at':
                        $stmt->bindValue($identifier, $this->updated_at ? $this->updated_at->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'updated_by':
                        $stmt->bindValue($identifier, $this->updated_by, PDO::PARAM_INT);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = FieldTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getType();
                break;
            case 2:
                return $this->getName();
                break;
            case 3:
                return $this->getLabel();
                break;
            case 4:
                return $this->getTooltip();
                break;
            case 5:
                return $this->getDefaultValue();
                break;
            case 6:
                return $this->getValidationRegex();
                break;
            case 7:
                return $this->getValidationError();
                break;
            case 8:
                return $this->getIsUnique();
                break;
            case 9:
                return $this->getIsRequired();
                break;
            case 10:
                return $this->getIsSearchable();
                break;
            case 11:
                return $this->getCreatedAt();
                break;
            case 12:
                return $this->getCreatedBy();
                break;
            case 13:
                return $this->getUpdatedAt();
                break;
            case 14:
                return $this->getUpdatedBy();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['Field'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Field'][$this->hashCode()] = true;
        $keys = FieldTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getType(),
            $keys[2] => $this->getName(),
            $keys[3] => $this->getLabel(),
            $keys[4] => $this->getTooltip(),
            $keys[5] => $this->getDefaultValue(),
            $keys[6] => $this->getValidationRegex(),
            $keys[7] => $this->getValidationError(),
            $keys[8] => $this->getIsUnique(),
            $keys[9] => $this->getIsRequired(),
            $keys[10] => $this->getIsSearchable(),
            $keys[11] => $this->getCreatedAt(),
            $keys[12] => $this->getCreatedBy(),
            $keys[13] => $this->getUpdatedAt(),
            $keys[14] => $this->getUpdatedBy(),
        );
        if ($result[$keys[11]] instanceof \DateTimeInterface) {
            $result[$keys[11]] = $result[$keys[11]]->format('c');
        }

        if ($result[$keys[13]] instanceof \DateTimeInterface) {
            $result[$keys[13]] = $result[$keys[13]]->format('c');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aUserRelatedByCreatedBy) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'user';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'fenric_user';
                        break;
                    default:
                        $key = 'User';
                }

                $result[$key] = $this->aUserRelatedByCreatedBy->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aUserRelatedByUpdatedBy) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'user';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'fenric_user';
                        break;
                    default:
                        $key = 'User';
                }

                $result[$key] = $this->aUserRelatedByUpdatedBy->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collSectionFields) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'sectionFields';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'fenric_section_fields';
                        break;
                    default:
                        $key = 'SectionFields';
                }

                $result[$key] = $this->collSectionFields->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\Propel\Models\Field
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = FieldTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Propel\Models\Field
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setType($value);
                break;
            case 2:
                $this->setName($value);
                break;
            case 3:
                $this->setLabel($value);
                break;
            case 4:
                $this->setTooltip($value);
                break;
            case 5:
                $this->setDefaultValue($value);
                break;
            case 6:
                $this->setValidationRegex($value);
                break;
            case 7:
                $this->setValidationError($value);
                break;
            case 8:
                $this->setIsUnique($value);
                break;
            case 9:
                $this->setIsRequired($value);
                break;
            case 10:
                $this->setIsSearchable($value);
                break;
            case 11:
                $this->setCreatedAt($value);
                break;
            case 12:
                $this->setCreatedBy($value);
                break;
            case 13:
                $this->setUpdatedAt($value);
                break;
            case 14:
                $this->setUpdatedBy($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = FieldTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setType($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setName($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setLabel($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setTooltip($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setDefaultValue($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setValidationRegex($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setValidationError($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setIsUnique($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setIsRequired($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setIsSearchable($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setCreatedAt($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->setCreatedBy($arr[$keys[12]]);
        }
        if (array_key_exists($keys[13], $arr)) {
            $this->setUpdatedAt($arr[$keys[13]]);
        }
        if (array_key_exists($keys[14], $arr)) {
            $this->setUpdatedBy($arr[$keys[14]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\Propel\Models\Field The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(FieldTableMap::DATABASE_NAME);

        if ($this->isColumnModified(FieldTableMap::COL_ID)) {
            $criteria->add(FieldTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(FieldTableMap::COL_TYPE)) {
            $criteria->add(FieldTableMap::COL_TYPE, $this->type);
        }
        if ($this->isColumnModified(FieldTableMap::COL_NAME)) {
            $criteria->add(FieldTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(FieldTableMap::COL_LABEL)) {
            $criteria->add(FieldTableMap::COL_LABEL, $this->label);
        }
        if ($this->isColumnModified(FieldTableMap::COL_TOOLTIP)) {
            $criteria->add(FieldTableMap::COL_TOOLTIP, $this->tooltip);
        }
        if ($this->isColumnModified(FieldTableMap::COL_DEFAULT_VALUE)) {
            $criteria->add(FieldTableMap::COL_DEFAULT_VALUE, $this->default_value);
        }
        if ($this->isColumnModified(FieldTableMap::COL_VALIDATION_REGEX)) {
            $criteria->add(FieldTableMap::COL_VALIDATION_REGEX, $this->validation_regex);
        }
        if ($this->isColumnModified(FieldTableMap::COL_VALIDATION_ERROR)) {
            $criteria->add(FieldTableMap::COL_VALIDATION_ERROR, $this->validation_error);
        }
        if ($this->isColumnModified(FieldTableMap::COL_IS_UNIQUE)) {
            $criteria->add(FieldTableMap::COL_IS_UNIQUE, $this->is_unique);
        }
        if ($this->isColumnModified(FieldTableMap::COL_IS_REQUIRED)) {
            $criteria->add(FieldTableMap::COL_IS_REQUIRED, $this->is_required);
        }
        if ($this->isColumnModified(FieldTableMap::COL_IS_SEARCHABLE)) {
            $criteria->add(FieldTableMap::COL_IS_SEARCHABLE, $this->is_searchable);
        }
        if ($this->isColumnModified(FieldTableMap::COL_CREATED_AT)) {
            $criteria->add(FieldTableMap::COL_CREATED_AT, $this->created_at);
        }
        if ($this->isColumnModified(FieldTableMap::COL_CREATED_BY)) {
            $criteria->add(FieldTableMap::COL_CREATED_BY, $this->created_by);
        }
        if ($this->isColumnModified(FieldTableMap::COL_UPDATED_AT)) {
            $criteria->add(FieldTableMap::COL_UPDATED_AT, $this->updated_at);
        }
        if ($this->isColumnModified(FieldTableMap::COL_UPDATED_BY)) {
            $criteria->add(FieldTableMap::COL_UPDATED_BY, $this->updated_by);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildFieldQuery::create();
        $criteria->add(FieldTableMap::COL_ID, $this->id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Propel\Models\Field (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setType($this->getType());
        $copyObj->setName($this->getName());
        $copyObj->setLabel($this->getLabel());
        $copyObj->setTooltip($this->getTooltip());
        $copyObj->setDefaultValue($this->getDefaultValue());
        $copyObj->setValidationRegex($this->getValidationRegex());
        $copyObj->setValidationError($this->getValidationError());
        $copyObj->setIsUnique($this->getIsUnique());
        $copyObj->setIsRequired($this->getIsRequired());
        $copyObj->setIsSearchable($this->getIsSearchable());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setCreatedBy($this->getCreatedBy());
        $copyObj->setUpdatedAt($this->getUpdatedAt());
        $copyObj->setUpdatedBy($this->getUpdatedBy());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getSectionFields() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSectionField($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \Propel\Models\Field Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Declares an association between this object and a ChildUser object.
     *
     * @param  ChildUser $v
     * @return $this|\Propel\Models\Field The current object (for fluent API support)
     * @throws PropelException
     */
    public function setUserRelatedByCreatedBy(ChildUser $v = null)
    {
        if ($v === null) {
            $this->setCreatedBy(NULL);
        } else {
            $this->setCreatedBy($v->getId());
        }

        $this->aUserRelatedByCreatedBy = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildUser object, it will not be re-added.
        if ($v !== null) {
            $v->addFieldRelatedByCreatedBy($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildUser object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildUser The associated ChildUser object.
     * @throws PropelException
     */
    public function getUserRelatedByCreatedBy(ConnectionInterface $con = null)
    {
        if ($this->aUserRelatedByCreatedBy === null && ($this->created_by != 0)) {
            $this->aUserRelatedByCreatedBy = ChildUserQuery::create()->findPk($this->created_by, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aUserRelatedByCreatedBy->addFieldsRelatedByCreatedBy($this);
             */
        }

        return $this->aUserRelatedByCreatedBy;
    }

    /**
     * Declares an association between this object and a ChildUser object.
     *
     * @param  ChildUser $v
     * @return $this|\Propel\Models\Field The current object (for fluent API support)
     * @throws PropelException
     */
    public function setUserRelatedByUpdatedBy(ChildUser $v = null)
    {
        if ($v === null) {
            $this->setUpdatedBy(NULL);
        } else {
            $this->setUpdatedBy($v->getId());
        }

        $this->aUserRelatedByUpdatedBy = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildUser object, it will not be re-added.
        if ($v !== null) {
            $v->addFieldRelatedByUpdatedBy($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildUser object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildUser The associated ChildUser object.
     * @throws PropelException
     */
    public function getUserRelatedByUpdatedBy(ConnectionInterface $con = null)
    {
        if ($this->aUserRelatedByUpdatedBy === null && ($this->updated_by != 0)) {
            $this->aUserRelatedByUpdatedBy = ChildUserQuery::create()->findPk($this->updated_by, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aUserRelatedByUpdatedBy->addFieldsRelatedByUpdatedBy($this);
             */
        }

        return $this->aUserRelatedByUpdatedBy;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('SectionField' == $relationName) {
            $this->initSectionFields();
            return;
        }
    }

    /**
     * Clears out the collSectionFields collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSectionFields()
     */
    public function clearSectionFields()
    {
        $this->collSectionFields = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collSectionFields collection loaded partially.
     */
    public function resetPartialSectionFields($v = true)
    {
        $this->collSectionFieldsPartial = $v;
    }

    /**
     * Initializes the collSectionFields collection.
     *
     * By default this just sets the collSectionFields collection to an empty array (like clearcollSectionFields());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSectionFields($overrideExisting = true)
    {
        if (null !== $this->collSectionFields && !$overrideExisting) {
            return;
        }

        $collectionClassName = SectionFieldTableMap::getTableMap()->getCollectionClassName();

        $this->collSectionFields = new $collectionClassName;
        $this->collSectionFields->setModel('\Propel\Models\SectionField');
    }

    /**
     * Gets an array of ChildSectionField objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildField is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSectionField[] List of ChildSectionField objects
     * @throws PropelException
     */
    public function getSectionFields(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSectionFieldsPartial && !$this->isNew();
        if (null === $this->collSectionFields || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSectionFields) {
                // return empty collection
                $this->initSectionFields();
            } else {
                $collSectionFields = ChildSectionFieldQuery::create(null, $criteria)
                    ->filterByField($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSectionFieldsPartial && count($collSectionFields)) {
                        $this->initSectionFields(false);

                        foreach ($collSectionFields as $obj) {
                            if (false == $this->collSectionFields->contains($obj)) {
                                $this->collSectionFields->append($obj);
                            }
                        }

                        $this->collSectionFieldsPartial = true;
                    }

                    return $collSectionFields;
                }

                if ($partial && $this->collSectionFields) {
                    foreach ($this->collSectionFields as $obj) {
                        if ($obj->isNew()) {
                            $collSectionFields[] = $obj;
                        }
                    }
                }

                $this->collSectionFields = $collSectionFields;
                $this->collSectionFieldsPartial = false;
            }
        }

        return $this->collSectionFields;
    }

    /**
     * Sets a collection of ChildSectionField objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $sectionFields A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildField The current object (for fluent API support)
     */
    public function setSectionFields(Collection $sectionFields, ConnectionInterface $con = null)
    {
        /** @var ChildSectionField[] $sectionFieldsToDelete */
        $sectionFieldsToDelete = $this->getSectionFields(new Criteria(), $con)->diff($sectionFields);


        $this->sectionFieldsScheduledForDeletion = $sectionFieldsToDelete;

        foreach ($sectionFieldsToDelete as $sectionFieldRemoved) {
            $sectionFieldRemoved->setField(null);
        }

        $this->collSectionFields = null;
        foreach ($sectionFields as $sectionField) {
            $this->addSectionField($sectionField);
        }

        $this->collSectionFields = $sectionFields;
        $this->collSectionFieldsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related SectionField objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related SectionField objects.
     * @throws PropelException
     */
    public function countSectionFields(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSectionFieldsPartial && !$this->isNew();
        if (null === $this->collSectionFields || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSectionFields) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSectionFields());
            }

            $query = ChildSectionFieldQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByField($this)
                ->count($con);
        }

        return count($this->collSectionFields);
    }

    /**
     * Method called to associate a ChildSectionField object to this object
     * through the ChildSectionField foreign key attribute.
     *
     * @param  ChildSectionField $l ChildSectionField
     * @return $this|\Propel\Models\Field The current object (for fluent API support)
     */
    public function addSectionField(ChildSectionField $l)
    {
        if ($this->collSectionFields === null) {
            $this->initSectionFields();
            $this->collSectionFieldsPartial = true;
        }

        if (!$this->collSectionFields->contains($l)) {
            $this->doAddSectionField($l);

            if ($this->sectionFieldsScheduledForDeletion and $this->sectionFieldsScheduledForDeletion->contains($l)) {
                $this->sectionFieldsScheduledForDeletion->remove($this->sectionFieldsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildSectionField $sectionField The ChildSectionField object to add.
     */
    protected function doAddSectionField(ChildSectionField $sectionField)
    {
        $this->collSectionFields[]= $sectionField;
        $sectionField->setField($this);
    }

    /**
     * @param  ChildSectionField $sectionField The ChildSectionField object to remove.
     * @return $this|ChildField The current object (for fluent API support)
     */
    public function removeSectionField(ChildSectionField $sectionField)
    {
        if ($this->getSectionFields()->contains($sectionField)) {
            $pos = $this->collSectionFields->search($sectionField);
            $this->collSectionFields->remove($pos);
            if (null === $this->sectionFieldsScheduledForDeletion) {
                $this->sectionFieldsScheduledForDeletion = clone $this->collSectionFields;
                $this->sectionFieldsScheduledForDeletion->clear();
            }
            $this->sectionFieldsScheduledForDeletion[]= $sectionField;
            $sectionField->setField(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Field is new, it will return
     * an empty collection; or if this Field has previously
     * been saved, it will retrieve related SectionFields from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Field.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSectionField[] List of ChildSectionField objects
     */
    public function getSectionFieldsJoinSection(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSectionFieldQuery::create(null, $criteria);
        $query->joinWith('Section', $joinBehavior);

        return $this->getSectionFields($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aUserRelatedByCreatedBy) {
            $this->aUserRelatedByCreatedBy->removeFieldRelatedByCreatedBy($this);
        }
        if (null !== $this->aUserRelatedByUpdatedBy) {
            $this->aUserRelatedByUpdatedBy->removeFieldRelatedByUpdatedBy($this);
        }
        $this->id = null;
        $this->type = null;
        $this->name = null;
        $this->label = null;
        $this->tooltip = null;
        $this->default_value = null;
        $this->validation_regex = null;
        $this->validation_error = null;
        $this->is_unique = null;
        $this->is_required = null;
        $this->is_searchable = null;
        $this->created_at = null;
        $this->created_by = null;
        $this->updated_at = null;
        $this->updated_by = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collSectionFields) {
                foreach ($this->collSectionFields as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collSectionFields = null;
        $this->aUserRelatedByCreatedBy = null;
        $this->aUserRelatedByUpdatedBy = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string The value of the 'label' column
     */
    public function __toString()
    {
        return (string) $this->getLabel();
    }

    // Fenric\Propel\Behaviors\Timestampable behavior
    /**
     * @description
     */
    public function hasModifiedByTimestamp(int $timestamp) : bool
    {
        return $this->getUpdatedAt()->getTimestamp() > $timestamp;
    }
    // validate behavior

    /**
     * Configure validators constraints. The Validator object uses this method
     * to perform object validation.
     *
     * @param ClassMetadata $metadata
     */
    static public function loadValidatorMetadata(ClassMetadata $metadata)
    {
        fenric('event::model.field.validate')->run([func_get_arg(0), \Propel\Runtime\Propel::getServiceContainer()->getWriteConnection(FieldTableMap::DATABASE_NAME)]);

        $metadata->addPropertyConstraint('type', new NotBlank());
        $metadata->addPropertyConstraint('type', new Length(array ('max' => 255,)));
        $metadata->addPropertyConstraint('type', new Regex(array ('pattern' => '/^(?:flag|number|string|text|html|year|date|datetime|time|ip|url|email|image)$/',)));
        $metadata->addPropertyConstraint('name', new NotBlank());
        $metadata->addPropertyConstraint('name', new Length(array ('max' => 255,)));
        $metadata->addPropertyConstraint('name', new Regex(array ('pattern' => '/^[a-z0-9_]+$/',)));
        $metadata->addPropertyConstraint('name', new Unique());
        $metadata->addPropertyConstraint('label', new NotBlank());
        $metadata->addPropertyConstraint('label', new Length(array ('max' => 255,)));
    }

    /**
     * Validates the object and all objects related to this table.
     *
     * @see        getValidationFailures()
     * @param      ValidatorInterface|null $validator A Validator class instance
     * @return     boolean Whether all objects pass validation.
     */
    public function validate(ValidatorInterface $validator = null)
    {
        if (null === $validator) {
            $validator = new RecursiveValidator(
                new ExecutionContextFactory(new IdentityTranslator()),
                new LazyLoadingMetadataFactory(new StaticMethodLoader()),
                new ConstraintValidatorFactory()
            );
        }

        $failureMap = new ConstraintViolationList();

        if (!$this->alreadyInValidation) {
            $this->alreadyInValidation = true;
            $retval = null;

            // We call the validate method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            // If validate() method exists, the validate-behavior is configured for related object
            if (method_exists($this->aUserRelatedByCreatedBy, 'validate')) {
                if (!$this->aUserRelatedByCreatedBy->validate($validator)) {
                    $failureMap->addAll($this->aUserRelatedByCreatedBy->getValidationFailures());
                }
            }
            // If validate() method exists, the validate-behavior is configured for related object
            if (method_exists($this->aUserRelatedByUpdatedBy, 'validate')) {
                if (!$this->aUserRelatedByUpdatedBy->validate($validator)) {
                    $failureMap->addAll($this->aUserRelatedByUpdatedBy->getValidationFailures());
                }
            }

            $retval = $validator->validate($this);
            if (count($retval) > 0) {
                $failureMap->addAll($retval);
            }

            if (null !== $this->collSectionFields) {
                foreach ($this->collSectionFields as $referrerFK) {
                    if (method_exists($referrerFK, 'validate')) {
                        if (!$referrerFK->validate($validator)) {
                            $failureMap->addAll($referrerFK->getValidationFailures());
                        }
                    }
                }
            }

            $this->alreadyInValidation = false;
        }

        $this->validationFailures = $failureMap;

        return (Boolean) (!(count($this->validationFailures) > 0));

    }

    /**
     * Gets any ConstraintViolation objects that resulted from last call to validate().
     *
     *
     * @return     object ConstraintViolationList
     * @see        validate()
     */
    public function getValidationFailures()
    {
        return $this->validationFailures;
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preSave')) {
            return parent::preSave($con);
        }
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postSave')) {
            parent::postSave($con);
        }
    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preInsert')) {
            return parent::preInsert($con);
        }
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postInsert')) {
            parent::postInsert($con);
        }
    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preUpdate')) {
            return parent::preUpdate($con);
        }
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postUpdate')) {
            parent::postUpdate($con);
        }
    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preDelete')) {
            return parent::preDelete($con);
        }
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postDelete')) {
            parent::postDelete($con);
        }
    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
