<?php

namespace Propel\Models\Base;

use \DateTime;
use \Exception;
use \PDO;
use Propel\Models\Publication as ChildPublication;
use Propel\Models\PublicationQuery as ChildPublicationQuery;
use Propel\Models\Section as ChildSection;
use Propel\Models\SectionField as ChildSectionField;
use Propel\Models\SectionFieldQuery as ChildSectionFieldQuery;
use Propel\Models\SectionQuery as ChildSectionQuery;
use Propel\Models\User as ChildUser;
use Propel\Models\UserQuery as ChildUserQuery;
use Propel\Models\Map\PublicationTableMap;
use Propel\Models\Map\SectionFieldTableMap;
use Propel\Models\Map\SectionTableMap;
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
 * Base class that represents a row from the 'fenric_section' table.
 *
 *
 *
 * @package    propel.generator.Propel.Models.Base
 */
abstract class Section implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Propel\\Models\\Map\\SectionTableMap';


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
     * The value for the code field.
     *
     * @var        string
     */
    protected $code;

    /**
     * The value for the header field.
     *
     * @var        string
     */
    protected $header;

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
     * Whether the lazy-loaded $content value has been loaded from database.
     * This is necessary to avoid repeated lookups if $content column is NULL in the db.
     * @var boolean
     */
    protected $content_isLoaded = false;

    /**
     * The value for the meta_title field.
     *
     * @var        string
     */
    protected $meta_title;

    /**
     * The value for the meta_author field.
     *
     * @var        string
     */
    protected $meta_author;

    /**
     * The value for the meta_keywords field.
     *
     * @var        string
     */
    protected $meta_keywords;

    /**
     * The value for the meta_description field.
     *
     * @var        string
     */
    protected $meta_description;

    /**
     * The value for the meta_canonical field.
     *
     * @var        string
     */
    protected $meta_canonical;

    /**
     * The value for the meta_robots field.
     *
     * @var        string
     */
    protected $meta_robots;

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
     * @var        ChildSection
     */
    protected $aParent;

    /**
     * @var        ChildUser
     */
    protected $aUserRelatedByCreatedBy;

    /**
     * @var        ChildUser
     */
    protected $aUserRelatedByUpdatedBy;

    /**
     * @var        ObjectCollection|ChildSection[] Collection to store aggregation of ChildSection objects.
     */
    protected $collSectionsRelatedById;
    protected $collSectionsRelatedByIdPartial;

    /**
     * @var        ObjectCollection|ChildSectionField[] Collection to store aggregation of ChildSectionField objects.
     */
    protected $collSectionFields;
    protected $collSectionFieldsPartial;

    /**
     * @var        ObjectCollection|ChildPublication[] Collection to store aggregation of ChildPublication objects.
     */
    protected $collPublications;
    protected $collPublicationsPartial;

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
     * @var ObjectCollection|ChildSection[]
     */
    protected $sectionsRelatedByIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSectionField[]
     */
    protected $sectionFieldsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPublication[]
     */
    protected $publicationsScheduledForDeletion = null;

    /**
     * Initializes internal state of Propel\Models\Base\Section object.
     */
    public function __construct()
    {
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
     * Compares this with another <code>Section</code> instance.  If
     * <code>obj</code> is an instance of <code>Section</code>, delegates to
     * <code>equals(Section)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Section The current object, for fluid interface
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
     * Get the [code] column value.
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Get the [header] column value.
     *
     * @return string
     */
    public function getHeader()
    {
        return $this->header;
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
     * @param      ConnectionInterface $con An optional ConnectionInterface connection to use for fetching this lazy-loaded column.
     * @return string
     */
    public function getContent(ConnectionInterface $con = null)
    {
        if (!$this->content_isLoaded && $this->content === null && !$this->isNew()) {
            $this->loadContent($con);
        }

        return $this->content;
    }

    /**
     * Load the value for the lazy-loaded [content] column.
     *
     * This method performs an additional query to return the value for
     * the [content] column, since it is not populated by
     * the hydrate() method.
     *
     * @param      $con ConnectionInterface (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - any underlying error will be wrapped and re-thrown.
     */
    protected function loadContent(ConnectionInterface $con = null)
    {
        $c = $this->buildPkeyCriteria();
        $c->addSelectColumn(SectionTableMap::COL_CONTENT);
        try {
            $dataFetcher = ChildSectionQuery::create(null, $c)->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
            $row = $dataFetcher->fetch();
            $dataFetcher->close();

        $firstColumn = $row ? current($row) : null;

            $this->content = ($firstColumn !== null) ? (string) $firstColumn : null;
            $this->content_isLoaded = true;
        } catch (Exception $e) {
            throw new PropelException("Error loading value for [content] column on demand.", 0, $e);
        }
    }
    /**
     * Get the [meta_title] column value.
     *
     * @return string
     */
    public function getMetaTitle()
    {
        return $this->meta_title;
    }

    /**
     * Get the [meta_author] column value.
     *
     * @return string
     */
    public function getMetaAuthor()
    {
        return $this->meta_author;
    }

    /**
     * Get the [meta_keywords] column value.
     *
     * @return string
     */
    public function getMetaKeywords()
    {
        return $this->meta_keywords;
    }

    /**
     * Get the [meta_description] column value.
     *
     * @return string
     */
    public function getMetaDescription()
    {
        return $this->meta_description;
    }

    /**
     * Get the [meta_canonical] column value.
     *
     * @return string
     */
    public function getMetaCanonical()
    {
        return $this->meta_canonical;
    }

    /**
     * Get the [meta_robots] column value.
     *
     * @return string
     */
    public function getMetaRobots()
    {
        return $this->meta_robots;
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
     * @return $this|\Propel\Models\Section The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[SectionTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [parent_id] column.
     *
     * @param int $v new value
     * @return $this|\Propel\Models\Section The current object (for fluent API support)
     */
    public function setParentId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->parent_id !== $v) {
            $this->parent_id = $v;
            $this->modifiedColumns[SectionTableMap::COL_PARENT_ID] = true;
        }

        if ($this->aParent !== null && $this->aParent->getId() !== $v) {
            $this->aParent = null;
        }

        return $this;
    } // setParentId()

    /**
     * Set the value of [code] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\Section The current object (for fluent API support)
     */
    public function setCode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->code !== $v) {
            $this->code = $v;
            $this->modifiedColumns[SectionTableMap::COL_CODE] = true;
        }

        return $this;
    } // setCode()

    /**
     * Set the value of [header] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\Section The current object (for fluent API support)
     */
    public function setHeader($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->header !== $v) {
            $this->header = $v;
            $this->modifiedColumns[SectionTableMap::COL_HEADER] = true;
        }

        return $this;
    } // setHeader()

    /**
     * Set the value of [picture] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\Section The current object (for fluent API support)
     */
    public function setPicture($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->picture !== $v) {
            $this->picture = $v;
            $this->modifiedColumns[SectionTableMap::COL_PICTURE] = true;
        }

        return $this;
    } // setPicture()

    /**
     * Set the value of [content] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\Section The current object (for fluent API support)
     */
    public function setContent($v)
    {
        // explicitly set the is-loaded flag to true for this lazy load col;
        // it doesn't matter if the value is actually set or not (logic below) as
        // any attempt to set the value means that no db lookup should be performed
        // when the getContent() method is called.
        $this->content_isLoaded = true;

        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->content !== $v) {
            $this->content = $v;
            $this->modifiedColumns[SectionTableMap::COL_CONTENT] = true;
        }

        return $this;
    } // setContent()

    /**
     * Set the value of [meta_title] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\Section The current object (for fluent API support)
     */
    public function setMetaTitle($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->meta_title !== $v) {
            $this->meta_title = $v;
            $this->modifiedColumns[SectionTableMap::COL_META_TITLE] = true;
        }

        return $this;
    } // setMetaTitle()

    /**
     * Set the value of [meta_author] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\Section The current object (for fluent API support)
     */
    public function setMetaAuthor($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->meta_author !== $v) {
            $this->meta_author = $v;
            $this->modifiedColumns[SectionTableMap::COL_META_AUTHOR] = true;
        }

        return $this;
    } // setMetaAuthor()

    /**
     * Set the value of [meta_keywords] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\Section The current object (for fluent API support)
     */
    public function setMetaKeywords($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->meta_keywords !== $v) {
            $this->meta_keywords = $v;
            $this->modifiedColumns[SectionTableMap::COL_META_KEYWORDS] = true;
        }

        return $this;
    } // setMetaKeywords()

    /**
     * Set the value of [meta_description] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\Section The current object (for fluent API support)
     */
    public function setMetaDescription($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->meta_description !== $v) {
            $this->meta_description = $v;
            $this->modifiedColumns[SectionTableMap::COL_META_DESCRIPTION] = true;
        }

        return $this;
    } // setMetaDescription()

    /**
     * Set the value of [meta_canonical] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\Section The current object (for fluent API support)
     */
    public function setMetaCanonical($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->meta_canonical !== $v) {
            $this->meta_canonical = $v;
            $this->modifiedColumns[SectionTableMap::COL_META_CANONICAL] = true;
        }

        return $this;
    } // setMetaCanonical()

    /**
     * Set the value of [meta_robots] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\Section The current object (for fluent API support)
     */
    public function setMetaRobots($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->meta_robots !== $v) {
            $this->meta_robots = $v;
            $this->modifiedColumns[SectionTableMap::COL_META_ROBOTS] = true;
        }

        return $this;
    } // setMetaRobots()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Propel\Models\Section The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($this->created_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->created_at->format("Y-m-d H:i:s.u")) {
                $this->created_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[SectionTableMap::COL_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setCreatedAt()

    /**
     * Set the value of [created_by] column.
     *
     * @param int $v new value
     * @return $this|\Propel\Models\Section The current object (for fluent API support)
     */
    public function setCreatedBy($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->created_by !== $v) {
            $this->created_by = $v;
            $this->modifiedColumns[SectionTableMap::COL_CREATED_BY] = true;
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
     * @return $this|\Propel\Models\Section The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($this->updated_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->updated_at->format("Y-m-d H:i:s.u")) {
                $this->updated_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[SectionTableMap::COL_UPDATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setUpdatedAt()

    /**
     * Set the value of [updated_by] column.
     *
     * @param int $v new value
     * @return $this|\Propel\Models\Section The current object (for fluent API support)
     */
    public function setUpdatedBy($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->updated_by !== $v) {
            $this->updated_by = $v;
            $this->modifiedColumns[SectionTableMap::COL_UPDATED_BY] = true;
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : SectionTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : SectionTableMap::translateFieldName('ParentId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->parent_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : SectionTableMap::translateFieldName('Code', TableMap::TYPE_PHPNAME, $indexType)];
            $this->code = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : SectionTableMap::translateFieldName('Header', TableMap::TYPE_PHPNAME, $indexType)];
            $this->header = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : SectionTableMap::translateFieldName('Picture', TableMap::TYPE_PHPNAME, $indexType)];
            $this->picture = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : SectionTableMap::translateFieldName('MetaTitle', TableMap::TYPE_PHPNAME, $indexType)];
            $this->meta_title = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : SectionTableMap::translateFieldName('MetaAuthor', TableMap::TYPE_PHPNAME, $indexType)];
            $this->meta_author = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : SectionTableMap::translateFieldName('MetaKeywords', TableMap::TYPE_PHPNAME, $indexType)];
            $this->meta_keywords = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : SectionTableMap::translateFieldName('MetaDescription', TableMap::TYPE_PHPNAME, $indexType)];
            $this->meta_description = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : SectionTableMap::translateFieldName('MetaCanonical', TableMap::TYPE_PHPNAME, $indexType)];
            $this->meta_canonical = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : SectionTableMap::translateFieldName('MetaRobots', TableMap::TYPE_PHPNAME, $indexType)];
            $this->meta_robots = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : SectionTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : SectionTableMap::translateFieldName('CreatedBy', TableMap::TYPE_PHPNAME, $indexType)];
            $this->created_by = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : SectionTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 14 + $startcol : SectionTableMap::translateFieldName('UpdatedBy', TableMap::TYPE_PHPNAME, $indexType)];
            $this->updated_by = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 15; // 15 = SectionTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Propel\\Models\\Section'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(SectionTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildSectionQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        // Reset the content lazy-load column
        $this->content = null;
        $this->content_isLoaded = false;

        if ($deep) {  // also de-associate any related objects?

            $this->aParent = null;
            $this->aUserRelatedByCreatedBy = null;
            $this->aUserRelatedByUpdatedBy = null;
            $this->collSectionsRelatedById = null;

            $this->collSectionFields = null;

            $this->collPublications = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Section::setDeleted()
     * @see Section::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(SectionTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildSectionQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
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
            $con = Propel::getServiceContainer()->getWriteConnection(SectionTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // Fenric\Propel\Behaviors\Authorable behavior
                    if (! $this->isColumnModified(SectionTableMap::COL_CREATED_BY)) {
                        if (fenric()->existsSharedService('user')) {
                            if (fenric('user')->isLogged()) {
                                $this->setCreatedBy(fenric('user')->getId());
                            }
                        }
                    }	if (! $this->isColumnModified(SectionTableMap::COL_UPDATED_BY)) {
                        if (fenric()->existsSharedService('user')) {
                            if (fenric('user')->isLogged()) {
                                $this->setUpdatedBy(fenric('user')->getId());
                            }
                        }
                    }
                // Fenric\Propel\Behaviors\Timestampable behavior
                    if (! $this->isColumnModified(SectionTableMap::COL_CREATED_AT)) {
                        $this->setCreatedAt(new \DateTime('now'));
                    }	if (! $this->isColumnModified(SectionTableMap::COL_UPDATED_AT)) {
                        $this->setUpdatedAt(new \DateTime('now'));
                    }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // Fenric\Propel\Behaviors\Authorable behavior
                    if (! $this->isColumnModified(SectionTableMap::COL_UPDATED_BY)) {
                        if (fenric()->existsSharedService('user')) {
                            if (fenric('user')->isLogged()) {
                                $this->setUpdatedBy(fenric('user')->getId());
                            }
                        }
                    }
                // Fenric\Propel\Behaviors\Timestampable behavior
                    if (! $this->isColumnModified(SectionTableMap::COL_UPDATED_AT)) {
                        $this->setUpdatedAt(new \DateTime('now'));
                    }
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                SectionTableMap::addInstanceToPool($this);
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

            if ($this->sectionsRelatedByIdScheduledForDeletion !== null) {
                if (!$this->sectionsRelatedByIdScheduledForDeletion->isEmpty()) {
                    \Propel\Models\SectionQuery::create()
                        ->filterByPrimaryKeys($this->sectionsRelatedByIdScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->sectionsRelatedByIdScheduledForDeletion = null;
                }
            }

            if ($this->collSectionsRelatedById !== null) {
                foreach ($this->collSectionsRelatedById as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
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

            if ($this->publicationsScheduledForDeletion !== null) {
                if (!$this->publicationsScheduledForDeletion->isEmpty()) {
                    \Propel\Models\PublicationQuery::create()
                        ->filterByPrimaryKeys($this->publicationsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->publicationsScheduledForDeletion = null;
                }
            }

            if ($this->collPublications !== null) {
                foreach ($this->collPublications as $referrerFK) {
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

        $this->modifiedColumns[SectionTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . SectionTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(SectionTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(SectionTableMap::COL_PARENT_ID)) {
            $modifiedColumns[':p' . $index++]  = 'parent_id';
        }
        if ($this->isColumnModified(SectionTableMap::COL_CODE)) {
            $modifiedColumns[':p' . $index++]  = 'code';
        }
        if ($this->isColumnModified(SectionTableMap::COL_HEADER)) {
            $modifiedColumns[':p' . $index++]  = 'header';
        }
        if ($this->isColumnModified(SectionTableMap::COL_PICTURE)) {
            $modifiedColumns[':p' . $index++]  = 'picture';
        }
        if ($this->isColumnModified(SectionTableMap::COL_CONTENT)) {
            $modifiedColumns[':p' . $index++]  = 'content';
        }
        if ($this->isColumnModified(SectionTableMap::COL_META_TITLE)) {
            $modifiedColumns[':p' . $index++]  = 'meta_title';
        }
        if ($this->isColumnModified(SectionTableMap::COL_META_AUTHOR)) {
            $modifiedColumns[':p' . $index++]  = 'meta_author';
        }
        if ($this->isColumnModified(SectionTableMap::COL_META_KEYWORDS)) {
            $modifiedColumns[':p' . $index++]  = 'meta_keywords';
        }
        if ($this->isColumnModified(SectionTableMap::COL_META_DESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = 'meta_description';
        }
        if ($this->isColumnModified(SectionTableMap::COL_META_CANONICAL)) {
            $modifiedColumns[':p' . $index++]  = 'meta_canonical';
        }
        if ($this->isColumnModified(SectionTableMap::COL_META_ROBOTS)) {
            $modifiedColumns[':p' . $index++]  = 'meta_robots';
        }
        if ($this->isColumnModified(SectionTableMap::COL_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'created_at';
        }
        if ($this->isColumnModified(SectionTableMap::COL_CREATED_BY)) {
            $modifiedColumns[':p' . $index++]  = 'created_by';
        }
        if ($this->isColumnModified(SectionTableMap::COL_UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'updated_at';
        }
        if ($this->isColumnModified(SectionTableMap::COL_UPDATED_BY)) {
            $modifiedColumns[':p' . $index++]  = 'updated_by';
        }

        $sql = sprintf(
            'INSERT INTO fenric_section (%s) VALUES (%s)',
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
                    case 'code':
                        $stmt->bindValue($identifier, $this->code, PDO::PARAM_STR);
                        break;
                    case 'header':
                        $stmt->bindValue($identifier, $this->header, PDO::PARAM_STR);
                        break;
                    case 'picture':
                        $stmt->bindValue($identifier, $this->picture, PDO::PARAM_STR);
                        break;
                    case 'content':
                        $stmt->bindValue($identifier, $this->content, PDO::PARAM_STR);
                        break;
                    case 'meta_title':
                        $stmt->bindValue($identifier, $this->meta_title, PDO::PARAM_STR);
                        break;
                    case 'meta_author':
                        $stmt->bindValue($identifier, $this->meta_author, PDO::PARAM_STR);
                        break;
                    case 'meta_keywords':
                        $stmt->bindValue($identifier, $this->meta_keywords, PDO::PARAM_STR);
                        break;
                    case 'meta_description':
                        $stmt->bindValue($identifier, $this->meta_description, PDO::PARAM_STR);
                        break;
                    case 'meta_canonical':
                        $stmt->bindValue($identifier, $this->meta_canonical, PDO::PARAM_STR);
                        break;
                    case 'meta_robots':
                        $stmt->bindValue($identifier, $this->meta_robots, PDO::PARAM_STR);
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
        $pos = SectionTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getCode();
                break;
            case 3:
                return $this->getHeader();
                break;
            case 4:
                return $this->getPicture();
                break;
            case 5:
                return $this->getContent();
                break;
            case 6:
                return $this->getMetaTitle();
                break;
            case 7:
                return $this->getMetaAuthor();
                break;
            case 8:
                return $this->getMetaKeywords();
                break;
            case 9:
                return $this->getMetaDescription();
                break;
            case 10:
                return $this->getMetaCanonical();
                break;
            case 11:
                return $this->getMetaRobots();
                break;
            case 12:
                return $this->getCreatedAt();
                break;
            case 13:
                return $this->getCreatedBy();
                break;
            case 14:
                return $this->getUpdatedAt();
                break;
            case 15:
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

        if (isset($alreadyDumpedObjects['Section'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Section'][$this->hashCode()] = true;
        $keys = SectionTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getParentId(),
            $keys[2] => $this->getCode(),
            $keys[3] => $this->getHeader(),
            $keys[4] => $this->getPicture(),
            $keys[5] => ($includeLazyLoadColumns) ? $this->getContent() : null,
            $keys[6] => $this->getMetaTitle(),
            $keys[7] => $this->getMetaAuthor(),
            $keys[8] => $this->getMetaKeywords(),
            $keys[9] => $this->getMetaDescription(),
            $keys[10] => $this->getMetaCanonical(),
            $keys[11] => $this->getMetaRobots(),
            $keys[12] => $this->getCreatedAt(),
            $keys[13] => $this->getCreatedBy(),
            $keys[14] => $this->getUpdatedAt(),
            $keys[15] => $this->getUpdatedBy(),
        );
        if ($result[$keys[12]] instanceof \DateTimeInterface) {
            $result[$keys[12]] = $result[$keys[12]]->format('c');
        }

        if ($result[$keys[14]] instanceof \DateTimeInterface) {
            $result[$keys[14]] = $result[$keys[14]]->format('c');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aParent) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'section';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'fenric_section';
                        break;
                    default:
                        $key = 'Parent';
                }

                $result[$key] = $this->aParent->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
            if (null !== $this->collSectionsRelatedById) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'sections';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'fenric_sections';
                        break;
                    default:
                        $key = 'Sections';
                }

                $result[$key] = $this->collSectionsRelatedById->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
            if (null !== $this->collPublications) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'publications';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'fenric_publications';
                        break;
                    default:
                        $key = 'Publications';
                }

                $result[$key] = $this->collPublications->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Propel\Models\Section
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = SectionTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Propel\Models\Section
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
                $this->setCode($value);
                break;
            case 3:
                $this->setHeader($value);
                break;
            case 4:
                $this->setPicture($value);
                break;
            case 5:
                $this->setContent($value);
                break;
            case 6:
                $this->setMetaTitle($value);
                break;
            case 7:
                $this->setMetaAuthor($value);
                break;
            case 8:
                $this->setMetaKeywords($value);
                break;
            case 9:
                $this->setMetaDescription($value);
                break;
            case 10:
                $this->setMetaCanonical($value);
                break;
            case 11:
                $this->setMetaRobots($value);
                break;
            case 12:
                $this->setCreatedAt($value);
                break;
            case 13:
                $this->setCreatedBy($value);
                break;
            case 14:
                $this->setUpdatedAt($value);
                break;
            case 15:
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
        $keys = SectionTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setParentId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setCode($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setHeader($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setPicture($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setContent($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setMetaTitle($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setMetaAuthor($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setMetaKeywords($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setMetaDescription($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setMetaCanonical($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setMetaRobots($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->setCreatedAt($arr[$keys[12]]);
        }
        if (array_key_exists($keys[13], $arr)) {
            $this->setCreatedBy($arr[$keys[13]]);
        }
        if (array_key_exists($keys[14], $arr)) {
            $this->setUpdatedAt($arr[$keys[14]]);
        }
        if (array_key_exists($keys[15], $arr)) {
            $this->setUpdatedBy($arr[$keys[15]]);
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
     * @return $this|\Propel\Models\Section The current object, for fluid interface
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
        $criteria = new Criteria(SectionTableMap::DATABASE_NAME);

        if ($this->isColumnModified(SectionTableMap::COL_ID)) {
            $criteria->add(SectionTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(SectionTableMap::COL_PARENT_ID)) {
            $criteria->add(SectionTableMap::COL_PARENT_ID, $this->parent_id);
        }
        if ($this->isColumnModified(SectionTableMap::COL_CODE)) {
            $criteria->add(SectionTableMap::COL_CODE, $this->code);
        }
        if ($this->isColumnModified(SectionTableMap::COL_HEADER)) {
            $criteria->add(SectionTableMap::COL_HEADER, $this->header);
        }
        if ($this->isColumnModified(SectionTableMap::COL_PICTURE)) {
            $criteria->add(SectionTableMap::COL_PICTURE, $this->picture);
        }
        if ($this->isColumnModified(SectionTableMap::COL_CONTENT)) {
            $criteria->add(SectionTableMap::COL_CONTENT, $this->content);
        }
        if ($this->isColumnModified(SectionTableMap::COL_META_TITLE)) {
            $criteria->add(SectionTableMap::COL_META_TITLE, $this->meta_title);
        }
        if ($this->isColumnModified(SectionTableMap::COL_META_AUTHOR)) {
            $criteria->add(SectionTableMap::COL_META_AUTHOR, $this->meta_author);
        }
        if ($this->isColumnModified(SectionTableMap::COL_META_KEYWORDS)) {
            $criteria->add(SectionTableMap::COL_META_KEYWORDS, $this->meta_keywords);
        }
        if ($this->isColumnModified(SectionTableMap::COL_META_DESCRIPTION)) {
            $criteria->add(SectionTableMap::COL_META_DESCRIPTION, $this->meta_description);
        }
        if ($this->isColumnModified(SectionTableMap::COL_META_CANONICAL)) {
            $criteria->add(SectionTableMap::COL_META_CANONICAL, $this->meta_canonical);
        }
        if ($this->isColumnModified(SectionTableMap::COL_META_ROBOTS)) {
            $criteria->add(SectionTableMap::COL_META_ROBOTS, $this->meta_robots);
        }
        if ($this->isColumnModified(SectionTableMap::COL_CREATED_AT)) {
            $criteria->add(SectionTableMap::COL_CREATED_AT, $this->created_at);
        }
        if ($this->isColumnModified(SectionTableMap::COL_CREATED_BY)) {
            $criteria->add(SectionTableMap::COL_CREATED_BY, $this->created_by);
        }
        if ($this->isColumnModified(SectionTableMap::COL_UPDATED_AT)) {
            $criteria->add(SectionTableMap::COL_UPDATED_AT, $this->updated_at);
        }
        if ($this->isColumnModified(SectionTableMap::COL_UPDATED_BY)) {
            $criteria->add(SectionTableMap::COL_UPDATED_BY, $this->updated_by);
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
        $criteria = ChildSectionQuery::create();
        $criteria->add(SectionTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \Propel\Models\Section (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setParentId($this->getParentId());
        $copyObj->setCode($this->getCode());
        $copyObj->setHeader($this->getHeader());
        $copyObj->setPicture($this->getPicture());
        $copyObj->setContent($this->getContent());
        $copyObj->setMetaTitle($this->getMetaTitle());
        $copyObj->setMetaAuthor($this->getMetaAuthor());
        $copyObj->setMetaKeywords($this->getMetaKeywords());
        $copyObj->setMetaDescription($this->getMetaDescription());
        $copyObj->setMetaCanonical($this->getMetaCanonical());
        $copyObj->setMetaRobots($this->getMetaRobots());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setCreatedBy($this->getCreatedBy());
        $copyObj->setUpdatedAt($this->getUpdatedAt());
        $copyObj->setUpdatedBy($this->getUpdatedBy());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getSectionsRelatedById() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSectionRelatedById($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSectionFields() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSectionField($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPublications() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPublication($relObj->copy($deepCopy));
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
     * @return \Propel\Models\Section Clone of current object.
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
     * Declares an association between this object and a ChildSection object.
     *
     * @param  ChildSection $v
     * @return $this|\Propel\Models\Section The current object (for fluent API support)
     * @throws PropelException
     */
    public function setParent(ChildSection $v = null)
    {
        if ($v === null) {
            $this->setParentId(NULL);
        } else {
            $this->setParentId($v->getId());
        }

        $this->aParent = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildSection object, it will not be re-added.
        if ($v !== null) {
            $v->addSectionRelatedById($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildSection object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildSection The associated ChildSection object.
     * @throws PropelException
     */
    public function getParent(ConnectionInterface $con = null)
    {
        if ($this->aParent === null && ($this->parent_id != 0)) {
            $this->aParent = ChildSectionQuery::create()->findPk($this->parent_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aParent->addSectionsRelatedById($this);
             */
        }

        return $this->aParent;
    }

    /**
     * Declares an association between this object and a ChildUser object.
     *
     * @param  ChildUser $v
     * @return $this|\Propel\Models\Section The current object (for fluent API support)
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
            $v->addSectionRelatedByCreatedBy($this);
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
                $this->aUserRelatedByCreatedBy->addSectionsRelatedByCreatedBy($this);
             */
        }

        return $this->aUserRelatedByCreatedBy;
    }

    /**
     * Declares an association between this object and a ChildUser object.
     *
     * @param  ChildUser $v
     * @return $this|\Propel\Models\Section The current object (for fluent API support)
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
            $v->addSectionRelatedByUpdatedBy($this);
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
                $this->aUserRelatedByUpdatedBy->addSectionsRelatedByUpdatedBy($this);
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
        if ('SectionRelatedById' == $relationName) {
            $this->initSectionsRelatedById();
            return;
        }
        if ('SectionField' == $relationName) {
            $this->initSectionFields();
            return;
        }
        if ('Publication' == $relationName) {
            $this->initPublications();
            return;
        }
    }

    /**
     * Clears out the collSectionsRelatedById collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSectionsRelatedById()
     */
    public function clearSectionsRelatedById()
    {
        $this->collSectionsRelatedById = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collSectionsRelatedById collection loaded partially.
     */
    public function resetPartialSectionsRelatedById($v = true)
    {
        $this->collSectionsRelatedByIdPartial = $v;
    }

    /**
     * Initializes the collSectionsRelatedById collection.
     *
     * By default this just sets the collSectionsRelatedById collection to an empty array (like clearcollSectionsRelatedById());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSectionsRelatedById($overrideExisting = true)
    {
        if (null !== $this->collSectionsRelatedById && !$overrideExisting) {
            return;
        }

        $collectionClassName = SectionTableMap::getTableMap()->getCollectionClassName();

        $this->collSectionsRelatedById = new $collectionClassName;
        $this->collSectionsRelatedById->setModel('\Propel\Models\Section');
    }

    /**
     * Gets an array of ChildSection objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSection is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSection[] List of ChildSection objects
     * @throws PropelException
     */
    public function getSectionsRelatedById(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSectionsRelatedByIdPartial && !$this->isNew();
        if (null === $this->collSectionsRelatedById || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSectionsRelatedById) {
                // return empty collection
                $this->initSectionsRelatedById();
            } else {
                $collSectionsRelatedById = ChildSectionQuery::create(null, $criteria)
                    ->filterByParent($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSectionsRelatedByIdPartial && count($collSectionsRelatedById)) {
                        $this->initSectionsRelatedById(false);

                        foreach ($collSectionsRelatedById as $obj) {
                            if (false == $this->collSectionsRelatedById->contains($obj)) {
                                $this->collSectionsRelatedById->append($obj);
                            }
                        }

                        $this->collSectionsRelatedByIdPartial = true;
                    }

                    return $collSectionsRelatedById;
                }

                if ($partial && $this->collSectionsRelatedById) {
                    foreach ($this->collSectionsRelatedById as $obj) {
                        if ($obj->isNew()) {
                            $collSectionsRelatedById[] = $obj;
                        }
                    }
                }

                $this->collSectionsRelatedById = $collSectionsRelatedById;
                $this->collSectionsRelatedByIdPartial = false;
            }
        }

        return $this->collSectionsRelatedById;
    }

    /**
     * Sets a collection of ChildSection objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $sectionsRelatedById A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSection The current object (for fluent API support)
     */
    public function setSectionsRelatedById(Collection $sectionsRelatedById, ConnectionInterface $con = null)
    {
        /** @var ChildSection[] $sectionsRelatedByIdToDelete */
        $sectionsRelatedByIdToDelete = $this->getSectionsRelatedById(new Criteria(), $con)->diff($sectionsRelatedById);


        $this->sectionsRelatedByIdScheduledForDeletion = $sectionsRelatedByIdToDelete;

        foreach ($sectionsRelatedByIdToDelete as $sectionRelatedByIdRemoved) {
            $sectionRelatedByIdRemoved->setParent(null);
        }

        $this->collSectionsRelatedById = null;
        foreach ($sectionsRelatedById as $sectionRelatedById) {
            $this->addSectionRelatedById($sectionRelatedById);
        }

        $this->collSectionsRelatedById = $sectionsRelatedById;
        $this->collSectionsRelatedByIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Section objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Section objects.
     * @throws PropelException
     */
    public function countSectionsRelatedById(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSectionsRelatedByIdPartial && !$this->isNew();
        if (null === $this->collSectionsRelatedById || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSectionsRelatedById) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSectionsRelatedById());
            }

            $query = ChildSectionQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByParent($this)
                ->count($con);
        }

        return count($this->collSectionsRelatedById);
    }

    /**
     * Method called to associate a ChildSection object to this object
     * through the ChildSection foreign key attribute.
     *
     * @param  ChildSection $l ChildSection
     * @return $this|\Propel\Models\Section The current object (for fluent API support)
     */
    public function addSectionRelatedById(ChildSection $l)
    {
        if ($this->collSectionsRelatedById === null) {
            $this->initSectionsRelatedById();
            $this->collSectionsRelatedByIdPartial = true;
        }

        if (!$this->collSectionsRelatedById->contains($l)) {
            $this->doAddSectionRelatedById($l);

            if ($this->sectionsRelatedByIdScheduledForDeletion and $this->sectionsRelatedByIdScheduledForDeletion->contains($l)) {
                $this->sectionsRelatedByIdScheduledForDeletion->remove($this->sectionsRelatedByIdScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildSection $sectionRelatedById The ChildSection object to add.
     */
    protected function doAddSectionRelatedById(ChildSection $sectionRelatedById)
    {
        $this->collSectionsRelatedById[]= $sectionRelatedById;
        $sectionRelatedById->setParent($this);
    }

    /**
     * @param  ChildSection $sectionRelatedById The ChildSection object to remove.
     * @return $this|ChildSection The current object (for fluent API support)
     */
    public function removeSectionRelatedById(ChildSection $sectionRelatedById)
    {
        if ($this->getSectionsRelatedById()->contains($sectionRelatedById)) {
            $pos = $this->collSectionsRelatedById->search($sectionRelatedById);
            $this->collSectionsRelatedById->remove($pos);
            if (null === $this->sectionsRelatedByIdScheduledForDeletion) {
                $this->sectionsRelatedByIdScheduledForDeletion = clone $this->collSectionsRelatedById;
                $this->sectionsRelatedByIdScheduledForDeletion->clear();
            }
            $this->sectionsRelatedByIdScheduledForDeletion[]= $sectionRelatedById;
            $sectionRelatedById->setParent(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Section is new, it will return
     * an empty collection; or if this Section has previously
     * been saved, it will retrieve related SectionsRelatedById from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Section.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSection[] List of ChildSection objects
     */
    public function getSectionsRelatedByIdJoinUserRelatedByCreatedBy(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSectionQuery::create(null, $criteria);
        $query->joinWith('UserRelatedByCreatedBy', $joinBehavior);

        return $this->getSectionsRelatedById($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Section is new, it will return
     * an empty collection; or if this Section has previously
     * been saved, it will retrieve related SectionsRelatedById from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Section.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSection[] List of ChildSection objects
     */
    public function getSectionsRelatedByIdJoinUserRelatedByUpdatedBy(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSectionQuery::create(null, $criteria);
        $query->joinWith('UserRelatedByUpdatedBy', $joinBehavior);

        return $this->getSectionsRelatedById($query, $con);
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
     * If this ChildSection is new, it will return
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
                    ->filterBySection($this)
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
     * @return $this|ChildSection The current object (for fluent API support)
     */
    public function setSectionFields(Collection $sectionFields, ConnectionInterface $con = null)
    {
        /** @var ChildSectionField[] $sectionFieldsToDelete */
        $sectionFieldsToDelete = $this->getSectionFields(new Criteria(), $con)->diff($sectionFields);


        $this->sectionFieldsScheduledForDeletion = $sectionFieldsToDelete;

        foreach ($sectionFieldsToDelete as $sectionFieldRemoved) {
            $sectionFieldRemoved->setSection(null);
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
                ->filterBySection($this)
                ->count($con);
        }

        return count($this->collSectionFields);
    }

    /**
     * Method called to associate a ChildSectionField object to this object
     * through the ChildSectionField foreign key attribute.
     *
     * @param  ChildSectionField $l ChildSectionField
     * @return $this|\Propel\Models\Section The current object (for fluent API support)
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
        $sectionField->setSection($this);
    }

    /**
     * @param  ChildSectionField $sectionField The ChildSectionField object to remove.
     * @return $this|ChildSection The current object (for fluent API support)
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
            $sectionField->setSection(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Section is new, it will return
     * an empty collection; or if this Section has previously
     * been saved, it will retrieve related SectionFields from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Section.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSectionField[] List of ChildSectionField objects
     */
    public function getSectionFieldsJoinField(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSectionFieldQuery::create(null, $criteria);
        $query->joinWith('Field', $joinBehavior);

        return $this->getSectionFields($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Section is new, it will return
     * an empty collection; or if this Section has previously
     * been saved, it will retrieve related SectionFields from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Section.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSectionField[] List of ChildSectionField objects
     */
    public function getSectionFieldsJoinUser(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSectionFieldQuery::create(null, $criteria);
        $query->joinWith('User', $joinBehavior);

        return $this->getSectionFields($query, $con);
    }

    /**
     * Clears out the collPublications collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPublications()
     */
    public function clearPublications()
    {
        $this->collPublications = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPublications collection loaded partially.
     */
    public function resetPartialPublications($v = true)
    {
        $this->collPublicationsPartial = $v;
    }

    /**
     * Initializes the collPublications collection.
     *
     * By default this just sets the collPublications collection to an empty array (like clearcollPublications());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPublications($overrideExisting = true)
    {
        if (null !== $this->collPublications && !$overrideExisting) {
            return;
        }

        $collectionClassName = PublicationTableMap::getTableMap()->getCollectionClassName();

        $this->collPublications = new $collectionClassName;
        $this->collPublications->setModel('\Propel\Models\Publication');
    }

    /**
     * Gets an array of ChildPublication objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSection is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPublication[] List of ChildPublication objects
     * @throws PropelException
     */
    public function getPublications(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPublicationsPartial && !$this->isNew();
        if (null === $this->collPublications || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPublications) {
                // return empty collection
                $this->initPublications();
            } else {
                $collPublications = ChildPublicationQuery::create(null, $criteria)
                    ->filterBySection($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPublicationsPartial && count($collPublications)) {
                        $this->initPublications(false);

                        foreach ($collPublications as $obj) {
                            if (false == $this->collPublications->contains($obj)) {
                                $this->collPublications->append($obj);
                            }
                        }

                        $this->collPublicationsPartial = true;
                    }

                    return $collPublications;
                }

                if ($partial && $this->collPublications) {
                    foreach ($this->collPublications as $obj) {
                        if ($obj->isNew()) {
                            $collPublications[] = $obj;
                        }
                    }
                }

                $this->collPublications = $collPublications;
                $this->collPublicationsPartial = false;
            }
        }

        return $this->collPublications;
    }

    /**
     * Sets a collection of ChildPublication objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $publications A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSection The current object (for fluent API support)
     */
    public function setPublications(Collection $publications, ConnectionInterface $con = null)
    {
        /** @var ChildPublication[] $publicationsToDelete */
        $publicationsToDelete = $this->getPublications(new Criteria(), $con)->diff($publications);


        $this->publicationsScheduledForDeletion = $publicationsToDelete;

        foreach ($publicationsToDelete as $publicationRemoved) {
            $publicationRemoved->setSection(null);
        }

        $this->collPublications = null;
        foreach ($publications as $publication) {
            $this->addPublication($publication);
        }

        $this->collPublications = $publications;
        $this->collPublicationsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Publication objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Publication objects.
     * @throws PropelException
     */
    public function countPublications(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPublicationsPartial && !$this->isNew();
        if (null === $this->collPublications || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPublications) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPublications());
            }

            $query = ChildPublicationQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySection($this)
                ->count($con);
        }

        return count($this->collPublications);
    }

    /**
     * Method called to associate a ChildPublication object to this object
     * through the ChildPublication foreign key attribute.
     *
     * @param  ChildPublication $l ChildPublication
     * @return $this|\Propel\Models\Section The current object (for fluent API support)
     */
    public function addPublication(ChildPublication $l)
    {
        if ($this->collPublications === null) {
            $this->initPublications();
            $this->collPublicationsPartial = true;
        }

        if (!$this->collPublications->contains($l)) {
            $this->doAddPublication($l);

            if ($this->publicationsScheduledForDeletion and $this->publicationsScheduledForDeletion->contains($l)) {
                $this->publicationsScheduledForDeletion->remove($this->publicationsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildPublication $publication The ChildPublication object to add.
     */
    protected function doAddPublication(ChildPublication $publication)
    {
        $this->collPublications[]= $publication;
        $publication->setSection($this);
    }

    /**
     * @param  ChildPublication $publication The ChildPublication object to remove.
     * @return $this|ChildSection The current object (for fluent API support)
     */
    public function removePublication(ChildPublication $publication)
    {
        if ($this->getPublications()->contains($publication)) {
            $pos = $this->collPublications->search($publication);
            $this->collPublications->remove($pos);
            if (null === $this->publicationsScheduledForDeletion) {
                $this->publicationsScheduledForDeletion = clone $this->collPublications;
                $this->publicationsScheduledForDeletion->clear();
            }
            $this->publicationsScheduledForDeletion[]= $publication;
            $publication->setSection(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Section is new, it will return
     * an empty collection; or if this Section has previously
     * been saved, it will retrieve related Publications from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Section.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPublication[] List of ChildPublication objects
     */
    public function getPublicationsJoinUserRelatedByCreatedBy(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPublicationQuery::create(null, $criteria);
        $query->joinWith('UserRelatedByCreatedBy', $joinBehavior);

        return $this->getPublications($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Section is new, it will return
     * an empty collection; or if this Section has previously
     * been saved, it will retrieve related Publications from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Section.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPublication[] List of ChildPublication objects
     */
    public function getPublicationsJoinUserRelatedByUpdatedBy(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPublicationQuery::create(null, $criteria);
        $query->joinWith('UserRelatedByUpdatedBy', $joinBehavior);

        return $this->getPublications($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aParent) {
            $this->aParent->removeSectionRelatedById($this);
        }
        if (null !== $this->aUserRelatedByCreatedBy) {
            $this->aUserRelatedByCreatedBy->removeSectionRelatedByCreatedBy($this);
        }
        if (null !== $this->aUserRelatedByUpdatedBy) {
            $this->aUserRelatedByUpdatedBy->removeSectionRelatedByUpdatedBy($this);
        }
        $this->id = null;
        $this->parent_id = null;
        $this->code = null;
        $this->header = null;
        $this->picture = null;
        $this->content = null;
        $this->content_isLoaded = false;
        $this->meta_title = null;
        $this->meta_author = null;
        $this->meta_keywords = null;
        $this->meta_description = null;
        $this->meta_canonical = null;
        $this->meta_robots = null;
        $this->created_at = null;
        $this->created_by = null;
        $this->updated_at = null;
        $this->updated_by = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
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
            if ($this->collSectionsRelatedById) {
                foreach ($this->collSectionsRelatedById as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSectionFields) {
                foreach ($this->collSectionFields as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPublications) {
                foreach ($this->collPublications as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collSectionsRelatedById = null;
        $this->collSectionFields = null;
        $this->collPublications = null;
        $this->aParent = null;
        $this->aUserRelatedByCreatedBy = null;
        $this->aUserRelatedByUpdatedBy = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string The value of the 'header' column
     */
    public function __toString()
    {
        return (string) $this->getHeader();
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
        $metadata->addPropertyConstraint('code', new NotBlank());
        $metadata->addPropertyConstraint('code', new Length(array ('max' => 255,)));
        $metadata->addPropertyConstraint('code', new Regex(array ('pattern' => '/^[a-z0-9-]+$/',)));
        $metadata->addPropertyConstraint('code', new Unique());
        $metadata->addPropertyConstraint('header', new NotBlank());
        $metadata->addPropertyConstraint('header', new Length(array ('max' => 255,)));
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

            if (null !== $this->collSectionsRelatedById) {
                foreach ($this->collSectionsRelatedById as $referrerFK) {
                    if (method_exists($referrerFK, 'validate')) {
                        if (!$referrerFK->validate($validator)) {
                            $failureMap->addAll($referrerFK->getValidationFailures());
                        }
                    }
                }
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
            if (null !== $this->collPublications) {
                foreach ($this->collPublications as $referrerFK) {
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
