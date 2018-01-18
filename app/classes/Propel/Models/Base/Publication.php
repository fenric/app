<?php

namespace Propel\Models\Base;

use \DateTime;
use \Exception;
use \PDO;
use Propel\Models\Comment as ChildComment;
use Propel\Models\CommentQuery as ChildCommentQuery;
use Propel\Models\Publication as ChildPublication;
use Propel\Models\PublicationField as ChildPublicationField;
use Propel\Models\PublicationFieldQuery as ChildPublicationFieldQuery;
use Propel\Models\PublicationPhoto as ChildPublicationPhoto;
use Propel\Models\PublicationPhotoQuery as ChildPublicationPhotoQuery;
use Propel\Models\PublicationQuery as ChildPublicationQuery;
use Propel\Models\PublicationRelation as ChildPublicationRelation;
use Propel\Models\PublicationRelationQuery as ChildPublicationRelationQuery;
use Propel\Models\PublicationTag as ChildPublicationTag;
use Propel\Models\PublicationTagQuery as ChildPublicationTagQuery;
use Propel\Models\Section as ChildSection;
use Propel\Models\SectionQuery as ChildSectionQuery;
use Propel\Models\User as ChildUser;
use Propel\Models\UserFavorite as ChildUserFavorite;
use Propel\Models\UserFavoriteQuery as ChildUserFavoriteQuery;
use Propel\Models\UserQuery as ChildUserQuery;
use Propel\Models\Map\CommentTableMap;
use Propel\Models\Map\PublicationFieldTableMap;
use Propel\Models\Map\PublicationPhotoTableMap;
use Propel\Models\Map\PublicationRelationTableMap;
use Propel\Models\Map\PublicationTableMap;
use Propel\Models\Map\PublicationTagTableMap;
use Propel\Models\Map\UserFavoriteTableMap;
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
use Symfony\Component\Validator\Constraints\Date;
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
 * Base class that represents a row from the 'fenric_publication' table.
 *
 *
 *
 * @package    propel.generator.Propel.Models.Base
 */
