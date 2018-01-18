<?php

namespace Propel\Models\Base;

use \DateTime;
use \Exception;
use \PDO;
use Propel\Models\Comment as ChildComment;
use Propel\Models\CommentQuery as ChildCommentQuery;
use Propel\Models\Publication as ChildPublication;
use Propel\Models\PublicationQuery as ChildPublicationQuery;
use Propel\Models\User as ChildUser;
use Propel\Models\UserQuery as ChildUserQuery;
use Propel\Models\Map\CommentTableMap;
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
use Symfony\Component\Translation\IdentityTranslator;
use Symfony\Component\Validator\ConstraintValidatorFactory;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Context\ExecutionContextFactory;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Mapping\Factory\LazyLoadingMetadataFactory;
use Symfony\Component\Validator\Mapping\Loader\StaticMethodLoader;
use Symfony\Component\Validator\Validator\RecursiveValidator;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Base class that represents a row from the 'fenric_comment' table.
 *
 *
 *
 * @package    propel.generator.Propel.Models.Base
 */
abstract class Comment implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Propel\\Models\\Map\\CommentTableMap';


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
     * The value for the parent_id field.
     *
     * @var        int
     */
    protected $parent_id;

    /**
     * The value for the publication_id field.
     *
     * @var        int
     */
    protected $publication_id;

    /**
     * The value for the picture field.
     *
     * @var        string
     */
    protected $picture;

    /**
     * The value for the content field.
     *
     * @var        string
     */
    protected $content;

    /**
     * The value for the is_deleted field.
     *
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $is_deleted;

    /**
     * The value for the is_verified field.
     *
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $is_verified;

    /**
     * The value for the updating_reason field.
     *
     * @var        string
     */
    protected $updating_reason;

    /**
     * The value for the deleting_reason field.
     *
     * @var        string
     */
    protected $deleting_reason;

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
     * The value for the deleted_at field.
     *
     * @var        DateTime
     */
    protected $deleted_at;

    /**
     * The value for the deleted_by field.
     *
     * @var        int
     */
    protected $deleted_by;

    /**
     * The value for the verified_at field.
     *
     * @var        DateTime
     */
    protected $verified_at;

    /**
     * The value for the verified_by field.
     *
     * @var        int
     */
    protected $verified_by;

    /**
     * @var        ChildComment
     */
    protected $aParent;

    /**
     * @var        ChildPublication
     */
    protected $aPublication;

    /**
     * @var        ChildUser
     */
    protected $aUserRelatedByCreatedBy;

    /**
     * @var        ChildUser
     */
    protected $aUserRelatedByUpdatedBy;

    /**
     * @var        ChildUser
     */
    protected $aUserRelatedByDeletedBy;

    /**
     * @var        ChildUser
     */
    protected $aUserRelatedByVerifiedBy;

    /**
     * @var        ObjectCollection|ChildComment[] Collection to store aggregation of ChildComment objects.
     */
    protected $collCommentsRelatedById;
    protected $collCommentsRelatedByIdPartial;

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
     * @var ObjectCollection|ChildComment[]
     */
    protected $commentsRelatedByIdScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->is_deleted = false;
        $this->is_verified = false;
    }

    /**
     * Initializes internal state of Propel\Models\Base\Comment object.
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
     * Compares this with another <code>Comment</code> instance.  If
     * <code>obj</code> is an instance of <code>Comment</code>, delegates to
     * <code>equals(Comment)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Comment The current object, for fluid interface
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
     * Get the [parent_id] column value.
     *
     * @return int
     */
    public function getParentId()
    {
        return $this->parent_id;
    }

    /**
     * Get the [publication_id] column value.
     *
     * @return int
     */
    public function getPublicationId()
    {
        return $this->publication_id;
    }

    /**
     * Get the [picture] column value.
     *
     * @return string
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Get the [content] column value.
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Get the [is_deleted] column value.
     *
     * @return boolean
     */
    public function getIsDeleted()
    {
        return $this->is_deleted;
    }

    /**
     * Get the [is_verified] column value.
     *
     * @return boolean
     */
    public function getIsVerified()
    {
        return $this->is_verified;
    }

    /**
     * Get the [is_verified] column value.
     *
     * @return boolean
     */
    public function isVerified()
    {
        return $this->getIsVerified();
    }

    /**
     * Get the [updating_reason] column value.
     *
     * @return string
     */
    public function getUpdatingReason()
    {
        return $this->updating_reason;
    }

    /**
     * Get the [deleting_reason] column value.
     *
     * @return string
     */
    public function getDeletingReason()
    {
        return $this->deleting_reason;
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
     * Get the [optionally formatted] temporal [deleted_at] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDeletedAt($format = NULL)
    {
        if ($format === null) {
            return $this->deleted_at;
        } else {
            return $this->deleted_at instanceof \DateTimeInterface ? $this->deleted_at->format($format) : null;
        }
    }

    /**
     * Get the [deleted_by] column value.
     *
     * @return int
     */
    public function getDeletedBy()
    {
        return $this->deleted_by;
    }

    /**
     * Get the [optionally formatted] temporal [verified_at] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getVerifiedAt($format = NULL)
    {
        if ($format === null) {
            return $this->verified_at;
        } else {
            return $this->verified_at instanceof \DateTimeInterface ? $this->verified_at->format($format) : null;
        }
    }

    /**
     * Get the [verified_by] column value.
     *
     * @return int
     */
    public function getVerifiedBy()
    {
        return $this->verified_by;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\Propel\Models\Comment The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[CommentTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [parent_id] column.
     *
     * @param int $v new value
     * @return $this|\Propel\Models\Comment The current object (for fluent API support)
     */
    public function setParentId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->parent_id !== $v) {
            $this->parent_id = $v;
            $this->modifiedColumns[CommentTableMap::COL_PARENT_ID] = true;
        }

        if ($this->aParent !== null && $this->aParent->getId() !== $v) {
            $this->aParent = null;
        }

        return $this;
    } // setParentId()

    /**
     * Set the value of [publication_id] column.
     *
     * @param int $v new value
     * @return $this|\Propel\Models\Comment The current object (for fluent API support)
     */
    public function setPublicationId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->publication_id !== $v) {
            $this->publication_id = $v;
            $this->modifiedColumns[CommentTableMap::COL_PUBLICATION_ID] = true;
        }

        if ($this->aPublication !== null && $this->aPublication->getId() !== $v) {
            $this->aPublication = null;
        }

        return $this;
    } // setPublicationId()

    /**
     * Set the value of [picture] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\Comment The current object (for fluent API support)
     */
    public function setPicture($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->picture !== $v) {
            $this->picture = $v;
            $this->modifiedColumns[CommentTableMap::COL_PICTURE] = true;
        }

        return $this;
    } // setPicture()

    /**
     * Set the value of [content] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\Comment The current object (for fluent API support)
     */
    public function setContent($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->content !== $v) {
            $this->content = $v;
            $this->modifiedColumns[CommentTableMap::COL_CONTENT] = true;
        }

        return $this;
    } // setContent()

    /**
     * Sets the value of the [is_deleted] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\Propel\Models\Comment The current object (for fluent API support)
     */
    public function setIsDeleted($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->is_deleted !== $v) {
            $this->is_deleted = $v;
            $this->modifiedColumns[CommentTableMap::COL_IS_DELETED] = true;
        }

        return $this;
    } // setIsDeleted()

    /**
     * Sets the value of the [is_verified] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\Propel\Models\Comment The current object (for fluent API support)
     */
    public function setIsVerified($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->is_verified !== $v) {
            $this->is_verified = $v;
            $this->modifiedColumns[CommentTableMap::COL_IS_VERIFIED] = true;
        }

        return $this;
    } // setIsVerified()

    /**
     * Set the value of [updating_reason] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\Comment The current object (for fluent API support)
     */
    public function setUpdatingReason($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->updating_reason !== $v) {
            $this->updating_reason = $v;
            $this->modifiedColumns[CommentTableMap::COL_UPDATING_REASON] = true;
        }

        return $this;
    } // setUpdatingReason()

    /**
     * Set the value of [deleting_reason] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\Comment The current object (for fluent API support)
     */
    public function setDeletingReason($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->deleting_reason !== $v) {
            $this->deleting_reason = $v;
            $this->modifiedColumns[CommentTableMap::COL_DELETING_REASON] = true;
        }

        return $this;
    } // setDeletingReason()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Propel\Models\Comment The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($this->created_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->created_at->format("Y-m-d H:i:s.u")) {
                $this->created_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[CommentTableMap::COL_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setCreatedAt()

    /**
     * Set the value of [created_by] column.
     *
     * @param int $v new value
     * @return $this|\Propel\Models\Comment The current object (for fluent API support)
     */
    public function setCreatedBy($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->created_by !== $v) {
            $this->created_by = $v;
            $this->modifiedColumns[CommentTableMap::COL_CREATED_BY] = true;
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
     * @return $this|\Propel\Models\Comment The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($this->updated_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->updated_at->format("Y-m-d H:i:s.u")) {
                $this->updated_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[CommentTableMap::COL_UPDATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setUpdatedAt()

    /**
     * Set the value of [updated_by] column.
     *
     * @param int $v new value
     * @return $this|\Propel\Models\Comment The current object (for fluent API support)
     */
    public function setUpdatedBy($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->updated_by !== $v) {
            $this->updated_by = $v;
            $this->modifiedColumns[CommentTableMap::COL_UPDATED_BY] = true;
        }

        if ($this->aUserRelatedByUpdatedBy !== null && $this->aUserRelatedByUpdatedBy->getId() !== $v) {
            $this->aUserRelatedByUpdatedBy = null;
        }

        return $this;
    } // setUpdatedBy()

    /**
     * Sets the value of [deleted_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Propel\Models\Comment The current object (for fluent API support)
     */
    public function setDeletedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->deleted_at !== null || $dt !== null) {
            if ($this->deleted_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->deleted_at->format("Y-m-d H:i:s.u")) {
                $this->deleted_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[CommentTableMap::COL_DELETED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setDeletedAt()

    /**
     * Set the value of [deleted_by] column.
     *
     * @param int $v new value
     * @return $this|\Propel\Models\Comment The current object (for fluent API support)
     */
    public function setDeletedBy($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->deleted_by !== $v) {
            $this->deleted_by = $v;
            $this->modifiedColumns[CommentTableMap::COL_DELETED_BY] = true;
        }

        if ($this->aUserRelatedByDeletedBy !== null && $this->aUserRelatedByDeletedBy->getId() !== $v) {
            $this->aUserRelatedByDeletedBy = null;
        }

        return $this;
    } // setDeletedBy()

    /**
     * Sets the value of [verified_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Propel\Models\Comment The current object (for fluent API support)
     */
    public function setVerifiedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->verified_at !== null || $dt !== null) {
            if ($this->verified_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->verified_at->format("Y-m-d H:i:s.u")) {
                $this->verified_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[CommentTableMap::COL_VERIFIED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setVerifiedAt()

    /**
     * Set the value of [verified_by] column.
     *
     * @param int $v new value
     * @return $this|\Propel\Models\Comment The current object (for fluent API support)
     */
    public function setVerifiedBy($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->verified_by !== $v) {
            $this->verified_by = $v;
            $this->modifiedColumns[CommentTableMap::COL_VERIFIED_BY] = true;
        }

        if ($this->aUserRelatedByVerifiedBy !== null && $this->aUserRelatedByVerifiedBy->getId() !== $v) {
            $this->aUserRelatedByVerifiedBy = null;
        }

        return $this;
    } // setVerifiedBy()

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
            if ($this->is_deleted !== false) {
                return false;
            }

            if ($this->is_verified !== false) {
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : CommentTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : CommentTableMap::translateFieldName('ParentId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->parent_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : CommentTableMap::translateFieldName('PublicationId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->publication_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : CommentTableMap::translateFieldName('Picture', TableMap::TYPE_PHPNAME, $indexType)];
            $this->picture = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : CommentTableMap::translateFieldName('Content', TableMap::TYPE_PHPNAME, $indexType)];
            $this->content = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : CommentTableMap::translateFieldName('IsDeleted', TableMap::TYPE_PHPNAME, $indexType)];
            $this->is_deleted = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : CommentTableMap::translateFieldName('IsVerified', TableMap::TYPE_PHPNAME, $indexType)];
            $this->is_verified = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : CommentTableMap::translateFieldName('UpdatingReason', TableMap::TYPE_PHPNAME, $indexType)];
            $this->updating_reason = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : CommentTableMap::translateFieldName('DeletingReason', TableMap::TYPE_PHPNAME, $indexType)];
            $this->deleting_reason = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : CommentTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : CommentTableMap::translateFieldName('CreatedBy', TableMap::TYPE_PHPNAME, $indexType)];
            $this->created_by = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : CommentTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : CommentTableMap::translateFieldName('UpdatedBy', TableMap::TYPE_PHPNAME, $indexType)];
            $this->updated_by = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : CommentTableMap::translateFieldName('DeletedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->deleted_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 14 + $startcol : CommentTableMap::translateFieldName('DeletedBy', TableMap::TYPE_PHPNAME, $indexType)];
            $this->deleted_by = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 15 + $startcol : CommentTableMap::translateFieldName('VerifiedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->verified_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 16 + $startcol : CommentTableMap::translateFieldName('VerifiedBy', TableMap::TYPE_PHPNAME, $indexType)];
            $this->verified_by = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 17; // 17 = CommentTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Propel\\Models\\Comment'), 0, $e);
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
        if ($this->aParent !== null && $this->parent_id !== $this->aParent->getId()) {
            $this->aParent = null;
        }
        if ($this->aPublication !== null && $this->publication_id !== $this->aPublication->getId()) {
            $this->aPublication = null;
        }
        if ($this->aUserRelatedByCreatedBy !== null && $this->created_by !== $this->aUserRelatedByCreatedBy->getId()) {
            $this->aUserRelatedByCreatedBy = null;
        }
        if ($this->aUserRelatedByUpdatedBy !== null && $this->updated_by !== $this->aUserRelatedByUpdatedBy->getId()) {
            $this->aUserRelatedByUpdatedBy = null;
        }
        if ($this->aUserRelatedByDeletedBy !== null && $this->deleted_by !== $this->aUserRelatedByDeletedBy->getId()) {
            $this->aUserRelatedByDeletedBy = null;
        }
        if ($this->aUserRelatedByVerifiedBy !== null && $this->verified_by !== $this->aUserRelatedByVerifiedBy->getId()) {
            $this->aUserRelatedByVerifiedBy = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(CommentTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildCommentQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aParent = null;
            $this->aPublication = null;
            $this->aUserRelatedByCreatedBy = null;
            $this->aUserRelatedByUpdatedBy = null;
            $this->aUserRelatedByDeletedBy = null;
            $this->aUserRelatedByVerifiedBy = null;
            $this->collCommentsRelatedById = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Comment::setDeleted()
     * @see Comment::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(CommentTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildCommentQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            // Fenric\Propel\Behaviors\Eventable behavior
            if (! fenric('event::model.comment.pre.delete')->run([$this, \Propel\Runtime\Propel::getServiceContainer()->getWriteConnection(CommentTableMap::DATABASE_NAME)])) {
                return 0;
            }
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                // Fenric\Propel\Behaviors\Eventable behavior
                fenric('event::model.comment.post.delete')->run([$this, \Propel\Runtime\Propel::getServiceContainer()->getWriteConnection(CommentTableMap::DATABASE_NAME)]);
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
            $con = Propel::getServiceContainer()->getWriteConnection(CommentTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            // Fenric\Propel\Behaviors\Eventable behavior
            if (! fenric('event::model.comment.pre.save')->run([$this, \Propel\Runtime\Propel::getServiceContainer()->getWriteConnection(CommentTableMap::DATABASE_NAME)])) {
                return 0;
            }
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // Fenric\Propel\Behaviors\Authorable behavior
                    if (! $this->isColumnModified(CommentTableMap::COL_CREATED_BY)) {
                        if (fenric()->existsSharedService('user')) {
                            if (fenric('user')->isLogged()) {
                                $this->setCreatedBy(fenric('user')->getId());
                            }
                        }
                    }	if (! $this->isColumnModified(CommentTableMap::COL_UPDATED_BY)) {
                        if (fenric()->existsSharedService('user')) {
                            if (fenric('user')->isLogged()) {
                                $this->setUpdatedBy(fenric('user')->getId());
                            }
                        }
                    }
                // Fenric\Propel\Behaviors\Timestampable behavior
                    if (! $this->isColumnModified(CommentTableMap::COL_CREATED_AT)) {
                        $this->setCreatedAt(new \DateTime('now'));
                    }	if (! $this->isColumnModified(CommentTableMap::COL_UPDATED_AT)) {
                        $this->setUpdatedAt(new \DateTime('now'));
                    }
                // Fenric\Propel\Behaviors\Eventable behavior
                if (! fenric('event::model.comment.pre.insert')->run([$this, \Propel\Runtime\Propel::getServiceContainer()->getWriteConnection(CommentTableMap::DATABASE_NAME)])) {
                    return 0;
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // Fenric\Propel\Behaviors\Authorable behavior
                    if (! $this->isColumnModified(CommentTableMap::COL_UPDATED_BY)) {
                        if (fenric()->existsSharedService('user')) {
                            if (fenric('user')->isLogged()) {
                                $this->setUpdatedBy(fenric('user')->getId());
                            }
                        }
                    }
                // Fenric\Propel\Behaviors\Timestampable behavior
                    if (! $this->isColumnModified(CommentTableMap::COL_UPDATED_AT)) {
                        $this->setUpdatedAt(new \DateTime('now'));
                    }
                // Fenric\Propel\Behaviors\Eventable behavior
                if (! fenric('event::model.comment.pre.update')->run([$this, \Propel\Runtime\Propel::getServiceContainer()->getWriteConnection(CommentTableMap::DATABASE_NAME)])) {
                    return 0;
                }
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                    // Fenric\Propel\Behaviors\Eventable behavior
                    fenric('event::model.comment.post.insert')->run([$this, \Propel\Runtime\Propel::getServiceContainer()->getWriteConnection(CommentTableMap::DATABASE_NAME)]);
                } else {
                    $this->postUpdate($con);
                    // Fenric\Propel\Behaviors\Eventable behavior
                    fenric('event::model.comment.post.update')->run([$this, \Propel\Runtime\Propel::getServiceContainer()->getWriteConnection(CommentTableMap::DATABASE_NAME)]);
                }
                $this->postSave($con);
                // Fenric\Propel\Behaviors\Eventable behavior
                fenric('event::model.comment.post.save')->run([$this, \Propel\Runtime\Propel::getServiceContainer()->getWriteConnection(CommentTableMap::DATABASE_NAME)]);
                CommentTableMap::addInstanceToPool($this);
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

            if ($this->aParent !== null) {
                if ($this->aParent->isModified() || $this->aParent->isNew()) {
                    $affectedRows += $this->aParent->save($con);
                }
                $this->setParent($this->aParent);
            }

            if ($this->aPublication !== null) {
                if ($this->aPublication->isModified() || $this->aPublication->isNew()) {
                    $affectedRows += $this->aPublication->save($con);
                }
                $this->setPublication($this->aPublication);
            }

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

            if ($this->aUserRelatedByDeletedBy !== null) {
                if ($this->aUserRelatedByDeletedBy->isModified() || $this->aUserRelatedByDeletedBy->isNew()) {
                    $affectedRows += $this->aUserRelatedByDeletedBy->save($con);
                }
                $this->setUserRelatedByDeletedBy($this->aUserRelatedByDeletedBy);
            }

            if ($this->aUserRelatedByVerifiedBy !== null) {
                if ($this->aUserRelatedByVerifiedBy->isModified() || $this->aUserRelatedByVerifiedBy->isNew()) {
                    $affectedRows += $this->aUserRelatedByVerifiedBy->save($con);
                }
                $this->setUserRelatedByVerifiedBy($this->aUserRelatedByVerifiedBy);
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

            if ($this->commentsRelatedByIdScheduledForDeletion !== null) {
                if (!$this->commentsRelatedByIdScheduledForDeletion->isEmpty()) {
                    \Propel\Models\CommentQuery::create()
                        ->filterByPrimaryKeys($this->commentsRelatedByIdScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->commentsRelatedByIdScheduledForDeletion = null;
                }
            }

            if ($this->collCommentsRelatedById !== null) {
                foreach ($this->collCommentsRelatedById as $referrerFK) {
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

        $this->modifiedColumns[CommentTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . CommentTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(CommentTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(CommentTableMap::COL_PARENT_ID)) {
            $modifiedColumns[':p' . $index++]  = 'parent_id';
        }
        if ($this->isColumnModified(CommentTableMap::COL_PUBLICATION_ID)) {
            $modifiedColumns[':p' . $index++]  = 'publication_id';
        }
        if ($this->isColumnModified(CommentTableMap::COL_PICTURE)) {
            $modifiedColumns[':p' . $index++]  = 'picture';
        }
        if ($this->isColumnModified(CommentTableMap::COL_CONTENT)) {
            $modifiedColumns[':p' . $index++]  = 'content';
        }
        if ($this->isColumnModified(CommentTableMap::COL_IS_DELETED)) {
            $modifiedColumns[':p' . $index++]  = 'is_deleted';
        }
        if ($this->isColumnModified(CommentTableMap::COL_IS_VERIFIED)) {
            $modifiedColumns[':p' . $index++]  = 'is_verified';
        }
        if ($this->isColumnModified(CommentTableMap::COL_UPDATING_REASON)) {
            $modifiedColumns[':p' . $index++]  = 'updating_reason';
        }
        if ($this->isColumnModified(CommentTableMap::COL_DELETING_REASON)) {
            $modifiedColumns[':p' . $index++]  = 'deleting_reason';
        }
        if ($this->isColumnModified(CommentTableMap::COL_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'created_at';
        }
        if ($this->isColumnModified(CommentTableMap::COL_CREATED_BY)) {
            $modifiedColumns[':p' . $index++]  = 'created_by';
        }
        if ($this->isColumnModified(CommentTableMap::COL_UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'updated_at';
        }
        if ($this->isColumnModified(CommentTableMap::COL_UPDATED_BY)) {
            $modifiedColumns[':p' . $index++]  = 'updated_by';
        }
        if ($this->isColumnModified(CommentTableMap::COL_DELETED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'deleted_at';
        }
        if ($this->isColumnModified(CommentTableMap::COL_DELETED_BY)) {
            $modifiedColumns[':p' . $index++]  = 'deleted_by';
        }
        if ($this->isColumnModified(CommentTableMap::COL_VERIFIED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'verified_at';
        }
        if ($this->isColumnModified(CommentTableMap::COL_VERIFIED_BY)) {
            $modifiedColumns[':p' . $index++]  = 'verified_by';
        }

        $sql = sprintf(
            'INSERT INTO fenric_comment (%s) VALUES (%s)',
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
                    case 'parent_id':
                        $stmt->bindValue($identifier, $this->parent_id, PDO::PARAM_INT);
                        break;
                    case 'publication_id':
                        $stmt->bindValue($identifier, $this->publication_id, PDO::PARAM_INT);
                        break;
                    case 'picture':
                        $stmt->bindValue($identifier, $this->picture, PDO::PARAM_STR);
                        break;
                    case 'content':
                        $stmt->bindValue($identifier, $this->content, PDO::PARAM_STR);
                        break;
                    case 'is_deleted':
                        $stmt->bindValue($identifier, (int) $this->is_deleted, PDO::PARAM_INT);
                        break;
                    case 'is_verified':
                        $stmt->bindValue($identifier, (int) $this->is_verified, PDO::PARAM_INT);
                        break;
                    case 'updating_reason':
                        $stmt->bindValue($identifier, $this->updating_reason, PDO::PARAM_STR);
                        break;
                    case 'deleting_reason':
                        $stmt->bindValue($identifier, $this->deleting_reason, PDO::PARAM_STR);
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
                    case 'deleted_at':
                        $stmt->bindValue($identifier, $this->deleted_at ? $this->deleted_at->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'deleted_by':
                        $stmt->bindValue($identifier, $this->deleted_by, PDO::PARAM_INT);
                        break;
                    case 'verified_at':
                        $stmt->bindValue($identifier, $this->verified_at ? $this->verified_at->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'verified_by':
                        $stmt->bindValue($identifier, $this->verified_by, PDO::PARAM_INT);
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
        $pos = CommentTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getParentId();
                break;
            case 2:
                return $this->getPublicationId();
                break;
            case 3:
                return $this->getPicture();
                break;
            case 4:
                return $this->getContent();
                break;
            case 5:
                return $this->getIsDeleted();
                break;
            case 6:
                return $this->getIsVerified();
                break;
            case 7:
                return $this->getUpdatingReason();
                break;
            case 8:
                return $this->getDeletingReason();
                break;
            case 9:
                return $this->getCreatedAt();
                break;
            case 10:
                return $this->getCreatedBy();
                break;
            case 11:
                return $this->getUpdatedAt();
                break;
            case 12:
                return $this->getUpdatedBy();
                break;
            case 13:
                return $this->getDeletedAt();
                break;
            case 14:
                return $this->getDeletedBy();
                break;
            case 15:
                return $this->getVerifiedAt();
                break;
            case 16:
                return $this->getVerifiedBy();
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

        if (isset($alreadyDumpedObjects['Comment'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Comment'][$this->hashCode()] = true;
        $keys = CommentTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getParentId(),
            $keys[2] => $this->getPublicationId(),
            $keys[3] => $this->getPicture(),
            $keys[4] => $this->getContent(),
            $keys[5] => $this->getIsDeleted(),
            $keys[6] => $this->getIsVerified(),
            $keys[7] => $this->getUpdatingReason(),
            $keys[8] => $this->getDeletingReason(),
            $keys[9] => $this->getCreatedAt(),
            $keys[10] => $this->getCreatedBy(),
            $keys[11] => $this->getUpdatedAt(),
            $keys[12] => $this->getUpdatedBy(),
            $keys[13] => $this->getDeletedAt(),
            $keys[14] => $this->getDeletedBy(),
            $keys[15] => $this->getVerifiedAt(),
            $keys[16] => $this->getVerifiedBy(),
        );
        if ($result[$keys[9]] instanceof \DateTimeInterface) {
            $result[$keys[9]] = $result[$keys[9]]->format('c');
        }

        if ($result[$keys[11]] instanceof \DateTimeInterface) {
            $result[$keys[11]] = $result[$keys[11]]->format('c');
        }

        if ($result[$keys[13]] instanceof \DateTimeInterface) {
            $result[$keys[13]] = $result[$keys[13]]->format('c');
        }

        if ($result[$keys[15]] instanceof \DateTimeInterface) {
            $result[$keys[15]] = $result[$keys[15]]->format('c');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aParent) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'comment';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'fenric_comment';
                        break;
                    default:
                        $key = 'Parent';
                }

                $result[$key] = $this->aParent->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aPublication) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'publication';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'fenric_publication';
                        break;
                    default:
                        $key = 'Publication';
                }

                $result[$key] = $this->aPublication->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
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
            if (null !== $this->aUserRelatedByDeletedBy) {

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

                $result[$key] = $this->aUserRelatedByDeletedBy->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aUserRelatedByVerifiedBy) {

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

                $result[$key] = $this->aUserRelatedByVerifiedBy->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collCommentsRelatedById) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'comments';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'fenric_comments';
                        break;
                    default:
                        $key = 'Comments';
                }

                $result[$key] = $this->collCommentsRelatedById->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Propel\Models\Comment
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = CommentTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Propel\Models\Comment
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setParentId($value);
                break;
            case 2:
                $this->setPublicationId($value);
                break;
            case 3:
                $this->setPicture($value);
                break;
            case 4:
                $this->setContent($value);
                break;
            case 5:
                $this->setIsDeleted($value);
                break;
            case 6:
                $this->setIsVerified($value);
                break;
            case 7:
                $this->setUpdatingReason($value);
                break;
            case 8:
                $this->setDeletingReason($value);
                break;
            case 9:
                $this->setCreatedAt($value);
                break;
            case 10:
                $this->setCreatedBy($value);
                break;
            case 11:
                $this->setUpdatedAt($value);
                break;
            case 12:
                $this->setUpdatedBy($value);
                break;
            case 13:
                $this->setDeletedAt($value);
                break;
            case 14:
                $this->setDeletedBy($value);
                break;
            case 15:
                $this->setVerifiedAt($value);
                break;
            case 16:
                $this->setVerifiedBy($value);
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
        $keys = CommentTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setParentId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setPublicationId($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setPicture($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setContent($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setIsDeleted($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setIsVerified($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setUpdatingReason($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setDeletingReason($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setCreatedAt($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setCreatedBy($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setUpdatedAt($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->setUpdatedBy($arr[$keys[12]]);
        }
        if (array_key_exists($keys[13], $arr)) {
            $this->setDeletedAt($arr[$keys[13]]);
        }
        if (array_key_exists($keys[14], $arr)) {
            $this->setDeletedBy($arr[$keys[14]]);
        }
        if (array_key_exists($keys[15], $arr)) {
            $this->setVerifiedAt($arr[$keys[15]]);
        }
        if (array_key_exists($keys[16], $arr)) {
            $this->setVerifiedBy($arr[$keys[16]]);
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
     * @return $this|\Propel\Models\Comment The current object, for fluid interface
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
        $criteria = new Criteria(CommentTableMap::DATABASE_NAME);

        if ($this->isColumnModified(CommentTableMap::COL_ID)) {
            $criteria->add(CommentTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(CommentTableMap::COL_PARENT_ID)) {
            $criteria->add(CommentTableMap::COL_PARENT_ID, $this->parent_id);
        }
        if ($this->isColumnModified(CommentTableMap::COL_PUBLICATION_ID)) {
            $criteria->add(CommentTableMap::COL_PUBLICATION_ID, $this->publication_id);
        }
        if ($this->isColumnModified(CommentTableMap::COL_PICTURE)) {
            $criteria->add(CommentTableMap::COL_PICTURE, $this->picture);
        }
        if ($this->isColumnModified(CommentTableMap::COL_CONTENT)) {
            $criteria->add(CommentTableMap::COL_CONTENT, $this->content);
        }
        if ($this->isColumnModified(CommentTableMap::COL_IS_DELETED)) {
            $criteria->add(CommentTableMap::COL_IS_DELETED, $this->is_deleted);
        }
        if ($this->isColumnModified(CommentTableMap::COL_IS_VERIFIED)) {
            $criteria->add(CommentTableMap::COL_IS_VERIFIED, $this->is_verified);
        }
        if ($this->isColumnModified(CommentTableMap::COL_UPDATING_REASON)) {
            $criteria->add(CommentTableMap::COL_UPDATING_REASON, $this->updating_reason);
        }
        if ($this->isColumnModified(CommentTableMap::COL_DELETING_REASON)) {
            $criteria->add(CommentTableMap::COL_DELETING_REASON, $this->deleting_reason);
        }
        if ($this->isColumnModified(CommentTableMap::COL_CREATED_AT)) {
            $criteria->add(CommentTableMap::COL_CREATED_AT, $this->created_at);
        }
        if ($this->isColumnModified(CommentTableMap::COL_CREATED_BY)) {
            $criteria->add(CommentTableMap::COL_CREATED_BY, $this->created_by);
        }
        if ($this->isColumnModified(CommentTableMap::COL_UPDATED_AT)) {
            $criteria->add(CommentTableMap::COL_UPDATED_AT, $this->updated_at);
        }
        if ($this->isColumnModified(CommentTableMap::COL_UPDATED_BY)) {
            $criteria->add(CommentTableMap::COL_UPDATED_BY, $this->updated_by);
        }
        if ($this->isColumnModified(CommentTableMap::COL_DELETED_AT)) {
            $criteria->add(CommentTableMap::COL_DELETED_AT, $this->deleted_at);
        }
        if ($this->isColumnModified(CommentTableMap::COL_DELETED_BY)) {
            $criteria->add(CommentTableMap::COL_DELETED_BY, $this->deleted_by);
        }
        if ($this->isColumnModified(CommentTableMap::COL_VERIFIED_AT)) {
            $criteria->add(CommentTableMap::COL_VERIFIED_AT, $this->verified_at);
        }
        if ($this->isColumnModified(CommentTableMap::COL_VERIFIED_BY)) {
            $criteria->add(CommentTableMap::COL_VERIFIED_BY, $this->verified_by);
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
        $criteria = ChildCommentQuery::create();
        $criteria->add(CommentTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \Propel\Models\Comment (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setParentId($this->getParentId());
        $copyObj->setPublicationId($this->getPublicationId());
        $copyObj->setPicture($this->getPicture());
        $copyObj->setContent($this->getContent());
        $copyObj->setIsDeleted($this->getIsDeleted());
        $copyObj->setIsVerified($this->getIsVerified());
        $copyObj->setUpdatingReason($this->getUpdatingReason());
        $copyObj->setDeletingReason($this->getDeletingReason());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setCreatedBy($this->getCreatedBy());
        $copyObj->setUpdatedAt($this->getUpdatedAt());
        $copyObj->setUpdatedBy($this->getUpdatedBy());
        $copyObj->setDeletedAt($this->getDeletedAt());
        $copyObj->setDeletedBy($this->getDeletedBy());
        $copyObj->setVerifiedAt($this->getVerifiedAt());
        $copyObj->setVerifiedBy($this->getVerifiedBy());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getCommentsRelatedById() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCommentRelatedById($relObj->copy($deepCopy));
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
     * @return \Propel\Models\Comment Clone of current object.
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
     * Declares an association between this object and a ChildComment object.
     *
     * @param  ChildComment $v
     * @return $this|\Propel\Models\Comment The current object (for fluent API support)
     * @throws PropelException
     */
    public function setParent(ChildComment $v = null)
    {
        if ($v === null) {
            $this->setParentId(NULL);
        } else {
            $this->setParentId($v->getId());
        }

        $this->aParent = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildComment object, it will not be re-added.
        if ($v !== null) {
            $v->addCommentRelatedById($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildComment object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildComment The associated ChildComment object.
     * @throws PropelException
     */
    public function getParent(ConnectionInterface $con = null)
    {
        if ($this->aParent === null && ($this->parent_id != 0)) {
            $this->aParent = ChildCommentQuery::create()->findPk($this->parent_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aParent->addCommentsRelatedById($this);
             */
        }

        return $this->aParent;
    }

    /**
     * Declares an association between this object and a ChildPublication object.
     *
     * @param  ChildPublication $v
     * @return $this|\Propel\Models\Comment The current object (for fluent API support)
     * @throws PropelException
     */
    public function setPublication(ChildPublication $v = null)
    {
        if ($v === null) {
            $this->setPublicationId(NULL);
        } else {
            $this->setPublicationId($v->getId());
        }

        $this->aPublication = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildPublication object, it will not be re-added.
        if ($v !== null) {
            $v->addComment($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildPublication object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildPublication The associated ChildPublication object.
     * @throws PropelException
     */
    public function getPublication(ConnectionInterface $con = null)
    {
        if ($this->aPublication === null && ($this->publication_id != 0)) {
            $this->aPublication = ChildPublicationQuery::create()->findPk($this->publication_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aPublication->addComments($this);
             */
        }

        return $this->aPublication;
    }

    /**
     * Declares an association between this object and a ChildUser object.
     *
     * @param  ChildUser $v
     * @return $this|\Propel\Models\Comment The current object (for fluent API support)
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
            $v->addCommentRelatedByCreatedBy($this);
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
                $this->aUserRelatedByCreatedBy->addCommentsRelatedByCreatedBy($this);
             */
        }

        return $this->aUserRelatedByCreatedBy;
    }

    /**
     * Declares an association between this object and a ChildUser object.
     *
     * @param  ChildUser $v
     * @return $this|\Propel\Models\Comment The current object (for fluent API support)
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
            $v->addCommentRelatedByUpdatedBy($this);
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
                $this->aUserRelatedByUpdatedBy->addCommentsRelatedByUpdatedBy($this);
             */
        }

        return $this->aUserRelatedByUpdatedBy;
    }

    /**
     * Declares an association between this object and a ChildUser object.
     *
     * @param  ChildUser $v
     * @return $this|\Propel\Models\Comment The current object (for fluent API support)
     * @throws PropelException
     */
    public function setUserRelatedByDeletedBy(ChildUser $v = null)
    {
        if ($v === null) {
            $this->setDeletedBy(NULL);
        } else {
            $this->setDeletedBy($v->getId());
        }

        $this->aUserRelatedByDeletedBy = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildUser object, it will not be re-added.
        if ($v !== null) {
            $v->addCommentRelatedByDeletedBy($this);
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
    public function getUserRelatedByDeletedBy(ConnectionInterface $con = null)
    {
        if ($this->aUserRelatedByDeletedBy === null && ($this->deleted_by != 0)) {
            $this->aUserRelatedByDeletedBy = ChildUserQuery::create()->findPk($this->deleted_by, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aUserRelatedByDeletedBy->addCommentsRelatedByDeletedBy($this);
             */
        }

        return $this->aUserRelatedByDeletedBy;
    }

    /**
     * Declares an association between this object and a ChildUser object.
     *
     * @param  ChildUser $v
     * @return $this|\Propel\Models\Comment The current object (for fluent API support)
     * @throws PropelException
     */
    public function setUserRelatedByVerifiedBy(ChildUser $v = null)
    {
        if ($v === null) {
            $this->setVerifiedBy(NULL);
        } else {
            $this->setVerifiedBy($v->getId());
        }

        $this->aUserRelatedByVerifiedBy = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildUser object, it will not be re-added.
        if ($v !== null) {
            $v->addCommentRelatedByVerifiedBy($this);
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
    public function getUserRelatedByVerifiedBy(ConnectionInterface $con = null)
    {
        if ($this->aUserRelatedByVerifiedBy === null && ($this->verified_by != 0)) {
            $this->aUserRelatedByVerifiedBy = ChildUserQuery::create()->findPk($this->verified_by, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aUserRelatedByVerifiedBy->addCommentsRelatedByVerifiedBy($this);
             */
        }

        return $this->aUserRelatedByVerifiedBy;
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
        if ('CommentRelatedById' == $relationName) {
            $this->initCommentsRelatedById();
            return;
        }
    }

    /**
     * Clears out the collCommentsRelatedById collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addCommentsRelatedById()
     */
    public function clearCommentsRelatedById()
    {
        $this->collCommentsRelatedById = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collCommentsRelatedById collection loaded partially.
     */
    public function resetPartialCommentsRelatedById($v = true)
    {
        $this->collCommentsRelatedByIdPartial = $v;
    }

    /**
     * Initializes the collCommentsRelatedById collection.
     *
     * By default this just sets the collCommentsRelatedById collection to an empty array (like clearcollCommentsRelatedById());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCommentsRelatedById($overrideExisting = true)
    {
        if (null !== $this->collCommentsRelatedById && !$overrideExisting) {
            return;
        }

        $collectionClassName = CommentTableMap::getTableMap()->getCollectionClassName();

        $this->collCommentsRelatedById = new $collectionClassName;
        $this->collCommentsRelatedById->setModel('\Propel\Models\Comment');
    }

    /**
     * Gets an array of ChildComment objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildComment is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildComment[] List of ChildComment objects
     * @throws PropelException
     */
    public function getCommentsRelatedById(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collCommentsRelatedByIdPartial && !$this->isNew();
        if (null === $this->collCommentsRelatedById || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCommentsRelatedById) {
                // return empty collection
                $this->initCommentsRelatedById();
            } else {
                $collCommentsRelatedById = ChildCommentQuery::create(null, $criteria)
                    ->filterByParent($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collCommentsRelatedByIdPartial && count($collCommentsRelatedById)) {
                        $this->initCommentsRelatedById(false);

                        foreach ($collCommentsRelatedById as $obj) {
                            if (false == $this->collCommentsRelatedById->contains($obj)) {
                                $this->collCommentsRelatedById->append($obj);
                            }
                        }

                        $this->collCommentsRelatedByIdPartial = true;
                    }

                    return $collCommentsRelatedById;
                }

                if ($partial && $this->collCommentsRelatedById) {
                    foreach ($this->collCommentsRelatedById as $obj) {
                        if ($obj->isNew()) {
                            $collCommentsRelatedById[] = $obj;
                        }
                    }
                }

                $this->collCommentsRelatedById = $collCommentsRelatedById;
                $this->collCommentsRelatedByIdPartial = false;
            }
        }

        return $this->collCommentsRelatedById;
    }

    /**
     * Sets a collection of ChildComment objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $commentsRelatedById A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildComment The current object (for fluent API support)
     */
    public function setCommentsRelatedById(Collection $commentsRelatedById, ConnectionInterface $con = null)
    {
        /** @var ChildComment[] $commentsRelatedByIdToDelete */
        $commentsRelatedByIdToDelete = $this->getCommentsRelatedById(new Criteria(), $con)->diff($commentsRelatedById);


        $this->commentsRelatedByIdScheduledForDeletion = $commentsRelatedByIdToDelete;

        foreach ($commentsRelatedByIdToDelete as $commentRelatedByIdRemoved) {
            $commentRelatedByIdRemoved->setParent(null);
        }

        $this->collCommentsRelatedById = null;
        foreach ($commentsRelatedById as $commentRelatedById) {
            $this->addCommentRelatedById($commentRelatedById);
        }

        $this->collCommentsRelatedById = $commentsRelatedById;
        $this->collCommentsRelatedByIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Comment objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Comment objects.
     * @throws PropelException
     */
    public function countCommentsRelatedById(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collCommentsRelatedByIdPartial && !$this->isNew();
        if (null === $this->collCommentsRelatedById || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCommentsRelatedById) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getCommentsRelatedById());
            }

            $query = ChildCommentQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByParent($this)
                ->count($con);
        }

        return count($this->collCommentsRelatedById);
    }

    /**
     * Method called to associate a ChildComment object to this object
     * through the ChildComment foreign key attribute.
     *
     * @param  ChildComment $l ChildComment
     * @return $this|\Propel\Models\Comment The current object (for fluent API support)
     */
    public function addCommentRelatedById(ChildComment $l)
    {
        if ($this->collCommentsRelatedById === null) {
            $this->initCommentsRelatedById();
            $this->collCommentsRelatedByIdPartial = true;
        }

        if (!$this->collCommentsRelatedById->contains($l)) {
            $this->doAddCommentRelatedById($l);

            if ($this->commentsRelatedByIdScheduledForDeletion and $this->commentsRelatedByIdScheduledForDeletion->contains($l)) {
                $this->commentsRelatedByIdScheduledForDeletion->remove($this->commentsRelatedByIdScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildComment $commentRelatedById The ChildComment object to add.
     */
    protected function doAddCommentRelatedById(ChildComment $commentRelatedById)
    {
        $this->collCommentsRelatedById[]= $commentRelatedById;
        $commentRelatedById->setParent($this);
    }

    /**
     * @param  ChildComment $commentRelatedById The ChildComment object to remove.
     * @return $this|ChildComment The current object (for fluent API support)
     */
    public function removeCommentRelatedById(ChildComment $commentRelatedById)
    {
        if ($this->getCommentsRelatedById()->contains($commentRelatedById)) {
            $pos = $this->collCommentsRelatedById->search($commentRelatedById);
            $this->collCommentsRelatedById->remove($pos);
            if (null === $this->commentsRelatedByIdScheduledForDeletion) {
                $this->commentsRelatedByIdScheduledForDeletion = clone $this->collCommentsRelatedById;
                $this->commentsRelatedByIdScheduledForDeletion->clear();
            }
            $this->commentsRelatedByIdScheduledForDeletion[]= $commentRelatedById;
            $commentRelatedById->setParent(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Comment is new, it will return
     * an empty collection; or if this Comment has previously
     * been saved, it will retrieve related CommentsRelatedById from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Comment.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildComment[] List of ChildComment objects
     */
    public function getCommentsRelatedByIdJoinPublication(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCommentQuery::create(null, $criteria);
        $query->joinWith('Publication', $joinBehavior);

        return $this->getCommentsRelatedById($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Comment is new, it will return
     * an empty collection; or if this Comment has previously
     * been saved, it will retrieve related CommentsRelatedById from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Comment.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildComment[] List of ChildComment objects
     */
    public function getCommentsRelatedByIdJoinUserRelatedByCreatedBy(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCommentQuery::create(null, $criteria);
        $query->joinWith('UserRelatedByCreatedBy', $joinBehavior);

        return $this->getCommentsRelatedById($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Comment is new, it will return
     * an empty collection; or if this Comment has previously
     * been saved, it will retrieve related CommentsRelatedById from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Comment.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildComment[] List of ChildComment objects
     */
    public function getCommentsRelatedByIdJoinUserRelatedByUpdatedBy(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCommentQuery::create(null, $criteria);
        $query->joinWith('UserRelatedByUpdatedBy', $joinBehavior);

        return $this->getCommentsRelatedById($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Comment is new, it will return
     * an empty collection; or if this Comment has previously
     * been saved, it will retrieve related CommentsRelatedById from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Comment.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildComment[] List of ChildComment objects
     */
    public function getCommentsRelatedByIdJoinUserRelatedByDeletedBy(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCommentQuery::create(null, $criteria);
        $query->joinWith('UserRelatedByDeletedBy', $joinBehavior);

        return $this->getCommentsRelatedById($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Comment is new, it will return
     * an empty collection; or if this Comment has previously
     * been saved, it will retrieve related CommentsRelatedById from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Comment.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildComment[] List of ChildComment objects
     */
    public function getCommentsRelatedByIdJoinUserRelatedByVerifiedBy(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCommentQuery::create(null, $criteria);
        $query->joinWith('UserRelatedByVerifiedBy', $joinBehavior);

        return $this->getCommentsRelatedById($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aParent) {
            $this->aParent->removeCommentRelatedById($this);
        }
        if (null !== $this->aPublication) {
            $this->aPublication->removeComment($this);
        }
        if (null !== $this->aUserRelatedByCreatedBy) {
            $this->aUserRelatedByCreatedBy->removeCommentRelatedByCreatedBy($this);
        }
        if (null !== $this->aUserRelatedByUpdatedBy) {
            $this->aUserRelatedByUpdatedBy->removeCommentRelatedByUpdatedBy($this);
        }
        if (null !== $this->aUserRelatedByDeletedBy) {
            $this->aUserRelatedByDeletedBy->removeCommentRelatedByDeletedBy($this);
        }
        if (null !== $this->aUserRelatedByVerifiedBy) {
            $this->aUserRelatedByVerifiedBy->removeCommentRelatedByVerifiedBy($this);
        }
        $this->id = null;
        $this->parent_id = null;
        $this->publication_id = null;
        $this->picture = null;
        $this->content = null;
        $this->is_deleted = null;
        $this->is_verified = null;
        $this->updating_reason = null;
        $this->deleting_reason = null;
        $this->created_at = null;
        $this->created_by = null;
        $this->updated_at = null;
        $this->updated_by = null;
        $this->deleted_at = null;
        $this->deleted_by = null;
        $this->verified_at = null;
        $this->verified_by = null;
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
            if ($this->collCommentsRelatedById) {
                foreach ($this->collCommentsRelatedById as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collCommentsRelatedById = null;
        $this->aParent = null;
        $this->aPublication = null;
        $this->aUserRelatedByCreatedBy = null;
        $this->aUserRelatedByUpdatedBy = null;
        $this->aUserRelatedByDeletedBy = null;
        $this->aUserRelatedByVerifiedBy = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(CommentTableMap::DEFAULT_STRING_FORMAT);
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
        fenric('event::model.comment.validate')->run([func_get_arg(0), \Propel\Runtime\Propel::getServiceContainer()->getWriteConnection(CommentTableMap::DATABASE_NAME)]);

        $metadata->addPropertyConstraint('content', new NotNull());
        $metadata->addPropertyConstraint('content', new NotBlank());
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
            if (method_exists($this->aParent, 'validate')) {
                if (!$this->aParent->validate($validator)) {
                    $failureMap->addAll($this->aParent->getValidationFailures());
                }
            }
            // If validate() method exists, the validate-behavior is configured for related object
            if (method_exists($this->aPublication, 'validate')) {
                if (!$this->aPublication->validate($validator)) {
                    $failureMap->addAll($this->aPublication->getValidationFailures());
                }
            }
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
            // If validate() method exists, the validate-behavior is configured for related object
            if (method_exists($this->aUserRelatedByDeletedBy, 'validate')) {
                if (!$this->aUserRelatedByDeletedBy->validate($validator)) {
                    $failureMap->addAll($this->aUserRelatedByDeletedBy->getValidationFailures());
                }
            }
            // If validate() method exists, the validate-behavior is configured for related object
            if (method_exists($this->aUserRelatedByVerifiedBy, 'validate')) {
                if (!$this->aUserRelatedByVerifiedBy->validate($validator)) {
                    $failureMap->addAll($this->aUserRelatedByVerifiedBy->getValidationFailures());
                }
            }

            $retval = $validator->validate($this);
            if (count($retval) > 0) {
                $failureMap->addAll($retval);
            }

            if (null !== $this->collCommentsRelatedById) {
                foreach ($this->collCommentsRelatedById as $referrerFK) {
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
