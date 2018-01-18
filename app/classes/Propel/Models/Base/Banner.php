<?php

namespace Propel\Models\Base;

use \DateTime;
use \Exception;
use \PDO;
use Propel\Models\BannerClient as ChildBannerClient;
use Propel\Models\BannerClientQuery as ChildBannerClientQuery;
use Propel\Models\BannerGroup as ChildBannerGroup;
use Propel\Models\BannerGroupQuery as ChildBannerGroupQuery;
use Propel\Models\BannerQuery as ChildBannerQuery;
use Propel\Models\User as ChildUser;
use Propel\Models\UserQuery as ChildUserQuery;
use Propel\Models\Map\BannerTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
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
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Url;
use Symfony\Component\Validator\Context\ExecutionContextFactory;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Mapping\Factory\LazyLoadingMetadataFactory;
use Symfony\Component\Validator\Mapping\Loader\StaticMethodLoader;
use Symfony\Component\Validator\Validator\RecursiveValidator;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Base class that represents a row from the 'fenric_banner' table.
 *
 *
 *
 * @package    propel.generator.Propel.Models.Base
 */
abstract class Banner implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Propel\\Models\\Map\\BannerTableMap';


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
     * The value for the banner_group_id field.
     *
     * @var        int
     */
    protected $banner_group_id;

    /**
     * The value for the banner_client_id field.
     *
     * @var        int
     */
    protected $banner_client_id;

    /**
     * The value for the title field.
     *
     * @var        string
     */
    protected $title;

    /**
     * The value for the description field.
     *
     * @var        string
     */
    protected $description;

    /**
     * The value for the picture field.
     *
     * @var        string
     */
    protected $picture;

    /**
     * The value for the picture_alt field.
     *
     * @var        string
     */
    protected $picture_alt;

    /**
     * The value for the picture_title field.
     *
     * @var        string
     */
    protected $picture_title;

    /**
     * The value for the hyperlink_url field.
     *
     * @var        string
     */
    protected $hyperlink_url;

    /**
     * The value for the hyperlink_title field.
     *
     * @var        string
     */
    protected $hyperlink_title;

    /**
     * The value for the hyperlink_target field.
     *
     * @var        string
     */
    protected $hyperlink_target;

    /**
     * The value for the show_start field.
     *
     * @var        DateTime
     */
    protected $show_start;

    /**
     * The value for the show_end field.
     *
     * @var        DateTime
     */
    protected $show_end;

    /**
     * The value for the shows field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $shows;

    /**
     * The value for the shows_limit field.
     *
     * @var        string
     */
    protected $shows_limit;

    /**
     * The value for the clicks field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $clicks;

    /**
     * The value for the clicks_limit field.
     *
     * @var        string
     */
    protected $clicks_limit;

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
     * @var        ChildBannerGroup
     */
    protected $aBannerGroup;

    /**
     * @var        ChildBannerClient
     */
    protected $aBannerClient;

    /**
     * @var        ChildUser
     */
    protected $aUserRelatedByCreatedBy;

    /**
     * @var        ChildUser
     */
    protected $aUserRelatedByUpdatedBy;

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
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->shows = '0';
        $this->clicks = '0';
    }

    /**
     * Initializes internal state of Propel\Models\Base\Banner object.
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
     * Compares this with another <code>Banner</code> instance.  If
     * <code>obj</code> is an instance of <code>Banner</code>, delegates to
     * <code>equals(Banner)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Banner The current object, for fluid interface
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
     * Get the [banner_group_id] column value.
     *
     * @return int
     */
    public function getBannerGroupId()
    {
        return $this->banner_group_id;
    }

    /**
     * Get the [banner_client_id] column value.
     *
     * @return int
     */
    public function getBannerClientId()
    {
        return $this->banner_client_id;
    }

    /**
     * Get the [title] column value.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get the [description] column value.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
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
     * Get the [picture_alt] column value.
     *
     * @return string
     */
    public function getPictureAlt()
    {
        return $this->picture_alt;
    }

    /**
     * Get the [picture_title] column value.
     *
     * @return string
     */
    public function getPictureTitle()
    {
        return $this->picture_title;
    }

    /**
     * Get the [hyperlink_url] column value.
     *
     * @return string
     */
    public function getHyperlinkUrl()
    {
        return $this->hyperlink_url;
    }

    /**
     * Get the [hyperlink_title] column value.
     *
     * @return string
     */
    public function getHyperlinkTitle()
    {
        return $this->hyperlink_title;
    }

    /**
     * Get the [hyperlink_target] column value.
     *
     * @return string
     */
    public function getHyperlinkTarget()
    {
        return $this->hyperlink_target;
    }

    /**
     * Get the [optionally formatted] temporal [show_start] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getShowStart($format = NULL)
    {
        if ($format === null) {
            return $this->show_start;
        } else {
            return $this->show_start instanceof \DateTimeInterface ? $this->show_start->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [show_end] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getShowEnd($format = NULL)
    {
        if ($format === null) {
            return $this->show_end;
        } else {
            return $this->show_end instanceof \DateTimeInterface ? $this->show_end->format($format) : null;
        }
    }

    /**
     * Get the [shows] column value.
     *
     * @return string
     */
    public function getShows()
    {
        return $this->shows;
    }

    /**
     * Get the [shows_limit] column value.
     *
     * @return string
     */
    public function getShowsLimit()
    {
        return $this->shows_limit;
    }

    /**
     * Get the [clicks] column value.
     *
     * @return string
     */
    public function getClicks()
    {
        return $this->clicks;
    }

    /**
     * Get the [clicks_limit] column value.
     *
     * @return string
     */
    public function getClicksLimit()
    {
        return $this->clicks_limit;
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
     * @return $this|\Propel\Models\Banner The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[BannerTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [banner_group_id] column.
     *
     * @param int $v new value
     * @return $this|\Propel\Models\Banner The current object (for fluent API support)
     */
    public function setBannerGroupId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->banner_group_id !== $v) {
            $this->banner_group_id = $v;
            $this->modifiedColumns[BannerTableMap::COL_BANNER_GROUP_ID] = true;
        }

        if ($this->aBannerGroup !== null && $this->aBannerGroup->getId() !== $v) {
            $this->aBannerGroup = null;
        }

        return $this;
    } // setBannerGroupId()

    /**
     * Set the value of [banner_client_id] column.
     *
     * @param int $v new value
     * @return $this|\Propel\Models\Banner The current object (for fluent API support)
     */
    public function setBannerClientId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->banner_client_id !== $v) {
            $this->banner_client_id = $v;
            $this->modifiedColumns[BannerTableMap::COL_BANNER_CLIENT_ID] = true;
        }

        if ($this->aBannerClient !== null && $this->aBannerClient->getId() !== $v) {
            $this->aBannerClient = null;
        }

        return $this;
    } // setBannerClientId()

    /**
     * Set the value of [title] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\Banner The current object (for fluent API support)
     */
    public function setTitle($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->title !== $v) {
            $this->title = $v;
            $this->modifiedColumns[BannerTableMap::COL_TITLE] = true;
        }

        return $this;
    } // setTitle()

    /**
     * Set the value of [description] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\Banner The current object (for fluent API support)
     */
    public function setDescription($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->description !== $v) {
            $this->description = $v;
            $this->modifiedColumns[BannerTableMap::COL_DESCRIPTION] = true;
        }

        return $this;
    } // setDescription()

    /**
     * Set the value of [picture] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\Banner The current object (for fluent API support)
     */
    public function setPicture($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->picture !== $v) {
            $this->picture = $v;
            $this->modifiedColumns[BannerTableMap::COL_PICTURE] = true;
        }

        return $this;
    } // setPicture()

    /**
     * Set the value of [picture_alt] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\Banner The current object (for fluent API support)
     */
    public function setPictureAlt($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->picture_alt !== $v) {
            $this->picture_alt = $v;
            $this->modifiedColumns[BannerTableMap::COL_PICTURE_ALT] = true;
        }

        return $this;
    } // setPictureAlt()

    /**
     * Set the value of [picture_title] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\Banner The current object (for fluent API support)
     */
    public function setPictureTitle($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->picture_title !== $v) {
            $this->picture_title = $v;
            $this->modifiedColumns[BannerTableMap::COL_PICTURE_TITLE] = true;
        }

        return $this;
    } // setPictureTitle()

    /**
     * Set the value of [hyperlink_url] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\Banner The current object (for fluent API support)
     */
    public function setHyperlinkUrl($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->hyperlink_url !== $v) {
            $this->hyperlink_url = $v;
            $this->modifiedColumns[BannerTableMap::COL_HYPERLINK_URL] = true;
        }

        return $this;
    } // setHyperlinkUrl()

    /**
     * Set the value of [hyperlink_title] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\Banner The current object (for fluent API support)
     */
    public function setHyperlinkTitle($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->hyperlink_title !== $v) {
            $this->hyperlink_title = $v;
            $this->modifiedColumns[BannerTableMap::COL_HYPERLINK_TITLE] = true;
        }

        return $this;
    } // setHyperlinkTitle()

    /**
     * Set the value of [hyperlink_target] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\Banner The current object (for fluent API support)
     */
    public function setHyperlinkTarget($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->hyperlink_target !== $v) {
            $this->hyperlink_target = $v;
            $this->modifiedColumns[BannerTableMap::COL_HYPERLINK_TARGET] = true;
        }

        return $this;
    } // setHyperlinkTarget()

    /**
     * Sets the value of [show_start] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Propel\Models\Banner The current object (for fluent API support)
     */
    public function setShowStart($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->show_start !== null || $dt !== null) {
            if ($this->show_start === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->show_start->format("Y-m-d H:i:s.u")) {
                $this->show_start = $dt === null ? null : clone $dt;
                $this->modifiedColumns[BannerTableMap::COL_SHOW_START] = true;
            }
        } // if either are not null

        return $this;
    } // setShowStart()

    /**
     * Sets the value of [show_end] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Propel\Models\Banner The current object (for fluent API support)
     */
    public function setShowEnd($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->show_end !== null || $dt !== null) {
            if ($this->show_end === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->show_end->format("Y-m-d H:i:s.u")) {
                $this->show_end = $dt === null ? null : clone $dt;
                $this->modifiedColumns[BannerTableMap::COL_SHOW_END] = true;
            }
        } // if either are not null

        return $this;
    } // setShowEnd()

    /**
     * Set the value of [shows] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\Banner The current object (for fluent API support)
     */
    public function setShows($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->shows !== $v) {
            $this->shows = $v;
            $this->modifiedColumns[BannerTableMap::COL_SHOWS] = true;
        }

        return $this;
    } // setShows()

    /**
     * Set the value of [shows_limit] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\Banner The current object (for fluent API support)
     */
    public function setShowsLimit($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->shows_limit !== $v) {
            $this->shows_limit = $v;
            $this->modifiedColumns[BannerTableMap::COL_SHOWS_LIMIT] = true;
        }

        return $this;
    } // setShowsLimit()

    /**
     * Set the value of [clicks] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\Banner The current object (for fluent API support)
     */
    public function setClicks($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->clicks !== $v) {
            $this->clicks = $v;
            $this->modifiedColumns[BannerTableMap::COL_CLICKS] = true;
        }

        return $this;
    } // setClicks()

    /**
     * Set the value of [clicks_limit] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\Banner The current object (for fluent API support)
     */
    public function setClicksLimit($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->clicks_limit !== $v) {
            $this->clicks_limit = $v;
            $this->modifiedColumns[BannerTableMap::COL_CLICKS_LIMIT] = true;
        }

        return $this;
    } // setClicksLimit()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Propel\Models\Banner The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($this->created_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->created_at->format("Y-m-d H:i:s.u")) {
                $this->created_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[BannerTableMap::COL_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setCreatedAt()

    /**
     * Set the value of [created_by] column.
     *
     * @param int $v new value
     * @return $this|\Propel\Models\Banner The current object (for fluent API support)
     */
    public function setCreatedBy($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->created_by !== $v) {
            $this->created_by = $v;
            $this->modifiedColumns[BannerTableMap::COL_CREATED_BY] = true;
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
     * @return $this|\Propel\Models\Banner The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($this->updated_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->updated_at->format("Y-m-d H:i:s.u")) {
                $this->updated_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[BannerTableMap::COL_UPDATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setUpdatedAt()

    /**
     * Set the value of [updated_by] column.
     *
     * @param int $v new value
     * @return $this|\Propel\Models\Banner The current object (for fluent API support)
     */
    public function setUpdatedBy($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->updated_by !== $v) {
            $this->updated_by = $v;
            $this->modifiedColumns[BannerTableMap::COL_UPDATED_BY] = true;
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
            if ($this->shows !== '0') {
                return false;
            }

            if ($this->clicks !== '0') {
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : BannerTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : BannerTableMap::translateFieldName('BannerGroupId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->banner_group_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : BannerTableMap::translateFieldName('BannerClientId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->banner_client_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : BannerTableMap::translateFieldName('Title', TableMap::TYPE_PHPNAME, $indexType)];
            $this->title = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : BannerTableMap::translateFieldName('Description', TableMap::TYPE_PHPNAME, $indexType)];
            $this->description = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : BannerTableMap::translateFieldName('Picture', TableMap::TYPE_PHPNAME, $indexType)];
            $this->picture = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : BannerTableMap::translateFieldName('PictureAlt', TableMap::TYPE_PHPNAME, $indexType)];
            $this->picture_alt = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : BannerTableMap::translateFieldName('PictureTitle', TableMap::TYPE_PHPNAME, $indexType)];
            $this->picture_title = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : BannerTableMap::translateFieldName('HyperlinkUrl', TableMap::TYPE_PHPNAME, $indexType)];
            $this->hyperlink_url = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : BannerTableMap::translateFieldName('HyperlinkTitle', TableMap::TYPE_PHPNAME, $indexType)];
            $this->hyperlink_title = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : BannerTableMap::translateFieldName('HyperlinkTarget', TableMap::TYPE_PHPNAME, $indexType)];
            $this->hyperlink_target = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : BannerTableMap::translateFieldName('ShowStart', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->show_start = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : BannerTableMap::translateFieldName('ShowEnd', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->show_end = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : BannerTableMap::translateFieldName('Shows', TableMap::TYPE_PHPNAME, $indexType)];
            $this->shows = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 14 + $startcol : BannerTableMap::translateFieldName('ShowsLimit', TableMap::TYPE_PHPNAME, $indexType)];
            $this->shows_limit = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 15 + $startcol : BannerTableMap::translateFieldName('Clicks', TableMap::TYPE_PHPNAME, $indexType)];
            $this->clicks = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 16 + $startcol : BannerTableMap::translateFieldName('ClicksLimit', TableMap::TYPE_PHPNAME, $indexType)];
            $this->clicks_limit = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 17 + $startcol : BannerTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 18 + $startcol : BannerTableMap::translateFieldName('CreatedBy', TableMap::TYPE_PHPNAME, $indexType)];
            $this->created_by = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 19 + $startcol : BannerTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 20 + $startcol : BannerTableMap::translateFieldName('UpdatedBy', TableMap::TYPE_PHPNAME, $indexType)];
            $this->updated_by = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 21; // 21 = BannerTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Propel\\Models\\Banner'), 0, $e);
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
        if ($this->aBannerGroup !== null && $this->banner_group_id !== $this->aBannerGroup->getId()) {
            $this->aBannerGroup = null;
        }
        if ($this->aBannerClient !== null && $this->banner_client_id !== $this->aBannerClient->getId()) {
            $this->aBannerClient = null;
        }
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
            $con = Propel::getServiceContainer()->getReadConnection(BannerTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildBannerQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aBannerGroup = null;
            $this->aBannerClient = null;
            $this->aUserRelatedByCreatedBy = null;
            $this->aUserRelatedByUpdatedBy = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Banner::setDeleted()
     * @see Banner::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(BannerTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildBannerQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            // Fenric\Propel\Behaviors\Eventable behavior
            if (! fenric('event::model.banner.pre.delete')->run([$this, \Propel\Runtime\Propel::getServiceContainer()->getWriteConnection(BannerTableMap::DATABASE_NAME)])) {
                return 0;
            }
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                // Fenric\Propel\Behaviors\Eventable behavior
                fenric('event::model.banner.post.delete')->run([$this, \Propel\Runtime\Propel::getServiceContainer()->getWriteConnection(BannerTableMap::DATABASE_NAME)]);
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
            $con = Propel::getServiceContainer()->getWriteConnection(BannerTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            // Fenric\Propel\Behaviors\Eventable behavior
            if (! fenric('event::model.banner.pre.save')->run([$this, \Propel\Runtime\Propel::getServiceContainer()->getWriteConnection(BannerTableMap::DATABASE_NAME)])) {
                return 0;
            }
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // Fenric\Propel\Behaviors\Authorable behavior
                    if (! $this->isColumnModified(BannerTableMap::COL_CREATED_BY)) {
                        if (fenric()->existsSharedService('user')) {
                            if (fenric('user')->isLogged()) {
                                $this->setCreatedBy(fenric('user')->getId());
                            }
                        }
                    }	if (! $this->isColumnModified(BannerTableMap::COL_UPDATED_BY)) {
                        if (fenric()->existsSharedService('user')) {
                            if (fenric('user')->isLogged()) {
                                $this->setUpdatedBy(fenric('user')->getId());
                            }
                        }
                    }
                // Fenric\Propel\Behaviors\Timestampable behavior
                    if (! $this->isColumnModified(BannerTableMap::COL_CREATED_AT)) {
                        $this->setCreatedAt(new \DateTime('now'));
                    }	if (! $this->isColumnModified(BannerTableMap::COL_UPDATED_AT)) {
                        $this->setUpdatedAt(new \DateTime('now'));
                    }
                // Fenric\Propel\Behaviors\Eventable behavior
                if (! fenric('event::model.banner.pre.insert')->run([$this, \Propel\Runtime\Propel::getServiceContainer()->getWriteConnection(BannerTableMap::DATABASE_NAME)])) {
                    return 0;
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // Fenric\Propel\Behaviors\Authorable behavior
                    if (! $this->isColumnModified(BannerTableMap::COL_UPDATED_BY)) {
                        if (fenric()->existsSharedService('user')) {
                            if (fenric('user')->isLogged()) {
                                $this->setUpdatedBy(fenric('user')->getId());
                            }
                        }
                    }
                // Fenric\Propel\Behaviors\Timestampable behavior
                    if (! $this->isColumnModified(BannerTableMap::COL_UPDATED_AT)) {
                        $this->setUpdatedAt(new \DateTime('now'));
                    }
                // Fenric\Propel\Behaviors\Eventable behavior
                if (! fenric('event::model.banner.pre.update')->run([$this, \Propel\Runtime\Propel::getServiceContainer()->getWriteConnection(BannerTableMap::DATABASE_NAME)])) {
                    return 0;
                }
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                    // Fenric\Propel\Behaviors\Eventable behavior
                    fenric('event::model.banner.post.insert')->run([$this, \Propel\Runtime\Propel::getServiceContainer()->getWriteConnection(BannerTableMap::DATABASE_NAME)]);
                } else {
                    $this->postUpdate($con);
                    // Fenric\Propel\Behaviors\Eventable behavior
                    fenric('event::model.banner.post.update')->run([$this, \Propel\Runtime\Propel::getServiceContainer()->getWriteConnection(BannerTableMap::DATABASE_NAME)]);
                }
                $this->postSave($con);
                // Fenric\Propel\Behaviors\Eventable behavior
                fenric('event::model.banner.post.save')->run([$this, \Propel\Runtime\Propel::getServiceContainer()->getWriteConnection(BannerTableMap::DATABASE_NAME)]);
                BannerTableMap::addInstanceToPool($this);
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

            if ($this->aBannerGroup !== null) {
                if ($this->aBannerGroup->isModified() || $this->aBannerGroup->isNew()) {
                    $affectedRows += $this->aBannerGroup->save($con);
                }
                $this->setBannerGroup($this->aBannerGroup);
            }

            if ($this->aBannerClient !== null) {
                if ($this->aBannerClient->isModified() || $this->aBannerClient->isNew()) {
                    $affectedRows += $this->aBannerClient->save($con);
                }
                $this->setBannerClient($this->aBannerClient);
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

        $this->modifiedColumns[BannerTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . BannerTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(BannerTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(BannerTableMap::COL_BANNER_GROUP_ID)) {
            $modifiedColumns[':p' . $index++]  = 'banner_group_id';
        }
        if ($this->isColumnModified(BannerTableMap::COL_BANNER_CLIENT_ID)) {
            $modifiedColumns[':p' . $index++]  = 'banner_client_id';
        }
        if ($this->isColumnModified(BannerTableMap::COL_TITLE)) {
            $modifiedColumns[':p' . $index++]  = 'title';
        }
        if ($this->isColumnModified(BannerTableMap::COL_DESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = 'description';
        }
        if ($this->isColumnModified(BannerTableMap::COL_PICTURE)) {
            $modifiedColumns[':p' . $index++]  = 'picture';
        }
        if ($this->isColumnModified(BannerTableMap::COL_PICTURE_ALT)) {
            $modifiedColumns[':p' . $index++]  = 'picture_alt';
        }
        if ($this->isColumnModified(BannerTableMap::COL_PICTURE_TITLE)) {
            $modifiedColumns[':p' . $index++]  = 'picture_title';
        }
        if ($this->isColumnModified(BannerTableMap::COL_HYPERLINK_URL)) {
            $modifiedColumns[':p' . $index++]  = 'hyperlink_url';
        }
        if ($this->isColumnModified(BannerTableMap::COL_HYPERLINK_TITLE)) {
            $modifiedColumns[':p' . $index++]  = 'hyperlink_title';
        }
        if ($this->isColumnModified(BannerTableMap::COL_HYPERLINK_TARGET)) {
            $modifiedColumns[':p' . $index++]  = 'hyperlink_target';
        }
        if ($this->isColumnModified(BannerTableMap::COL_SHOW_START)) {
            $modifiedColumns[':p' . $index++]  = 'show_start';
        }
        if ($this->isColumnModified(BannerTableMap::COL_SHOW_END)) {
            $modifiedColumns[':p' . $index++]  = 'show_end';
        }
        if ($this->isColumnModified(BannerTableMap::COL_SHOWS)) {
            $modifiedColumns[':p' . $index++]  = 'shows';
        }
        if ($this->isColumnModified(BannerTableMap::COL_SHOWS_LIMIT)) {
            $modifiedColumns[':p' . $index++]  = 'shows_limit';
        }
        if ($this->isColumnModified(BannerTableMap::COL_CLICKS)) {
            $modifiedColumns[':p' . $index++]  = 'clicks';
        }
        if ($this->isColumnModified(BannerTableMap::COL_CLICKS_LIMIT)) {
            $modifiedColumns[':p' . $index++]  = 'clicks_limit';
        }
        if ($this->isColumnModified(BannerTableMap::COL_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'created_at';
        }
        if ($this->isColumnModified(BannerTableMap::COL_CREATED_BY)) {
            $modifiedColumns[':p' . $index++]  = 'created_by';
        }
        if ($this->isColumnModified(BannerTableMap::COL_UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'updated_at';
        }
        if ($this->isColumnModified(BannerTableMap::COL_UPDATED_BY)) {
            $modifiedColumns[':p' . $index++]  = 'updated_by';
        }

        $sql = sprintf(
            'INSERT INTO fenric_banner (%s) VALUES (%s)',
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
                    case 'banner_group_id':
                        $stmt->bindValue($identifier, $this->banner_group_id, PDO::PARAM_INT);
                        break;
                    case 'banner_client_id':
                        $stmt->bindValue($identifier, $this->banner_client_id, PDO::PARAM_INT);
                        break;
                    case 'title':
                        $stmt->bindValue($identifier, $this->title, PDO::PARAM_STR);
                        break;
                    case 'description':
                        $stmt->bindValue($identifier, $this->description, PDO::PARAM_STR);
                        break;
                    case 'picture':
                        $stmt->bindValue($identifier, $this->picture, PDO::PARAM_STR);
                        break;
                    case 'picture_alt':
                        $stmt->bindValue($identifier, $this->picture_alt, PDO::PARAM_STR);
                        break;
                    case 'picture_title':
                        $stmt->bindValue($identifier, $this->picture_title, PDO::PARAM_STR);
                        break;
                    case 'hyperlink_url':
                        $stmt->bindValue($identifier, $this->hyperlink_url, PDO::PARAM_STR);
                        break;
                    case 'hyperlink_title':
                        $stmt->bindValue($identifier, $this->hyperlink_title, PDO::PARAM_STR);
                        break;
                    case 'hyperlink_target':
                        $stmt->bindValue($identifier, $this->hyperlink_target, PDO::PARAM_STR);
                        break;
                    case 'show_start':
                        $stmt->bindValue($identifier, $this->show_start ? $this->show_start->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'show_end':
                        $stmt->bindValue($identifier, $this->show_end ? $this->show_end->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'shows':
                        $stmt->bindValue($identifier, $this->shows, PDO::PARAM_INT);
                        break;
                    case 'shows_limit':
                        $stmt->bindValue($identifier, $this->shows_limit, PDO::PARAM_INT);
                        break;
                    case 'clicks':
                        $stmt->bindValue($identifier, $this->clicks, PDO::PARAM_INT);
                        break;
                    case 'clicks_limit':
                        $stmt->bindValue($identifier, $this->clicks_limit, PDO::PARAM_INT);
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
        $pos = BannerTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getBannerGroupId();
                break;
            case 2:
                return $this->getBannerClientId();
                break;
            case 3:
                return $this->getTitle();
                break;
            case 4:
                return $this->getDescription();
                break;
            case 5:
                return $this->getPicture();
                break;
            case 6:
                return $this->getPictureAlt();
                break;
            case 7:
                return $this->getPictureTitle();
                break;
            case 8:
                return $this->getHyperlinkUrl();
                break;
            case 9:
                return $this->getHyperlinkTitle();
                break;
            case 10:
                return $this->getHyperlinkTarget();
                break;
            case 11:
                return $this->getShowStart();
                break;
            case 12:
                return $this->getShowEnd();
                break;
            case 13:
                return $this->getShows();
                break;
            case 14:
                return $this->getShowsLimit();
                break;
            case 15:
                return $this->getClicks();
                break;
            case 16:
                return $this->getClicksLimit();
                break;
            case 17:
                return $this->getCreatedAt();
                break;
            case 18:
                return $this->getCreatedBy();
                break;
            case 19:
                return $this->getUpdatedAt();
                break;
            case 20:
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

        if (isset($alreadyDumpedObjects['Banner'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Banner'][$this->hashCode()] = true;
        $keys = BannerTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getBannerGroupId(),
            $keys[2] => $this->getBannerClientId(),
            $keys[3] => $this->getTitle(),
            $keys[4] => $this->getDescription(),
            $keys[5] => $this->getPicture(),
            $keys[6] => $this->getPictureAlt(),
            $keys[7] => $this->getPictureTitle(),
            $keys[8] => $this->getHyperlinkUrl(),
            $keys[9] => $this->getHyperlinkTitle(),
            $keys[10] => $this->getHyperlinkTarget(),
            $keys[11] => $this->getShowStart(),
            $keys[12] => $this->getShowEnd(),
            $keys[13] => $this->getShows(),
            $keys[14] => $this->getShowsLimit(),
            $keys[15] => $this->getClicks(),
            $keys[16] => $this->getClicksLimit(),
            $keys[17] => $this->getCreatedAt(),
            $keys[18] => $this->getCreatedBy(),
            $keys[19] => $this->getUpdatedAt(),
            $keys[20] => $this->getUpdatedBy(),
        );
        if ($result[$keys[11]] instanceof \DateTimeInterface) {
            $result[$keys[11]] = $result[$keys[11]]->format('c');
        }

        if ($result[$keys[12]] instanceof \DateTimeInterface) {
            $result[$keys[12]] = $result[$keys[12]]->format('c');
        }

        if ($result[$keys[17]] instanceof \DateTimeInterface) {
            $result[$keys[17]] = $result[$keys[17]]->format('c');
        }

        if ($result[$keys[19]] instanceof \DateTimeInterface) {
            $result[$keys[19]] = $result[$keys[19]]->format('c');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aBannerGroup) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'bannerGroup';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'fenric_banner_group';
                        break;
                    default:
                        $key = 'BannerGroup';
                }

                $result[$key] = $this->aBannerGroup->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aBannerClient) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'bannerClient';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'fenric_banner_client';
                        break;
                    default:
                        $key = 'BannerClient';
                }

                $result[$key] = $this->aBannerClient->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
     * @return $this|\Propel\Models\Banner
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = BannerTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Propel\Models\Banner
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setBannerGroupId($value);
                break;
            case 2:
                $this->setBannerClientId($value);
                break;
            case 3:
                $this->setTitle($value);
                break;
            case 4:
                $this->setDescription($value);
                break;
            case 5:
                $this->setPicture($value);
                break;
            case 6:
                $this->setPictureAlt($value);
                break;
            case 7:
                $this->setPictureTitle($value);
                break;
            case 8:
                $this->setHyperlinkUrl($value);
                break;
            case 9:
                $this->setHyperlinkTitle($value);
                break;
            case 10:
                $this->setHyperlinkTarget($value);
                break;
            case 11:
                $this->setShowStart($value);
                break;
            case 12:
                $this->setShowEnd($value);
                break;
            case 13:
                $this->setShows($value);
                break;
            case 14:
                $this->setShowsLimit($value);
                break;
            case 15:
                $this->setClicks($value);
                break;
            case 16:
                $this->setClicksLimit($value);
                break;
            case 17:
                $this->setCreatedAt($value);
                break;
            case 18:
                $this->setCreatedBy($value);
                break;
            case 19:
                $this->setUpdatedAt($value);
                break;
            case 20:
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
        $keys = BannerTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setBannerGroupId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setBannerClientId($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setTitle($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setDescription($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setPicture($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setPictureAlt($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setPictureTitle($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setHyperlinkUrl($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setHyperlinkTitle($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setHyperlinkTarget($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setShowStart($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->setShowEnd($arr[$keys[12]]);
        }
        if (array_key_exists($keys[13], $arr)) {
            $this->setShows($arr[$keys[13]]);
        }
        if (array_key_exists($keys[14], $arr)) {
            $this->setShowsLimit($arr[$keys[14]]);
        }
        if (array_key_exists($keys[15], $arr)) {
            $this->setClicks($arr[$keys[15]]);
        }
        if (array_key_exists($keys[16], $arr)) {
            $this->setClicksLimit($arr[$keys[16]]);
        }
        if (array_key_exists($keys[17], $arr)) {
            $this->setCreatedAt($arr[$keys[17]]);
        }
        if (array_key_exists($keys[18], $arr)) {
            $this->setCreatedBy($arr[$keys[18]]);
        }
        if (array_key_exists($keys[19], $arr)) {
            $this->setUpdatedAt($arr[$keys[19]]);
        }
        if (array_key_exists($keys[20], $arr)) {
            $this->setUpdatedBy($arr[$keys[20]]);
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
     * @return $this|\Propel\Models\Banner The current object, for fluid interface
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
        $criteria = new Criteria(BannerTableMap::DATABASE_NAME);

        if ($this->isColumnModified(BannerTableMap::COL_ID)) {
            $criteria->add(BannerTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(BannerTableMap::COL_BANNER_GROUP_ID)) {
            $criteria->add(BannerTableMap::COL_BANNER_GROUP_ID, $this->banner_group_id);
        }
        if ($this->isColumnModified(BannerTableMap::COL_BANNER_CLIENT_ID)) {
            $criteria->add(BannerTableMap::COL_BANNER_CLIENT_ID, $this->banner_client_id);
        }
        if ($this->isColumnModified(BannerTableMap::COL_TITLE)) {
            $criteria->add(BannerTableMap::COL_TITLE, $this->title);
        }
        if ($this->isColumnModified(BannerTableMap::COL_DESCRIPTION)) {
            $criteria->add(BannerTableMap::COL_DESCRIPTION, $this->description);
        }
        if ($this->isColumnModified(BannerTableMap::COL_PICTURE)) {
            $criteria->add(BannerTableMap::COL_PICTURE, $this->picture);
        }
        if ($this->isColumnModified(BannerTableMap::COL_PICTURE_ALT)) {
            $criteria->add(BannerTableMap::COL_PICTURE_ALT, $this->picture_alt);
        }
        if ($this->isColumnModified(BannerTableMap::COL_PICTURE_TITLE)) {
            $criteria->add(BannerTableMap::COL_PICTURE_TITLE, $this->picture_title);
        }
        if ($this->isColumnModified(BannerTableMap::COL_HYPERLINK_URL)) {
            $criteria->add(BannerTableMap::COL_HYPERLINK_URL, $this->hyperlink_url);
        }
        if ($this->isColumnModified(BannerTableMap::COL_HYPERLINK_TITLE)) {
            $criteria->add(BannerTableMap::COL_HYPERLINK_TITLE, $this->hyperlink_title);
        }
        if ($this->isColumnModified(BannerTableMap::COL_HYPERLINK_TARGET)) {
            $criteria->add(BannerTableMap::COL_HYPERLINK_TARGET, $this->hyperlink_target);
        }
        if ($this->isColumnModified(BannerTableMap::COL_SHOW_START)) {
            $criteria->add(BannerTableMap::COL_SHOW_START, $this->show_start);
        }
        if ($this->isColumnModified(BannerTableMap::COL_SHOW_END)) {
            $criteria->add(BannerTableMap::COL_SHOW_END, $this->show_end);
        }
        if ($this->isColumnModified(BannerTableMap::COL_SHOWS)) {
            $criteria->add(BannerTableMap::COL_SHOWS, $this->shows);
        }
        if ($this->isColumnModified(BannerTableMap::COL_SHOWS_LIMIT)) {
            $criteria->add(BannerTableMap::COL_SHOWS_LIMIT, $this->shows_limit);
        }
        if ($this->isColumnModified(BannerTableMap::COL_CLICKS)) {
            $criteria->add(BannerTableMap::COL_CLICKS, $this->clicks);
        }
        if ($this->isColumnModified(BannerTableMap::COL_CLICKS_LIMIT)) {
            $criteria->add(BannerTableMap::COL_CLICKS_LIMIT, $this->clicks_limit);
        }
        if ($this->isColumnModified(BannerTableMap::COL_CREATED_AT)) {
            $criteria->add(BannerTableMap::COL_CREATED_AT, $this->created_at);
        }
        if ($this->isColumnModified(BannerTableMap::COL_CREATED_BY)) {
            $criteria->add(BannerTableMap::COL_CREATED_BY, $this->created_by);
        }
        if ($this->isColumnModified(BannerTableMap::COL_UPDATED_AT)) {
            $criteria->add(BannerTableMap::COL_UPDATED_AT, $this->updated_at);
        }
        if ($this->isColumnModified(BannerTableMap::COL_UPDATED_BY)) {
            $criteria->add(BannerTableMap::COL_UPDATED_BY, $this->updated_by);
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
        $criteria = ChildBannerQuery::create();
        $criteria->add(BannerTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \Propel\Models\Banner (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setBannerGroupId($this->getBannerGroupId());
        $copyObj->setBannerClientId($this->getBannerClientId());
        $copyObj->setTitle($this->getTitle());
        $copyObj->setDescription($this->getDescription());
        $copyObj->setPicture($this->getPicture());
        $copyObj->setPictureAlt($this->getPictureAlt());
        $copyObj->setPictureTitle($this->getPictureTitle());
        $copyObj->setHyperlinkUrl($this->getHyperlinkUrl());
        $copyObj->setHyperlinkTitle($this->getHyperlinkTitle());
        $copyObj->setHyperlinkTarget($this->getHyperlinkTarget());
        $copyObj->setShowStart($this->getShowStart());
        $copyObj->setShowEnd($this->getShowEnd());
        $copyObj->setShows($this->getShows());
        $copyObj->setShowsLimit($this->getShowsLimit());
        $copyObj->setClicks($this->getClicks());
        $copyObj->setClicksLimit($this->getClicksLimit());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setCreatedBy($this->getCreatedBy());
        $copyObj->setUpdatedAt($this->getUpdatedAt());
        $copyObj->setUpdatedBy($this->getUpdatedBy());
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
     * @return \Propel\Models\Banner Clone of current object.
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
     * Declares an association between this object and a ChildBannerGroup object.
     *
     * @param  ChildBannerGroup $v
     * @return $this|\Propel\Models\Banner The current object (for fluent API support)
     * @throws PropelException
     */
    public function setBannerGroup(ChildBannerGroup $v = null)
    {
        if ($v === null) {
            $this->setBannerGroupId(NULL);
        } else {
            $this->setBannerGroupId($v->getId());
        }

        $this->aBannerGroup = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildBannerGroup object, it will not be re-added.
        if ($v !== null) {
            $v->addBanner($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildBannerGroup object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildBannerGroup The associated ChildBannerGroup object.
     * @throws PropelException
     */
    public function getBannerGroup(ConnectionInterface $con = null)
    {
        if ($this->aBannerGroup === null && ($this->banner_group_id != 0)) {
            $this->aBannerGroup = ChildBannerGroupQuery::create()->findPk($this->banner_group_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aBannerGroup->addBanners($this);
             */
        }

        return $this->aBannerGroup;
    }

    /**
     * Declares an association between this object and a ChildBannerClient object.
     *
     * @param  ChildBannerClient $v
     * @return $this|\Propel\Models\Banner The current object (for fluent API support)
     * @throws PropelException
     */
    public function setBannerClient(ChildBannerClient $v = null)
    {
        if ($v === null) {
            $this->setBannerClientId(NULL);
        } else {
            $this->setBannerClientId($v->getId());
        }

        $this->aBannerClient = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildBannerClient object, it will not be re-added.
        if ($v !== null) {
            $v->addBanner($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildBannerClient object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildBannerClient The associated ChildBannerClient object.
     * @throws PropelException
     */
    public function getBannerClient(ConnectionInterface $con = null)
    {
        if ($this->aBannerClient === null && ($this->banner_client_id != 0)) {
            $this->aBannerClient = ChildBannerClientQuery::create()->findPk($this->banner_client_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aBannerClient->addBanners($this);
             */
        }

        return $this->aBannerClient;
    }

    /**
     * Declares an association between this object and a ChildUser object.
     *
     * @param  ChildUser $v
     * @return $this|\Propel\Models\Banner The current object (for fluent API support)
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
            $v->addBannerRelatedByCreatedBy($this);
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
                $this->aUserRelatedByCreatedBy->addBannersRelatedByCreatedBy($this);
             */
        }

        return $this->aUserRelatedByCreatedBy;
    }

    /**
     * Declares an association between this object and a ChildUser object.
     *
     * @param  ChildUser $v
     * @return $this|\Propel\Models\Banner The current object (for fluent API support)
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
            $v->addBannerRelatedByUpdatedBy($this);
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
                $this->aUserRelatedByUpdatedBy->addBannersRelatedByUpdatedBy($this);
             */
        }

        return $this->aUserRelatedByUpdatedBy;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aBannerGroup) {
            $this->aBannerGroup->removeBanner($this);
        }
        if (null !== $this->aBannerClient) {
            $this->aBannerClient->removeBanner($this);
        }
        if (null !== $this->aUserRelatedByCreatedBy) {
            $this->aUserRelatedByCreatedBy->removeBannerRelatedByCreatedBy($this);
        }
        if (null !== $this->aUserRelatedByUpdatedBy) {
            $this->aUserRelatedByUpdatedBy->removeBannerRelatedByUpdatedBy($this);
        }
        $this->id = null;
        $this->banner_group_id = null;
        $this->banner_client_id = null;
        $this->title = null;
        $this->description = null;
        $this->picture = null;
        $this->picture_alt = null;
        $this->picture_title = null;
        $this->hyperlink_url = null;
        $this->hyperlink_title = null;
        $this->hyperlink_target = null;
        $this->show_start = null;
        $this->show_end = null;
        $this->shows = null;
        $this->shows_limit = null;
        $this->clicks = null;
        $this->clicks_limit = null;
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
        } // if ($deep)

        $this->aBannerGroup = null;
        $this->aBannerClient = null;
        $this->aUserRelatedByCreatedBy = null;
        $this->aUserRelatedByUpdatedBy = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string The value of the 'title' column
     */
    public function __toString()
    {
        return (string) $this->getTitle();
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
        fenric('event::model.banner.validate')->run([func_get_arg(0), \Propel\Runtime\Propel::getServiceContainer()->getWriteConnection(BannerTableMap::DATABASE_NAME)]);

        $metadata->addPropertyConstraint('banner_group_id', new NotBlank());
        $metadata->addPropertyConstraint('banner_client_id', new NotBlank());
        $metadata->addPropertyConstraint('title', new NotBlank());
        $metadata->addPropertyConstraint('title', new Length(array ('max' => 255,)));
        $metadata->addPropertyConstraint('picture', new NotBlank());
        $metadata->addPropertyConstraint('picture', new Length(array ('max' => 255,)));
        $metadata->addPropertyConstraint('hyperlink_url', new NotBlank());
        $metadata->addPropertyConstraint('hyperlink_url', new Length(array ('max' => 255,)));
        $metadata->addPropertyConstraint('hyperlink_url', new Url());
        $metadata->addPropertyConstraint('shows_limit', new Range(array ('min' => 1,)));
        $metadata->addPropertyConstraint('clicks_limit', new Range(array ('min' => 1,)));
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
            if (method_exists($this->aBannerGroup, 'validate')) {
                if (!$this->aBannerGroup->validate($validator)) {
                    $failureMap->addAll($this->aBannerGroup->getValidationFailures());
                }
            }
            // If validate() method exists, the validate-behavior is configured for related object
            if (method_exists($this->aBannerClient, 'validate')) {
                if (!$this->aBannerClient->validate($validator)) {
                    $failureMap->addAll($this->aBannerClient->getValidationFailures());
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

            $retval = $validator->validate($this);
            if (count($retval) > 0) {
                $failureMap->addAll($retval);
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