abstract class Publication implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Propel\\Models\\Map\\PublicationTableMap';


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
     * The value for the section_id field.
     *
     * @var        int
     */
    protected $section_id;

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
     * The value for the picture_source field.
     *
     * @var        string
     */
    protected $picture_source;

    /**
     * The value for the picture_signature field.
     *
     * @var        string
     */
    protected $picture_signature;

    /**
     * The value for the anons field.
     *
     * @var        string
     */
    protected $anons;

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
     * The value for the show_at field.
     *
     * @var        DateTime
     */
    protected $show_at;

    /**
     * The value for the hide_at field.
     *
     * @var        DateTime
     */
    protected $hide_at;

    /**
     * The value for the hits field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $hits;

    /**
     * @var        ChildSection
     */
    protected $aSection;

    /**
     * @var        ChildUser
     */
    protected $aUserRelatedByCreatedBy;

    /**
     * @var        ChildUser
     */
    protected $aUserRelatedByUpdatedBy;

    /**
     * @var        ObjectCollection|ChildComment[] Collection to store aggregation of ChildComment objects.
     */
    protected $collComments;
    protected $collCommentsPartial;

    /**
     * @var        ObjectCollection|ChildPublicationField[] Collection to store aggregation of ChildPublicationField objects.
     */
    protected $collPublicationFields;
    protected $collPublicationFieldsPartial;

    /**
     * @var        ObjectCollection|ChildPublicationPhoto[] Collection to store aggregation of ChildPublicationPhoto objects.
     */
    protected $collPublicationPhotos;
    protected $collPublicationPhotosPartial;

    /**
     * @var        ObjectCollection|ChildPublicationRelation[] Collection to store aggregation of ChildPublicationRelation objects.
     */
    protected $collPublicationRelations;
    protected $collPublicationRelationsPartial;

    /**
     * @var        ObjectCollection|ChildPublicationTag[] Collection to store aggregation of ChildPublicationTag objects.
     */
    protected $collPublicationTags;
    protected $collPublicationTagsPartial;

    /**
     * @var        ObjectCollection|ChildUserFavorite[] Collection to store aggregation of ChildUserFavorite objects.
     */
    protected $collUserFavorites;
    protected $collUserFavoritesPartial;

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
    protected $commentsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPublicationField[]
     */
    protected $publicationFieldsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPublicationPhoto[]
     */
    protected $publicationPhotosScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPublicationRelation[]
     */
    protected $publicationRelationsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPublicationTag[]
     */
    protected $publicationTagsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildUserFavorite[]
     */
    protected $userFavoritesScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->hits = '0';
    }

    /**
     * Initializes internal state of Propel\Models\Base\Publication object.
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
     * Compares this with another <code>Publication</code> instance.  If
     * <code>obj</code> is an instance of <code>Publication</code>, delegates to
     * <code>equals(Publication)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Publication The current object, for fluid interface
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
     * Get the [section_id] column value.
     *
     * @return int
     */
    public function getSectionId()
    {
        return $this->section_id;
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
     * Get the [picture_source] column value.
     *
     * @return string
     */
    public function getPictureSource()
    {
        return $this->picture_source;
    }

    /**
     * Get the [picture_signature] column value.
     *
     * @return string
     */
    public function getPictureSignature()
    {
        return $this->picture_signature;
    }

    /**
     * Get the [anons] column value.
     *
     * @return string
     */
    public function getAnons()
    {
        return $this->anons;
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
        $c->addSelectColumn(PublicationTableMap::COL_CONTENT);
        try {
            $dataFetcher = ChildPublicationQuery::create(null, $c)->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
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
     * Get the [optionally formatted] temporal [show_at] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getShowAt($format = NULL)
    {
        if ($format === null) {
            return $this->show_at;
        } else {
            return $this->show_at instanceof \DateTimeInterface ? $this->show_at->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [hide_at] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getHideAt($format = NULL)
    {
        if ($format === null) {
            return $this->hide_at;
        } else {
            return $this->hide_at instanceof \DateTimeInterface ? $this->hide_at->format($format) : null;
        }
    }

    /**
     * Get the [hits] column value.
     *
     * @return string
     */
    public function getHits()
    {
        return $this->hits;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\Propel\Models\Publication The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[PublicationTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [section_id] column.
     *
     * @param int $v new value
     * @return $this|\Propel\Models\Publication The current object (for fluent API support)
     */
    public function setSectionId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->section_id !== $v) {
            $this->section_id = $v;
            $this->modifiedColumns[PublicationTableMap::COL_SECTION_ID] = true;
        }

        if ($this->aSection !== null && $this->aSection->getId() !== $v) {
            $this->aSection = null;
        }

        return $this;
    } // setSectionId()

    /**
     * Set the value of [code] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\Publication The current object (for fluent API support)
     */
    public function setCode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->code !== $v) {
            $this->code = $v;
            $this->modifiedColumns[PublicationTableMap::COL_CODE] = true;
        }

        return $this;
    } // setCode()

    /**
     * Set the value of [header] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\Publication The current object (for fluent API support)
     */
    public function setHeader($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->header !== $v) {
            $this->header = $v;
            $this->modifiedColumns[PublicationTableMap::COL_HEADER] = true;
        }

        return $this;
    } // setHeader()

    /**
     * Set the value of [picture] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\Publication The current object (for fluent API support)
     */
    public function setPicture($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->picture !== $v) {
            $this->picture = $v;
            $this->modifiedColumns[PublicationTableMap::COL_PICTURE] = true;
        }

        return $this;
    } // setPicture()

    /**
     * Set the value of [picture_source] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\Publication The current object (for fluent API support)
     */
    public function setPictureSource($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->picture_source !== $v) {
            $this->picture_source = $v;
            $this->modifiedColumns[PublicationTableMap::COL_PICTURE_SOURCE] = true;
        }

        return $this;
    } // setPictureSource()

    /**
     * Set the value of [picture_signature] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\Publication The current object (for fluent API support)
     */
    public function setPictureSignature($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->picture_signature !== $v) {
            $this->picture_signature = $v;
            $this->modifiedColumns[PublicationTableMap::COL_PICTURE_SIGNATURE] = true;
        }

        return $this;
    } // setPictureSignature()

    /**
     * Set the value of [anons] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\Publication The current object (for fluent API support)
     */
    public function setAnons($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->anons !== $v) {
            $this->anons = $v;
            $this->modifiedColumns[PublicationTableMap::COL_ANONS] = true;
        }

        return $this;
    } // setAnons()

    /**
     * Set the value of [content] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\Publication The current object (for fluent API support)
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
            $this->modifiedColumns[PublicationTableMap::COL_CONTENT] = true;
        }

        return $this;
    } // setContent()

    /**
     * Set the value of [meta_title] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\Publication The current object (for fluent API support)
     */
    public function setMetaTitle($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->meta_title !== $v) {
            $this->meta_title = $v;
            $this->modifiedColumns[PublicationTableMap::COL_META_TITLE] = true;
        }

        return $this;
    } // setMetaTitle()

    /**
     * Set the value of [meta_author] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\Publication The current object (for fluent API support)
     */
    public function setMetaAuthor($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->meta_author !== $v) {
            $this->meta_author = $v;
            $this->modifiedColumns[PublicationTableMap::COL_META_AUTHOR] = true;
        }

        return $this;
    } // setMetaAuthor()

    /**
     * Set the value of [meta_keywords] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\Publication The current object (for fluent API support)
     */
    public function setMetaKeywords($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->meta_keywords !== $v) {
            $this->meta_keywords = $v;
            $this->modifiedColumns[PublicationTableMap::COL_META_KEYWORDS] = true;
        }

        return $this;
    } // setMetaKeywords()

    /**
     * Set the value of [meta_description] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\Publication The current object (for fluent API support)
     */
    public function setMetaDescription($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->meta_description !== $v) {
            $this->meta_description = $v;
            $this->modifiedColumns[PublicationTableMap::COL_META_DESCRIPTION] = true;
        }

        return $this;
    } // setMetaDescription()

    /**
     * Set the value of [meta_canonical] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\Publication The current object (for fluent API support)
     */
    public function setMetaCanonical($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->meta_canonical !== $v) {
            $this->meta_canonical = $v;
            $this->modifiedColumns[PublicationTableMap::COL_META_CANONICAL] = true;
        }

        return $this;
    } // setMetaCanonical()

    /**
     * Set the value of [meta_robots] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\Publication The current object (for fluent API support)
     */
    public function setMetaRobots($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->meta_robots !== $v) {
            $this->meta_robots = $v;
            $this->modifiedColumns[PublicationTableMap::COL_META_ROBOTS] = true;
        }

        return $this;
    } // setMetaRobots()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Propel\Models\Publication The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($this->created_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->created_at->format("Y-m-d H:i:s.u")) {
                $this->created_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[PublicationTableMap::COL_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setCreatedAt()

    /**
     * Set the value of [created_by] column.
     *
     * @param int $v new value
     * @return $this|\Propel\Models\Publication The current object (for fluent API support)
     */
    public function setCreatedBy($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->created_by !== $v) {
            $this->created_by = $v;
            $this->modifiedColumns[PublicationTableMap::COL_CREATED_BY] = true;
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
     * @return $this|\Propel\Models\Publication The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($this->updated_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->updated_at->format("Y-m-d H:i:s.u")) {
                $this->updated_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[PublicationTableMap::COL_UPDATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setUpdatedAt()

    /**
     * Set the value of [updated_by] column.
     *
     * @param int $v new value
     * @return $this|\Propel\Models\Publication The current object (for fluent API support)
     */
    public function setUpdatedBy($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->updated_by !== $v) {
            $this->updated_by = $v;
            $this->modifiedColumns[PublicationTableMap::COL_UPDATED_BY] = true;
        }

        if ($this->aUserRelatedByUpdatedBy !== null && $this->aUserRelatedByUpdatedBy->getId() !== $v) {
            $this->aUserRelatedByUpdatedBy = null;
        }

        return $this;
    } // setUpdatedBy()

    /**
     * Sets the value of [show_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Propel\Models\Publication The current object (for fluent API support)
     */
    public function setShowAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->show_at !== null || $dt !== null) {
            if ($this->show_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->show_at->format("Y-m-d H:i:s.u")) {
                $this->show_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[PublicationTableMap::COL_SHOW_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setShowAt()

    /**
     * Sets the value of [hide_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Propel\Models\Publication The current object (for fluent API support)
     */
    public function setHideAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->hide_at !== null || $dt !== null) {
            if ($this->hide_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->hide_at->format("Y-m-d H:i:s.u")) {
                $this->hide_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[PublicationTableMap::COL_HIDE_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setHideAt()

    /**
     * Set the value of [hits] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\Publication The current object (for fluent API support)
     */
    public function setHits($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->hits !== $v) {
            $this->hits = $v;
            $this->modifiedColumns[PublicationTableMap::COL_HITS] = true;
        }

        return $this;
    } // setHits()

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
            if ($this->hits !== '0') {
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : PublicationTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : PublicationTableMap::translateFieldName('SectionId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->section_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : PublicationTableMap::translateFieldName('Code', TableMap::TYPE_PHPNAME, $indexType)];
            $this->code = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : PublicationTableMap::translateFieldName('Header', TableMap::TYPE_PHPNAME, $indexType)];
            $this->header = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : PublicationTableMap::translateFieldName('Picture', TableMap::TYPE_PHPNAME, $indexType)];
            $this->picture = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : PublicationTableMap::translateFieldName('PictureSource', TableMap::TYPE_PHPNAME, $indexType)];
            $this->picture_source = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : PublicationTableMap::translateFieldName('PictureSignature', TableMap::TYPE_PHPNAME, $indexType)];
            $this->picture_signature = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : PublicationTableMap::translateFieldName('Anons', TableMap::TYPE_PHPNAME, $indexType)];
            $this->anons = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : PublicationTableMap::translateFieldName('MetaTitle', TableMap::TYPE_PHPNAME, $indexType)];
            $this->meta_title = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : PublicationTableMap::translateFieldName('MetaAuthor', TableMap::TYPE_PHPNAME, $indexType)];
            $this->meta_author = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : PublicationTableMap::translateFieldName('MetaKeywords', TableMap::TYPE_PHPNAME, $indexType)];
            $this->meta_keywords = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : PublicationTableMap::translateFieldName('MetaDescription', TableMap::TYPE_PHPNAME, $indexType)];
            $this->meta_description = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : PublicationTableMap::translateFieldName('MetaCanonical', TableMap::TYPE_PHPNAME, $indexType)];
            $this->meta_canonical = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : PublicationTableMap::translateFieldName('MetaRobots', TableMap::TYPE_PHPNAME, $indexType)];
            $this->meta_robots = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 14 + $startcol : PublicationTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 15 + $startcol : PublicationTableMap::translateFieldName('CreatedBy', TableMap::TYPE_PHPNAME, $indexType)];
            $this->created_by = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 16 + $startcol : PublicationTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 17 + $startcol : PublicationTableMap::translateFieldName('UpdatedBy', TableMap::TYPE_PHPNAME, $indexType)];
            $this->updated_by = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 18 + $startcol : PublicationTableMap::translateFieldName('ShowAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->show_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 19 + $startcol : PublicationTableMap::translateFieldName('HideAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->hide_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 20 + $startcol : PublicationTableMap::translateFieldName('Hits', TableMap::TYPE_PHPNAME, $indexType)];
            $this->hits = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 21; // 21 = PublicationTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Propel\\Models\\Publication'), 0, $e);
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
        if ($this->aSection !== null && $this->section_id !== $this->aSection->getId()) {
            $this->aSection = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(PublicationTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildPublicationQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
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

            $this->aSection = null;
            $this->aUserRelatedByCreatedBy = null;
            $this->aUserRelatedByUpdatedBy = null;
            $this->collComments = null;

            $this->collPublicationFields = null;

            $this->collPublicationPhotos = null;

            $this->collPublicationRelations = null;

            $this->collPublicationTags = null;

            $this->collUserFavorites = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Publication::setDeleted()
     * @see Publication::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PublicationTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildPublicationQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            // Fenric\Propel\Behaviors\Eventable behavior
            if (! fenric('event::model.publication.pre.delete')->run([$this, \Propel\Runtime\Propel::getServiceContainer()->getWriteConnection(PublicationTableMap::DATABASE_NAME)])) {
                return 0;
            }
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                // Fenric\Propel\Behaviors\Eventable behavior
                fenric('event::model.publication.post.delete')->run([$this, \Propel\Runtime\Propel::getServiceContainer()->getWriteConnection(PublicationTableMap::DATABASE_NAME)]);
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
            $con = Propel::getServiceContainer()->getWriteConnection(PublicationTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            // Fenric\Propel\Behaviors\Eventable behavior
            if (! fenric('event::model.publication.pre.save')->run([$this, \Propel\Runtime\Propel::getServiceContainer()->getWriteConnection(PublicationTableMap::DATABASE_NAME)])) {
                return 0;
            }
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // Fenric\Propel\Behaviors\Authorable behavior
                    if (! $this->isColumnModified(PublicationTableMap::COL_CREATED_BY)) {
                        if (fenric()->existsSharedService('user')) {
                            if (fenric('user')->isLogged()) {
                                $this->setCreatedBy(fenric('user')->getId());
                            }
                        }
                    }	if (! $this->isColumnModified(PublicationTableMap::COL_UPDATED_BY)) {
                        if (fenric()->existsSharedService('user')) {
                            if (fenric('user')->isLogged()) {
                                $this->setUpdatedBy(fenric('user')->getId());
                            }
                        }
                    }
                // Fenric\Propel\Behaviors\Timestampable behavior
                    if (! $this->isColumnModified(PublicationTableMap::COL_CREATED_AT)) {
                        $this->setCreatedAt(new \DateTime('now'));
                    }	if (! $this->isColumnModified(PublicationTableMap::COL_UPDATED_AT)) {
                        $this->setUpdatedAt(new \DateTime('now'));
                    }
                // Fenric\Propel\Behaviors\Eventable behavior
                if (! fenric('event::model.publication.pre.insert')->run([$this, \Propel\Runtime\Propel::getServiceContainer()->getWriteConnection(PublicationTableMap::DATABASE_NAME)])) {
                    return 0;
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // Fenric\Propel\Behaviors\Authorable behavior
                    if (! $this->isColumnModified(PublicationTableMap::COL_UPDATED_BY)) {
                        if (fenric()->existsSharedService('user')) {
                            if (fenric('user')->isLogged()) {
                                $this->setUpdatedBy(fenric('user')->getId());
                            }
                        }
                    }
                // Fenric\Propel\Behaviors\Timestampable behavior
                    if (! $this->isColumnModified(PublicationTableMap::COL_UPDATED_AT)) {
                        $this->setUpdatedAt(new \DateTime('now'));
                    }
                // Fenric\Propel\Behaviors\Eventable behavior
                if (! fenric('event::model.publication.pre.update')->run([$this, \Propel\Runtime\Propel::getServiceContainer()->getWriteConnection(PublicationTableMap::DATABASE_NAME)])) {
                    return 0;
                }
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                    // Fenric\Propel\Behaviors\Eventable behavior
                    fenric('event::model.publication.post.insert')->run([$this, \Propel\Runtime\Propel::getServiceContainer()->getWriteConnection(PublicationTableMap::DATABASE_NAME)]);
                } else {
                    $this->postUpdate($con);
                    // Fenric\Propel\Behaviors\Eventable behavior
                    fenric('event::model.publication.post.update')->run([$this, \Propel\Runtime\Propel::getServiceContainer()->getWriteConnection(PublicationTableMap::DATABASE_NAME)]);
                }
                $this->postSave($con);
                // Fenric\Propel\Behaviors\Eventable behavior
                fenric('event::model.publication.post.save')->run([$this, \Propel\Runtime\Propel::getServiceContainer()->getWriteConnection(PublicationTableMap::DATABASE_NAME)]);
                PublicationTableMap::addInstanceToPool($this);
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

            if ($this->aSection !== null) {
                if ($this->aSection->isModified() || $this->aSection->isNew()) {
                    $affectedRows += $this->aSection->save($con);
                }
                $this->setSection($this->aSection);
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

            if ($this->commentsScheduledForDeletion !== null) {
                if (!$this->commentsScheduledForDeletion->isEmpty()) {
                    \Propel\Models\CommentQuery::create()
                        ->filterByPrimaryKeys($this->commentsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->commentsScheduledForDeletion = null;
                }
            }

            if ($this->collComments !== null) {
                foreach ($this->collComments as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->publicationFieldsScheduledForDeletion !== null) {
                if (!$this->publicationFieldsScheduledForDeletion->isEmpty()) {
                    \Propel\Models\PublicationFieldQuery::create()
                        ->filterByPrimaryKeys($this->publicationFieldsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->publicationFieldsScheduledForDeletion = null;
                }
            }

            if ($this->collPublicationFields !== null) {
                foreach ($this->collPublicationFields as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->publicationPhotosScheduledForDeletion !== null) {
                if (!$this->publicationPhotosScheduledForDeletion->isEmpty()) {
                    \Propel\Models\PublicationPhotoQuery::create()
                        ->filterByPrimaryKeys($this->publicationPhotosScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->publicationPhotosScheduledForDeletion = null;
                }
            }

            if ($this->collPublicationPhotos !== null) {
                foreach ($this->collPublicationPhotos as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->publicationRelationsScheduledForDeletion !== null) {
                if (!$this->publicationRelationsScheduledForDeletion->isEmpty()) {
                    \Propel\Models\PublicationRelationQuery::create()
                        ->filterByPrimaryKeys($this->publicationRelationsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->publicationRelationsScheduledForDeletion = null;
                }
            }

            if ($this->collPublicationRelations !== null) {
                foreach ($this->collPublicationRelations as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->publicationTagsScheduledForDeletion !== null) {
                if (!$this->publicationTagsScheduledForDeletion->isEmpty()) {
                    \Propel\Models\PublicationTagQuery::create()
                        ->filterByPrimaryKeys($this->publicationTagsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->publicationTagsScheduledForDeletion = null;
                }
            }

            if ($this->collPublicationTags !== null) {
                foreach ($this->collPublicationTags as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->userFavoritesScheduledForDeletion !== null) {
                if (!$this->userFavoritesScheduledForDeletion->isEmpty()) {
                    \Propel\Models\UserFavoriteQuery::create()
                        ->filterByPrimaryKeys($this->userFavoritesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->userFavoritesScheduledForDeletion = null;
                }
            }

            if ($this->collUserFavorites !== null) {
                foreach ($this->collUserFavorites as $referrerFK) {
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

        $this->modifiedColumns[PublicationTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . PublicationTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(PublicationTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(PublicationTableMap::COL_SECTION_ID)) {
            $modifiedColumns[':p' . $index++]  = 'section_id';
        }
        if ($this->isColumnModified(PublicationTableMap::COL_CODE)) {
            $modifiedColumns[':p' . $index++]  = 'code';
        }
        if ($this->isColumnModified(PublicationTableMap::COL_HEADER)) {
            $modifiedColumns[':p' . $index++]  = 'header';
        }
        if ($this->isColumnModified(PublicationTableMap::COL_PICTURE)) {
            $modifiedColumns[':p' . $index++]  = 'picture';
        }
        if ($this->isColumnModified(PublicationTableMap::COL_PICTURE_SOURCE)) {
            $modifiedColumns[':p' . $index++]  = 'picture_source';
        }
        if ($this->isColumnModified(PublicationTableMap::COL_PICTURE_SIGNATURE)) {
            $modifiedColumns[':p' . $index++]  = 'picture_signature';
        }
        if ($this->isColumnModified(PublicationTableMap::COL_ANONS)) {
            $modifiedColumns[':p' . $index++]  = 'anons';
        }
        if ($this->isColumnModified(PublicationTableMap::COL_CONTENT)) {
            $modifiedColumns[':p' . $index++]  = 'content';
        }
        if ($this->isColumnModified(PublicationTableMap::COL_META_TITLE)) {
            $modifiedColumns[':p' . $index++]  = 'meta_title';
        }
        if ($this->isColumnModified(PublicationTableMap::COL_META_AUTHOR)) {
            $modifiedColumns[':p' . $index++]  = 'meta_author';
        }
        if ($this->isColumnModified(PublicationTableMap::COL_META_KEYWORDS)) {
            $modifiedColumns[':p' . $index++]  = 'meta_keywords';
        }
        if ($this->isColumnModified(PublicationTableMap::COL_META_DESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = 'meta_description';
        }
        if ($this->isColumnModified(PublicationTableMap::COL_META_CANONICAL)) {
            $modifiedColumns[':p' . $index++]  = 'meta_canonical';
        }
        if ($this->isColumnModified(PublicationTableMap::COL_META_ROBOTS)) {
            $modifiedColumns[':p' . $index++]  = 'meta_robots';
        }
        if ($this->isColumnModified(PublicationTableMap::COL_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'created_at';
        }
        if ($this->isColumnModified(PublicationTableMap::COL_CREATED_BY)) {
            $modifiedColumns[':p' . $index++]  = 'created_by';
        }
        if ($this->isColumnModified(PublicationTableMap::COL_UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'updated_at';
        }
        if ($this->isColumnModified(PublicationTableMap::COL_UPDATED_BY)) {
            $modifiedColumns[':p' . $index++]  = 'updated_by';
        }
        if ($this->isColumnModified(PublicationTableMap::COL_SHOW_AT)) {
            $modifiedColumns[':p' . $index++]  = 'show_at';
        }
        if ($this->isColumnModified(PublicationTableMap::COL_HIDE_AT)) {
            $modifiedColumns[':p' . $index++]  = 'hide_at';
        }
        if ($this->isColumnModified(PublicationTableMap::COL_HITS)) {
            $modifiedColumns[':p' . $index++]  = 'hits';
        }

        $sql = sprintf(
            'INSERT INTO fenric_publication (%s) VALUES (%s)',
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
                    case 'section_id':
                        $stmt->bindValue($identifier, $this->section_id, PDO::PARAM_INT);
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
                    case 'picture_source':
                        $stmt->bindValue($identifier, $this->picture_source, PDO::PARAM_STR);
                        break;
                    case 'picture_signature':
                        $stmt->bindValue($identifier, $this->picture_signature, PDO::PARAM_STR);
                        break;
                    case 'anons':
                        $stmt->bindValue($identifier, $this->anons, PDO::PARAM_STR);
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
                    case 'show_at':
                        $stmt->bindValue($identifier, $this->show_at ? $this->show_at->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'hide_at':
                        $stmt->bindValue($identifier, $this->hide_at ? $this->hide_at->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'hits':
                        $stmt->bindValue($identifier, $this->hits, PDO::PARAM_INT);
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
        $pos = PublicationTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getSectionId();
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
                return $this->getPictureSource();
                break;
            case 6:
                return $this->getPictureSignature();
                break;
            case 7:
                return $this->getAnons();
                break;
            case 8:
                return $this->getContent();
                break;
            case 9:
                return $this->getMetaTitle();
                break;
            case 10:
                return $this->getMetaAuthor();
                break;
            case 11:
                return $this->getMetaKeywords();
                break;
            case 12:
                return $this->getMetaDescription();
                break;
            case 13:
                return $this->getMetaCanonical();
                break;
            case 14:
                return $this->getMetaRobots();
                break;
            case 15:
                return $this->getCreatedAt();
                break;
            case 16:
                return $this->getCreatedBy();
                break;
            case 17:
                return $this->getUpdatedAt();
                break;
            case 18:
                return $this->getUpdatedBy();
                break;
            case 19:
                return $this->getShowAt();
                break;
            case 20:
                return $this->getHideAt();
                break;
            case 21:
                return $this->getHits();
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

        if (isset($alreadyDumpedObjects['Publication'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Publication'][$this->hashCode()] = true;
        $keys = PublicationTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getSectionId(),
            $keys[2] => $this->getCode(),
            $keys[3] => $this->getHeader(),
            $keys[4] => $this->getPicture(),
            $keys[5] => $this->getPictureSource(),
            $keys[6] => $this->getPictureSignature(),
            $keys[7] => $this->getAnons(),
            $keys[8] => ($includeLazyLoadColumns) ? $this->getContent() : null,
            $keys[9] => $this->getMetaTitle(),
            $keys[10] => $this->getMetaAuthor(),
            $keys[11] => $this->getMetaKeywords(),
            $keys[12] => $this->getMetaDescription(),
            $keys[13] => $this->getMetaCanonical(),
            $keys[14] => $this->getMetaRobots(),
            $keys[15] => $this->getCreatedAt(),
            $keys[16] => $this->getCreatedBy(),
            $keys[17] => $this->getUpdatedAt(),
            $keys[18] => $this->getUpdatedBy(),
            $keys[19] => $this->getShowAt(),
            $keys[20] => $this->getHideAt(),
            $keys[21] => $this->getHits(),
        );
        if ($result[$keys[15]] instanceof \DateTimeInterface) {
            $result[$keys[15]] = $result[$keys[15]]->format('c');
        }

        if ($result[$keys[17]] instanceof \DateTimeInterface) {
            $result[$keys[17]] = $result[$keys[17]]->format('c');
        }

        if ($result[$keys[19]] instanceof \DateTimeInterface) {
            $result[$keys[19]] = $result[$keys[19]]->format('c');
        }

        if ($result[$keys[20]] instanceof \DateTimeInterface) {
            $result[$keys[20]] = $result[$keys[20]]->format('c');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aSection) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'section';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'fenric_section';
                        break;
                    default:
                        $key = 'Section';
                }

                $result[$key] = $this->aSection->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
            if (null !== $this->collComments) {

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

                $result[$key] = $this->collComments->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPublicationFields) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'publicationFields';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'fenric_publication_fields';
                        break;
                    default:
                        $key = 'PublicationFields';
                }

                $result[$key] = $this->collPublicationFields->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPublicationPhotos) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'publicationPhotos';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'fenric_publication_photos';
                        break;
                    default:
                        $key = 'PublicationPhotos';
                }

                $result[$key] = $this->collPublicationPhotos->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPublicationRelations) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'publicationRelations';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'fenric_publication_relations';
                        break;
                    default:
                        $key = 'PublicationRelations';
                }

                $result[$key] = $this->collPublicationRelations->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPublicationTags) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'publicationTags';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'fenric_publication_tags';
                        break;
                    default:
                        $key = 'PublicationTags';
                }

                $result[$key] = $this->collPublicationTags->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collUserFavorites) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'userFavorites';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'fenric_user_favorites';
                        break;
                    default:
                        $key = 'UserFavorites';
                }

                $result[$key] = $this->collUserFavorites->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Propel\Models\Publication
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = PublicationTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Propel\Models\Publication
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setSectionId($value);
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
                $this->setPictureSource($value);
                break;
            case 6:
                $this->setPictureSignature($value);
                break;
            case 7:
                $this->setAnons($value);
                break;
            case 8:
                $this->setContent($value);
                break;
            case 9:
                $this->setMetaTitle($value);
                break;
            case 10:
                $this->setMetaAuthor($value);
                break;
            case 11:
                $this->setMetaKeywords($value);
                break;
            case 12:
                $this->setMetaDescription($value);
                break;
            case 13:
                $this->setMetaCanonical($value);
                break;
            case 14:
                $this->setMetaRobots($value);
                break;
            case 15:
                $this->setCreatedAt($value);
                break;
            case 16:
                $this->setCreatedBy($value);
                break;
            case 17:
                $this->setUpdatedAt($value);
                break;
            case 18:
                $this->setUpdatedBy($value);
                break;
            case 19:
                $this->setShowAt($value);
                break;
            case 20:
                $this->setHideAt($value);
                break;
            case 21:
                $this->setHits($value);
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
        $keys = PublicationTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setSectionId($arr[$keys[1]]);
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
            $this->setPictureSource($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setPictureSignature($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setAnons($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setContent($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setMetaTitle($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setMetaAuthor($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setMetaKeywords($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->setMetaDescription($arr[$keys[12]]);
        }
        if (array_key_exists($keys[13], $arr)) {
            $this->setMetaCanonical($arr[$keys[13]]);
        }
        if (array_key_exists($keys[14], $arr)) {
            $this->setMetaRobots($arr[$keys[14]]);
        }
        if (array_key_exists($keys[15], $arr)) {
            $this->setCreatedAt($arr[$keys[15]]);
        }
        if (array_key_exists($keys[16], $arr)) {
            $this->setCreatedBy($arr[$keys[16]]);
        }
        if (array_key_exists($keys[17], $arr)) {
            $this->setUpdatedAt($arr[$keys[17]]);
        }
        if (array_key_exists($keys[18], $arr)) {
            $this->setUpdatedBy($arr[$keys[18]]);
        }
        if (array_key_exists($keys[19], $arr)) {
            $this->setShowAt($arr[$keys[19]]);
        }
        if (array_key_exists($keys[20], $arr)) {
            $this->setHideAt($arr[$keys[20]]);
        }
        if (array_key_exists($keys[21], $arr)) {
            $this->setHits($arr[$keys[21]]);
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
     * @return $this|\Propel\Models\Publication The current object, for fluid interface
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
        $criteria = new Criteria(PublicationTableMap::DATABASE_NAME);

        if ($this->isColumnModified(PublicationTableMap::COL_ID)) {
            $criteria->add(PublicationTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(PublicationTableMap::COL_SECTION_ID)) {
            $criteria->add(PublicationTableMap::COL_SECTION_ID, $this->section_id);
        }
        if ($this->isColumnModified(PublicationTableMap::COL_CODE)) {
            $criteria->add(PublicationTableMap::COL_CODE, $this->code);
        }
        if ($this->isColumnModified(PublicationTableMap::COL_HEADER)) {
            $criteria->add(PublicationTableMap::COL_HEADER, $this->header);
        }
        if ($this->isColumnModified(PublicationTableMap::COL_PICTURE)) {
            $criteria->add(PublicationTableMap::COL_PICTURE, $this->picture);
        }
        if ($this->isColumnModified(PublicationTableMap::COL_PICTURE_SOURCE)) {
            $criteria->add(PublicationTableMap::COL_PICTURE_SOURCE, $this->picture_source);
        }
        if ($this->isColumnModified(PublicationTableMap::COL_PICTURE_SIGNATURE)) {
            $criteria->add(PublicationTableMap::COL_PICTURE_SIGNATURE, $this->picture_signature);
        }
        if ($this->isColumnModified(PublicationTableMap::COL_ANONS)) {
            $criteria->add(PublicationTableMap::COL_ANONS, $this->anons);
        }
        if ($this->isColumnModified(PublicationTableMap::COL_CONTENT)) {
            $criteria->add(PublicationTableMap::COL_CONTENT, $this->content);
        }
        if ($this->isColumnModified(PublicationTableMap::COL_META_TITLE)) {
            $criteria->add(PublicationTableMap::COL_META_TITLE, $this->meta_title);
        }
        if ($this->isColumnModified(PublicationTableMap::COL_META_AUTHOR)) {
            $criteria->add(PublicationTableMap::COL_META_AUTHOR, $this->meta_author);
        }
        if ($this->isColumnModified(PublicationTableMap::COL_META_KEYWORDS)) {
            $criteria->add(PublicationTableMap::COL_META_KEYWORDS, $this->meta_keywords);
        }
        if ($this->isColumnModified(PublicationTableMap::COL_META_DESCRIPTION)) {
            $criteria->add(PublicationTableMap::COL_META_DESCRIPTION, $this->meta_description);
        }
        if ($this->isColumnModified(PublicationTableMap::COL_META_CANONICAL)) {
            $criteria->add(PublicationTableMap::COL_META_CANONICAL, $this->meta_canonical);
        }
        if ($this->isColumnModified(PublicationTableMap::COL_META_ROBOTS)) {
            $criteria->add(PublicationTableMap::COL_META_ROBOTS, $this->meta_robots);
        }
        if ($this->isColumnModified(PublicationTableMap::COL_CREATED_AT)) {
            $criteria->add(PublicationTableMap::COL_CREATED_AT, $this->created_at);
        }
        if ($this->isColumnModified(PublicationTableMap::COL_CREATED_BY)) {
            $criteria->add(PublicationTableMap::COL_CREATED_BY, $this->created_by);
        }
        if ($this->isColumnModified(PublicationTableMap::COL_UPDATED_AT)) {
            $criteria->add(PublicationTableMap::COL_UPDATED_AT, $this->updated_at);
        }
        if ($this->isColumnModified(PublicationTableMap::COL_UPDATED_BY)) {
            $criteria->add(PublicationTableMap::COL_UPDATED_BY, $this->updated_by);
        }
        if ($this->isColumnModified(PublicationTableMap::COL_SHOW_AT)) {
            $criteria->add(PublicationTableMap::COL_SHOW_AT, $this->show_at);
        }
        if ($this->isColumnModified(PublicationTableMap::COL_HIDE_AT)) {
            $criteria->add(PublicationTableMap::COL_HIDE_AT, $this->hide_at);
        }
        if ($this->isColumnModified(PublicationTableMap::COL_HITS)) {
            $criteria->add(PublicationTableMap::COL_HITS, $this->hits);
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
        $criteria = ChildPublicationQuery::create();
        $criteria->add(PublicationTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \Propel\Models\Publication (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setSectionId($this->getSectionId());
        $copyObj->setCode($this->getCode());
        $copyObj->setHeader($this->getHeader());
        $copyObj->setPicture($this->getPicture());
        $copyObj->setPictureSource($this->getPictureSource());
        $copyObj->setPictureSignature($this->getPictureSignature());
        $copyObj->setAnons($this->getAnons());
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
        $copyObj->setShowAt($this->getShowAt());
        $copyObj->setHideAt($this->getHideAt());
        $copyObj->setHits($this->getHits());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getComments() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addComment($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPublicationFields() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPublicationField($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPublicationPhotos() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPublicationPhoto($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPublicationRelations() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPublicationRelation($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPublicationTags() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPublicationTag($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getUserFavorites() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addUserFavorite($relObj->copy($deepCopy));
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
     * @return \Propel\Models\Publication Clone of current object.
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
     * @return $this|\Propel\Models\Publication The current object (for fluent API support)
     * @throws PropelException
     */
    public function setSection(ChildSection $v = null)
    {
        if ($v === null) {
            $this->setSectionId(NULL);
        } else {
            $this->setSectionId($v->getId());
        }

        $this->aSection = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildSection object, it will not be re-added.
        if ($v !== null) {
            $v->addPublication($this);
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
    public function getSection(ConnectionInterface $con = null)
    {
        if ($this->aSection === null && ($this->section_id != 0)) {
            $this->aSection = ChildSectionQuery::create()->findPk($this->section_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aSection->addPublications($this);
             */
        }

        return $this->aSection;
    }

    /**
     * Declares an association between this object and a ChildUser object.
     *
     * @param  ChildUser $v
     * @return $this|\Propel\Models\Publication The current object (for fluent API support)
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
            $v->addPublicationRelatedByCreatedBy($this);
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
                $this->aUserRelatedByCreatedBy->addPublicationsRelatedByCreatedBy($this);
             */
        }

        return $this->aUserRelatedByCreatedBy;
    }

    /**
     * Declares an association between this object and a ChildUser object.
     *
     * @param  ChildUser $v
     * @return $this|\Propel\Models\Publication The current object (for fluent API support)
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
            $v->addPublicationRelatedByUpdatedBy($this);
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
                $this->aUserRelatedByUpdatedBy->addPublicationsRelatedByUpdatedBy($this);
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
        if ('Comment' == $relationName) {
            $this->initComments();
            return;
        }
        if ('PublicationField' == $relationName) {
            $this->initPublicationFields();
            return;
        }
        if ('PublicationPhoto' == $relationName) {
            $this->initPublicationPhotos();
            return;
        }
        if ('PublicationRelation' == $relationName) {
            $this->initPublicationRelations();
            return;
        }
        if ('PublicationTag' == $relationName) {
            $this->initPublicationTags();
            return;
        }
        if ('UserFavorite' == $relationName) {
            $this->initUserFavorites();
            return;
        }
    }

    /**
     * Clears out the collComments collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addComments()
     */
    public function clearComments()
    {
        $this->collComments = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collComments collection loaded partially.
     */
    public function resetPartialComments($v = true)
    {
        $this->collCommentsPartial = $v;
    }

    /**
     * Initializes the collComments collection.
     *
     * By default this just sets the collComments collection to an empty array (like clearcollComments());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initComments($overrideExisting = true)
    {
        if (null !== $this->collComments && !$overrideExisting) {
            return;
        }

        $collectionClassName = CommentTableMap::getTableMap()->getCollectionClassName();

        $this->collComments = new $collectionClassName;
        $this->collComments->setModel('\Propel\Models\Comment');
    }

    /**
     * Gets an array of ChildComment objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPublication is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildComment[] List of ChildComment objects
     * @throws PropelException
     */
    public function getComments(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collCommentsPartial && !$this->isNew();
        if (null === $this->collComments || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collComments) {
                // return empty collection
                $this->initComments();
            } else {
                $collComments = ChildCommentQuery::create(null, $criteria)
                    ->filterByPublication($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collCommentsPartial && count($collComments)) {
                        $this->initComments(false);

                        foreach ($collComments as $obj) {
                            if (false == $this->collComments->contains($obj)) {
                                $this->collComments->append($obj);
                            }
                        }

                        $this->collCommentsPartial = true;
                    }

                    return $collComments;
                }

                if ($partial && $this->collComments) {
                    foreach ($this->collComments as $obj) {
                        if ($obj->isNew()) {
                            $collComments[] = $obj;
                        }
                    }
                }

                $this->collComments = $collComments;
                $this->collCommentsPartial = false;
            }
        }

        return $this->collComments;
    }

    /**
     * Sets a collection of ChildComment objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $comments A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPublication The current object (for fluent API support)
     */
    public function setComments(Collection $comments, ConnectionInterface $con = null)
    {
        /** @var ChildComment[] $commentsToDelete */
        $commentsToDelete = $this->getComments(new Criteria(), $con)->diff($comments);


        $this->commentsScheduledForDeletion = $commentsToDelete;

        foreach ($commentsToDelete as $commentRemoved) {
            $commentRemoved->setPublication(null);
        }

        $this->collComments = null;
        foreach ($comments as $comment) {
            $this->addComment($comment);
        }

        $this->collComments = $comments;
        $this->collCommentsPartial = false;

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
    public function countComments(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collCommentsPartial && !$this->isNew();
        if (null === $this->collComments || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collComments) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getComments());
            }

            $query = ChildCommentQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPublication($this)
                ->count($con);
        }

        return count($this->collComments);
    }

    /**
     * Method called to associate a ChildComment object to this object
     * through the ChildComment foreign key attribute.
     *
     * @param  ChildComment $l ChildComment
     * @return $this|\Propel\Models\Publication The current object (for fluent API support)
     */
    public function addComment(ChildComment $l)
    {
        if ($this->collComments === null) {
            $this->initComments();
            $this->collCommentsPartial = true;
        }

        if (!$this->collComments->contains($l)) {
            $this->doAddComment($l);

            if ($this->commentsScheduledForDeletion and $this->commentsScheduledForDeletion->contains($l)) {
                $this->commentsScheduledForDeletion->remove($this->commentsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildComment $comment The ChildComment object to add.
     */
    protected function doAddComment(ChildComment $comment)
    {
        $this->collComments[]= $comment;
        $comment->setPublication($this);
    }

    /**
     * @param  ChildComment $comment The ChildComment object to remove.
     * @return $this|ChildPublication The current object (for fluent API support)
     */
    public function removeComment(ChildComment $comment)
    {
        if ($this->getComments()->contains($comment)) {
            $pos = $this->collComments->search($comment);
            $this->collComments->remove($pos);
            if (null === $this->commentsScheduledForDeletion) {
                $this->commentsScheduledForDeletion = clone $this->collComments;
                $this->commentsScheduledForDeletion->clear();
            }
            $this->commentsScheduledForDeletion[]= $comment;
            $comment->setPublication(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Publication is new, it will return
     * an empty collection; or if this Publication has previously
     * been saved, it will retrieve related Comments from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Publication.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildComment[] List of ChildComment objects
     */
    public function getCommentsJoinParent(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCommentQuery::create(null, $criteria);
        $query->joinWith('Parent', $joinBehavior);

        return $this->getComments($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Publication is new, it will return
     * an empty collection; or if this Publication has previously
     * been saved, it will retrieve related Comments from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Publication.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildComment[] List of ChildComment objects
     */
    public function getCommentsJoinUserRelatedByCreatedBy(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCommentQuery::create(null, $criteria);
        $query->joinWith('UserRelatedByCreatedBy', $joinBehavior);

        return $this->getComments($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Publication is new, it will return
     * an empty collection; or if this Publication has previously
     * been saved, it will retrieve related Comments from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Publication.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildComment[] List of ChildComment objects
     */
    public function getCommentsJoinUserRelatedByUpdatedBy(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCommentQuery::create(null, $criteria);
        $query->joinWith('UserRelatedByUpdatedBy', $joinBehavior);

        return $this->getComments($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Publication is new, it will return
     * an empty collection; or if this Publication has previously
     * been saved, it will retrieve related Comments from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Publication.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildComment[] List of ChildComment objects
     */
    public function getCommentsJoinUserRelatedByDeletedBy(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCommentQuery::create(null, $criteria);
        $query->joinWith('UserRelatedByDeletedBy', $joinBehavior);

        return $this->getComments($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Publication is new, it will return
     * an empty collection; or if this Publication has previously
     * been saved, it will retrieve related Comments from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Publication.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildComment[] List of ChildComment objects
     */
    public function getCommentsJoinUserRelatedByVerifiedBy(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCommentQuery::create(null, $criteria);
        $query->joinWith('UserRelatedByVerifiedBy', $joinBehavior);

        return $this->getComments($query, $con);
    }

    /**
     * Clears out the collPublicationFields collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPublicationFields()
     */
    public function clearPublicationFields()
    {
        $this->collPublicationFields = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPublicationFields collection loaded partially.
     */
    public function resetPartialPublicationFields($v = true)
    {
        $this->collPublicationFieldsPartial = $v;
    }

    /**
     * Initializes the collPublicationFields collection.
     *
     * By default this just sets the collPublicationFields collection to an empty array (like clearcollPublicationFields());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPublicationFields($overrideExisting = true)
    {
        if (null !== $this->collPublicationFields && !$overrideExisting) {
            return;
        }

        $collectionClassName = PublicationFieldTableMap::getTableMap()->getCollectionClassName();

        $this->collPublicationFields = new $collectionClassName;
        $this->collPublicationFields->setModel('\Propel\Models\PublicationField');
    }

    /**
     * Gets an array of ChildPublicationField objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPublication is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPublicationField[] List of ChildPublicationField objects
     * @throws PropelException
     */
    public function getPublicationFields(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPublicationFieldsPartial && !$this->isNew();
        if (null === $this->collPublicationFields || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPublicationFields) {
                // return empty collection
                $this->initPublicationFields();
            } else {
                $collPublicationFields = ChildPublicationFieldQuery::create(null, $criteria)
                    ->filterByPublication($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPublicationFieldsPartial && count($collPublicationFields)) {
                        $this->initPublicationFields(false);

                        foreach ($collPublicationFields as $obj) {
                            if (false == $this->collPublicationFields->contains($obj)) {
                                $this->collPublicationFields->append($obj);
                            }
                        }

                        $this->collPublicationFieldsPartial = true;
                    }

                    return $collPublicationFields;
                }

                if ($partial && $this->collPublicationFields) {
                    foreach ($this->collPublicationFields as $obj) {
                        if ($obj->isNew()) {
                            $collPublicationFields[] = $obj;
                        }
                    }
                }

                $this->collPublicationFields = $collPublicationFields;
                $this->collPublicationFieldsPartial = false;
            }
        }

        return $this->collPublicationFields;
    }

    /**
     * Sets a collection of ChildPublicationField objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $publicationFields A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPublication The current object (for fluent API support)
     */
    public function setPublicationFields(Collection $publicationFields, ConnectionInterface $con = null)
    {
        /** @var ChildPublicationField[] $publicationFieldsToDelete */
        $publicationFieldsToDelete = $this->getPublicationFields(new Criteria(), $con)->diff($publicationFields);


        $this->publicationFieldsScheduledForDeletion = $publicationFieldsToDelete;

        foreach ($publicationFieldsToDelete as $publicationFieldRemoved) {
            $publicationFieldRemoved->setPublication(null);
        }

        $this->collPublicationFields = null;
        foreach ($publicationFields as $publicationField) {
            $this->addPublicationField($publicationField);
        }

        $this->collPublicationFields = $publicationFields;
        $this->collPublicationFieldsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related PublicationField objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related PublicationField objects.
     * @throws PropelException
     */
    public function countPublicationFields(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPublicationFieldsPartial && !$this->isNew();
        if (null === $this->collPublicationFields || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPublicationFields) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPublicationFields());
            }

            $query = ChildPublicationFieldQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPublication($this)
                ->count($con);
        }

        return count($this->collPublicationFields);
    }

    /**
     * Method called to associate a ChildPublicationField object to this object
     * through the ChildPublicationField foreign key attribute.
     *
     * @param  ChildPublicationField $l ChildPublicationField
     * @return $this|\Propel\Models\Publication The current object (for fluent API support)
     */
    public function addPublicationField(ChildPublicationField $l)
    {
        if ($this->collPublicationFields === null) {
            $this->initPublicationFields();
            $this->collPublicationFieldsPartial = true;
        }

        if (!$this->collPublicationFields->contains($l)) {
            $this->doAddPublicationField($l);

            if ($this->publicationFieldsScheduledForDeletion and $this->publicationFieldsScheduledForDeletion->contains($l)) {
                $this->publicationFieldsScheduledForDeletion->remove($this->publicationFieldsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildPublicationField $publicationField The ChildPublicationField object to add.
     */
    protected function doAddPublicationField(ChildPublicationField $publicationField)
    {
        $this->collPublicationFields[]= $publicationField;
        $publicationField->setPublication($this);
    }

    /**
     * @param  ChildPublicationField $publicationField The ChildPublicationField object to remove.
     * @return $this|ChildPublication The current object (for fluent API support)
     */
    public function removePublicationField(ChildPublicationField $publicationField)
    {
        if ($this->getPublicationFields()->contains($publicationField)) {
            $pos = $this->collPublicationFields->search($publicationField);
            $this->collPublicationFields->remove($pos);
            if (null === $this->publicationFieldsScheduledForDeletion) {
                $this->publicationFieldsScheduledForDeletion = clone $this->collPublicationFields;
                $this->publicationFieldsScheduledForDeletion->clear();
            }
            $this->publicationFieldsScheduledForDeletion[]= $publicationField;
            $publicationField->setPublication(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Publication is new, it will return
     * an empty collection; or if this Publication has previously
     * been saved, it will retrieve related PublicationFields from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Publication.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPublicationField[] List of ChildPublicationField objects
     */
    public function getPublicationFieldsJoinSectionField(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPublicationFieldQuery::create(null, $criteria);
        $query->joinWith('SectionField', $joinBehavior);

        return $this->getPublicationFields($query, $con);
    }

    /**
     * Clears out the collPublicationPhotos collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPublicationPhotos()
     */
    public function clearPublicationPhotos()
    {
        $this->collPublicationPhotos = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPublicationPhotos collection loaded partially.
     */
    public function resetPartialPublicationPhotos($v = true)
    {
        $this->collPublicationPhotosPartial = $v;
    }

    /**
     * Initializes the collPublicationPhotos collection.
     *
     * By default this just sets the collPublicationPhotos collection to an empty array (like clearcollPublicationPhotos());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPublicationPhotos($overrideExisting = true)
    {
        if (null !== $this->collPublicationPhotos && !$overrideExisting) {
            return;
        }

        $collectionClassName = PublicationPhotoTableMap::getTableMap()->getCollectionClassName();

        $this->collPublicationPhotos = new $collectionClassName;
        $this->collPublicationPhotos->setModel('\Propel\Models\PublicationPhoto');
    }

    /**
     * Gets an array of ChildPublicationPhoto objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPublication is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPublicationPhoto[] List of ChildPublicationPhoto objects
     * @throws PropelException
     */
    public function getPublicationPhotos(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPublicationPhotosPartial && !$this->isNew();
        if (null === $this->collPublicationPhotos || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPublicationPhotos) {
                // return empty collection
                $this->initPublicationPhotos();
            } else {
                $collPublicationPhotos = ChildPublicationPhotoQuery::create(null, $criteria)
                    ->filterByPublication($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPublicationPhotosPartial && count($collPublicationPhotos)) {
                        $this->initPublicationPhotos(false);

                        foreach ($collPublicationPhotos as $obj) {
                            if (false == $this->collPublicationPhotos->contains($obj)) {
                                $this->collPublicationPhotos->append($obj);
                            }
                        }

                        $this->collPublicationPhotosPartial = true;
                    }

                    return $collPublicationPhotos;
                }

                if ($partial && $this->collPublicationPhotos) {
                    foreach ($this->collPublicationPhotos as $obj) {
                        if ($obj->isNew()) {
                            $collPublicationPhotos[] = $obj;
                        }
                    }
                }

                $this->collPublicationPhotos = $collPublicationPhotos;
                $this->collPublicationPhotosPartial = false;
            }
        }

        return $this->collPublicationPhotos;
    }

    /**
     * Sets a collection of ChildPublicationPhoto objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $publicationPhotos A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPublication The current object (for fluent API support)
     */
    public function setPublicationPhotos(Collection $publicationPhotos, ConnectionInterface $con = null)
    {
        /** @var ChildPublicationPhoto[] $publicationPhotosToDelete */
        $publicationPhotosToDelete = $this->getPublicationPhotos(new Criteria(), $con)->diff($publicationPhotos);


        $this->publicationPhotosScheduledForDeletion = $publicationPhotosToDelete;

        foreach ($publicationPhotosToDelete as $publicationPhotoRemoved) {
            $publicationPhotoRemoved->setPublication(null);
        }

        $this->collPublicationPhotos = null;
        foreach ($publicationPhotos as $publicationPhoto) {
            $this->addPublicationPhoto($publicationPhoto);
        }

        $this->collPublicationPhotos = $publicationPhotos;
        $this->collPublicationPhotosPartial = false;

        return $this;
    }

    /**
     * Returns the number of related PublicationPhoto objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related PublicationPhoto objects.
     * @throws PropelException
     */
    public function countPublicationPhotos(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPublicationPhotosPartial && !$this->isNew();
        if (null === $this->collPublicationPhotos || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPublicationPhotos) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPublicationPhotos());
            }

            $query = ChildPublicationPhotoQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPublication($this)
                ->count($con);
        }

        return count($this->collPublicationPhotos);
    }

    /**
     * Method called to associate a ChildPublicationPhoto object to this object
     * through the ChildPublicationPhoto foreign key attribute.
     *
     * @param  ChildPublicationPhoto $l ChildPublicationPhoto
     * @return $this|\Propel\Models\Publication The current object (for fluent API support)
     */
    public function addPublicationPhoto(ChildPublicationPhoto $l)
    {
        if ($this->collPublicationPhotos === null) {
            $this->initPublicationPhotos();
            $this->collPublicationPhotosPartial = true;
        }

        if (!$this->collPublicationPhotos->contains($l)) {
            $this->doAddPublicationPhoto($l);

            if ($this->publicationPhotosScheduledForDeletion and $this->publicationPhotosScheduledForDeletion->contains($l)) {
                $this->publicationPhotosScheduledForDeletion->remove($this->publicationPhotosScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildPublicationPhoto $publicationPhoto The ChildPublicationPhoto object to add.
     */
    protected function doAddPublicationPhoto(ChildPublicationPhoto $publicationPhoto)
    {
        $this->collPublicationPhotos[]= $publicationPhoto;
        $publicationPhoto->setPublication($this);
    }

    /**
     * @param  ChildPublicationPhoto $publicationPhoto The ChildPublicationPhoto object to remove.
     * @return $this|ChildPublication The current object (for fluent API support)
     */
    public function removePublicationPhoto(ChildPublicationPhoto $publicationPhoto)
    {
        if ($this->getPublicationPhotos()->contains($publicationPhoto)) {
            $pos = $this->collPublicationPhotos->search($publicationPhoto);
            $this->collPublicationPhotos->remove($pos);
            if (null === $this->publicationPhotosScheduledForDeletion) {
                $this->publicationPhotosScheduledForDeletion = clone $this->collPublicationPhotos;
                $this->publicationPhotosScheduledForDeletion->clear();
            }
            $this->publicationPhotosScheduledForDeletion[]= $publicationPhoto;
            $publicationPhoto->setPublication(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Publication is new, it will return
     * an empty collection; or if this Publication has previously
     * been saved, it will retrieve related PublicationPhotos from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Publication.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPublicationPhoto[] List of ChildPublicationPhoto objects
     */
    public function getPublicationPhotosJoinUserRelatedByCreatedBy(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPublicationPhotoQuery::create(null, $criteria);
        $query->joinWith('UserRelatedByCreatedBy', $joinBehavior);

        return $this->getPublicationPhotos($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Publication is new, it will return
     * an empty collection; or if this Publication has previously
     * been saved, it will retrieve related PublicationPhotos from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Publication.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPublicationPhoto[] List of ChildPublicationPhoto objects
     */
    public function getPublicationPhotosJoinUserRelatedByUpdatedBy(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPublicationPhotoQuery::create(null, $criteria);
        $query->joinWith('UserRelatedByUpdatedBy', $joinBehavior);

        return $this->getPublicationPhotos($query, $con);
    }

    /**
     * Clears out the collPublicationRelations collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPublicationRelations()
     */
    public function clearPublicationRelations()
    {
        $this->collPublicationRelations = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPublicationRelations collection loaded partially.
     */
    public function resetPartialPublicationRelations($v = true)
    {
        $this->collPublicationRelationsPartial = $v;
    }

    /**
     * Initializes the collPublicationRelations collection.
     *
     * By default this just sets the collPublicationRelations collection to an empty array (like clearcollPublicationRelations());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPublicationRelations($overrideExisting = true)
    {
        if (null !== $this->collPublicationRelations && !$overrideExisting) {
            return;
        }

        $collectionClassName = PublicationRelationTableMap::getTableMap()->getCollectionClassName();

        $this->collPublicationRelations = new $collectionClassName;
        $this->collPublicationRelations->setModel('\Propel\Models\PublicationRelation');
    }

    /**
     * Gets an array of ChildPublicationRelation objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPublication is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPublicationRelation[] List of ChildPublicationRelation objects
     * @throws PropelException
     */
    public function getPublicationRelations(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPublicationRelationsPartial && !$this->isNew();
        if (null === $this->collPublicationRelations || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPublicationRelations) {
                // return empty collection
                $this->initPublicationRelations();
            } else {
                $collPublicationRelations = ChildPublicationRelationQuery::create(null, $criteria)
                    ->filterByPublication($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPublicationRelationsPartial && count($collPublicationRelations)) {
                        $this->initPublicationRelations(false);

                        foreach ($collPublicationRelations as $obj) {
                            if (false == $this->collPublicationRelations->contains($obj)) {
                                $this->collPublicationRelations->append($obj);
                            }
                        }

                        $this->collPublicationRelationsPartial = true;
                    }

                    return $collPublicationRelations;
                }

                if ($partial && $this->collPublicationRelations) {
                    foreach ($this->collPublicationRelations as $obj) {
                        if ($obj->isNew()) {
                            $collPublicationRelations[] = $obj;
                        }
                    }
                }

                $this->collPublicationRelations = $collPublicationRelations;
                $this->collPublicationRelationsPartial = false;
            }
        }

        return $this->collPublicationRelations;
    }

    /**
     * Sets a collection of ChildPublicationRelation objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $publicationRelations A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPublication The current object (for fluent API support)
     */
    public function setPublicationRelations(Collection $publicationRelations, ConnectionInterface $con = null)
    {
        /** @var ChildPublicationRelation[] $publicationRelationsToDelete */
        $publicationRelationsToDelete = $this->getPublicationRelations(new Criteria(), $con)->diff($publicationRelations);


        $this->publicationRelationsScheduledForDeletion = $publicationRelationsToDelete;

        foreach ($publicationRelationsToDelete as $publicationRelationRemoved) {
            $publicationRelationRemoved->setPublication(null);
        }

        $this->collPublicationRelations = null;
        foreach ($publicationRelations as $publicationRelation) {
            $this->addPublicationRelation($publicationRelation);
        }

        $this->collPublicationRelations = $publicationRelations;
        $this->collPublicationRelationsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related PublicationRelation objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related PublicationRelation objects.
     * @throws PropelException
     */
    public function countPublicationRelations(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPublicationRelationsPartial && !$this->isNew();
        if (null === $this->collPublicationRelations || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPublicationRelations) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPublicationRelations());
            }

            $query = ChildPublicationRelationQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPublication($this)
                ->count($con);
        }

        return count($this->collPublicationRelations);
    }

    /**
     * Method called to associate a ChildPublicationRelation object to this object
     * through the ChildPublicationRelation foreign key attribute.
     *
     * @param  ChildPublicationRelation $l ChildPublicationRelation
     * @return $this|\Propel\Models\Publication The current object (for fluent API support)
     */
    public function addPublicationRelation(ChildPublicationRelation $l)
    {
        if ($this->collPublicationRelations === null) {
            $this->initPublicationRelations();
            $this->collPublicationRelationsPartial = true;
        }

        if (!$this->collPublicationRelations->contains($l)) {
            $this->doAddPublicationRelation($l);

            if ($this->publicationRelationsScheduledForDeletion and $this->publicationRelationsScheduledForDeletion->contains($l)) {
                $this->publicationRelationsScheduledForDeletion->remove($this->publicationRelationsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildPublicationRelation $publicationRelation The ChildPublicationRelation object to add.
     */
    protected function doAddPublicationRelation(ChildPublicationRelation $publicationRelation)
    {
        $this->collPublicationRelations[]= $publicationRelation;
        $publicationRelation->setPublication($this);
    }

    /**
     * @param  ChildPublicationRelation $publicationRelation The ChildPublicationRelation object to remove.
     * @return $this|ChildPublication The current object (for fluent API support)
     */
    public function removePublicationRelation(ChildPublicationRelation $publicationRelation)
    {
        if ($this->getPublicationRelations()->contains($publicationRelation)) {
            $pos = $this->collPublicationRelations->search($publicationRelation);
            $this->collPublicationRelations->remove($pos);
            if (null === $this->publicationRelationsScheduledForDeletion) {
                $this->publicationRelationsScheduledForDeletion = clone $this->collPublicationRelations;
                $this->publicationRelationsScheduledForDeletion->clear();
            }
            $this->publicationRelationsScheduledForDeletion[]= $publicationRelation;
            $publicationRelation->setPublication(null);
        }

        return $this;
    }

    /**
     * Clears out the collPublicationTags collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPublicationTags()
     */
    public function clearPublicationTags()
    {
        $this->collPublicationTags = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPublicationTags collection loaded partially.
     */
    public function resetPartialPublicationTags($v = true)
    {
        $this->collPublicationTagsPartial = $v;
    }

    /**
     * Initializes the collPublicationTags collection.
     *
     * By default this just sets the collPublicationTags collection to an empty array (like clearcollPublicationTags());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPublicationTags($overrideExisting = true)
    {
        if (null !== $this->collPublicationTags && !$overrideExisting) {
            return;
        }

        $collectionClassName = PublicationTagTableMap::getTableMap()->getCollectionClassName();

        $this->collPublicationTags = new $collectionClassName;
        $this->collPublicationTags->setModel('\Propel\Models\PublicationTag');
    }

    /**
     * Gets an array of ChildPublicationTag objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPublication is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPublicationTag[] List of ChildPublicationTag objects
     * @throws PropelException
     */
    public function getPublicationTags(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPublicationTagsPartial && !$this->isNew();
        if (null === $this->collPublicationTags || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPublicationTags) {
                // return empty collection
                $this->initPublicationTags();
            } else {
                $collPublicationTags = ChildPublicationTagQuery::create(null, $criteria)
                    ->filterByPublication($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPublicationTagsPartial && count($collPublicationTags)) {
                        $this->initPublicationTags(false);

                        foreach ($collPublicationTags as $obj) {
                            if (false == $this->collPublicationTags->contains($obj)) {
                                $this->collPublicationTags->append($obj);
                            }
                        }

                        $this->collPublicationTagsPartial = true;
                    }

                    return $collPublicationTags;
                }

                if ($partial && $this->collPublicationTags) {
                    foreach ($this->collPublicationTags as $obj) {
                        if ($obj->isNew()) {
                            $collPublicationTags[] = $obj;
                        }
                    }
                }

                $this->collPublicationTags = $collPublicationTags;
                $this->collPublicationTagsPartial = false;
            }
        }

        return $this->collPublicationTags;
    }

    /**
     * Sets a collection of ChildPublicationTag objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $publicationTags A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPublication The current object (for fluent API support)
     */
    public function setPublicationTags(Collection $publicationTags, ConnectionInterface $con = null)
    {
        /** @var ChildPublicationTag[] $publicationTagsToDelete */
        $publicationTagsToDelete = $this->getPublicationTags(new Criteria(), $con)->diff($publicationTags);


        $this->publicationTagsScheduledForDeletion = $publicationTagsToDelete;

        foreach ($publicationTagsToDelete as $publicationTagRemoved) {
            $publicationTagRemoved->setPublication(null);
        }

        $this->collPublicationTags = null;
        foreach ($publicationTags as $publicationTag) {
            $this->addPublicationTag($publicationTag);
        }

        $this->collPublicationTags = $publicationTags;
        $this->collPublicationTagsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related PublicationTag objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related PublicationTag objects.
     * @throws PropelException
     */
    public function countPublicationTags(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPublicationTagsPartial && !$this->isNew();
        if (null === $this->collPublicationTags || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPublicationTags) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPublicationTags());
            }

            $query = ChildPublicationTagQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPublication($this)
                ->count($con);
        }

        return count($this->collPublicationTags);
    }

    /**
     * Method called to associate a ChildPublicationTag object to this object
     * through the ChildPublicationTag foreign key attribute.
     *
     * @param  ChildPublicationTag $l ChildPublicationTag
     * @return $this|\Propel\Models\Publication The current object (for fluent API support)
     */
    public function addPublicationTag(ChildPublicationTag $l)
    {
        if ($this->collPublicationTags === null) {
            $this->initPublicationTags();
            $this->collPublicationTagsPartial = true;
        }

        if (!$this->collPublicationTags->contains($l)) {
            $this->doAddPublicationTag($l);

            if ($this->publicationTagsScheduledForDeletion and $this->publicationTagsScheduledForDeletion->contains($l)) {
                $this->publicationTagsScheduledForDeletion->remove($this->publicationTagsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildPublicationTag $publicationTag The ChildPublicationTag object to add.
     */
    protected function doAddPublicationTag(ChildPublicationTag $publicationTag)
    {
        $this->collPublicationTags[]= $publicationTag;
        $publicationTag->setPublication($this);
    }

    /**
     * @param  ChildPublicationTag $publicationTag The ChildPublicationTag object to remove.
     * @return $this|ChildPublication The current object (for fluent API support)
     */
    public function removePublicationTag(ChildPublicationTag $publicationTag)
    {
        if ($this->getPublicationTags()->contains($publicationTag)) {
            $pos = $this->collPublicationTags->search($publicationTag);
            $this->collPublicationTags->remove($pos);
            if (null === $this->publicationTagsScheduledForDeletion) {
                $this->publicationTagsScheduledForDeletion = clone $this->collPublicationTags;
                $this->publicationTagsScheduledForDeletion->clear();
            }
            $this->publicationTagsScheduledForDeletion[]= $publicationTag;
            $publicationTag->setPublication(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Publication is new, it will return
     * an empty collection; or if this Publication has previously
     * been saved, it will retrieve related PublicationTags from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Publication.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPublicationTag[] List of ChildPublicationTag objects
     */
    public function getPublicationTagsJoinTag(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPublicationTagQuery::create(null, $criteria);
        $query->joinWith('Tag', $joinBehavior);

        return $this->getPublicationTags($query, $con);
    }

    /**
     * Clears out the collUserFavorites collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addUserFavorites()
     */
    public function clearUserFavorites()
    {
        $this->collUserFavorites = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collUserFavorites collection loaded partially.
     */
    public function resetPartialUserFavorites($v = true)
    {
        $this->collUserFavoritesPartial = $v;
    }

    /**
     * Initializes the collUserFavorites collection.
     *
     * By default this just sets the collUserFavorites collection to an empty array (like clearcollUserFavorites());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initUserFavorites($overrideExisting = true)
    {
        if (null !== $this->collUserFavorites && !$overrideExisting) {
            return;
        }

        $collectionClassName = UserFavoriteTableMap::getTableMap()->getCollectionClassName();

        $this->collUserFavorites = new $collectionClassName;
        $this->collUserFavorites->setModel('\Propel\Models\UserFavorite');
    }

    /**
     * Gets an array of ChildUserFavorite objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPublication is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildUserFavorite[] List of ChildUserFavorite objects
     * @throws PropelException
     */
    public function getUserFavorites(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collUserFavoritesPartial && !$this->isNew();
        if (null === $this->collUserFavorites || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collUserFavorites) {
                // return empty collection
                $this->initUserFavorites();
            } else {
                $collUserFavorites = ChildUserFavoriteQuery::create(null, $criteria)
                    ->filterByPublication($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collUserFavoritesPartial && count($collUserFavorites)) {
                        $this->initUserFavorites(false);

                        foreach ($collUserFavorites as $obj) {
                            if (false == $this->collUserFavorites->contains($obj)) {
                                $this->collUserFavorites->append($obj);
                            }
                        }

                        $this->collUserFavoritesPartial = true;
                    }

                    return $collUserFavorites;
                }

                if ($partial && $this->collUserFavorites) {
                    foreach ($this->collUserFavorites as $obj) {
                        if ($obj->isNew()) {
                            $collUserFavorites[] = $obj;
                        }
                    }
                }

                $this->collUserFavorites = $collUserFavorites;
                $this->collUserFavoritesPartial = false;
            }
        }

        return $this->collUserFavorites;
    }

    /**
     * Sets a collection of ChildUserFavorite objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $userFavorites A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPublication The current object (for fluent API support)
     */
    public function setUserFavorites(Collection $userFavorites, ConnectionInterface $con = null)
    {
        /** @var ChildUserFavorite[] $userFavoritesToDelete */
        $userFavoritesToDelete = $this->getUserFavorites(new Criteria(), $con)->diff($userFavorites);


        $this->userFavoritesScheduledForDeletion = $userFavoritesToDelete;

        foreach ($userFavoritesToDelete as $userFavoriteRemoved) {
            $userFavoriteRemoved->setPublication(null);
        }

        $this->collUserFavorites = null;
        foreach ($userFavorites as $userFavorite) {
            $this->addUserFavorite($userFavorite);
        }

        $this->collUserFavorites = $userFavorites;
        $this->collUserFavoritesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related UserFavorite objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related UserFavorite objects.
     * @throws PropelException
     */
    public function countUserFavorites(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collUserFavoritesPartial && !$this->isNew();
        if (null === $this->collUserFavorites || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collUserFavorites) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getUserFavorites());
            }

            $query = ChildUserFavoriteQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPublication($this)
                ->count($con);
        }

        return count($this->collUserFavorites);
    }

    /**
     * Method called to associate a ChildUserFavorite object to this object
     * through the ChildUserFavorite foreign key attribute.
     *
     * @param  ChildUserFavorite $l ChildUserFavorite
     * @return $this|\Propel\Models\Publication The current object (for fluent API support)
     */
    public function addUserFavorite(ChildUserFavorite $l)
    {
        if ($this->collUserFavorites === null) {
            $this->initUserFavorites();
            $this->collUserFavoritesPartial = true;
        }

        if (!$this->collUserFavorites->contains($l)) {
            $this->doAddUserFavorite($l);

            if ($this->userFavoritesScheduledForDeletion and $this->userFavoritesScheduledForDeletion->contains($l)) {
                $this->userFavoritesScheduledForDeletion->remove($this->userFavoritesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildUserFavorite $userFavorite The ChildUserFavorite object to add.
     */
    protected function doAddUserFavorite(ChildUserFavorite $userFavorite)
    {
        $this->collUserFavorites[]= $userFavorite;
        $userFavorite->setPublication($this);
    }

    /**
     * @param  ChildUserFavorite $userFavorite The ChildUserFavorite object to remove.
     * @return $this|ChildPublication The current object (for fluent API support)
     */
    public function removeUserFavorite(ChildUserFavorite $userFavorite)
    {
        if ($this->getUserFavorites()->contains($userFavorite)) {
            $pos = $this->collUserFavorites->search($userFavorite);
            $this->collUserFavorites->remove($pos);
            if (null === $this->userFavoritesScheduledForDeletion) {
                $this->userFavoritesScheduledForDeletion = clone $this->collUserFavorites;
                $this->userFavoritesScheduledForDeletion->clear();
            }
            $this->userFavoritesScheduledForDeletion[]= $userFavorite;
            $userFavorite->setPublication(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Publication is new, it will return
     * an empty collection; or if this Publication has previously
     * been saved, it will retrieve related UserFavorites from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Publication.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildUserFavorite[] List of ChildUserFavorite objects
     */
    public function getUserFavoritesJoinUser(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildUserFavoriteQuery::create(null, $criteria);
        $query->joinWith('User', $joinBehavior);

        return $this->getUserFavorites($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aSection) {
            $this->aSection->removePublication($this);
        }
        if (null !== $this->aUserRelatedByCreatedBy) {
            $this->aUserRelatedByCreatedBy->removePublicationRelatedByCreatedBy($this);
        }
        if (null !== $this->aUserRelatedByUpdatedBy) {
            $this->aUserRelatedByUpdatedBy->removePublicationRelatedByUpdatedBy($this);
        }
        $this->id = null;
        $this->section_id = null;
        $this->code = null;
        $this->header = null;
        $this->picture = null;
        $this->picture_source = null;
        $this->picture_signature = null;
        $this->anons = null;
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
        $this->show_at = null;
        $this->hide_at = null;
        $this->hits = null;
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
            if ($this->collComments) {
                foreach ($this->collComments as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPublicationFields) {
                foreach ($this->collPublicationFields as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPublicationPhotos) {
                foreach ($this->collPublicationPhotos as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPublicationRelations) {
                foreach ($this->collPublicationRelations as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPublicationTags) {
                foreach ($this->collPublicationTags as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collUserFavorites) {
                foreach ($this->collUserFavorites as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collComments = null;
        $this->collPublicationFields = null;
        $this->collPublicationPhotos = null;
        $this->collPublicationRelations = null;
        $this->collPublicationTags = null;
        $this->collUserFavorites = null;
        $this->aSection = null;
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
        fenric('event::model.publication.validate')->run([func_get_arg(0), \Propel\Runtime\Propel::getServiceContainer()->getWriteConnection(PublicationTableMap::DATABASE_NAME)]);

        $metadata->addPropertyConstraint('section_id', new NotBlank());
        $metadata->addPropertyConstraint('code', new NotBlank());
        $metadata->addPropertyConstraint('code', new Length(array ('max' => 255,)));
        $metadata->addPropertyConstraint('code', new Regex(array ('pattern' => '/^[a-z0-9-]+$/',)));
        $metadata->addPropertyConstraint('code', new Unique());
        $metadata->addPropertyConstraint('header', new NotBlank());
        $metadata->addPropertyConstraint('header', new Length(array ('max' => 255,)));
        $metadata->addPropertyConstraint('anons', new NotBlank());
        $metadata->addPropertyConstraint('show_at', new NotBlank());
        $metadata->addPropertyConstraint('show_at', new Date());
        $metadata->addPropertyConstraint('hide_at', new Date());
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
            if (method_exists($this->aSection, 'validate')) {
                if (!$this->aSection->validate($validator)) {
                    $failureMap->addAll($this->aSection->getValidationFailures());
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

            if (null !== $this->collComments) {
                foreach ($this->collComments as $referrerFK) {
                    if (method_exists($referrerFK, 'validate')) {
                        if (!$referrerFK->validate($validator)) {
                            $failureMap->addAll($referrerFK->getValidationFailures());
                        }
                    }
                }
            }
            if (null !== $this->collPublicationFields) {
                foreach ($this->collPublicationFields as $referrerFK) {
                    if (method_exists($referrerFK, 'validate')) {
                        if (!$referrerFK->validate($validator)) {
                            $failureMap->addAll($referrerFK->getValidationFailures());
                        }
                    }
                }
            }
            if (null !== $this->collPublicationPhotos) {
                foreach ($this->collPublicationPhotos as $referrerFK) {
                    if (method_exists($referrerFK, 'validate')) {
                        if (!$referrerFK->validate($validator)) {
                            $failureMap->addAll($referrerFK->getValidationFailures());
                        }
                    }
                }
            }
            if (null !== $this->collPublicationRelations) {
                foreach ($this->collPublicationRelations as $referrerFK) {
                    if (method_exists($referrerFK, 'validate')) {
                        if (!$referrerFK->validate($validator)) {
                            $failureMap->addAll($referrerFK->getValidationFailures());
                        }
                    }
                }
            }
            if (null !== $this->collPublicationTags) {
                foreach ($this->collPublicationTags as $referrerFK) {
                    if (method_exists($referrerFK, 'validate')) {
                        if (!$referrerFK->validate($validator)) {
                            $failureMap->addAll($referrerFK->getValidationFailures());
                        }
                    }
                }
            }
            if (null !== $this->collUserFavorites) {
                foreach ($this->collUserFavorites as $referrerFK) {
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
