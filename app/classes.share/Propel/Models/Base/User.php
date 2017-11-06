<?php

namespace Propel\Models\Base;

use \DateTime;
use \Exception;
use \PDO;
use Propel\Models\Banner as ChildBanner;
use Propel\Models\BannerClient as ChildBannerClient;
use Propel\Models\BannerClientQuery as ChildBannerClientQuery;
use Propel\Models\BannerGroup as ChildBannerGroup;
use Propel\Models\BannerGroupQuery as ChildBannerGroupQuery;
use Propel\Models\BannerQuery as ChildBannerQuery;
use Propel\Models\Comment as ChildComment;
use Propel\Models\CommentQuery as ChildCommentQuery;
use Propel\Models\Field as ChildField;
use Propel\Models\FieldQuery as ChildFieldQuery;
use Propel\Models\Poll as ChildPoll;
use Propel\Models\PollQuery as ChildPollQuery;
use Propel\Models\PollVariant as ChildPollVariant;
use Propel\Models\PollVariantQuery as ChildPollVariantQuery;
use Propel\Models\Publication as ChildPublication;
use Propel\Models\PublicationPhoto as ChildPublicationPhoto;
use Propel\Models\PublicationPhotoQuery as ChildPublicationPhotoQuery;
use Propel\Models\PublicationQuery as ChildPublicationQuery;
use Propel\Models\Radio as ChildRadio;
use Propel\Models\RadioQuery as ChildRadioQuery;
use Propel\Models\Section as ChildSection;
use Propel\Models\SectionQuery as ChildSectionQuery;
use Propel\Models\Snippet as ChildSnippet;
use Propel\Models\SnippetQuery as ChildSnippetQuery;
use Propel\Models\Tag as ChildTag;
use Propel\Models\TagQuery as ChildTagQuery;
use Propel\Models\User as ChildUser;
use Propel\Models\UserFavorite as ChildUserFavorite;
use Propel\Models\UserFavoriteQuery as ChildUserFavoriteQuery;
use Propel\Models\UserQuery as ChildUserQuery;
use Propel\Models\Map\BannerClientTableMap;
use Propel\Models\Map\BannerGroupTableMap;
use Propel\Models\Map\BannerTableMap;
use Propel\Models\Map\CommentTableMap;
use Propel\Models\Map\FieldTableMap;
use Propel\Models\Map\PollTableMap;
use Propel\Models\Map\PollVariantTableMap;
use Propel\Models\Map\PublicationPhotoTableMap;
use Propel\Models\Map\PublicationTableMap;
use Propel\Models\Map\RadioTableMap;
use Propel\Models\Map\SectionTableMap;
use Propel\Models\Map\SnippetTableMap;
use Propel\Models\Map\TagTableMap;
use Propel\Models\Map\UserFavoriteTableMap;
use Propel\Models\Map\UserTableMap;
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
use Symfony\Component\Validator\Constraints\Email;
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
 * Base class that represents a row from the 'fenric_user' table.
 *
 *
 *
 * @package    propel.generator.Propel.Models.Base
 */
abstract class User implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Propel\\Models\\Map\\UserTableMap';


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
     * The value for the role field.
     *
     * Note: this column has a database default value of: 'user'
     * @var        string
     */
    protected $role;

    /**
     * The value for the email field.
     *
     * @var        string
     */
    protected $email;

    /**
     * The value for the username field.
     *
     * @var        string
     */
    protected $username;

    /**
     * The value for the password field.
     *
     * @var        string
     */
    protected $password;

    /**
     * Whether the lazy-loaded $password value has been loaded from database.
     * This is necessary to avoid repeated lookups if $password column is NULL in the db.
     * @var boolean
     */
    protected $password_isLoaded = false;

    /**
     * The value for the photo field.
     *
     * @var        string
     */
    protected $photo;

    /**
     * The value for the firstname field.
     *
     * @var        string
     */
    protected $firstname;

    /**
     * The value for the lastname field.
     *
     * @var        string
     */
    protected $lastname;

    /**
     * The value for the gender field.
     *
     * @var        string
     */
    protected $gender;

    /**
     * The value for the birthday field.
     *
     * @var        DateTime
     */
    protected $birthday;

    /**
     * The value for the about field.
     *
     * @var        string
     */
    protected $about;

    /**
     * Whether the lazy-loaded $about value has been loaded from database.
     * This is necessary to avoid repeated lookups if $about column is NULL in the db.
     * @var boolean
     */
    protected $about_isLoaded = false;

    /**
     * The value for the params field.
     *
     * @var        string
     */
    protected $params;

    /**
     * Whether the lazy-loaded $params value has been loaded from database.
     * This is necessary to avoid repeated lookups if $params column is NULL in the db.
     * @var boolean
     */
    protected $params_isLoaded = false;

    /**
     * The value for the registration_at field.
     *
     * @var        DateTime
     */
    protected $registration_at;

    /**
     * The value for the registration_ip field.
     *
     * @var        string
     */
    protected $registration_ip;

    /**
     * The value for the registration_confirmed field.
     *
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $registration_confirmed;

    /**
     * The value for the registration_confirmed_at field.
     *
     * @var        DateTime
     */
    protected $registration_confirmed_at;

    /**
     * The value for the registration_confirmed_ip field.
     *
     * @var        string
     */
    protected $registration_confirmed_ip;

    /**
     * The value for the registration_confirmation_code field.
     *
     * @var        string
     */
    protected $registration_confirmation_code;

    /**
     * Whether the lazy-loaded $registration_confirmation_code value has been loaded from database.
     * This is necessary to avoid repeated lookups if $registration_confirmation_code column is NULL in the db.
     * @var boolean
     */
    protected $registration_confirmation_code_isLoaded = false;

    /**
     * The value for the authentication_at field.
     *
     * @var        DateTime
     */
    protected $authentication_at;

    /**
     * The value for the authentication_ip field.
     *
     * @var        string
     */
    protected $authentication_ip;

    /**
     * The value for the authentication_key field.
     *
     * @var        string
     */
    protected $authentication_key;

    /**
     * Whether the lazy-loaded $authentication_key value has been loaded from database.
     * This is necessary to avoid repeated lookups if $authentication_key column is NULL in the db.
     * @var boolean
     */
    protected $authentication_key_isLoaded = false;

    /**
     * The value for the authentication_token field.
     *
     * @var        string
     */
    protected $authentication_token;

    /**
     * Whether the lazy-loaded $authentication_token value has been loaded from database.
     * This is necessary to avoid repeated lookups if $authentication_token column is NULL in the db.
     * @var boolean
     */
    protected $authentication_token_isLoaded = false;

    /**
     * The value for the authentication_token_at field.
     *
     * @var        DateTime
     */
    protected $authentication_token_at;

    /**
     * The value for the authentication_token_ip field.
     *
     * @var        string
     */
    protected $authentication_token_ip;

    /**
     * The value for the authentication_attempt_count field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $authentication_attempt_count;

    /**
     * The value for the track_at field.
     *
     * @var        DateTime
     */
    protected $track_at;

    /**
     * The value for the track_ip field.
     *
     * @var        string
     */
    protected $track_ip;

    /**
     * The value for the track_url field.
     *
     * @var        string
     */
    protected $track_url;

    /**
     * The value for the ban_from field.
     *
     * @var        DateTime
     */
    protected $ban_from;

    /**
     * The value for the ban_until field.
     *
     * @var        DateTime
     */
    protected $ban_until;

    /**
     * The value for the ban_reason field.
     *
     * @var        string
     */
    protected $ban_reason;

    /**
     * @var        ObjectCollection|ChildBanner[] Collection to store aggregation of ChildBanner objects.
     */
    protected $collBannersRelatedByCreatedBy;
    protected $collBannersRelatedByCreatedByPartial;

    /**
     * @var        ObjectCollection|ChildBanner[] Collection to store aggregation of ChildBanner objects.
     */
    protected $collBannersRelatedByUpdatedBy;
    protected $collBannersRelatedByUpdatedByPartial;

    /**
     * @var        ObjectCollection|ChildBannerGroup[] Collection to store aggregation of ChildBannerGroup objects.
     */
    protected $collBannerGroupsRelatedByCreatedBy;
    protected $collBannerGroupsRelatedByCreatedByPartial;

    /**
     * @var        ObjectCollection|ChildBannerGroup[] Collection to store aggregation of ChildBannerGroup objects.
     */
    protected $collBannerGroupsRelatedByUpdatedBy;
    protected $collBannerGroupsRelatedByUpdatedByPartial;

    /**
     * @var        ObjectCollection|ChildBannerClient[] Collection to store aggregation of ChildBannerClient objects.
     */
    protected $collBannerClientsRelatedByCreatedBy;
    protected $collBannerClientsRelatedByCreatedByPartial;

    /**
     * @var        ObjectCollection|ChildBannerClient[] Collection to store aggregation of ChildBannerClient objects.
     */
    protected $collBannerClientsRelatedByUpdatedBy;
    protected $collBannerClientsRelatedByUpdatedByPartial;

    /**
     * @var        ObjectCollection|ChildComment[] Collection to store aggregation of ChildComment objects.
     */
    protected $collCommentsRelatedByCreatedBy;
    protected $collCommentsRelatedByCreatedByPartial;

    /**
     * @var        ObjectCollection|ChildComment[] Collection to store aggregation of ChildComment objects.
     */
    protected $collCommentsRelatedByUpdatedBy;
    protected $collCommentsRelatedByUpdatedByPartial;

    /**
     * @var        ObjectCollection|ChildComment[] Collection to store aggregation of ChildComment objects.
     */
    protected $collCommentsRelatedByDeletedBy;
    protected $collCommentsRelatedByDeletedByPartial;

    /**
     * @var        ObjectCollection|ChildField[] Collection to store aggregation of ChildField objects.
     */
    protected $collFieldsRelatedByCreatedBy;
    protected $collFieldsRelatedByCreatedByPartial;

    /**
     * @var        ObjectCollection|ChildField[] Collection to store aggregation of ChildField objects.
     */
    protected $collFieldsRelatedByUpdatedBy;
    protected $collFieldsRelatedByUpdatedByPartial;

    /**
     * @var        ObjectCollection|ChildPoll[] Collection to store aggregation of ChildPoll objects.
     */
    protected $collPollsRelatedByCreatedBy;
    protected $collPollsRelatedByCreatedByPartial;

    /**
     * @var        ObjectCollection|ChildPoll[] Collection to store aggregation of ChildPoll objects.
     */
    protected $collPollsRelatedByUpdatedBy;
    protected $collPollsRelatedByUpdatedByPartial;

    /**
     * @var        ObjectCollection|ChildPollVariant[] Collection to store aggregation of ChildPollVariant objects.
     */
    protected $collPollVariantsRelatedByCreatedBy;
    protected $collPollVariantsRelatedByCreatedByPartial;

    /**
     * @var        ObjectCollection|ChildPollVariant[] Collection to store aggregation of ChildPollVariant objects.
     */
    protected $collPollVariantsRelatedByUpdatedBy;
    protected $collPollVariantsRelatedByUpdatedByPartial;

    /**
     * @var        ObjectCollection|ChildSection[] Collection to store aggregation of ChildSection objects.
     */
    protected $collSectionsRelatedByCreatedBy;
    protected $collSectionsRelatedByCreatedByPartial;

    /**
     * @var        ObjectCollection|ChildSection[] Collection to store aggregation of ChildSection objects.
     */
    protected $collSectionsRelatedByUpdatedBy;
    protected $collSectionsRelatedByUpdatedByPartial;

    /**
     * @var        ObjectCollection|ChildPublication[] Collection to store aggregation of ChildPublication objects.
     */
    protected $collPublicationsRelatedByCreatedBy;
    protected $collPublicationsRelatedByCreatedByPartial;

    /**
     * @var        ObjectCollection|ChildPublication[] Collection to store aggregation of ChildPublication objects.
     */
    protected $collPublicationsRelatedByUpdatedBy;
    protected $collPublicationsRelatedByUpdatedByPartial;

    /**
     * @var        ObjectCollection|ChildPublicationPhoto[] Collection to store aggregation of ChildPublicationPhoto objects.
     */
    protected $collPublicationPhotosRelatedByCreatedBy;
    protected $collPublicationPhotosRelatedByCreatedByPartial;

    /**
     * @var        ObjectCollection|ChildPublicationPhoto[] Collection to store aggregation of ChildPublicationPhoto objects.
     */
    protected $collPublicationPhotosRelatedByUpdatedBy;
    protected $collPublicationPhotosRelatedByUpdatedByPartial;

    /**
     * @var        ObjectCollection|ChildRadio[] Collection to store aggregation of ChildRadio objects.
     */
    protected $collRadiosRelatedByCreatedBy;
    protected $collRadiosRelatedByCreatedByPartial;

    /**
     * @var        ObjectCollection|ChildRadio[] Collection to store aggregation of ChildRadio objects.
     */
    protected $collRadiosRelatedByUpdatedBy;
    protected $collRadiosRelatedByUpdatedByPartial;

    /**
     * @var        ObjectCollection|ChildSnippet[] Collection to store aggregation of ChildSnippet objects.
     */
    protected $collSnippetsRelatedByCreatedBy;
    protected $collSnippetsRelatedByCreatedByPartial;

    /**
     * @var        ObjectCollection|ChildSnippet[] Collection to store aggregation of ChildSnippet objects.
     */
    protected $collSnippetsRelatedByUpdatedBy;
    protected $collSnippetsRelatedByUpdatedByPartial;

    /**
     * @var        ObjectCollection|ChildTag[] Collection to store aggregation of ChildTag objects.
     */
    protected $collTagsRelatedByCreatedBy;
    protected $collTagsRelatedByCreatedByPartial;

    /**
     * @var        ObjectCollection|ChildTag[] Collection to store aggregation of ChildTag objects.
     */
    protected $collTagsRelatedByUpdatedBy;
    protected $collTagsRelatedByUpdatedByPartial;

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
     * @var ObjectCollection|ChildBanner[]
     */
    protected $bannersRelatedByCreatedByScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildBanner[]
     */
    protected $bannersRelatedByUpdatedByScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildBannerGroup[]
     */
    protected $bannerGroupsRelatedByCreatedByScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildBannerGroup[]
     */
    protected $bannerGroupsRelatedByUpdatedByScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildBannerClient[]
     */
    protected $bannerClientsRelatedByCreatedByScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildBannerClient[]
     */
    protected $bannerClientsRelatedByUpdatedByScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildComment[]
     */
    protected $commentsRelatedByCreatedByScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildComment[]
     */
    protected $commentsRelatedByUpdatedByScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildComment[]
     */
    protected $commentsRelatedByDeletedByScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildField[]
     */
    protected $fieldsRelatedByCreatedByScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildField[]
     */
    protected $fieldsRelatedByUpdatedByScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPoll[]
     */
    protected $pollsRelatedByCreatedByScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPoll[]
     */
    protected $pollsRelatedByUpdatedByScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPollVariant[]
     */
    protected $pollVariantsRelatedByCreatedByScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPollVariant[]
     */
    protected $pollVariantsRelatedByUpdatedByScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSection[]
     */
    protected $sectionsRelatedByCreatedByScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSection[]
     */
    protected $sectionsRelatedByUpdatedByScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPublication[]
     */
    protected $publicationsRelatedByCreatedByScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPublication[]
     */
    protected $publicationsRelatedByUpdatedByScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPublicationPhoto[]
     */
    protected $publicationPhotosRelatedByCreatedByScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPublicationPhoto[]
     */
    protected $publicationPhotosRelatedByUpdatedByScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRadio[]
     */
    protected $radiosRelatedByCreatedByScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRadio[]
     */
    protected $radiosRelatedByUpdatedByScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSnippet[]
     */
    protected $snippetsRelatedByCreatedByScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSnippet[]
     */
    protected $snippetsRelatedByUpdatedByScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildTag[]
     */
    protected $tagsRelatedByCreatedByScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildTag[]
     */
    protected $tagsRelatedByUpdatedByScheduledForDeletion = null;

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
        $this->role = 'user';
        $this->registration_confirmed = false;
        $this->authentication_attempt_count = '0';
    }

    /**
     * Initializes internal state of Propel\Models\Base\User object.
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
     * Compares this with another <code>User</code> instance.  If
     * <code>obj</code> is an instance of <code>User</code>, delegates to
     * <code>equals(User)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|User The current object, for fluid interface
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
     * Get the [role] column value.
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Get the [email] column value.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the [username] column value.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Get the [password] column value.
     *
     * @param      ConnectionInterface $con An optional ConnectionInterface connection to use for fetching this lazy-loaded column.
     * @return string
     */
    public function getPassword(ConnectionInterface $con = null)
    {
        if (!$this->password_isLoaded && $this->password === null && !$this->isNew()) {
            $this->loadPassword($con);
        }

        return $this->password;
    }

    /**
     * Load the value for the lazy-loaded [password] column.
     *
     * This method performs an additional query to return the value for
     * the [password] column, since it is not populated by
     * the hydrate() method.
     *
     * @param      $con ConnectionInterface (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - any underlying error will be wrapped and re-thrown.
     */
    protected function loadPassword(ConnectionInterface $con = null)
    {
        $c = $this->buildPkeyCriteria();
        $c->addSelectColumn(UserTableMap::COL_PASSWORD);
        try {
            $dataFetcher = ChildUserQuery::create(null, $c)->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
            $row = $dataFetcher->fetch();
            $dataFetcher->close();

        $firstColumn = $row ? current($row) : null;

            $this->password = ($firstColumn !== null) ? (string) $firstColumn : null;
            $this->password_isLoaded = true;
        } catch (Exception $e) {
            throw new PropelException("Error loading value for [password] column on demand.", 0, $e);
        }
    }
    /**
     * Get the [photo] column value.
     *
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Get the [firstname] column value.
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Get the [lastname] column value.
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Get the [gender] column value.
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Get the [optionally formatted] temporal [birthday] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getBirthday($format = NULL)
    {
        if ($format === null) {
            return $this->birthday;
        } else {
            return $this->birthday instanceof \DateTimeInterface ? $this->birthday->format($format) : null;
        }
    }

    /**
     * Get the [about] column value.
     *
     * @param      ConnectionInterface $con An optional ConnectionInterface connection to use for fetching this lazy-loaded column.
     * @return string
     */
    public function getAbout(ConnectionInterface $con = null)
    {
        if (!$this->about_isLoaded && $this->about === null && !$this->isNew()) {
            $this->loadAbout($con);
        }

        return $this->about;
    }

    /**
     * Load the value for the lazy-loaded [about] column.
     *
     * This method performs an additional query to return the value for
     * the [about] column, since it is not populated by
     * the hydrate() method.
     *
     * @param      $con ConnectionInterface (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - any underlying error will be wrapped and re-thrown.
     */
    protected function loadAbout(ConnectionInterface $con = null)
    {
        $c = $this->buildPkeyCriteria();
        $c->addSelectColumn(UserTableMap::COL_ABOUT);
        try {
            $dataFetcher = ChildUserQuery::create(null, $c)->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
            $row = $dataFetcher->fetch();
            $dataFetcher->close();

        $firstColumn = $row ? current($row) : null;

            $this->about = ($firstColumn !== null) ? (string) $firstColumn : null;
            $this->about_isLoaded = true;
        } catch (Exception $e) {
            throw new PropelException("Error loading value for [about] column on demand.", 0, $e);
        }
    }
    /**
     * Get the [params] column value.
     *
     * @param      ConnectionInterface $con An optional ConnectionInterface connection to use for fetching this lazy-loaded column.
     * @return string
     */
    public function getParams(ConnectionInterface $con = null)
    {
        if (!$this->params_isLoaded && $this->params === null && !$this->isNew()) {
            $this->loadParams($con);
        }

        return $this->params;
    }

    /**
     * Load the value for the lazy-loaded [params] column.
     *
     * This method performs an additional query to return the value for
     * the [params] column, since it is not populated by
     * the hydrate() method.
     *
     * @param      $con ConnectionInterface (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - any underlying error will be wrapped and re-thrown.
     */
    protected function loadParams(ConnectionInterface $con = null)
    {
        $c = $this->buildPkeyCriteria();
        $c->addSelectColumn(UserTableMap::COL_PARAMS);
        try {
            $dataFetcher = ChildUserQuery::create(null, $c)->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
            $row = $dataFetcher->fetch();
            $dataFetcher->close();

        $firstColumn = $row ? current($row) : null;

            $this->params = ($firstColumn !== null) ? (string) $firstColumn : null;
            $this->params_isLoaded = true;
        } catch (Exception $e) {
            throw new PropelException("Error loading value for [params] column on demand.", 0, $e);
        }
    }
    /**
     * Get the [optionally formatted] temporal [registration_at] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getRegistrationAt($format = NULL)
    {
        if ($format === null) {
            return $this->registration_at;
        } else {
            return $this->registration_at instanceof \DateTimeInterface ? $this->registration_at->format($format) : null;
        }
    }

    /**
     * Get the [registration_ip] column value.
     *
     * @return string
     */
    public function getRegistrationIp()
    {
        return $this->registration_ip;
    }

    /**
     * Get the [registration_confirmed] column value.
     *
     * @return boolean
     */
    public function getRegistrationConfirmed()
    {
        return $this->registration_confirmed;
    }

    /**
     * Get the [registration_confirmed] column value.
     *
     * @return boolean
     */
    public function isRegistrationConfirmed()
    {
        return $this->getRegistrationConfirmed();
    }

    /**
     * Get the [optionally formatted] temporal [registration_confirmed_at] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getRegistrationConfirmedAt($format = NULL)
    {
        if ($format === null) {
            return $this->registration_confirmed_at;
        } else {
            return $this->registration_confirmed_at instanceof \DateTimeInterface ? $this->registration_confirmed_at->format($format) : null;
        }
    }

    /**
     * Get the [registration_confirmed_ip] column value.
     *
     * @return string
     */
    public function getRegistrationConfirmedIp()
    {
        return $this->registration_confirmed_ip;
    }

    /**
     * Get the [registration_confirmation_code] column value.
     *
     * @param      ConnectionInterface $con An optional ConnectionInterface connection to use for fetching this lazy-loaded column.
     * @return string
     */
    public function getRegistrationConfirmationCode(ConnectionInterface $con = null)
    {
        if (!$this->registration_confirmation_code_isLoaded && $this->registration_confirmation_code === null && !$this->isNew()) {
            $this->loadRegistrationConfirmationCode($con);
        }

        return $this->registration_confirmation_code;
    }

    /**
     * Load the value for the lazy-loaded [registration_confirmation_code] column.
     *
     * This method performs an additional query to return the value for
     * the [registration_confirmation_code] column, since it is not populated by
     * the hydrate() method.
     *
     * @param      $con ConnectionInterface (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - any underlying error will be wrapped and re-thrown.
     */
    protected function loadRegistrationConfirmationCode(ConnectionInterface $con = null)
    {
        $c = $this->buildPkeyCriteria();
        $c->addSelectColumn(UserTableMap::COL_REGISTRATION_CONFIRMATION_CODE);
        try {
            $dataFetcher = ChildUserQuery::create(null, $c)->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
            $row = $dataFetcher->fetch();
            $dataFetcher->close();

        $firstColumn = $row ? current($row) : null;

            $this->registration_confirmation_code = ($firstColumn !== null) ? (string) $firstColumn : null;
            $this->registration_confirmation_code_isLoaded = true;
        } catch (Exception $e) {
            throw new PropelException("Error loading value for [registration_confirmation_code] column on demand.", 0, $e);
        }
    }
    /**
     * Get the [optionally formatted] temporal [authentication_at] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getAuthenticationAt($format = NULL)
    {
        if ($format === null) {
            return $this->authentication_at;
        } else {
            return $this->authentication_at instanceof \DateTimeInterface ? $this->authentication_at->format($format) : null;
        }
    }

    /**
     * Get the [authentication_ip] column value.
     *
     * @return string
     */
    public function getAuthenticationIp()
    {
        return $this->authentication_ip;
    }

    /**
     * Get the [authentication_key] column value.
     *
     * @param      ConnectionInterface $con An optional ConnectionInterface connection to use for fetching this lazy-loaded column.
     * @return string
     */
    public function getAuthenticationKey(ConnectionInterface $con = null)
    {
        if (!$this->authentication_key_isLoaded && $this->authentication_key === null && !$this->isNew()) {
            $this->loadAuthenticationKey($con);
        }

        return $this->authentication_key;
    }

    /**
     * Load the value for the lazy-loaded [authentication_key] column.
     *
     * This method performs an additional query to return the value for
     * the [authentication_key] column, since it is not populated by
     * the hydrate() method.
     *
     * @param      $con ConnectionInterface (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - any underlying error will be wrapped and re-thrown.
     */
    protected function loadAuthenticationKey(ConnectionInterface $con = null)
    {
        $c = $this->buildPkeyCriteria();
        $c->addSelectColumn(UserTableMap::COL_AUTHENTICATION_KEY);
        try {
            $dataFetcher = ChildUserQuery::create(null, $c)->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
            $row = $dataFetcher->fetch();
            $dataFetcher->close();

        $firstColumn = $row ? current($row) : null;

            $this->authentication_key = ($firstColumn !== null) ? (string) $firstColumn : null;
            $this->authentication_key_isLoaded = true;
        } catch (Exception $e) {
            throw new PropelException("Error loading value for [authentication_key] column on demand.", 0, $e);
        }
    }
    /**
     * Get the [authentication_token] column value.
     *
     * @param      ConnectionInterface $con An optional ConnectionInterface connection to use for fetching this lazy-loaded column.
     * @return string
     */
    public function getAuthenticationToken(ConnectionInterface $con = null)
    {
        if (!$this->authentication_token_isLoaded && $this->authentication_token === null && !$this->isNew()) {
            $this->loadAuthenticationToken($con);
        }

        return $this->authentication_token;
    }

    /**
     * Load the value for the lazy-loaded [authentication_token] column.
     *
     * This method performs an additional query to return the value for
     * the [authentication_token] column, since it is not populated by
     * the hydrate() method.
     *
     * @param      $con ConnectionInterface (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - any underlying error will be wrapped and re-thrown.
     */
    protected function loadAuthenticationToken(ConnectionInterface $con = null)
    {
        $c = $this->buildPkeyCriteria();
        $c->addSelectColumn(UserTableMap::COL_AUTHENTICATION_TOKEN);
        try {
            $dataFetcher = ChildUserQuery::create(null, $c)->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
            $row = $dataFetcher->fetch();
            $dataFetcher->close();

        $firstColumn = $row ? current($row) : null;

            $this->authentication_token = ($firstColumn !== null) ? (string) $firstColumn : null;
            $this->authentication_token_isLoaded = true;
        } catch (Exception $e) {
            throw new PropelException("Error loading value for [authentication_token] column on demand.", 0, $e);
        }
    }
    /**
     * Get the [optionally formatted] temporal [authentication_token_at] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getAuthenticationTokenAt($format = NULL)
    {
        if ($format === null) {
            return $this->authentication_token_at;
        } else {
            return $this->authentication_token_at instanceof \DateTimeInterface ? $this->authentication_token_at->format($format) : null;
        }
    }

    /**
     * Get the [authentication_token_ip] column value.
     *
     * @return string
     */
    public function getAuthenticationTokenIp()
    {
        return $this->authentication_token_ip;
    }

    /**
     * Get the [authentication_attempt_count] column value.
     *
     * @return string
     */
    public function getAuthenticationAttemptCount()
    {
        return $this->authentication_attempt_count;
    }

    /**
     * Get the [optionally formatted] temporal [track_at] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getTrackAt($format = NULL)
    {
        if ($format === null) {
            return $this->track_at;
        } else {
            return $this->track_at instanceof \DateTimeInterface ? $this->track_at->format($format) : null;
        }
    }

    /**
     * Get the [track_ip] column value.
     *
     * @return string
     */
    public function getTrackIp()
    {
        return $this->track_ip;
    }

    /**
     * Get the [track_url] column value.
     *
     * @return string
     */
    public function getTrackUrl()
    {
        return $this->track_url;
    }

    /**
     * Get the [optionally formatted] temporal [ban_from] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getBanFrom($format = NULL)
    {
        if ($format === null) {
            return $this->ban_from;
        } else {
            return $this->ban_from instanceof \DateTimeInterface ? $this->ban_from->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [ban_until] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getBanUntil($format = NULL)
    {
        if ($format === null) {
            return $this->ban_until;
        } else {
            return $this->ban_until instanceof \DateTimeInterface ? $this->ban_until->format($format) : null;
        }
    }

    /**
     * Get the [ban_reason] column value.
     *
     * @return string
     */
    public function getBanReason()
    {
        return $this->ban_reason;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\Propel\Models\User The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[UserTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [role] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\User The current object (for fluent API support)
     */
    public function setRole($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->role !== $v) {
            $this->role = $v;
            $this->modifiedColumns[UserTableMap::COL_ROLE] = true;
        }

        return $this;
    } // setRole()

    /**
     * Set the value of [email] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\User The current object (for fluent API support)
     */
    public function setEmail($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->email !== $v) {
            $this->email = $v;
            $this->modifiedColumns[UserTableMap::COL_EMAIL] = true;
        }

        return $this;
    } // setEmail()

    /**
     * Set the value of [username] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\User The current object (for fluent API support)
     */
    public function setUsername($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->username !== $v) {
            $this->username = $v;
            $this->modifiedColumns[UserTableMap::COL_USERNAME] = true;
        }

        return $this;
    } // setUsername()

    /**
     * Set the value of [password] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\User The current object (for fluent API support)
     */
    public function setPassword($v)
    {
        // explicitly set the is-loaded flag to true for this lazy load col;
        // it doesn't matter if the value is actually set or not (logic below) as
        // any attempt to set the value means that no db lookup should be performed
        // when the getPassword() method is called.
        $this->password_isLoaded = true;

        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->password !== $v) {
            $this->password = $v;
            $this->modifiedColumns[UserTableMap::COL_PASSWORD] = true;
        }

        return $this;
    } // setPassword()

    /**
     * Set the value of [photo] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\User The current object (for fluent API support)
     */
    public function setPhoto($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->photo !== $v) {
            $this->photo = $v;
            $this->modifiedColumns[UserTableMap::COL_PHOTO] = true;
        }

        return $this;
    } // setPhoto()

    /**
     * Set the value of [firstname] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\User The current object (for fluent API support)
     */
    public function setFirstname($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->firstname !== $v) {
            $this->firstname = $v;
            $this->modifiedColumns[UserTableMap::COL_FIRSTNAME] = true;
        }

        return $this;
    } // setFirstname()

    /**
     * Set the value of [lastname] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\User The current object (for fluent API support)
     */
    public function setLastname($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->lastname !== $v) {
            $this->lastname = $v;
            $this->modifiedColumns[UserTableMap::COL_LASTNAME] = true;
        }

        return $this;
    } // setLastname()

    /**
     * Set the value of [gender] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\User The current object (for fluent API support)
     */
    public function setGender($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->gender !== $v) {
            $this->gender = $v;
            $this->modifiedColumns[UserTableMap::COL_GENDER] = true;
        }

        return $this;
    } // setGender()

    /**
     * Sets the value of [birthday] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Propel\Models\User The current object (for fluent API support)
     */
    public function setBirthday($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->birthday !== null || $dt !== null) {
            if ($this->birthday === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->birthday->format("Y-m-d H:i:s.u")) {
                $this->birthday = $dt === null ? null : clone $dt;
                $this->modifiedColumns[UserTableMap::COL_BIRTHDAY] = true;
            }
        } // if either are not null

        return $this;
    } // setBirthday()

    /**
     * Set the value of [about] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\User The current object (for fluent API support)
     */
    public function setAbout($v)
    {
        // explicitly set the is-loaded flag to true for this lazy load col;
        // it doesn't matter if the value is actually set or not (logic below) as
        // any attempt to set the value means that no db lookup should be performed
        // when the getAbout() method is called.
        $this->about_isLoaded = true;

        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->about !== $v) {
            $this->about = $v;
            $this->modifiedColumns[UserTableMap::COL_ABOUT] = true;
        }

        return $this;
    } // setAbout()

    /**
     * Set the value of [params] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\User The current object (for fluent API support)
     */
    public function setParams($v)
    {
        // explicitly set the is-loaded flag to true for this lazy load col;
        // it doesn't matter if the value is actually set or not (logic below) as
        // any attempt to set the value means that no db lookup should be performed
        // when the getParams() method is called.
        $this->params_isLoaded = true;

        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->params !== $v) {
            $this->params = $v;
            $this->modifiedColumns[UserTableMap::COL_PARAMS] = true;
        }

        return $this;
    } // setParams()

    /**
     * Sets the value of [registration_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Propel\Models\User The current object (for fluent API support)
     */
    public function setRegistrationAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->registration_at !== null || $dt !== null) {
            if ($this->registration_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->registration_at->format("Y-m-d H:i:s.u")) {
                $this->registration_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[UserTableMap::COL_REGISTRATION_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setRegistrationAt()

    /**
     * Set the value of [registration_ip] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\User The current object (for fluent API support)
     */
    public function setRegistrationIp($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->registration_ip !== $v) {
            $this->registration_ip = $v;
            $this->modifiedColumns[UserTableMap::COL_REGISTRATION_IP] = true;
        }

        return $this;
    } // setRegistrationIp()

    /**
     * Sets the value of the [registration_confirmed] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\Propel\Models\User The current object (for fluent API support)
     */
    public function setRegistrationConfirmed($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->registration_confirmed !== $v) {
            $this->registration_confirmed = $v;
            $this->modifiedColumns[UserTableMap::COL_REGISTRATION_CONFIRMED] = true;
        }

        return $this;
    } // setRegistrationConfirmed()

    /**
     * Sets the value of [registration_confirmed_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Propel\Models\User The current object (for fluent API support)
     */
    public function setRegistrationConfirmedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->registration_confirmed_at !== null || $dt !== null) {
            if ($this->registration_confirmed_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->registration_confirmed_at->format("Y-m-d H:i:s.u")) {
                $this->registration_confirmed_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[UserTableMap::COL_REGISTRATION_CONFIRMED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setRegistrationConfirmedAt()

    /**
     * Set the value of [registration_confirmed_ip] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\User The current object (for fluent API support)
     */
    public function setRegistrationConfirmedIp($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->registration_confirmed_ip !== $v) {
            $this->registration_confirmed_ip = $v;
            $this->modifiedColumns[UserTableMap::COL_REGISTRATION_CONFIRMED_IP] = true;
        }

        return $this;
    } // setRegistrationConfirmedIp()

    /**
     * Set the value of [registration_confirmation_code] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\User The current object (for fluent API support)
     */
    public function setRegistrationConfirmationCode($v)
    {
        // explicitly set the is-loaded flag to true for this lazy load col;
        // it doesn't matter if the value is actually set or not (logic below) as
        // any attempt to set the value means that no db lookup should be performed
        // when the getRegistrationConfirmationCode() method is called.
        $this->registration_confirmation_code_isLoaded = true;

        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->registration_confirmation_code !== $v) {
            $this->registration_confirmation_code = $v;
            $this->modifiedColumns[UserTableMap::COL_REGISTRATION_CONFIRMATION_CODE] = true;
        }

        return $this;
    } // setRegistrationConfirmationCode()

    /**
     * Sets the value of [authentication_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Propel\Models\User The current object (for fluent API support)
     */
    public function setAuthenticationAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->authentication_at !== null || $dt !== null) {
            if ($this->authentication_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->authentication_at->format("Y-m-d H:i:s.u")) {
                $this->authentication_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[UserTableMap::COL_AUTHENTICATION_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setAuthenticationAt()

    /**
     * Set the value of [authentication_ip] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\User The current object (for fluent API support)
     */
    public function setAuthenticationIp($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->authentication_ip !== $v) {
            $this->authentication_ip = $v;
            $this->modifiedColumns[UserTableMap::COL_AUTHENTICATION_IP] = true;
        }

        return $this;
    } // setAuthenticationIp()

    /**
     * Set the value of [authentication_key] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\User The current object (for fluent API support)
     */
    public function setAuthenticationKey($v)
    {
        // explicitly set the is-loaded flag to true for this lazy load col;
        // it doesn't matter if the value is actually set or not (logic below) as
        // any attempt to set the value means that no db lookup should be performed
        // when the getAuthenticationKey() method is called.
        $this->authentication_key_isLoaded = true;

        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->authentication_key !== $v) {
            $this->authentication_key = $v;
            $this->modifiedColumns[UserTableMap::COL_AUTHENTICATION_KEY] = true;
        }

        return $this;
    } // setAuthenticationKey()

    /**
     * Set the value of [authentication_token] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\User The current object (for fluent API support)
     */
    public function setAuthenticationToken($v)
    {
        // explicitly set the is-loaded flag to true for this lazy load col;
        // it doesn't matter if the value is actually set or not (logic below) as
        // any attempt to set the value means that no db lookup should be performed
        // when the getAuthenticationToken() method is called.
        $this->authentication_token_isLoaded = true;

        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->authentication_token !== $v) {
            $this->authentication_token = $v;
            $this->modifiedColumns[UserTableMap::COL_AUTHENTICATION_TOKEN] = true;
        }

        return $this;
    } // setAuthenticationToken()

    /**
     * Sets the value of [authentication_token_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Propel\Models\User The current object (for fluent API support)
     */
    public function setAuthenticationTokenAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->authentication_token_at !== null || $dt !== null) {
            if ($this->authentication_token_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->authentication_token_at->format("Y-m-d H:i:s.u")) {
                $this->authentication_token_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[UserTableMap::COL_AUTHENTICATION_TOKEN_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setAuthenticationTokenAt()

    /**
     * Set the value of [authentication_token_ip] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\User The current object (for fluent API support)
     */
    public function setAuthenticationTokenIp($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->authentication_token_ip !== $v) {
            $this->authentication_token_ip = $v;
            $this->modifiedColumns[UserTableMap::COL_AUTHENTICATION_TOKEN_IP] = true;
        }

        return $this;
    } // setAuthenticationTokenIp()

    /**
     * Set the value of [authentication_attempt_count] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\User The current object (for fluent API support)
     */
    public function setAuthenticationAttemptCount($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->authentication_attempt_count !== $v) {
            $this->authentication_attempt_count = $v;
            $this->modifiedColumns[UserTableMap::COL_AUTHENTICATION_ATTEMPT_COUNT] = true;
        }

        return $this;
    } // setAuthenticationAttemptCount()

    /**
     * Sets the value of [track_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Propel\Models\User The current object (for fluent API support)
     */
    public function setTrackAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->track_at !== null || $dt !== null) {
            if ($this->track_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->track_at->format("Y-m-d H:i:s.u")) {
                $this->track_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[UserTableMap::COL_TRACK_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setTrackAt()

    /**
     * Set the value of [track_ip] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\User The current object (for fluent API support)
     */
    public function setTrackIp($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->track_ip !== $v) {
            $this->track_ip = $v;
            $this->modifiedColumns[UserTableMap::COL_TRACK_IP] = true;
        }

        return $this;
    } // setTrackIp()

    /**
     * Set the value of [track_url] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\User The current object (for fluent API support)
     */
    public function setTrackUrl($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->track_url !== $v) {
            $this->track_url = $v;
            $this->modifiedColumns[UserTableMap::COL_TRACK_URL] = true;
        }

        return $this;
    } // setTrackUrl()

    /**
     * Sets the value of [ban_from] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Propel\Models\User The current object (for fluent API support)
     */
    public function setBanFrom($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->ban_from !== null || $dt !== null) {
            if ($this->ban_from === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->ban_from->format("Y-m-d H:i:s.u")) {
                $this->ban_from = $dt === null ? null : clone $dt;
                $this->modifiedColumns[UserTableMap::COL_BAN_FROM] = true;
            }
        } // if either are not null

        return $this;
    } // setBanFrom()

    /**
     * Sets the value of [ban_until] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Propel\Models\User The current object (for fluent API support)
     */
    public function setBanUntil($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->ban_until !== null || $dt !== null) {
            if ($this->ban_until === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->ban_until->format("Y-m-d H:i:s.u")) {
                $this->ban_until = $dt === null ? null : clone $dt;
                $this->modifiedColumns[UserTableMap::COL_BAN_UNTIL] = true;
            }
        } // if either are not null

        return $this;
    } // setBanUntil()

    /**
     * Set the value of [ban_reason] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Models\User The current object (for fluent API support)
     */
    public function setBanReason($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->ban_reason !== $v) {
            $this->ban_reason = $v;
            $this->modifiedColumns[UserTableMap::COL_BAN_REASON] = true;
        }

        return $this;
    } // setBanReason()

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
            if ($this->role !== 'user') {
                return false;
            }

            if ($this->registration_confirmed !== false) {
                return false;
            }

            if ($this->authentication_attempt_count !== '0') {
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : UserTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : UserTableMap::translateFieldName('Role', TableMap::TYPE_PHPNAME, $indexType)];
            $this->role = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : UserTableMap::translateFieldName('Email', TableMap::TYPE_PHPNAME, $indexType)];
            $this->email = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : UserTableMap::translateFieldName('Username', TableMap::TYPE_PHPNAME, $indexType)];
            $this->username = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : UserTableMap::translateFieldName('Photo', TableMap::TYPE_PHPNAME, $indexType)];
            $this->photo = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : UserTableMap::translateFieldName('Firstname', TableMap::TYPE_PHPNAME, $indexType)];
            $this->firstname = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : UserTableMap::translateFieldName('Lastname', TableMap::TYPE_PHPNAME, $indexType)];
            $this->lastname = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : UserTableMap::translateFieldName('Gender', TableMap::TYPE_PHPNAME, $indexType)];
            $this->gender = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : UserTableMap::translateFieldName('Birthday', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->birthday = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : UserTableMap::translateFieldName('RegistrationAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->registration_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : UserTableMap::translateFieldName('RegistrationIp', TableMap::TYPE_PHPNAME, $indexType)];
            $this->registration_ip = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : UserTableMap::translateFieldName('RegistrationConfirmed', TableMap::TYPE_PHPNAME, $indexType)];
            $this->registration_confirmed = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : UserTableMap::translateFieldName('RegistrationConfirmedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->registration_confirmed_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : UserTableMap::translateFieldName('RegistrationConfirmedIp', TableMap::TYPE_PHPNAME, $indexType)];
            $this->registration_confirmed_ip = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 14 + $startcol : UserTableMap::translateFieldName('AuthenticationAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->authentication_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 15 + $startcol : UserTableMap::translateFieldName('AuthenticationIp', TableMap::TYPE_PHPNAME, $indexType)];
            $this->authentication_ip = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 16 + $startcol : UserTableMap::translateFieldName('AuthenticationTokenAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->authentication_token_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 17 + $startcol : UserTableMap::translateFieldName('AuthenticationTokenIp', TableMap::TYPE_PHPNAME, $indexType)];
            $this->authentication_token_ip = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 18 + $startcol : UserTableMap::translateFieldName('AuthenticationAttemptCount', TableMap::TYPE_PHPNAME, $indexType)];
            $this->authentication_attempt_count = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 19 + $startcol : UserTableMap::translateFieldName('TrackAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->track_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 20 + $startcol : UserTableMap::translateFieldName('TrackIp', TableMap::TYPE_PHPNAME, $indexType)];
            $this->track_ip = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 21 + $startcol : UserTableMap::translateFieldName('TrackUrl', TableMap::TYPE_PHPNAME, $indexType)];
            $this->track_url = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 22 + $startcol : UserTableMap::translateFieldName('BanFrom', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->ban_from = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 23 + $startcol : UserTableMap::translateFieldName('BanUntil', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->ban_until = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 24 + $startcol : UserTableMap::translateFieldName('BanReason', TableMap::TYPE_PHPNAME, $indexType)];
            $this->ban_reason = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 25; // 25 = UserTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Propel\\Models\\User'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(UserTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildUserQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        // Reset the password lazy-load column
        $this->password = null;
        $this->password_isLoaded = false;

        // Reset the about lazy-load column
        $this->about = null;
        $this->about_isLoaded = false;

        // Reset the params lazy-load column
        $this->params = null;
        $this->params_isLoaded = false;

        // Reset the registration_confirmation_code lazy-load column
        $this->registration_confirmation_code = null;
        $this->registration_confirmation_code_isLoaded = false;

        // Reset the authentication_key lazy-load column
        $this->authentication_key = null;
        $this->authentication_key_isLoaded = false;

        // Reset the authentication_token lazy-load column
        $this->authentication_token = null;
        $this->authentication_token_isLoaded = false;

        if ($deep) {  // also de-associate any related objects?

            $this->collBannersRelatedByCreatedBy = null;

            $this->collBannersRelatedByUpdatedBy = null;

            $this->collBannerGroupsRelatedByCreatedBy = null;

            $this->collBannerGroupsRelatedByUpdatedBy = null;

            $this->collBannerClientsRelatedByCreatedBy = null;

            $this->collBannerClientsRelatedByUpdatedBy = null;

            $this->collCommentsRelatedByCreatedBy = null;

            $this->collCommentsRelatedByUpdatedBy = null;

            $this->collCommentsRelatedByDeletedBy = null;

            $this->collFieldsRelatedByCreatedBy = null;

            $this->collFieldsRelatedByUpdatedBy = null;

            $this->collPollsRelatedByCreatedBy = null;

            $this->collPollsRelatedByUpdatedBy = null;

            $this->collPollVariantsRelatedByCreatedBy = null;

            $this->collPollVariantsRelatedByUpdatedBy = null;

            $this->collSectionsRelatedByCreatedBy = null;

            $this->collSectionsRelatedByUpdatedBy = null;

            $this->collPublicationsRelatedByCreatedBy = null;

            $this->collPublicationsRelatedByUpdatedBy = null;

            $this->collPublicationPhotosRelatedByCreatedBy = null;

            $this->collPublicationPhotosRelatedByUpdatedBy = null;

            $this->collRadiosRelatedByCreatedBy = null;

            $this->collRadiosRelatedByUpdatedBy = null;

            $this->collSnippetsRelatedByCreatedBy = null;

            $this->collSnippetsRelatedByUpdatedBy = null;

            $this->collTagsRelatedByCreatedBy = null;

            $this->collTagsRelatedByUpdatedBy = null;

            $this->collUserFavorites = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see User::setDeleted()
     * @see User::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildUserQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(UserTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                UserTableMap::addInstanceToPool($this);
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

            if ($this->bannersRelatedByCreatedByScheduledForDeletion !== null) {
                if (!$this->bannersRelatedByCreatedByScheduledForDeletion->isEmpty()) {
                    foreach ($this->bannersRelatedByCreatedByScheduledForDeletion as $bannerRelatedByCreatedBy) {
                        // need to save related object because we set the relation to null
                        $bannerRelatedByCreatedBy->save($con);
                    }
                    $this->bannersRelatedByCreatedByScheduledForDeletion = null;
                }
            }

            if ($this->collBannersRelatedByCreatedBy !== null) {
                foreach ($this->collBannersRelatedByCreatedBy as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->bannersRelatedByUpdatedByScheduledForDeletion !== null) {
                if (!$this->bannersRelatedByUpdatedByScheduledForDeletion->isEmpty()) {
                    foreach ($this->bannersRelatedByUpdatedByScheduledForDeletion as $bannerRelatedByUpdatedBy) {
                        // need to save related object because we set the relation to null
                        $bannerRelatedByUpdatedBy->save($con);
                    }
                    $this->bannersRelatedByUpdatedByScheduledForDeletion = null;
                }
            }

            if ($this->collBannersRelatedByUpdatedBy !== null) {
                foreach ($this->collBannersRelatedByUpdatedBy as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->bannerGroupsRelatedByCreatedByScheduledForDeletion !== null) {
                if (!$this->bannerGroupsRelatedByCreatedByScheduledForDeletion->isEmpty()) {
                    foreach ($this->bannerGroupsRelatedByCreatedByScheduledForDeletion as $bannerGroupRelatedByCreatedBy) {
                        // need to save related object because we set the relation to null
                        $bannerGroupRelatedByCreatedBy->save($con);
                    }
                    $this->bannerGroupsRelatedByCreatedByScheduledForDeletion = null;
                }
            }

            if ($this->collBannerGroupsRelatedByCreatedBy !== null) {
                foreach ($this->collBannerGroupsRelatedByCreatedBy as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->bannerGroupsRelatedByUpdatedByScheduledForDeletion !== null) {
                if (!$this->bannerGroupsRelatedByUpdatedByScheduledForDeletion->isEmpty()) {
                    foreach ($this->bannerGroupsRelatedByUpdatedByScheduledForDeletion as $bannerGroupRelatedByUpdatedBy) {
                        // need to save related object because we set the relation to null
                        $bannerGroupRelatedByUpdatedBy->save($con);
                    }
                    $this->bannerGroupsRelatedByUpdatedByScheduledForDeletion = null;
                }
            }

            if ($this->collBannerGroupsRelatedByUpdatedBy !== null) {
                foreach ($this->collBannerGroupsRelatedByUpdatedBy as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->bannerClientsRelatedByCreatedByScheduledForDeletion !== null) {
                if (!$this->bannerClientsRelatedByCreatedByScheduledForDeletion->isEmpty()) {
                    foreach ($this->bannerClientsRelatedByCreatedByScheduledForDeletion as $bannerClientRelatedByCreatedBy) {
                        // need to save related object because we set the relation to null
                        $bannerClientRelatedByCreatedBy->save($con);
                    }
                    $this->bannerClientsRelatedByCreatedByScheduledForDeletion = null;
                }
            }

            if ($this->collBannerClientsRelatedByCreatedBy !== null) {
                foreach ($this->collBannerClientsRelatedByCreatedBy as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->bannerClientsRelatedByUpdatedByScheduledForDeletion !== null) {
                if (!$this->bannerClientsRelatedByUpdatedByScheduledForDeletion->isEmpty()) {
                    foreach ($this->bannerClientsRelatedByUpdatedByScheduledForDeletion as $bannerClientRelatedByUpdatedBy) {
                        // need to save related object because we set the relation to null
                        $bannerClientRelatedByUpdatedBy->save($con);
                    }
                    $this->bannerClientsRelatedByUpdatedByScheduledForDeletion = null;
                }
            }

            if ($this->collBannerClientsRelatedByUpdatedBy !== null) {
                foreach ($this->collBannerClientsRelatedByUpdatedBy as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->commentsRelatedByCreatedByScheduledForDeletion !== null) {
                if (!$this->commentsRelatedByCreatedByScheduledForDeletion->isEmpty()) {
                    \Propel\Models\CommentQuery::create()
                        ->filterByPrimaryKeys($this->commentsRelatedByCreatedByScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->commentsRelatedByCreatedByScheduledForDeletion = null;
                }
            }

            if ($this->collCommentsRelatedByCreatedBy !== null) {
                foreach ($this->collCommentsRelatedByCreatedBy as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->commentsRelatedByUpdatedByScheduledForDeletion !== null) {
                if (!$this->commentsRelatedByUpdatedByScheduledForDeletion->isEmpty()) {
                    \Propel\Models\CommentQuery::create()
                        ->filterByPrimaryKeys($this->commentsRelatedByUpdatedByScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->commentsRelatedByUpdatedByScheduledForDeletion = null;
                }
            }

            if ($this->collCommentsRelatedByUpdatedBy !== null) {
                foreach ($this->collCommentsRelatedByUpdatedBy as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->commentsRelatedByDeletedByScheduledForDeletion !== null) {
                if (!$this->commentsRelatedByDeletedByScheduledForDeletion->isEmpty()) {
                    \Propel\Models\CommentQuery::create()
                        ->filterByPrimaryKeys($this->commentsRelatedByDeletedByScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->commentsRelatedByDeletedByScheduledForDeletion = null;
                }
            }

            if ($this->collCommentsRelatedByDeletedBy !== null) {
                foreach ($this->collCommentsRelatedByDeletedBy as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->fieldsRelatedByCreatedByScheduledForDeletion !== null) {
                if (!$this->fieldsRelatedByCreatedByScheduledForDeletion->isEmpty()) {
                    foreach ($this->fieldsRelatedByCreatedByScheduledForDeletion as $fieldRelatedByCreatedBy) {
                        // need to save related object because we set the relation to null
                        $fieldRelatedByCreatedBy->save($con);
                    }
                    $this->fieldsRelatedByCreatedByScheduledForDeletion = null;
                }
            }

            if ($this->collFieldsRelatedByCreatedBy !== null) {
                foreach ($this->collFieldsRelatedByCreatedBy as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->fieldsRelatedByUpdatedByScheduledForDeletion !== null) {
                if (!$this->fieldsRelatedByUpdatedByScheduledForDeletion->isEmpty()) {
                    foreach ($this->fieldsRelatedByUpdatedByScheduledForDeletion as $fieldRelatedByUpdatedBy) {
                        // need to save related object because we set the relation to null
                        $fieldRelatedByUpdatedBy->save($con);
                    }
                    $this->fieldsRelatedByUpdatedByScheduledForDeletion = null;
                }
            }

            if ($this->collFieldsRelatedByUpdatedBy !== null) {
                foreach ($this->collFieldsRelatedByUpdatedBy as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->pollsRelatedByCreatedByScheduledForDeletion !== null) {
                if (!$this->pollsRelatedByCreatedByScheduledForDeletion->isEmpty()) {
                    foreach ($this->pollsRelatedByCreatedByScheduledForDeletion as $pollRelatedByCreatedBy) {
                        // need to save related object because we set the relation to null
                        $pollRelatedByCreatedBy->save($con);
                    }
                    $this->pollsRelatedByCreatedByScheduledForDeletion = null;
                }
            }

            if ($this->collPollsRelatedByCreatedBy !== null) {
                foreach ($this->collPollsRelatedByCreatedBy as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->pollsRelatedByUpdatedByScheduledForDeletion !== null) {
                if (!$this->pollsRelatedByUpdatedByScheduledForDeletion->isEmpty()) {
                    foreach ($this->pollsRelatedByUpdatedByScheduledForDeletion as $pollRelatedByUpdatedBy) {
                        // need to save related object because we set the relation to null
                        $pollRelatedByUpdatedBy->save($con);
                    }
                    $this->pollsRelatedByUpdatedByScheduledForDeletion = null;
                }
            }

            if ($this->collPollsRelatedByUpdatedBy !== null) {
                foreach ($this->collPollsRelatedByUpdatedBy as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->pollVariantsRelatedByCreatedByScheduledForDeletion !== null) {
                if (!$this->pollVariantsRelatedByCreatedByScheduledForDeletion->isEmpty()) {
                    foreach ($this->pollVariantsRelatedByCreatedByScheduledForDeletion as $pollVariantRelatedByCreatedBy) {
                        // need to save related object because we set the relation to null
                        $pollVariantRelatedByCreatedBy->save($con);
                    }
                    $this->pollVariantsRelatedByCreatedByScheduledForDeletion = null;
                }
            }

            if ($this->collPollVariantsRelatedByCreatedBy !== null) {
                foreach ($this->collPollVariantsRelatedByCreatedBy as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->pollVariantsRelatedByUpdatedByScheduledForDeletion !== null) {
                if (!$this->pollVariantsRelatedByUpdatedByScheduledForDeletion->isEmpty()) {
                    foreach ($this->pollVariantsRelatedByUpdatedByScheduledForDeletion as $pollVariantRelatedByUpdatedBy) {
                        // need to save related object because we set the relation to null
                        $pollVariantRelatedByUpdatedBy->save($con);
                    }
                    $this->pollVariantsRelatedByUpdatedByScheduledForDeletion = null;
                }
            }

            if ($this->collPollVariantsRelatedByUpdatedBy !== null) {
                foreach ($this->collPollVariantsRelatedByUpdatedBy as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->sectionsRelatedByCreatedByScheduledForDeletion !== null) {
                if (!$this->sectionsRelatedByCreatedByScheduledForDeletion->isEmpty()) {
                    foreach ($this->sectionsRelatedByCreatedByScheduledForDeletion as $sectionRelatedByCreatedBy) {
                        // need to save related object because we set the relation to null
                        $sectionRelatedByCreatedBy->save($con);
                    }
                    $this->sectionsRelatedByCreatedByScheduledForDeletion = null;
                }
            }

            if ($this->collSectionsRelatedByCreatedBy !== null) {
                foreach ($this->collSectionsRelatedByCreatedBy as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->sectionsRelatedByUpdatedByScheduledForDeletion !== null) {
                if (!$this->sectionsRelatedByUpdatedByScheduledForDeletion->isEmpty()) {
                    foreach ($this->sectionsRelatedByUpdatedByScheduledForDeletion as $sectionRelatedByUpdatedBy) {
                        // need to save related object because we set the relation to null
                        $sectionRelatedByUpdatedBy->save($con);
                    }
                    $this->sectionsRelatedByUpdatedByScheduledForDeletion = null;
                }
            }

            if ($this->collSectionsRelatedByUpdatedBy !== null) {
                foreach ($this->collSectionsRelatedByUpdatedBy as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->publicationsRelatedByCreatedByScheduledForDeletion !== null) {
                if (!$this->publicationsRelatedByCreatedByScheduledForDeletion->isEmpty()) {
                    foreach ($this->publicationsRelatedByCreatedByScheduledForDeletion as $publicationRelatedByCreatedBy) {
                        // need to save related object because we set the relation to null
                        $publicationRelatedByCreatedBy->save($con);
                    }
                    $this->publicationsRelatedByCreatedByScheduledForDeletion = null;
                }
            }

            if ($this->collPublicationsRelatedByCreatedBy !== null) {
                foreach ($this->collPublicationsRelatedByCreatedBy as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->publicationsRelatedByUpdatedByScheduledForDeletion !== null) {
                if (!$this->publicationsRelatedByUpdatedByScheduledForDeletion->isEmpty()) {
                    foreach ($this->publicationsRelatedByUpdatedByScheduledForDeletion as $publicationRelatedByUpdatedBy) {
                        // need to save related object because we set the relation to null
                        $publicationRelatedByUpdatedBy->save($con);
                    }
                    $this->publicationsRelatedByUpdatedByScheduledForDeletion = null;
                }
            }

            if ($this->collPublicationsRelatedByUpdatedBy !== null) {
                foreach ($this->collPublicationsRelatedByUpdatedBy as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->publicationPhotosRelatedByCreatedByScheduledForDeletion !== null) {
                if (!$this->publicationPhotosRelatedByCreatedByScheduledForDeletion->isEmpty()) {
                    foreach ($this->publicationPhotosRelatedByCreatedByScheduledForDeletion as $publicationPhotoRelatedByCreatedBy) {
                        // need to save related object because we set the relation to null
                        $publicationPhotoRelatedByCreatedBy->save($con);
                    }
                    $this->publicationPhotosRelatedByCreatedByScheduledForDeletion = null;
                }
            }

            if ($this->collPublicationPhotosRelatedByCreatedBy !== null) {
                foreach ($this->collPublicationPhotosRelatedByCreatedBy as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->publicationPhotosRelatedByUpdatedByScheduledForDeletion !== null) {
                if (!$this->publicationPhotosRelatedByUpdatedByScheduledForDeletion->isEmpty()) {
                    foreach ($this->publicationPhotosRelatedByUpdatedByScheduledForDeletion as $publicationPhotoRelatedByUpdatedBy) {
                        // need to save related object because we set the relation to null
                        $publicationPhotoRelatedByUpdatedBy->save($con);
                    }
                    $this->publicationPhotosRelatedByUpdatedByScheduledForDeletion = null;
                }
            }

            if ($this->collPublicationPhotosRelatedByUpdatedBy !== null) {
                foreach ($this->collPublicationPhotosRelatedByUpdatedBy as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->radiosRelatedByCreatedByScheduledForDeletion !== null) {
                if (!$this->radiosRelatedByCreatedByScheduledForDeletion->isEmpty()) {
                    foreach ($this->radiosRelatedByCreatedByScheduledForDeletion as $radioRelatedByCreatedBy) {
                        // need to save related object because we set the relation to null
                        $radioRelatedByCreatedBy->save($con);
                    }
                    $this->radiosRelatedByCreatedByScheduledForDeletion = null;
                }
            }

            if ($this->collRadiosRelatedByCreatedBy !== null) {
                foreach ($this->collRadiosRelatedByCreatedBy as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->radiosRelatedByUpdatedByScheduledForDeletion !== null) {
                if (!$this->radiosRelatedByUpdatedByScheduledForDeletion->isEmpty()) {
                    foreach ($this->radiosRelatedByUpdatedByScheduledForDeletion as $radioRelatedByUpdatedBy) {
                        // need to save related object because we set the relation to null
                        $radioRelatedByUpdatedBy->save($con);
                    }
                    $this->radiosRelatedByUpdatedByScheduledForDeletion = null;
                }
            }

            if ($this->collRadiosRelatedByUpdatedBy !== null) {
                foreach ($this->collRadiosRelatedByUpdatedBy as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->snippetsRelatedByCreatedByScheduledForDeletion !== null) {
                if (!$this->snippetsRelatedByCreatedByScheduledForDeletion->isEmpty()) {
                    foreach ($this->snippetsRelatedByCreatedByScheduledForDeletion as $snippetRelatedByCreatedBy) {
                        // need to save related object because we set the relation to null
                        $snippetRelatedByCreatedBy->save($con);
                    }
                    $this->snippetsRelatedByCreatedByScheduledForDeletion = null;
                }
            }

            if ($this->collSnippetsRelatedByCreatedBy !== null) {
                foreach ($this->collSnippetsRelatedByCreatedBy as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->snippetsRelatedByUpdatedByScheduledForDeletion !== null) {
                if (!$this->snippetsRelatedByUpdatedByScheduledForDeletion->isEmpty()) {
                    foreach ($this->snippetsRelatedByUpdatedByScheduledForDeletion as $snippetRelatedByUpdatedBy) {
                        // need to save related object because we set the relation to null
                        $snippetRelatedByUpdatedBy->save($con);
                    }
                    $this->snippetsRelatedByUpdatedByScheduledForDeletion = null;
                }
            }

            if ($this->collSnippetsRelatedByUpdatedBy !== null) {
                foreach ($this->collSnippetsRelatedByUpdatedBy as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->tagsRelatedByCreatedByScheduledForDeletion !== null) {
                if (!$this->tagsRelatedByCreatedByScheduledForDeletion->isEmpty()) {
                    foreach ($this->tagsRelatedByCreatedByScheduledForDeletion as $tagRelatedByCreatedBy) {
                        // need to save related object because we set the relation to null
                        $tagRelatedByCreatedBy->save($con);
                    }
                    $this->tagsRelatedByCreatedByScheduledForDeletion = null;
                }
            }

            if ($this->collTagsRelatedByCreatedBy !== null) {
                foreach ($this->collTagsRelatedByCreatedBy as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->tagsRelatedByUpdatedByScheduledForDeletion !== null) {
                if (!$this->tagsRelatedByUpdatedByScheduledForDeletion->isEmpty()) {
                    foreach ($this->tagsRelatedByUpdatedByScheduledForDeletion as $tagRelatedByUpdatedBy) {
                        // need to save related object because we set the relation to null
                        $tagRelatedByUpdatedBy->save($con);
                    }
                    $this->tagsRelatedByUpdatedByScheduledForDeletion = null;
                }
            }

            if ($this->collTagsRelatedByUpdatedBy !== null) {
                foreach ($this->collTagsRelatedByUpdatedBy as $referrerFK) {
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

        $this->modifiedColumns[UserTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . UserTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(UserTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(UserTableMap::COL_ROLE)) {
            $modifiedColumns[':p' . $index++]  = 'role';
        }
        if ($this->isColumnModified(UserTableMap::COL_EMAIL)) {
            $modifiedColumns[':p' . $index++]  = 'email';
        }
        if ($this->isColumnModified(UserTableMap::COL_USERNAME)) {
            $modifiedColumns[':p' . $index++]  = 'username';
        }
        if ($this->isColumnModified(UserTableMap::COL_PASSWORD)) {
            $modifiedColumns[':p' . $index++]  = 'password';
        }
        if ($this->isColumnModified(UserTableMap::COL_PHOTO)) {
            $modifiedColumns[':p' . $index++]  = 'photo';
        }
        if ($this->isColumnModified(UserTableMap::COL_FIRSTNAME)) {
            $modifiedColumns[':p' . $index++]  = 'firstname';
        }
        if ($this->isColumnModified(UserTableMap::COL_LASTNAME)) {
            $modifiedColumns[':p' . $index++]  = 'lastname';
        }
        if ($this->isColumnModified(UserTableMap::COL_GENDER)) {
            $modifiedColumns[':p' . $index++]  = 'gender';
        }
        if ($this->isColumnModified(UserTableMap::COL_BIRTHDAY)) {
            $modifiedColumns[':p' . $index++]  = 'birthday';
        }
        if ($this->isColumnModified(UserTableMap::COL_ABOUT)) {
            $modifiedColumns[':p' . $index++]  = 'about';
        }
        if ($this->isColumnModified(UserTableMap::COL_PARAMS)) {
            $modifiedColumns[':p' . $index++]  = 'params';
        }
        if ($this->isColumnModified(UserTableMap::COL_REGISTRATION_AT)) {
            $modifiedColumns[':p' . $index++]  = 'registration_at';
        }
        if ($this->isColumnModified(UserTableMap::COL_REGISTRATION_IP)) {
            $modifiedColumns[':p' . $index++]  = 'registration_ip';
        }
        if ($this->isColumnModified(UserTableMap::COL_REGISTRATION_CONFIRMED)) {
            $modifiedColumns[':p' . $index++]  = 'registration_confirmed';
        }
        if ($this->isColumnModified(UserTableMap::COL_REGISTRATION_CONFIRMED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'registration_confirmed_at';
        }
        if ($this->isColumnModified(UserTableMap::COL_REGISTRATION_CONFIRMED_IP)) {
            $modifiedColumns[':p' . $index++]  = 'registration_confirmed_ip';
        }
        if ($this->isColumnModified(UserTableMap::COL_REGISTRATION_CONFIRMATION_CODE)) {
            $modifiedColumns[':p' . $index++]  = 'registration_confirmation_code';
        }
        if ($this->isColumnModified(UserTableMap::COL_AUTHENTICATION_AT)) {
            $modifiedColumns[':p' . $index++]  = 'authentication_at';
        }
        if ($this->isColumnModified(UserTableMap::COL_AUTHENTICATION_IP)) {
            $modifiedColumns[':p' . $index++]  = 'authentication_ip';
        }
        if ($this->isColumnModified(UserTableMap::COL_AUTHENTICATION_KEY)) {
            $modifiedColumns[':p' . $index++]  = 'authentication_key';
        }
        if ($this->isColumnModified(UserTableMap::COL_AUTHENTICATION_TOKEN)) {
            $modifiedColumns[':p' . $index++]  = 'authentication_token';
        }
        if ($this->isColumnModified(UserTableMap::COL_AUTHENTICATION_TOKEN_AT)) {
            $modifiedColumns[':p' . $index++]  = 'authentication_token_at';
        }
        if ($this->isColumnModified(UserTableMap::COL_AUTHENTICATION_TOKEN_IP)) {
            $modifiedColumns[':p' . $index++]  = 'authentication_token_ip';
        }
        if ($this->isColumnModified(UserTableMap::COL_AUTHENTICATION_ATTEMPT_COUNT)) {
            $modifiedColumns[':p' . $index++]  = 'authentication_attempt_count';
        }
        if ($this->isColumnModified(UserTableMap::COL_TRACK_AT)) {
            $modifiedColumns[':p' . $index++]  = 'track_at';
        }
        if ($this->isColumnModified(UserTableMap::COL_TRACK_IP)) {
            $modifiedColumns[':p' . $index++]  = 'track_ip';
        }
        if ($this->isColumnModified(UserTableMap::COL_TRACK_URL)) {
            $modifiedColumns[':p' . $index++]  = 'track_url';
        }
        if ($this->isColumnModified(UserTableMap::COL_BAN_FROM)) {
            $modifiedColumns[':p' . $index++]  = 'ban_from';
        }
        if ($this->isColumnModified(UserTableMap::COL_BAN_UNTIL)) {
            $modifiedColumns[':p' . $index++]  = 'ban_until';
        }
        if ($this->isColumnModified(UserTableMap::COL_BAN_REASON)) {
            $modifiedColumns[':p' . $index++]  = 'ban_reason';
        }

        $sql = sprintf(
            'INSERT INTO fenric_user (%s) VALUES (%s)',
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
                    case 'role':
                        $stmt->bindValue($identifier, $this->role, PDO::PARAM_STR);
                        break;
                    case 'email':
                        $stmt->bindValue($identifier, $this->email, PDO::PARAM_STR);
                        break;
                    case 'username':
                        $stmt->bindValue($identifier, $this->username, PDO::PARAM_STR);
                        break;
                    case 'password':
                        $stmt->bindValue($identifier, $this->password, PDO::PARAM_STR);
                        break;
                    case 'photo':
                        $stmt->bindValue($identifier, $this->photo, PDO::PARAM_STR);
                        break;
                    case 'firstname':
                        $stmt->bindValue($identifier, $this->firstname, PDO::PARAM_STR);
                        break;
                    case 'lastname':
                        $stmt->bindValue($identifier, $this->lastname, PDO::PARAM_STR);
                        break;
                    case 'gender':
                        $stmt->bindValue($identifier, $this->gender, PDO::PARAM_STR);
                        break;
                    case 'birthday':
                        $stmt->bindValue($identifier, $this->birthday ? $this->birthday->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'about':
                        $stmt->bindValue($identifier, $this->about, PDO::PARAM_STR);
                        break;
                    case 'params':
                        $stmt->bindValue($identifier, $this->params, PDO::PARAM_STR);
                        break;
                    case 'registration_at':
                        $stmt->bindValue($identifier, $this->registration_at ? $this->registration_at->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'registration_ip':
                        $stmt->bindValue($identifier, $this->registration_ip, PDO::PARAM_STR);
                        break;
                    case 'registration_confirmed':
                        $stmt->bindValue($identifier, (int) $this->registration_confirmed, PDO::PARAM_INT);
                        break;
                    case 'registration_confirmed_at':
                        $stmt->bindValue($identifier, $this->registration_confirmed_at ? $this->registration_confirmed_at->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'registration_confirmed_ip':
                        $stmt->bindValue($identifier, $this->registration_confirmed_ip, PDO::PARAM_STR);
                        break;
                    case 'registration_confirmation_code':
                        $stmt->bindValue($identifier, $this->registration_confirmation_code, PDO::PARAM_STR);
                        break;
                    case 'authentication_at':
                        $stmt->bindValue($identifier, $this->authentication_at ? $this->authentication_at->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'authentication_ip':
                        $stmt->bindValue($identifier, $this->authentication_ip, PDO::PARAM_STR);
                        break;
                    case 'authentication_key':
                        $stmt->bindValue($identifier, $this->authentication_key, PDO::PARAM_STR);
                        break;
                    case 'authentication_token':
                        $stmt->bindValue($identifier, $this->authentication_token, PDO::PARAM_STR);
                        break;
                    case 'authentication_token_at':
                        $stmt->bindValue($identifier, $this->authentication_token_at ? $this->authentication_token_at->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'authentication_token_ip':
                        $stmt->bindValue($identifier, $this->authentication_token_ip, PDO::PARAM_STR);
                        break;
                    case 'authentication_attempt_count':
                        $stmt->bindValue($identifier, $this->authentication_attempt_count, PDO::PARAM_INT);
                        break;
                    case 'track_at':
                        $stmt->bindValue($identifier, $this->track_at ? $this->track_at->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'track_ip':
                        $stmt->bindValue($identifier, $this->track_ip, PDO::PARAM_STR);
                        break;
                    case 'track_url':
                        $stmt->bindValue($identifier, $this->track_url, PDO::PARAM_STR);
                        break;
                    case 'ban_from':
                        $stmt->bindValue($identifier, $this->ban_from ? $this->ban_from->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'ban_until':
                        $stmt->bindValue($identifier, $this->ban_until ? $this->ban_until->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'ban_reason':
                        $stmt->bindValue($identifier, $this->ban_reason, PDO::PARAM_STR);
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
        $pos = UserTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getRole();
                break;
            case 2:
                return $this->getEmail();
                break;
            case 3:
                return $this->getUsername();
                break;
            case 4:
                return $this->getPassword();
                break;
            case 5:
                return $this->getPhoto();
                break;
            case 6:
                return $this->getFirstname();
                break;
            case 7:
                return $this->getLastname();
                break;
            case 8:
                return $this->getGender();
                break;
            case 9:
                return $this->getBirthday();
                break;
            case 10:
                return $this->getAbout();
                break;
            case 11:
                return $this->getParams();
                break;
            case 12:
                return $this->getRegistrationAt();
                break;
            case 13:
                return $this->getRegistrationIp();
                break;
            case 14:
                return $this->getRegistrationConfirmed();
                break;
            case 15:
                return $this->getRegistrationConfirmedAt();
                break;
            case 16:
                return $this->getRegistrationConfirmedIp();
                break;
            case 17:
                return $this->getRegistrationConfirmationCode();
                break;
            case 18:
                return $this->getAuthenticationAt();
                break;
            case 19:
                return $this->getAuthenticationIp();
                break;
            case 20:
                return $this->getAuthenticationKey();
                break;
            case 21:
                return $this->getAuthenticationToken();
                break;
            case 22:
                return $this->getAuthenticationTokenAt();
                break;
            case 23:
                return $this->getAuthenticationTokenIp();
                break;
            case 24:
                return $this->getAuthenticationAttemptCount();
                break;
            case 25:
                return $this->getTrackAt();
                break;
            case 26:
                return $this->getTrackIp();
                break;
            case 27:
                return $this->getTrackUrl();
                break;
            case 28:
                return $this->getBanFrom();
                break;
            case 29:
                return $this->getBanUntil();
                break;
            case 30:
                return $this->getBanReason();
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

        if (isset($alreadyDumpedObjects['User'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['User'][$this->hashCode()] = true;
        $keys = UserTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getRole(),
            $keys[2] => $this->getEmail(),
            $keys[3] => $this->getUsername(),
            $keys[4] => ($includeLazyLoadColumns) ? $this->getPassword() : null,
            $keys[5] => $this->getPhoto(),
            $keys[6] => $this->getFirstname(),
            $keys[7] => $this->getLastname(),
            $keys[8] => $this->getGender(),
            $keys[9] => $this->getBirthday(),
            $keys[10] => ($includeLazyLoadColumns) ? $this->getAbout() : null,
            $keys[11] => ($includeLazyLoadColumns) ? $this->getParams() : null,
            $keys[12] => $this->getRegistrationAt(),
            $keys[13] => $this->getRegistrationIp(),
            $keys[14] => $this->getRegistrationConfirmed(),
            $keys[15] => $this->getRegistrationConfirmedAt(),
            $keys[16] => $this->getRegistrationConfirmedIp(),
            $keys[17] => ($includeLazyLoadColumns) ? $this->getRegistrationConfirmationCode() : null,
            $keys[18] => $this->getAuthenticationAt(),
            $keys[19] => $this->getAuthenticationIp(),
            $keys[20] => ($includeLazyLoadColumns) ? $this->getAuthenticationKey() : null,
            $keys[21] => ($includeLazyLoadColumns) ? $this->getAuthenticationToken() : null,
            $keys[22] => $this->getAuthenticationTokenAt(),
            $keys[23] => $this->getAuthenticationTokenIp(),
            $keys[24] => $this->getAuthenticationAttemptCount(),
            $keys[25] => $this->getTrackAt(),
            $keys[26] => $this->getTrackIp(),
            $keys[27] => $this->getTrackUrl(),
            $keys[28] => $this->getBanFrom(),
            $keys[29] => $this->getBanUntil(),
            $keys[30] => $this->getBanReason(),
        );
        if ($result[$keys[9]] instanceof \DateTimeInterface) {
            $result[$keys[9]] = $result[$keys[9]]->format('c');
        }

        if ($result[$keys[12]] instanceof \DateTimeInterface) {
            $result[$keys[12]] = $result[$keys[12]]->format('c');
        }

        if ($result[$keys[15]] instanceof \DateTimeInterface) {
            $result[$keys[15]] = $result[$keys[15]]->format('c');
        }

        if ($result[$keys[18]] instanceof \DateTimeInterface) {
            $result[$keys[18]] = $result[$keys[18]]->format('c');
        }

        if ($result[$keys[22]] instanceof \DateTimeInterface) {
            $result[$keys[22]] = $result[$keys[22]]->format('c');
        }

        if ($result[$keys[25]] instanceof \DateTimeInterface) {
            $result[$keys[25]] = $result[$keys[25]]->format('c');
        }

        if ($result[$keys[28]] instanceof \DateTimeInterface) {
            $result[$keys[28]] = $result[$keys[28]]->format('c');
        }

        if ($result[$keys[29]] instanceof \DateTimeInterface) {
            $result[$keys[29]] = $result[$keys[29]]->format('c');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collBannersRelatedByCreatedBy) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'banners';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'fenric_banners';
                        break;
                    default:
                        $key = 'Banners';
                }

                $result[$key] = $this->collBannersRelatedByCreatedBy->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collBannersRelatedByUpdatedBy) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'banners';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'fenric_banners';
                        break;
                    default:
                        $key = 'Banners';
                }

                $result[$key] = $this->collBannersRelatedByUpdatedBy->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collBannerGroupsRelatedByCreatedBy) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'bannerGroups';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'fenric_banner_groups';
                        break;
                    default:
                        $key = 'BannerGroups';
                }

                $result[$key] = $this->collBannerGroupsRelatedByCreatedBy->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collBannerGroupsRelatedByUpdatedBy) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'bannerGroups';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'fenric_banner_groups';
                        break;
                    default:
                        $key = 'BannerGroups';
                }

                $result[$key] = $this->collBannerGroupsRelatedByUpdatedBy->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collBannerClientsRelatedByCreatedBy) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'bannerClients';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'fenric_banner_clients';
                        break;
                    default:
                        $key = 'BannerClients';
                }

                $result[$key] = $this->collBannerClientsRelatedByCreatedBy->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collBannerClientsRelatedByUpdatedBy) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'bannerClients';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'fenric_banner_clients';
                        break;
                    default:
                        $key = 'BannerClients';
                }

                $result[$key] = $this->collBannerClientsRelatedByUpdatedBy->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collCommentsRelatedByCreatedBy) {

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

                $result[$key] = $this->collCommentsRelatedByCreatedBy->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collCommentsRelatedByUpdatedBy) {

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

                $result[$key] = $this->collCommentsRelatedByUpdatedBy->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collCommentsRelatedByDeletedBy) {

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

                $result[$key] = $this->collCommentsRelatedByDeletedBy->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collFieldsRelatedByCreatedBy) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'fields';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'fenric_fields';
                        break;
                    default:
                        $key = 'Fields';
                }

                $result[$key] = $this->collFieldsRelatedByCreatedBy->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collFieldsRelatedByUpdatedBy) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'fields';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'fenric_fields';
                        break;
                    default:
                        $key = 'Fields';
                }

                $result[$key] = $this->collFieldsRelatedByUpdatedBy->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPollsRelatedByCreatedBy) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'polls';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'fenric_polls';
                        break;
                    default:
                        $key = 'Polls';
                }

                $result[$key] = $this->collPollsRelatedByCreatedBy->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPollsRelatedByUpdatedBy) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'polls';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'fenric_polls';
                        break;
                    default:
                        $key = 'Polls';
                }

                $result[$key] = $this->collPollsRelatedByUpdatedBy->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPollVariantsRelatedByCreatedBy) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'pollVariants';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'fenric_poll_variants';
                        break;
                    default:
                        $key = 'PollVariants';
                }

                $result[$key] = $this->collPollVariantsRelatedByCreatedBy->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPollVariantsRelatedByUpdatedBy) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'pollVariants';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'fenric_poll_variants';
                        break;
                    default:
                        $key = 'PollVariants';
                }

                $result[$key] = $this->collPollVariantsRelatedByUpdatedBy->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collSectionsRelatedByCreatedBy) {

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

                $result[$key] = $this->collSectionsRelatedByCreatedBy->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collSectionsRelatedByUpdatedBy) {

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

                $result[$key] = $this->collSectionsRelatedByUpdatedBy->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPublicationsRelatedByCreatedBy) {

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

                $result[$key] = $this->collPublicationsRelatedByCreatedBy->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPublicationsRelatedByUpdatedBy) {

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

                $result[$key] = $this->collPublicationsRelatedByUpdatedBy->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPublicationPhotosRelatedByCreatedBy) {

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

                $result[$key] = $this->collPublicationPhotosRelatedByCreatedBy->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPublicationPhotosRelatedByUpdatedBy) {

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

                $result[$key] = $this->collPublicationPhotosRelatedByUpdatedBy->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collRadiosRelatedByCreatedBy) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'radios';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'fenric_radios';
                        break;
                    default:
                        $key = 'Radios';
                }

                $result[$key] = $this->collRadiosRelatedByCreatedBy->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collRadiosRelatedByUpdatedBy) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'radios';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'fenric_radios';
                        break;
                    default:
                        $key = 'Radios';
                }

                $result[$key] = $this->collRadiosRelatedByUpdatedBy->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collSnippetsRelatedByCreatedBy) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'snippets';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'fenric_snippets';
                        break;
                    default:
                        $key = 'Snippets';
                }

                $result[$key] = $this->collSnippetsRelatedByCreatedBy->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collSnippetsRelatedByUpdatedBy) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'snippets';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'fenric_snippets';
                        break;
                    default:
                        $key = 'Snippets';
                }

                $result[$key] = $this->collSnippetsRelatedByUpdatedBy->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collTagsRelatedByCreatedBy) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'tags';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'fenric_tags';
                        break;
                    default:
                        $key = 'Tags';
                }

                $result[$key] = $this->collTagsRelatedByCreatedBy->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collTagsRelatedByUpdatedBy) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'tags';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'fenric_tags';
                        break;
                    default:
                        $key = 'Tags';
                }

                $result[$key] = $this->collTagsRelatedByUpdatedBy->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Propel\Models\User
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = UserTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Propel\Models\User
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setRole($value);
                break;
            case 2:
                $this->setEmail($value);
                break;
            case 3:
                $this->setUsername($value);
                break;
            case 4:
                $this->setPassword($value);
                break;
            case 5:
                $this->setPhoto($value);
                break;
            case 6:
                $this->setFirstname($value);
                break;
            case 7:
                $this->setLastname($value);
                break;
            case 8:
                $this->setGender($value);
                break;
            case 9:
                $this->setBirthday($value);
                break;
            case 10:
                $this->setAbout($value);
                break;
            case 11:
                $this->setParams($value);
                break;
            case 12:
                $this->setRegistrationAt($value);
                break;
            case 13:
                $this->setRegistrationIp($value);
                break;
            case 14:
                $this->setRegistrationConfirmed($value);
                break;
            case 15:
                $this->setRegistrationConfirmedAt($value);
                break;
            case 16:
                $this->setRegistrationConfirmedIp($value);
                break;
            case 17:
                $this->setRegistrationConfirmationCode($value);
                break;
            case 18:
                $this->setAuthenticationAt($value);
                break;
            case 19:
                $this->setAuthenticationIp($value);
                break;
            case 20:
                $this->setAuthenticationKey($value);
                break;
            case 21:
                $this->setAuthenticationToken($value);
                break;
            case 22:
                $this->setAuthenticationTokenAt($value);
                break;
            case 23:
                $this->setAuthenticationTokenIp($value);
                break;
            case 24:
                $this->setAuthenticationAttemptCount($value);
                break;
            case 25:
                $this->setTrackAt($value);
                break;
            case 26:
                $this->setTrackIp($value);
                break;
            case 27:
                $this->setTrackUrl($value);
                break;
            case 28:
                $this->setBanFrom($value);
                break;
            case 29:
                $this->setBanUntil($value);
                break;
            case 30:
                $this->setBanReason($value);
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
        $keys = UserTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setRole($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setEmail($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setUsername($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setPassword($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setPhoto($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setFirstname($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setLastname($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setGender($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setBirthday($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setAbout($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setParams($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->setRegistrationAt($arr[$keys[12]]);
        }
        if (array_key_exists($keys[13], $arr)) {
            $this->setRegistrationIp($arr[$keys[13]]);
        }
        if (array_key_exists($keys[14], $arr)) {
            $this->setRegistrationConfirmed($arr[$keys[14]]);
        }
        if (array_key_exists($keys[15], $arr)) {
            $this->setRegistrationConfirmedAt($arr[$keys[15]]);
        }
        if (array_key_exists($keys[16], $arr)) {
            $this->setRegistrationConfirmedIp($arr[$keys[16]]);
        }
        if (array_key_exists($keys[17], $arr)) {
            $this->setRegistrationConfirmationCode($arr[$keys[17]]);
        }
        if (array_key_exists($keys[18], $arr)) {
            $this->setAuthenticationAt($arr[$keys[18]]);
        }
        if (array_key_exists($keys[19], $arr)) {
            $this->setAuthenticationIp($arr[$keys[19]]);
        }
        if (array_key_exists($keys[20], $arr)) {
            $this->setAuthenticationKey($arr[$keys[20]]);
        }
        if (array_key_exists($keys[21], $arr)) {
            $this->setAuthenticationToken($arr[$keys[21]]);
        }
        if (array_key_exists($keys[22], $arr)) {
            $this->setAuthenticationTokenAt($arr[$keys[22]]);
        }
        if (array_key_exists($keys[23], $arr)) {
            $this->setAuthenticationTokenIp($arr[$keys[23]]);
        }
        if (array_key_exists($keys[24], $arr)) {
            $this->setAuthenticationAttemptCount($arr[$keys[24]]);
        }
        if (array_key_exists($keys[25], $arr)) {
            $this->setTrackAt($arr[$keys[25]]);
        }
        if (array_key_exists($keys[26], $arr)) {
            $this->setTrackIp($arr[$keys[26]]);
        }
        if (array_key_exists($keys[27], $arr)) {
            $this->setTrackUrl($arr[$keys[27]]);
        }
        if (array_key_exists($keys[28], $arr)) {
            $this->setBanFrom($arr[$keys[28]]);
        }
        if (array_key_exists($keys[29], $arr)) {
            $this->setBanUntil($arr[$keys[29]]);
        }
        if (array_key_exists($keys[30], $arr)) {
            $this->setBanReason($arr[$keys[30]]);
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
     * @return $this|\Propel\Models\User The current object, for fluid interface
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
        $criteria = new Criteria(UserTableMap::DATABASE_NAME);

        if ($this->isColumnModified(UserTableMap::COL_ID)) {
            $criteria->add(UserTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(UserTableMap::COL_ROLE)) {
            $criteria->add(UserTableMap::COL_ROLE, $this->role);
        }
        if ($this->isColumnModified(UserTableMap::COL_EMAIL)) {
            $criteria->add(UserTableMap::COL_EMAIL, $this->email);
        }
        if ($this->isColumnModified(UserTableMap::COL_USERNAME)) {
            $criteria->add(UserTableMap::COL_USERNAME, $this->username);
        }
        if ($this->isColumnModified(UserTableMap::COL_PASSWORD)) {
            $criteria->add(UserTableMap::COL_PASSWORD, $this->password);
        }
        if ($this->isColumnModified(UserTableMap::COL_PHOTO)) {
            $criteria->add(UserTableMap::COL_PHOTO, $this->photo);
        }
        if ($this->isColumnModified(UserTableMap::COL_FIRSTNAME)) {
            $criteria->add(UserTableMap::COL_FIRSTNAME, $this->firstname);
        }
        if ($this->isColumnModified(UserTableMap::COL_LASTNAME)) {
            $criteria->add(UserTableMap::COL_LASTNAME, $this->lastname);
        }
        if ($this->isColumnModified(UserTableMap::COL_GENDER)) {
            $criteria->add(UserTableMap::COL_GENDER, $this->gender);
        }
        if ($this->isColumnModified(UserTableMap::COL_BIRTHDAY)) {
            $criteria->add(UserTableMap::COL_BIRTHDAY, $this->birthday);
        }
        if ($this->isColumnModified(UserTableMap::COL_ABOUT)) {
            $criteria->add(UserTableMap::COL_ABOUT, $this->about);
        }
        if ($this->isColumnModified(UserTableMap::COL_PARAMS)) {
            $criteria->add(UserTableMap::COL_PARAMS, $this->params);
        }
        if ($this->isColumnModified(UserTableMap::COL_REGISTRATION_AT)) {
            $criteria->add(UserTableMap::COL_REGISTRATION_AT, $this->registration_at);
        }
        if ($this->isColumnModified(UserTableMap::COL_REGISTRATION_IP)) {
            $criteria->add(UserTableMap::COL_REGISTRATION_IP, $this->registration_ip);
        }
        if ($this->isColumnModified(UserTableMap::COL_REGISTRATION_CONFIRMED)) {
            $criteria->add(UserTableMap::COL_REGISTRATION_CONFIRMED, $this->registration_confirmed);
        }
        if ($this->isColumnModified(UserTableMap::COL_REGISTRATION_CONFIRMED_AT)) {
            $criteria->add(UserTableMap::COL_REGISTRATION_CONFIRMED_AT, $this->registration_confirmed_at);
        }
        if ($this->isColumnModified(UserTableMap::COL_REGISTRATION_CONFIRMED_IP)) {
            $criteria->add(UserTableMap::COL_REGISTRATION_CONFIRMED_IP, $this->registration_confirmed_ip);
        }
        if ($this->isColumnModified(UserTableMap::COL_REGISTRATION_CONFIRMATION_CODE)) {
            $criteria->add(UserTableMap::COL_REGISTRATION_CONFIRMATION_CODE, $this->registration_confirmation_code);
        }
        if ($this->isColumnModified(UserTableMap::COL_AUTHENTICATION_AT)) {
            $criteria->add(UserTableMap::COL_AUTHENTICATION_AT, $this->authentication_at);
        }
        if ($this->isColumnModified(UserTableMap::COL_AUTHENTICATION_IP)) {
            $criteria->add(UserTableMap::COL_AUTHENTICATION_IP, $this->authentication_ip);
        }
        if ($this->isColumnModified(UserTableMap::COL_AUTHENTICATION_KEY)) {
            $criteria->add(UserTableMap::COL_AUTHENTICATION_KEY, $this->authentication_key);
        }
        if ($this->isColumnModified(UserTableMap::COL_AUTHENTICATION_TOKEN)) {
            $criteria->add(UserTableMap::COL_AUTHENTICATION_TOKEN, $this->authentication_token);
        }
        if ($this->isColumnModified(UserTableMap::COL_AUTHENTICATION_TOKEN_AT)) {
            $criteria->add(UserTableMap::COL_AUTHENTICATION_TOKEN_AT, $this->authentication_token_at);
        }
        if ($this->isColumnModified(UserTableMap::COL_AUTHENTICATION_TOKEN_IP)) {
            $criteria->add(UserTableMap::COL_AUTHENTICATION_TOKEN_IP, $this->authentication_token_ip);
        }
        if ($this->isColumnModified(UserTableMap::COL_AUTHENTICATION_ATTEMPT_COUNT)) {
            $criteria->add(UserTableMap::COL_AUTHENTICATION_ATTEMPT_COUNT, $this->authentication_attempt_count);
        }
        if ($this->isColumnModified(UserTableMap::COL_TRACK_AT)) {
            $criteria->add(UserTableMap::COL_TRACK_AT, $this->track_at);
        }
        if ($this->isColumnModified(UserTableMap::COL_TRACK_IP)) {
            $criteria->add(UserTableMap::COL_TRACK_IP, $this->track_ip);
        }
        if ($this->isColumnModified(UserTableMap::COL_TRACK_URL)) {
            $criteria->add(UserTableMap::COL_TRACK_URL, $this->track_url);
        }
        if ($this->isColumnModified(UserTableMap::COL_BAN_FROM)) {
            $criteria->add(UserTableMap::COL_BAN_FROM, $this->ban_from);
        }
        if ($this->isColumnModified(UserTableMap::COL_BAN_UNTIL)) {
            $criteria->add(UserTableMap::COL_BAN_UNTIL, $this->ban_until);
        }
        if ($this->isColumnModified(UserTableMap::COL_BAN_REASON)) {
            $criteria->add(UserTableMap::COL_BAN_REASON, $this->ban_reason);
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
        $criteria = ChildUserQuery::create();
        $criteria->add(UserTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \Propel\Models\User (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setRole($this->getRole());
        $copyObj->setEmail($this->getEmail());
        $copyObj->setUsername($this->getUsername());
        $copyObj->setPassword($this->getPassword());
        $copyObj->setPhoto($this->getPhoto());
        $copyObj->setFirstname($this->getFirstname());
        $copyObj->setLastname($this->getLastname());
        $copyObj->setGender($this->getGender());
        $copyObj->setBirthday($this->getBirthday());
        $copyObj->setAbout($this->getAbout());
        $copyObj->setParams($this->getParams());
        $copyObj->setRegistrationAt($this->getRegistrationAt());
        $copyObj->setRegistrationIp($this->getRegistrationIp());
        $copyObj->setRegistrationConfirmed($this->getRegistrationConfirmed());
        $copyObj->setRegistrationConfirmedAt($this->getRegistrationConfirmedAt());
        $copyObj->setRegistrationConfirmedIp($this->getRegistrationConfirmedIp());
        $copyObj->setRegistrationConfirmationCode($this->getRegistrationConfirmationCode());
        $copyObj->setAuthenticationAt($this->getAuthenticationAt());
        $copyObj->setAuthenticationIp($this->getAuthenticationIp());
        $copyObj->setAuthenticationKey($this->getAuthenticationKey());
        $copyObj->setAuthenticationToken($this->getAuthenticationToken());
        $copyObj->setAuthenticationTokenAt($this->getAuthenticationTokenAt());
        $copyObj->setAuthenticationTokenIp($this->getAuthenticationTokenIp());
        $copyObj->setAuthenticationAttemptCount($this->getAuthenticationAttemptCount());
        $copyObj->setTrackAt($this->getTrackAt());
        $copyObj->setTrackIp($this->getTrackIp());
        $copyObj->setTrackUrl($this->getTrackUrl());
        $copyObj->setBanFrom($this->getBanFrom());
        $copyObj->setBanUntil($this->getBanUntil());
        $copyObj->setBanReason($this->getBanReason());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getBannersRelatedByCreatedBy() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addBannerRelatedByCreatedBy($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getBannersRelatedByUpdatedBy() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addBannerRelatedByUpdatedBy($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getBannerGroupsRelatedByCreatedBy() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addBannerGroupRelatedByCreatedBy($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getBannerGroupsRelatedByUpdatedBy() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addBannerGroupRelatedByUpdatedBy($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getBannerClientsRelatedByCreatedBy() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addBannerClientRelatedByCreatedBy($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getBannerClientsRelatedByUpdatedBy() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addBannerClientRelatedByUpdatedBy($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getCommentsRelatedByCreatedBy() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCommentRelatedByCreatedBy($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getCommentsRelatedByUpdatedBy() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCommentRelatedByUpdatedBy($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getCommentsRelatedByDeletedBy() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCommentRelatedByDeletedBy($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getFieldsRelatedByCreatedBy() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFieldRelatedByCreatedBy($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getFieldsRelatedByUpdatedBy() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFieldRelatedByUpdatedBy($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPollsRelatedByCreatedBy() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPollRelatedByCreatedBy($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPollsRelatedByUpdatedBy() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPollRelatedByUpdatedBy($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPollVariantsRelatedByCreatedBy() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPollVariantRelatedByCreatedBy($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPollVariantsRelatedByUpdatedBy() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPollVariantRelatedByUpdatedBy($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSectionsRelatedByCreatedBy() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSectionRelatedByCreatedBy($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSectionsRelatedByUpdatedBy() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSectionRelatedByUpdatedBy($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPublicationsRelatedByCreatedBy() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPublicationRelatedByCreatedBy($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPublicationsRelatedByUpdatedBy() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPublicationRelatedByUpdatedBy($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPublicationPhotosRelatedByCreatedBy() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPublicationPhotoRelatedByCreatedBy($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPublicationPhotosRelatedByUpdatedBy() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPublicationPhotoRelatedByUpdatedBy($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getRadiosRelatedByCreatedBy() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRadioRelatedByCreatedBy($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getRadiosRelatedByUpdatedBy() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRadioRelatedByUpdatedBy($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSnippetsRelatedByCreatedBy() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSnippetRelatedByCreatedBy($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSnippetsRelatedByUpdatedBy() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSnippetRelatedByUpdatedBy($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getTagsRelatedByCreatedBy() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addTagRelatedByCreatedBy($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getTagsRelatedByUpdatedBy() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addTagRelatedByUpdatedBy($relObj->copy($deepCopy));
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
     * @return \Propel\Models\User Clone of current object.
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
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('BannerRelatedByCreatedBy' == $relationName) {
            $this->initBannersRelatedByCreatedBy();
            return;
        }
        if ('BannerRelatedByUpdatedBy' == $relationName) {
            $this->initBannersRelatedByUpdatedBy();
            return;
        }
        if ('BannerGroupRelatedByCreatedBy' == $relationName) {
            $this->initBannerGroupsRelatedByCreatedBy();
            return;
        }
        if ('BannerGroupRelatedByUpdatedBy' == $relationName) {
            $this->initBannerGroupsRelatedByUpdatedBy();
            return;
        }
        if ('BannerClientRelatedByCreatedBy' == $relationName) {
            $this->initBannerClientsRelatedByCreatedBy();
            return;
        }
        if ('BannerClientRelatedByUpdatedBy' == $relationName) {
            $this->initBannerClientsRelatedByUpdatedBy();
            return;
        }
        if ('CommentRelatedByCreatedBy' == $relationName) {
            $this->initCommentsRelatedByCreatedBy();
            return;
        }
        if ('CommentRelatedByUpdatedBy' == $relationName) {
            $this->initCommentsRelatedByUpdatedBy();
            return;
        }
        if ('CommentRelatedByDeletedBy' == $relationName) {
            $this->initCommentsRelatedByDeletedBy();
            return;
        }
        if ('FieldRelatedByCreatedBy' == $relationName) {
            $this->initFieldsRelatedByCreatedBy();
            return;
        }
        if ('FieldRelatedByUpdatedBy' == $relationName) {
            $this->initFieldsRelatedByUpdatedBy();
            return;
        }
        if ('PollRelatedByCreatedBy' == $relationName) {
            $this->initPollsRelatedByCreatedBy();
            return;
        }
        if ('PollRelatedByUpdatedBy' == $relationName) {
            $this->initPollsRelatedByUpdatedBy();
            return;
        }
        if ('PollVariantRelatedByCreatedBy' == $relationName) {
            $this->initPollVariantsRelatedByCreatedBy();
            return;
        }
        if ('PollVariantRelatedByUpdatedBy' == $relationName) {
            $this->initPollVariantsRelatedByUpdatedBy();
            return;
        }
        if ('SectionRelatedByCreatedBy' == $relationName) {
            $this->initSectionsRelatedByCreatedBy();
            return;
        }
        if ('SectionRelatedByUpdatedBy' == $relationName) {
            $this->initSectionsRelatedByUpdatedBy();
            return;
        }
        if ('PublicationRelatedByCreatedBy' == $relationName) {
            $this->initPublicationsRelatedByCreatedBy();
            return;
        }
        if ('PublicationRelatedByUpdatedBy' == $relationName) {
            $this->initPublicationsRelatedByUpdatedBy();
            return;
        }
        if ('PublicationPhotoRelatedByCreatedBy' == $relationName) {
            $this->initPublicationPhotosRelatedByCreatedBy();
            return;
        }
        if ('PublicationPhotoRelatedByUpdatedBy' == $relationName) {
            $this->initPublicationPhotosRelatedByUpdatedBy();
            return;
        }
        if ('RadioRelatedByCreatedBy' == $relationName) {
            $this->initRadiosRelatedByCreatedBy();
            return;
        }
        if ('RadioRelatedByUpdatedBy' == $relationName) {
            $this->initRadiosRelatedByUpdatedBy();
            return;
        }
        if ('SnippetRelatedByCreatedBy' == $relationName) {
            $this->initSnippetsRelatedByCreatedBy();
            return;
        }
        if ('SnippetRelatedByUpdatedBy' == $relationName) {
            $this->initSnippetsRelatedByUpdatedBy();
            return;
        }
        if ('TagRelatedByCreatedBy' == $relationName) {
            $this->initTagsRelatedByCreatedBy();
            return;
        }
        if ('TagRelatedByUpdatedBy' == $relationName) {
            $this->initTagsRelatedByUpdatedBy();
            return;
        }
        if ('UserFavorite' == $relationName) {
            $this->initUserFavorites();
            return;
        }
    }

    /**
     * Clears out the collBannersRelatedByCreatedBy collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addBannersRelatedByCreatedBy()
     */
    public function clearBannersRelatedByCreatedBy()
    {
        $this->collBannersRelatedByCreatedBy = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collBannersRelatedByCreatedBy collection loaded partially.
     */
    public function resetPartialBannersRelatedByCreatedBy($v = true)
    {
        $this->collBannersRelatedByCreatedByPartial = $v;
    }

    /**
     * Initializes the collBannersRelatedByCreatedBy collection.
     *
     * By default this just sets the collBannersRelatedByCreatedBy collection to an empty array (like clearcollBannersRelatedByCreatedBy());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initBannersRelatedByCreatedBy($overrideExisting = true)
    {
        if (null !== $this->collBannersRelatedByCreatedBy && !$overrideExisting) {
            return;
        }

        $collectionClassName = BannerTableMap::getTableMap()->getCollectionClassName();

        $this->collBannersRelatedByCreatedBy = new $collectionClassName;
        $this->collBannersRelatedByCreatedBy->setModel('\Propel\Models\Banner');
    }

    /**
     * Gets an array of ChildBanner objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildBanner[] List of ChildBanner objects
     * @throws PropelException
     */
    public function getBannersRelatedByCreatedBy(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collBannersRelatedByCreatedByPartial && !$this->isNew();
        if (null === $this->collBannersRelatedByCreatedBy || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collBannersRelatedByCreatedBy) {
                // return empty collection
                $this->initBannersRelatedByCreatedBy();
            } else {
                $collBannersRelatedByCreatedBy = ChildBannerQuery::create(null, $criteria)
                    ->filterByUserRelatedByCreatedBy($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collBannersRelatedByCreatedByPartial && count($collBannersRelatedByCreatedBy)) {
                        $this->initBannersRelatedByCreatedBy(false);

                        foreach ($collBannersRelatedByCreatedBy as $obj) {
                            if (false == $this->collBannersRelatedByCreatedBy->contains($obj)) {
                                $this->collBannersRelatedByCreatedBy->append($obj);
                            }
                        }

                        $this->collBannersRelatedByCreatedByPartial = true;
                    }

                    return $collBannersRelatedByCreatedBy;
                }

                if ($partial && $this->collBannersRelatedByCreatedBy) {
                    foreach ($this->collBannersRelatedByCreatedBy as $obj) {
                        if ($obj->isNew()) {
                            $collBannersRelatedByCreatedBy[] = $obj;
                        }
                    }
                }

                $this->collBannersRelatedByCreatedBy = $collBannersRelatedByCreatedBy;
                $this->collBannersRelatedByCreatedByPartial = false;
            }
        }

        return $this->collBannersRelatedByCreatedBy;
    }

    /**
     * Sets a collection of ChildBanner objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $bannersRelatedByCreatedBy A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setBannersRelatedByCreatedBy(Collection $bannersRelatedByCreatedBy, ConnectionInterface $con = null)
    {
        /** @var ChildBanner[] $bannersRelatedByCreatedByToDelete */
        $bannersRelatedByCreatedByToDelete = $this->getBannersRelatedByCreatedBy(new Criteria(), $con)->diff($bannersRelatedByCreatedBy);


        $this->bannersRelatedByCreatedByScheduledForDeletion = $bannersRelatedByCreatedByToDelete;

        foreach ($bannersRelatedByCreatedByToDelete as $bannerRelatedByCreatedByRemoved) {
            $bannerRelatedByCreatedByRemoved->setUserRelatedByCreatedBy(null);
        }

        $this->collBannersRelatedByCreatedBy = null;
        foreach ($bannersRelatedByCreatedBy as $bannerRelatedByCreatedBy) {
            $this->addBannerRelatedByCreatedBy($bannerRelatedByCreatedBy);
        }

        $this->collBannersRelatedByCreatedBy = $bannersRelatedByCreatedBy;
        $this->collBannersRelatedByCreatedByPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Banner objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Banner objects.
     * @throws PropelException
     */
    public function countBannersRelatedByCreatedBy(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collBannersRelatedByCreatedByPartial && !$this->isNew();
        if (null === $this->collBannersRelatedByCreatedBy || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collBannersRelatedByCreatedBy) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getBannersRelatedByCreatedBy());
            }

            $query = ChildBannerQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUserRelatedByCreatedBy($this)
                ->count($con);
        }

        return count($this->collBannersRelatedByCreatedBy);
    }

    /**
     * Method called to associate a ChildBanner object to this object
     * through the ChildBanner foreign key attribute.
     *
     * @param  ChildBanner $l ChildBanner
     * @return $this|\Propel\Models\User The current object (for fluent API support)
     */
    public function addBannerRelatedByCreatedBy(ChildBanner $l)
    {
        if ($this->collBannersRelatedByCreatedBy === null) {
            $this->initBannersRelatedByCreatedBy();
            $this->collBannersRelatedByCreatedByPartial = true;
        }

        if (!$this->collBannersRelatedByCreatedBy->contains($l)) {
            $this->doAddBannerRelatedByCreatedBy($l);

            if ($this->bannersRelatedByCreatedByScheduledForDeletion and $this->bannersRelatedByCreatedByScheduledForDeletion->contains($l)) {
                $this->bannersRelatedByCreatedByScheduledForDeletion->remove($this->bannersRelatedByCreatedByScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildBanner $bannerRelatedByCreatedBy The ChildBanner object to add.
     */
    protected function doAddBannerRelatedByCreatedBy(ChildBanner $bannerRelatedByCreatedBy)
    {
        $this->collBannersRelatedByCreatedBy[]= $bannerRelatedByCreatedBy;
        $bannerRelatedByCreatedBy->setUserRelatedByCreatedBy($this);
    }

    /**
     * @param  ChildBanner $bannerRelatedByCreatedBy The ChildBanner object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removeBannerRelatedByCreatedBy(ChildBanner $bannerRelatedByCreatedBy)
    {
        if ($this->getBannersRelatedByCreatedBy()->contains($bannerRelatedByCreatedBy)) {
            $pos = $this->collBannersRelatedByCreatedBy->search($bannerRelatedByCreatedBy);
            $this->collBannersRelatedByCreatedBy->remove($pos);
            if (null === $this->bannersRelatedByCreatedByScheduledForDeletion) {
                $this->bannersRelatedByCreatedByScheduledForDeletion = clone $this->collBannersRelatedByCreatedBy;
                $this->bannersRelatedByCreatedByScheduledForDeletion->clear();
            }
            $this->bannersRelatedByCreatedByScheduledForDeletion[]= $bannerRelatedByCreatedBy;
            $bannerRelatedByCreatedBy->setUserRelatedByCreatedBy(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related BannersRelatedByCreatedBy from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildBanner[] List of ChildBanner objects
     */
    public function getBannersRelatedByCreatedByJoinBannerGroup(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildBannerQuery::create(null, $criteria);
        $query->joinWith('BannerGroup', $joinBehavior);

        return $this->getBannersRelatedByCreatedBy($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related BannersRelatedByCreatedBy from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildBanner[] List of ChildBanner objects
     */
    public function getBannersRelatedByCreatedByJoinBannerClient(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildBannerQuery::create(null, $criteria);
        $query->joinWith('BannerClient', $joinBehavior);

        return $this->getBannersRelatedByCreatedBy($query, $con);
    }

    /**
     * Clears out the collBannersRelatedByUpdatedBy collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addBannersRelatedByUpdatedBy()
     */
    public function clearBannersRelatedByUpdatedBy()
    {
        $this->collBannersRelatedByUpdatedBy = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collBannersRelatedByUpdatedBy collection loaded partially.
     */
    public function resetPartialBannersRelatedByUpdatedBy($v = true)
    {
        $this->collBannersRelatedByUpdatedByPartial = $v;
    }

    /**
     * Initializes the collBannersRelatedByUpdatedBy collection.
     *
     * By default this just sets the collBannersRelatedByUpdatedBy collection to an empty array (like clearcollBannersRelatedByUpdatedBy());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initBannersRelatedByUpdatedBy($overrideExisting = true)
    {
        if (null !== $this->collBannersRelatedByUpdatedBy && !$overrideExisting) {
            return;
        }

        $collectionClassName = BannerTableMap::getTableMap()->getCollectionClassName();

        $this->collBannersRelatedByUpdatedBy = new $collectionClassName;
        $this->collBannersRelatedByUpdatedBy->setModel('\Propel\Models\Banner');
    }

    /**
     * Gets an array of ChildBanner objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildBanner[] List of ChildBanner objects
     * @throws PropelException
     */
    public function getBannersRelatedByUpdatedBy(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collBannersRelatedByUpdatedByPartial && !$this->isNew();
        if (null === $this->collBannersRelatedByUpdatedBy || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collBannersRelatedByUpdatedBy) {
                // return empty collection
                $this->initBannersRelatedByUpdatedBy();
            } else {
                $collBannersRelatedByUpdatedBy = ChildBannerQuery::create(null, $criteria)
                    ->filterByUserRelatedByUpdatedBy($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collBannersRelatedByUpdatedByPartial && count($collBannersRelatedByUpdatedBy)) {
                        $this->initBannersRelatedByUpdatedBy(false);

                        foreach ($collBannersRelatedByUpdatedBy as $obj) {
                            if (false == $this->collBannersRelatedByUpdatedBy->contains($obj)) {
                                $this->collBannersRelatedByUpdatedBy->append($obj);
                            }
                        }

                        $this->collBannersRelatedByUpdatedByPartial = true;
                    }

                    return $collBannersRelatedByUpdatedBy;
                }

                if ($partial && $this->collBannersRelatedByUpdatedBy) {
                    foreach ($this->collBannersRelatedByUpdatedBy as $obj) {
                        if ($obj->isNew()) {
                            $collBannersRelatedByUpdatedBy[] = $obj;
                        }
                    }
                }

                $this->collBannersRelatedByUpdatedBy = $collBannersRelatedByUpdatedBy;
                $this->collBannersRelatedByUpdatedByPartial = false;
            }
        }

        return $this->collBannersRelatedByUpdatedBy;
    }

    /**
     * Sets a collection of ChildBanner objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $bannersRelatedByUpdatedBy A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setBannersRelatedByUpdatedBy(Collection $bannersRelatedByUpdatedBy, ConnectionInterface $con = null)
    {
        /** @var ChildBanner[] $bannersRelatedByUpdatedByToDelete */
        $bannersRelatedByUpdatedByToDelete = $this->getBannersRelatedByUpdatedBy(new Criteria(), $con)->diff($bannersRelatedByUpdatedBy);


        $this->bannersRelatedByUpdatedByScheduledForDeletion = $bannersRelatedByUpdatedByToDelete;

        foreach ($bannersRelatedByUpdatedByToDelete as $bannerRelatedByUpdatedByRemoved) {
            $bannerRelatedByUpdatedByRemoved->setUserRelatedByUpdatedBy(null);
        }

        $this->collBannersRelatedByUpdatedBy = null;
        foreach ($bannersRelatedByUpdatedBy as $bannerRelatedByUpdatedBy) {
            $this->addBannerRelatedByUpdatedBy($bannerRelatedByUpdatedBy);
        }

        $this->collBannersRelatedByUpdatedBy = $bannersRelatedByUpdatedBy;
        $this->collBannersRelatedByUpdatedByPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Banner objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Banner objects.
     * @throws PropelException
     */
    public function countBannersRelatedByUpdatedBy(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collBannersRelatedByUpdatedByPartial && !$this->isNew();
        if (null === $this->collBannersRelatedByUpdatedBy || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collBannersRelatedByUpdatedBy) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getBannersRelatedByUpdatedBy());
            }

            $query = ChildBannerQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUserRelatedByUpdatedBy($this)
                ->count($con);
        }

        return count($this->collBannersRelatedByUpdatedBy);
    }

    /**
     * Method called to associate a ChildBanner object to this object
     * through the ChildBanner foreign key attribute.
     *
     * @param  ChildBanner $l ChildBanner
     * @return $this|\Propel\Models\User The current object (for fluent API support)
     */
    public function addBannerRelatedByUpdatedBy(ChildBanner $l)
    {
        if ($this->collBannersRelatedByUpdatedBy === null) {
            $this->initBannersRelatedByUpdatedBy();
            $this->collBannersRelatedByUpdatedByPartial = true;
        }

        if (!$this->collBannersRelatedByUpdatedBy->contains($l)) {
            $this->doAddBannerRelatedByUpdatedBy($l);

            if ($this->bannersRelatedByUpdatedByScheduledForDeletion and $this->bannersRelatedByUpdatedByScheduledForDeletion->contains($l)) {
                $this->bannersRelatedByUpdatedByScheduledForDeletion->remove($this->bannersRelatedByUpdatedByScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildBanner $bannerRelatedByUpdatedBy The ChildBanner object to add.
     */
    protected function doAddBannerRelatedByUpdatedBy(ChildBanner $bannerRelatedByUpdatedBy)
    {
        $this->collBannersRelatedByUpdatedBy[]= $bannerRelatedByUpdatedBy;
        $bannerRelatedByUpdatedBy->setUserRelatedByUpdatedBy($this);
    }

    /**
     * @param  ChildBanner $bannerRelatedByUpdatedBy The ChildBanner object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removeBannerRelatedByUpdatedBy(ChildBanner $bannerRelatedByUpdatedBy)
    {
        if ($this->getBannersRelatedByUpdatedBy()->contains($bannerRelatedByUpdatedBy)) {
            $pos = $this->collBannersRelatedByUpdatedBy->search($bannerRelatedByUpdatedBy);
            $this->collBannersRelatedByUpdatedBy->remove($pos);
            if (null === $this->bannersRelatedByUpdatedByScheduledForDeletion) {
                $this->bannersRelatedByUpdatedByScheduledForDeletion = clone $this->collBannersRelatedByUpdatedBy;
                $this->bannersRelatedByUpdatedByScheduledForDeletion->clear();
            }
            $this->bannersRelatedByUpdatedByScheduledForDeletion[]= $bannerRelatedByUpdatedBy;
            $bannerRelatedByUpdatedBy->setUserRelatedByUpdatedBy(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related BannersRelatedByUpdatedBy from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildBanner[] List of ChildBanner objects
     */
    public function getBannersRelatedByUpdatedByJoinBannerGroup(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildBannerQuery::create(null, $criteria);
        $query->joinWith('BannerGroup', $joinBehavior);

        return $this->getBannersRelatedByUpdatedBy($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related BannersRelatedByUpdatedBy from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildBanner[] List of ChildBanner objects
     */
    public function getBannersRelatedByUpdatedByJoinBannerClient(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildBannerQuery::create(null, $criteria);
        $query->joinWith('BannerClient', $joinBehavior);

        return $this->getBannersRelatedByUpdatedBy($query, $con);
    }

    /**
     * Clears out the collBannerGroupsRelatedByCreatedBy collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addBannerGroupsRelatedByCreatedBy()
     */
    public function clearBannerGroupsRelatedByCreatedBy()
    {
        $this->collBannerGroupsRelatedByCreatedBy = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collBannerGroupsRelatedByCreatedBy collection loaded partially.
     */
    public function resetPartialBannerGroupsRelatedByCreatedBy($v = true)
    {
        $this->collBannerGroupsRelatedByCreatedByPartial = $v;
    }

    /**
     * Initializes the collBannerGroupsRelatedByCreatedBy collection.
     *
     * By default this just sets the collBannerGroupsRelatedByCreatedBy collection to an empty array (like clearcollBannerGroupsRelatedByCreatedBy());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initBannerGroupsRelatedByCreatedBy($overrideExisting = true)
    {
        if (null !== $this->collBannerGroupsRelatedByCreatedBy && !$overrideExisting) {
            return;
        }

        $collectionClassName = BannerGroupTableMap::getTableMap()->getCollectionClassName();

        $this->collBannerGroupsRelatedByCreatedBy = new $collectionClassName;
        $this->collBannerGroupsRelatedByCreatedBy->setModel('\Propel\Models\BannerGroup');
    }

    /**
     * Gets an array of ChildBannerGroup objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildBannerGroup[] List of ChildBannerGroup objects
     * @throws PropelException
     */
    public function getBannerGroupsRelatedByCreatedBy(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collBannerGroupsRelatedByCreatedByPartial && !$this->isNew();
        if (null === $this->collBannerGroupsRelatedByCreatedBy || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collBannerGroupsRelatedByCreatedBy) {
                // return empty collection
                $this->initBannerGroupsRelatedByCreatedBy();
            } else {
                $collBannerGroupsRelatedByCreatedBy = ChildBannerGroupQuery::create(null, $criteria)
                    ->filterByUserRelatedByCreatedBy($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collBannerGroupsRelatedByCreatedByPartial && count($collBannerGroupsRelatedByCreatedBy)) {
                        $this->initBannerGroupsRelatedByCreatedBy(false);

                        foreach ($collBannerGroupsRelatedByCreatedBy as $obj) {
                            if (false == $this->collBannerGroupsRelatedByCreatedBy->contains($obj)) {
                                $this->collBannerGroupsRelatedByCreatedBy->append($obj);
                            }
                        }

                        $this->collBannerGroupsRelatedByCreatedByPartial = true;
                    }

                    return $collBannerGroupsRelatedByCreatedBy;
                }

                if ($partial && $this->collBannerGroupsRelatedByCreatedBy) {
                    foreach ($this->collBannerGroupsRelatedByCreatedBy as $obj) {
                        if ($obj->isNew()) {
                            $collBannerGroupsRelatedByCreatedBy[] = $obj;
                        }
                    }
                }

                $this->collBannerGroupsRelatedByCreatedBy = $collBannerGroupsRelatedByCreatedBy;
                $this->collBannerGroupsRelatedByCreatedByPartial = false;
            }
        }

        return $this->collBannerGroupsRelatedByCreatedBy;
    }

    /**
     * Sets a collection of ChildBannerGroup objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $bannerGroupsRelatedByCreatedBy A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setBannerGroupsRelatedByCreatedBy(Collection $bannerGroupsRelatedByCreatedBy, ConnectionInterface $con = null)
    {
        /** @var ChildBannerGroup[] $bannerGroupsRelatedByCreatedByToDelete */
        $bannerGroupsRelatedByCreatedByToDelete = $this->getBannerGroupsRelatedByCreatedBy(new Criteria(), $con)->diff($bannerGroupsRelatedByCreatedBy);


        $this->bannerGroupsRelatedByCreatedByScheduledForDeletion = $bannerGroupsRelatedByCreatedByToDelete;

        foreach ($bannerGroupsRelatedByCreatedByToDelete as $bannerGroupRelatedByCreatedByRemoved) {
            $bannerGroupRelatedByCreatedByRemoved->setUserRelatedByCreatedBy(null);
        }

        $this->collBannerGroupsRelatedByCreatedBy = null;
        foreach ($bannerGroupsRelatedByCreatedBy as $bannerGroupRelatedByCreatedBy) {
            $this->addBannerGroupRelatedByCreatedBy($bannerGroupRelatedByCreatedBy);
        }

        $this->collBannerGroupsRelatedByCreatedBy = $bannerGroupsRelatedByCreatedBy;
        $this->collBannerGroupsRelatedByCreatedByPartial = false;

        return $this;
    }

    /**
     * Returns the number of related BannerGroup objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related BannerGroup objects.
     * @throws PropelException
     */
    public function countBannerGroupsRelatedByCreatedBy(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collBannerGroupsRelatedByCreatedByPartial && !$this->isNew();
        if (null === $this->collBannerGroupsRelatedByCreatedBy || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collBannerGroupsRelatedByCreatedBy) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getBannerGroupsRelatedByCreatedBy());
            }

            $query = ChildBannerGroupQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUserRelatedByCreatedBy($this)
                ->count($con);
        }

        return count($this->collBannerGroupsRelatedByCreatedBy);
    }

    /**
     * Method called to associate a ChildBannerGroup object to this object
     * through the ChildBannerGroup foreign key attribute.
     *
     * @param  ChildBannerGroup $l ChildBannerGroup
     * @return $this|\Propel\Models\User The current object (for fluent API support)
     */
    public function addBannerGroupRelatedByCreatedBy(ChildBannerGroup $l)
    {
        if ($this->collBannerGroupsRelatedByCreatedBy === null) {
            $this->initBannerGroupsRelatedByCreatedBy();
            $this->collBannerGroupsRelatedByCreatedByPartial = true;
        }

        if (!$this->collBannerGroupsRelatedByCreatedBy->contains($l)) {
            $this->doAddBannerGroupRelatedByCreatedBy($l);

            if ($this->bannerGroupsRelatedByCreatedByScheduledForDeletion and $this->bannerGroupsRelatedByCreatedByScheduledForDeletion->contains($l)) {
                $this->bannerGroupsRelatedByCreatedByScheduledForDeletion->remove($this->bannerGroupsRelatedByCreatedByScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildBannerGroup $bannerGroupRelatedByCreatedBy The ChildBannerGroup object to add.
     */
    protected function doAddBannerGroupRelatedByCreatedBy(ChildBannerGroup $bannerGroupRelatedByCreatedBy)
    {
        $this->collBannerGroupsRelatedByCreatedBy[]= $bannerGroupRelatedByCreatedBy;
        $bannerGroupRelatedByCreatedBy->setUserRelatedByCreatedBy($this);
    }

    /**
     * @param  ChildBannerGroup $bannerGroupRelatedByCreatedBy The ChildBannerGroup object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removeBannerGroupRelatedByCreatedBy(ChildBannerGroup $bannerGroupRelatedByCreatedBy)
    {
        if ($this->getBannerGroupsRelatedByCreatedBy()->contains($bannerGroupRelatedByCreatedBy)) {
            $pos = $this->collBannerGroupsRelatedByCreatedBy->search($bannerGroupRelatedByCreatedBy);
            $this->collBannerGroupsRelatedByCreatedBy->remove($pos);
            if (null === $this->bannerGroupsRelatedByCreatedByScheduledForDeletion) {
                $this->bannerGroupsRelatedByCreatedByScheduledForDeletion = clone $this->collBannerGroupsRelatedByCreatedBy;
                $this->bannerGroupsRelatedByCreatedByScheduledForDeletion->clear();
            }
            $this->bannerGroupsRelatedByCreatedByScheduledForDeletion[]= $bannerGroupRelatedByCreatedBy;
            $bannerGroupRelatedByCreatedBy->setUserRelatedByCreatedBy(null);
        }

        return $this;
    }

    /**
     * Clears out the collBannerGroupsRelatedByUpdatedBy collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addBannerGroupsRelatedByUpdatedBy()
     */
    public function clearBannerGroupsRelatedByUpdatedBy()
    {
        $this->collBannerGroupsRelatedByUpdatedBy = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collBannerGroupsRelatedByUpdatedBy collection loaded partially.
     */
    public function resetPartialBannerGroupsRelatedByUpdatedBy($v = true)
    {
        $this->collBannerGroupsRelatedByUpdatedByPartial = $v;
    }

    /**
     * Initializes the collBannerGroupsRelatedByUpdatedBy collection.
     *
     * By default this just sets the collBannerGroupsRelatedByUpdatedBy collection to an empty array (like clearcollBannerGroupsRelatedByUpdatedBy());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initBannerGroupsRelatedByUpdatedBy($overrideExisting = true)
    {
        if (null !== $this->collBannerGroupsRelatedByUpdatedBy && !$overrideExisting) {
            return;
        }

        $collectionClassName = BannerGroupTableMap::getTableMap()->getCollectionClassName();

        $this->collBannerGroupsRelatedByUpdatedBy = new $collectionClassName;
        $this->collBannerGroupsRelatedByUpdatedBy->setModel('\Propel\Models\BannerGroup');
    }

    /**
     * Gets an array of ChildBannerGroup objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildBannerGroup[] List of ChildBannerGroup objects
     * @throws PropelException
     */
    public function getBannerGroupsRelatedByUpdatedBy(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collBannerGroupsRelatedByUpdatedByPartial && !$this->isNew();
        if (null === $this->collBannerGroupsRelatedByUpdatedBy || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collBannerGroupsRelatedByUpdatedBy) {
                // return empty collection
                $this->initBannerGroupsRelatedByUpdatedBy();
            } else {
                $collBannerGroupsRelatedByUpdatedBy = ChildBannerGroupQuery::create(null, $criteria)
                    ->filterByUserRelatedByUpdatedBy($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collBannerGroupsRelatedByUpdatedByPartial && count($collBannerGroupsRelatedByUpdatedBy)) {
                        $this->initBannerGroupsRelatedByUpdatedBy(false);

                        foreach ($collBannerGroupsRelatedByUpdatedBy as $obj) {
                            if (false == $this->collBannerGroupsRelatedByUpdatedBy->contains($obj)) {
                                $this->collBannerGroupsRelatedByUpdatedBy->append($obj);
                            }
                        }

                        $this->collBannerGroupsRelatedByUpdatedByPartial = true;
                    }

                    return $collBannerGroupsRelatedByUpdatedBy;
                }

                if ($partial && $this->collBannerGroupsRelatedByUpdatedBy) {
                    foreach ($this->collBannerGroupsRelatedByUpdatedBy as $obj) {
                        if ($obj->isNew()) {
                            $collBannerGroupsRelatedByUpdatedBy[] = $obj;
                        }
                    }
                }

                $this->collBannerGroupsRelatedByUpdatedBy = $collBannerGroupsRelatedByUpdatedBy;
                $this->collBannerGroupsRelatedByUpdatedByPartial = false;
            }
        }

        return $this->collBannerGroupsRelatedByUpdatedBy;
    }

    /**
     * Sets a collection of ChildBannerGroup objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $bannerGroupsRelatedByUpdatedBy A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setBannerGroupsRelatedByUpdatedBy(Collection $bannerGroupsRelatedByUpdatedBy, ConnectionInterface $con = null)
    {
        /** @var ChildBannerGroup[] $bannerGroupsRelatedByUpdatedByToDelete */
        $bannerGroupsRelatedByUpdatedByToDelete = $this->getBannerGroupsRelatedByUpdatedBy(new Criteria(), $con)->diff($bannerGroupsRelatedByUpdatedBy);


        $this->bannerGroupsRelatedByUpdatedByScheduledForDeletion = $bannerGroupsRelatedByUpdatedByToDelete;

        foreach ($bannerGroupsRelatedByUpdatedByToDelete as $bannerGroupRelatedByUpdatedByRemoved) {
            $bannerGroupRelatedByUpdatedByRemoved->setUserRelatedByUpdatedBy(null);
        }

        $this->collBannerGroupsRelatedByUpdatedBy = null;
        foreach ($bannerGroupsRelatedByUpdatedBy as $bannerGroupRelatedByUpdatedBy) {
            $this->addBannerGroupRelatedByUpdatedBy($bannerGroupRelatedByUpdatedBy);
        }

        $this->collBannerGroupsRelatedByUpdatedBy = $bannerGroupsRelatedByUpdatedBy;
        $this->collBannerGroupsRelatedByUpdatedByPartial = false;

        return $this;
    }

    /**
     * Returns the number of related BannerGroup objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related BannerGroup objects.
     * @throws PropelException
     */
    public function countBannerGroupsRelatedByUpdatedBy(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collBannerGroupsRelatedByUpdatedByPartial && !$this->isNew();
        if (null === $this->collBannerGroupsRelatedByUpdatedBy || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collBannerGroupsRelatedByUpdatedBy) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getBannerGroupsRelatedByUpdatedBy());
            }

            $query = ChildBannerGroupQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUserRelatedByUpdatedBy($this)
                ->count($con);
        }

        return count($this->collBannerGroupsRelatedByUpdatedBy);
    }

    /**
     * Method called to associate a ChildBannerGroup object to this object
     * through the ChildBannerGroup foreign key attribute.
     *
     * @param  ChildBannerGroup $l ChildBannerGroup
     * @return $this|\Propel\Models\User The current object (for fluent API support)
     */
    public function addBannerGroupRelatedByUpdatedBy(ChildBannerGroup $l)
    {
        if ($this->collBannerGroupsRelatedByUpdatedBy === null) {
            $this->initBannerGroupsRelatedByUpdatedBy();
            $this->collBannerGroupsRelatedByUpdatedByPartial = true;
        }

        if (!$this->collBannerGroupsRelatedByUpdatedBy->contains($l)) {
            $this->doAddBannerGroupRelatedByUpdatedBy($l);

            if ($this->bannerGroupsRelatedByUpdatedByScheduledForDeletion and $this->bannerGroupsRelatedByUpdatedByScheduledForDeletion->contains($l)) {
                $this->bannerGroupsRelatedByUpdatedByScheduledForDeletion->remove($this->bannerGroupsRelatedByUpdatedByScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildBannerGroup $bannerGroupRelatedByUpdatedBy The ChildBannerGroup object to add.
     */
    protected function doAddBannerGroupRelatedByUpdatedBy(ChildBannerGroup $bannerGroupRelatedByUpdatedBy)
    {
        $this->collBannerGroupsRelatedByUpdatedBy[]= $bannerGroupRelatedByUpdatedBy;
        $bannerGroupRelatedByUpdatedBy->setUserRelatedByUpdatedBy($this);
    }

    /**
     * @param  ChildBannerGroup $bannerGroupRelatedByUpdatedBy The ChildBannerGroup object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removeBannerGroupRelatedByUpdatedBy(ChildBannerGroup $bannerGroupRelatedByUpdatedBy)
    {
        if ($this->getBannerGroupsRelatedByUpdatedBy()->contains($bannerGroupRelatedByUpdatedBy)) {
            $pos = $this->collBannerGroupsRelatedByUpdatedBy->search($bannerGroupRelatedByUpdatedBy);
            $this->collBannerGroupsRelatedByUpdatedBy->remove($pos);
            if (null === $this->bannerGroupsRelatedByUpdatedByScheduledForDeletion) {
                $this->bannerGroupsRelatedByUpdatedByScheduledForDeletion = clone $this->collBannerGroupsRelatedByUpdatedBy;
                $this->bannerGroupsRelatedByUpdatedByScheduledForDeletion->clear();
            }
            $this->bannerGroupsRelatedByUpdatedByScheduledForDeletion[]= $bannerGroupRelatedByUpdatedBy;
            $bannerGroupRelatedByUpdatedBy->setUserRelatedByUpdatedBy(null);
        }

        return $this;
    }

    /**
     * Clears out the collBannerClientsRelatedByCreatedBy collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addBannerClientsRelatedByCreatedBy()
     */
    public function clearBannerClientsRelatedByCreatedBy()
    {
        $this->collBannerClientsRelatedByCreatedBy = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collBannerClientsRelatedByCreatedBy collection loaded partially.
     */
    public function resetPartialBannerClientsRelatedByCreatedBy($v = true)
    {
        $this->collBannerClientsRelatedByCreatedByPartial = $v;
    }

    /**
     * Initializes the collBannerClientsRelatedByCreatedBy collection.
     *
     * By default this just sets the collBannerClientsRelatedByCreatedBy collection to an empty array (like clearcollBannerClientsRelatedByCreatedBy());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initBannerClientsRelatedByCreatedBy($overrideExisting = true)
    {
        if (null !== $this->collBannerClientsRelatedByCreatedBy && !$overrideExisting) {
            return;
        }

        $collectionClassName = BannerClientTableMap::getTableMap()->getCollectionClassName();

        $this->collBannerClientsRelatedByCreatedBy = new $collectionClassName;
        $this->collBannerClientsRelatedByCreatedBy->setModel('\Propel\Models\BannerClient');
    }

    /**
     * Gets an array of ChildBannerClient objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildBannerClient[] List of ChildBannerClient objects
     * @throws PropelException
     */
    public function getBannerClientsRelatedByCreatedBy(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collBannerClientsRelatedByCreatedByPartial && !$this->isNew();
        if (null === $this->collBannerClientsRelatedByCreatedBy || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collBannerClientsRelatedByCreatedBy) {
                // return empty collection
                $this->initBannerClientsRelatedByCreatedBy();
            } else {
                $collBannerClientsRelatedByCreatedBy = ChildBannerClientQuery::create(null, $criteria)
                    ->filterByUserRelatedByCreatedBy($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collBannerClientsRelatedByCreatedByPartial && count($collBannerClientsRelatedByCreatedBy)) {
                        $this->initBannerClientsRelatedByCreatedBy(false);

                        foreach ($collBannerClientsRelatedByCreatedBy as $obj) {
                            if (false == $this->collBannerClientsRelatedByCreatedBy->contains($obj)) {
                                $this->collBannerClientsRelatedByCreatedBy->append($obj);
                            }
                        }

                        $this->collBannerClientsRelatedByCreatedByPartial = true;
                    }

                    return $collBannerClientsRelatedByCreatedBy;
                }

                if ($partial && $this->collBannerClientsRelatedByCreatedBy) {
                    foreach ($this->collBannerClientsRelatedByCreatedBy as $obj) {
                        if ($obj->isNew()) {
                            $collBannerClientsRelatedByCreatedBy[] = $obj;
                        }
                    }
                }

                $this->collBannerClientsRelatedByCreatedBy = $collBannerClientsRelatedByCreatedBy;
                $this->collBannerClientsRelatedByCreatedByPartial = false;
            }
        }

        return $this->collBannerClientsRelatedByCreatedBy;
    }

    /**
     * Sets a collection of ChildBannerClient objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $bannerClientsRelatedByCreatedBy A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setBannerClientsRelatedByCreatedBy(Collection $bannerClientsRelatedByCreatedBy, ConnectionInterface $con = null)
    {
        /** @var ChildBannerClient[] $bannerClientsRelatedByCreatedByToDelete */
        $bannerClientsRelatedByCreatedByToDelete = $this->getBannerClientsRelatedByCreatedBy(new Criteria(), $con)->diff($bannerClientsRelatedByCreatedBy);


        $this->bannerClientsRelatedByCreatedByScheduledForDeletion = $bannerClientsRelatedByCreatedByToDelete;

        foreach ($bannerClientsRelatedByCreatedByToDelete as $bannerClientRelatedByCreatedByRemoved) {
            $bannerClientRelatedByCreatedByRemoved->setUserRelatedByCreatedBy(null);
        }

        $this->collBannerClientsRelatedByCreatedBy = null;
        foreach ($bannerClientsRelatedByCreatedBy as $bannerClientRelatedByCreatedBy) {
            $this->addBannerClientRelatedByCreatedBy($bannerClientRelatedByCreatedBy);
        }

        $this->collBannerClientsRelatedByCreatedBy = $bannerClientsRelatedByCreatedBy;
        $this->collBannerClientsRelatedByCreatedByPartial = false;

        return $this;
    }

    /**
     * Returns the number of related BannerClient objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related BannerClient objects.
     * @throws PropelException
     */
    public function countBannerClientsRelatedByCreatedBy(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collBannerClientsRelatedByCreatedByPartial && !$this->isNew();
        if (null === $this->collBannerClientsRelatedByCreatedBy || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collBannerClientsRelatedByCreatedBy) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getBannerClientsRelatedByCreatedBy());
            }

            $query = ChildBannerClientQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUserRelatedByCreatedBy($this)
                ->count($con);
        }

        return count($this->collBannerClientsRelatedByCreatedBy);
    }

    /**
     * Method called to associate a ChildBannerClient object to this object
     * through the ChildBannerClient foreign key attribute.
     *
     * @param  ChildBannerClient $l ChildBannerClient
     * @return $this|\Propel\Models\User The current object (for fluent API support)
     */
    public function addBannerClientRelatedByCreatedBy(ChildBannerClient $l)
    {
        if ($this->collBannerClientsRelatedByCreatedBy === null) {
            $this->initBannerClientsRelatedByCreatedBy();
            $this->collBannerClientsRelatedByCreatedByPartial = true;
        }

        if (!$this->collBannerClientsRelatedByCreatedBy->contains($l)) {
            $this->doAddBannerClientRelatedByCreatedBy($l);

            if ($this->bannerClientsRelatedByCreatedByScheduledForDeletion and $this->bannerClientsRelatedByCreatedByScheduledForDeletion->contains($l)) {
                $this->bannerClientsRelatedByCreatedByScheduledForDeletion->remove($this->bannerClientsRelatedByCreatedByScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildBannerClient $bannerClientRelatedByCreatedBy The ChildBannerClient object to add.
     */
    protected function doAddBannerClientRelatedByCreatedBy(ChildBannerClient $bannerClientRelatedByCreatedBy)
    {
        $this->collBannerClientsRelatedByCreatedBy[]= $bannerClientRelatedByCreatedBy;
        $bannerClientRelatedByCreatedBy->setUserRelatedByCreatedBy($this);
    }

    /**
     * @param  ChildBannerClient $bannerClientRelatedByCreatedBy The ChildBannerClient object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removeBannerClientRelatedByCreatedBy(ChildBannerClient $bannerClientRelatedByCreatedBy)
    {
        if ($this->getBannerClientsRelatedByCreatedBy()->contains($bannerClientRelatedByCreatedBy)) {
            $pos = $this->collBannerClientsRelatedByCreatedBy->search($bannerClientRelatedByCreatedBy);
            $this->collBannerClientsRelatedByCreatedBy->remove($pos);
            if (null === $this->bannerClientsRelatedByCreatedByScheduledForDeletion) {
                $this->bannerClientsRelatedByCreatedByScheduledForDeletion = clone $this->collBannerClientsRelatedByCreatedBy;
                $this->bannerClientsRelatedByCreatedByScheduledForDeletion->clear();
            }
            $this->bannerClientsRelatedByCreatedByScheduledForDeletion[]= $bannerClientRelatedByCreatedBy;
            $bannerClientRelatedByCreatedBy->setUserRelatedByCreatedBy(null);
        }

        return $this;
    }

    /**
     * Clears out the collBannerClientsRelatedByUpdatedBy collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addBannerClientsRelatedByUpdatedBy()
     */
    public function clearBannerClientsRelatedByUpdatedBy()
    {
        $this->collBannerClientsRelatedByUpdatedBy = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collBannerClientsRelatedByUpdatedBy collection loaded partially.
     */
    public function resetPartialBannerClientsRelatedByUpdatedBy($v = true)
    {
        $this->collBannerClientsRelatedByUpdatedByPartial = $v;
    }

    /**
     * Initializes the collBannerClientsRelatedByUpdatedBy collection.
     *
     * By default this just sets the collBannerClientsRelatedByUpdatedBy collection to an empty array (like clearcollBannerClientsRelatedByUpdatedBy());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initBannerClientsRelatedByUpdatedBy($overrideExisting = true)
    {
        if (null !== $this->collBannerClientsRelatedByUpdatedBy && !$overrideExisting) {
            return;
        }

        $collectionClassName = BannerClientTableMap::getTableMap()->getCollectionClassName();

        $this->collBannerClientsRelatedByUpdatedBy = new $collectionClassName;
        $this->collBannerClientsRelatedByUpdatedBy->setModel('\Propel\Models\BannerClient');
    }

    /**
     * Gets an array of ChildBannerClient objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildBannerClient[] List of ChildBannerClient objects
     * @throws PropelException
     */
    public function getBannerClientsRelatedByUpdatedBy(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collBannerClientsRelatedByUpdatedByPartial && !$this->isNew();
        if (null === $this->collBannerClientsRelatedByUpdatedBy || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collBannerClientsRelatedByUpdatedBy) {
                // return empty collection
                $this->initBannerClientsRelatedByUpdatedBy();
            } else {
                $collBannerClientsRelatedByUpdatedBy = ChildBannerClientQuery::create(null, $criteria)
                    ->filterByUserRelatedByUpdatedBy($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collBannerClientsRelatedByUpdatedByPartial && count($collBannerClientsRelatedByUpdatedBy)) {
                        $this->initBannerClientsRelatedByUpdatedBy(false);

                        foreach ($collBannerClientsRelatedByUpdatedBy as $obj) {
                            if (false == $this->collBannerClientsRelatedByUpdatedBy->contains($obj)) {
                                $this->collBannerClientsRelatedByUpdatedBy->append($obj);
                            }
                        }

                        $this->collBannerClientsRelatedByUpdatedByPartial = true;
                    }

                    return $collBannerClientsRelatedByUpdatedBy;
                }

                if ($partial && $this->collBannerClientsRelatedByUpdatedBy) {
                    foreach ($this->collBannerClientsRelatedByUpdatedBy as $obj) {
                        if ($obj->isNew()) {
                            $collBannerClientsRelatedByUpdatedBy[] = $obj;
                        }
                    }
                }

                $this->collBannerClientsRelatedByUpdatedBy = $collBannerClientsRelatedByUpdatedBy;
                $this->collBannerClientsRelatedByUpdatedByPartial = false;
            }
        }

        return $this->collBannerClientsRelatedByUpdatedBy;
    }

    /**
     * Sets a collection of ChildBannerClient objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $bannerClientsRelatedByUpdatedBy A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setBannerClientsRelatedByUpdatedBy(Collection $bannerClientsRelatedByUpdatedBy, ConnectionInterface $con = null)
    {
        /** @var ChildBannerClient[] $bannerClientsRelatedByUpdatedByToDelete */
        $bannerClientsRelatedByUpdatedByToDelete = $this->getBannerClientsRelatedByUpdatedBy(new Criteria(), $con)->diff($bannerClientsRelatedByUpdatedBy);


        $this->bannerClientsRelatedByUpdatedByScheduledForDeletion = $bannerClientsRelatedByUpdatedByToDelete;

        foreach ($bannerClientsRelatedByUpdatedByToDelete as $bannerClientRelatedByUpdatedByRemoved) {
            $bannerClientRelatedByUpdatedByRemoved->setUserRelatedByUpdatedBy(null);
        }

        $this->collBannerClientsRelatedByUpdatedBy = null;
        foreach ($bannerClientsRelatedByUpdatedBy as $bannerClientRelatedByUpdatedBy) {
            $this->addBannerClientRelatedByUpdatedBy($bannerClientRelatedByUpdatedBy);
        }

        $this->collBannerClientsRelatedByUpdatedBy = $bannerClientsRelatedByUpdatedBy;
        $this->collBannerClientsRelatedByUpdatedByPartial = false;

        return $this;
    }

    /**
     * Returns the number of related BannerClient objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related BannerClient objects.
     * @throws PropelException
     */
    public function countBannerClientsRelatedByUpdatedBy(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collBannerClientsRelatedByUpdatedByPartial && !$this->isNew();
        if (null === $this->collBannerClientsRelatedByUpdatedBy || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collBannerClientsRelatedByUpdatedBy) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getBannerClientsRelatedByUpdatedBy());
            }

            $query = ChildBannerClientQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUserRelatedByUpdatedBy($this)
                ->count($con);
        }

        return count($this->collBannerClientsRelatedByUpdatedBy);
    }

    /**
     * Method called to associate a ChildBannerClient object to this object
     * through the ChildBannerClient foreign key attribute.
     *
     * @param  ChildBannerClient $l ChildBannerClient
     * @return $this|\Propel\Models\User The current object (for fluent API support)
     */
    public function addBannerClientRelatedByUpdatedBy(ChildBannerClient $l)
    {
        if ($this->collBannerClientsRelatedByUpdatedBy === null) {
            $this->initBannerClientsRelatedByUpdatedBy();
            $this->collBannerClientsRelatedByUpdatedByPartial = true;
        }

        if (!$this->collBannerClientsRelatedByUpdatedBy->contains($l)) {
            $this->doAddBannerClientRelatedByUpdatedBy($l);

            if ($this->bannerClientsRelatedByUpdatedByScheduledForDeletion and $this->bannerClientsRelatedByUpdatedByScheduledForDeletion->contains($l)) {
                $this->bannerClientsRelatedByUpdatedByScheduledForDeletion->remove($this->bannerClientsRelatedByUpdatedByScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildBannerClient $bannerClientRelatedByUpdatedBy The ChildBannerClient object to add.
     */
    protected function doAddBannerClientRelatedByUpdatedBy(ChildBannerClient $bannerClientRelatedByUpdatedBy)
    {
        $this->collBannerClientsRelatedByUpdatedBy[]= $bannerClientRelatedByUpdatedBy;
        $bannerClientRelatedByUpdatedBy->setUserRelatedByUpdatedBy($this);
    }

    /**
     * @param  ChildBannerClient $bannerClientRelatedByUpdatedBy The ChildBannerClient object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removeBannerClientRelatedByUpdatedBy(ChildBannerClient $bannerClientRelatedByUpdatedBy)
    {
        if ($this->getBannerClientsRelatedByUpdatedBy()->contains($bannerClientRelatedByUpdatedBy)) {
            $pos = $this->collBannerClientsRelatedByUpdatedBy->search($bannerClientRelatedByUpdatedBy);
            $this->collBannerClientsRelatedByUpdatedBy->remove($pos);
            if (null === $this->bannerClientsRelatedByUpdatedByScheduledForDeletion) {
                $this->bannerClientsRelatedByUpdatedByScheduledForDeletion = clone $this->collBannerClientsRelatedByUpdatedBy;
                $this->bannerClientsRelatedByUpdatedByScheduledForDeletion->clear();
            }
            $this->bannerClientsRelatedByUpdatedByScheduledForDeletion[]= $bannerClientRelatedByUpdatedBy;
            $bannerClientRelatedByUpdatedBy->setUserRelatedByUpdatedBy(null);
        }

        return $this;
    }

    /**
     * Clears out the collCommentsRelatedByCreatedBy collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addCommentsRelatedByCreatedBy()
     */
    public function clearCommentsRelatedByCreatedBy()
    {
        $this->collCommentsRelatedByCreatedBy = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collCommentsRelatedByCreatedBy collection loaded partially.
     */
    public function resetPartialCommentsRelatedByCreatedBy($v = true)
    {
        $this->collCommentsRelatedByCreatedByPartial = $v;
    }

    /**
     * Initializes the collCommentsRelatedByCreatedBy collection.
     *
     * By default this just sets the collCommentsRelatedByCreatedBy collection to an empty array (like clearcollCommentsRelatedByCreatedBy());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCommentsRelatedByCreatedBy($overrideExisting = true)
    {
        if (null !== $this->collCommentsRelatedByCreatedBy && !$overrideExisting) {
            return;
        }

        $collectionClassName = CommentTableMap::getTableMap()->getCollectionClassName();

        $this->collCommentsRelatedByCreatedBy = new $collectionClassName;
        $this->collCommentsRelatedByCreatedBy->setModel('\Propel\Models\Comment');
    }

    /**
     * Gets an array of ChildComment objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildComment[] List of ChildComment objects
     * @throws PropelException
     */
    public function getCommentsRelatedByCreatedBy(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collCommentsRelatedByCreatedByPartial && !$this->isNew();
        if (null === $this->collCommentsRelatedByCreatedBy || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCommentsRelatedByCreatedBy) {
                // return empty collection
                $this->initCommentsRelatedByCreatedBy();
            } else {
                $collCommentsRelatedByCreatedBy = ChildCommentQuery::create(null, $criteria)
                    ->filterByUserRelatedByCreatedBy($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collCommentsRelatedByCreatedByPartial && count($collCommentsRelatedByCreatedBy)) {
                        $this->initCommentsRelatedByCreatedBy(false);

                        foreach ($collCommentsRelatedByCreatedBy as $obj) {
                            if (false == $this->collCommentsRelatedByCreatedBy->contains($obj)) {
                                $this->collCommentsRelatedByCreatedBy->append($obj);
                            }
                        }

                        $this->collCommentsRelatedByCreatedByPartial = true;
                    }

                    return $collCommentsRelatedByCreatedBy;
                }

                if ($partial && $this->collCommentsRelatedByCreatedBy) {
                    foreach ($this->collCommentsRelatedByCreatedBy as $obj) {
                        if ($obj->isNew()) {
                            $collCommentsRelatedByCreatedBy[] = $obj;
                        }
                    }
                }

                $this->collCommentsRelatedByCreatedBy = $collCommentsRelatedByCreatedBy;
                $this->collCommentsRelatedByCreatedByPartial = false;
            }
        }

        return $this->collCommentsRelatedByCreatedBy;
    }

    /**
     * Sets a collection of ChildComment objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $commentsRelatedByCreatedBy A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setCommentsRelatedByCreatedBy(Collection $commentsRelatedByCreatedBy, ConnectionInterface $con = null)
    {
        /** @var ChildComment[] $commentsRelatedByCreatedByToDelete */
        $commentsRelatedByCreatedByToDelete = $this->getCommentsRelatedByCreatedBy(new Criteria(), $con)->diff($commentsRelatedByCreatedBy);


        $this->commentsRelatedByCreatedByScheduledForDeletion = $commentsRelatedByCreatedByToDelete;

        foreach ($commentsRelatedByCreatedByToDelete as $commentRelatedByCreatedByRemoved) {
            $commentRelatedByCreatedByRemoved->setUserRelatedByCreatedBy(null);
        }

        $this->collCommentsRelatedByCreatedBy = null;
        foreach ($commentsRelatedByCreatedBy as $commentRelatedByCreatedBy) {
            $this->addCommentRelatedByCreatedBy($commentRelatedByCreatedBy);
        }

        $this->collCommentsRelatedByCreatedBy = $commentsRelatedByCreatedBy;
        $this->collCommentsRelatedByCreatedByPartial = false;

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
    public function countCommentsRelatedByCreatedBy(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collCommentsRelatedByCreatedByPartial && !$this->isNew();
        if (null === $this->collCommentsRelatedByCreatedBy || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCommentsRelatedByCreatedBy) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getCommentsRelatedByCreatedBy());
            }

            $query = ChildCommentQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUserRelatedByCreatedBy($this)
                ->count($con);
        }

        return count($this->collCommentsRelatedByCreatedBy);
    }

    /**
     * Method called to associate a ChildComment object to this object
     * through the ChildComment foreign key attribute.
     *
     * @param  ChildComment $l ChildComment
     * @return $this|\Propel\Models\User The current object (for fluent API support)
     */
    public function addCommentRelatedByCreatedBy(ChildComment $l)
    {
        if ($this->collCommentsRelatedByCreatedBy === null) {
            $this->initCommentsRelatedByCreatedBy();
            $this->collCommentsRelatedByCreatedByPartial = true;
        }

        if (!$this->collCommentsRelatedByCreatedBy->contains($l)) {
            $this->doAddCommentRelatedByCreatedBy($l);

            if ($this->commentsRelatedByCreatedByScheduledForDeletion and $this->commentsRelatedByCreatedByScheduledForDeletion->contains($l)) {
                $this->commentsRelatedByCreatedByScheduledForDeletion->remove($this->commentsRelatedByCreatedByScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildComment $commentRelatedByCreatedBy The ChildComment object to add.
     */
    protected function doAddCommentRelatedByCreatedBy(ChildComment $commentRelatedByCreatedBy)
    {
        $this->collCommentsRelatedByCreatedBy[]= $commentRelatedByCreatedBy;
        $commentRelatedByCreatedBy->setUserRelatedByCreatedBy($this);
    }

    /**
     * @param  ChildComment $commentRelatedByCreatedBy The ChildComment object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removeCommentRelatedByCreatedBy(ChildComment $commentRelatedByCreatedBy)
    {
        if ($this->getCommentsRelatedByCreatedBy()->contains($commentRelatedByCreatedBy)) {
            $pos = $this->collCommentsRelatedByCreatedBy->search($commentRelatedByCreatedBy);
            $this->collCommentsRelatedByCreatedBy->remove($pos);
            if (null === $this->commentsRelatedByCreatedByScheduledForDeletion) {
                $this->commentsRelatedByCreatedByScheduledForDeletion = clone $this->collCommentsRelatedByCreatedBy;
                $this->commentsRelatedByCreatedByScheduledForDeletion->clear();
            }
            $this->commentsRelatedByCreatedByScheduledForDeletion[]= $commentRelatedByCreatedBy;
            $commentRelatedByCreatedBy->setUserRelatedByCreatedBy(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related CommentsRelatedByCreatedBy from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildComment[] List of ChildComment objects
     */
    public function getCommentsRelatedByCreatedByJoinCommentRelatedByParentId(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCommentQuery::create(null, $criteria);
        $query->joinWith('CommentRelatedByParentId', $joinBehavior);

        return $this->getCommentsRelatedByCreatedBy($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related CommentsRelatedByCreatedBy from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildComment[] List of ChildComment objects
     */
    public function getCommentsRelatedByCreatedByJoinPublication(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCommentQuery::create(null, $criteria);
        $query->joinWith('Publication', $joinBehavior);

        return $this->getCommentsRelatedByCreatedBy($query, $con);
    }

    /**
     * Clears out the collCommentsRelatedByUpdatedBy collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addCommentsRelatedByUpdatedBy()
     */
    public function clearCommentsRelatedByUpdatedBy()
    {
        $this->collCommentsRelatedByUpdatedBy = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collCommentsRelatedByUpdatedBy collection loaded partially.
     */
    public function resetPartialCommentsRelatedByUpdatedBy($v = true)
    {
        $this->collCommentsRelatedByUpdatedByPartial = $v;
    }

    /**
     * Initializes the collCommentsRelatedByUpdatedBy collection.
     *
     * By default this just sets the collCommentsRelatedByUpdatedBy collection to an empty array (like clearcollCommentsRelatedByUpdatedBy());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCommentsRelatedByUpdatedBy($overrideExisting = true)
    {
        if (null !== $this->collCommentsRelatedByUpdatedBy && !$overrideExisting) {
            return;
        }

        $collectionClassName = CommentTableMap::getTableMap()->getCollectionClassName();

        $this->collCommentsRelatedByUpdatedBy = new $collectionClassName;
        $this->collCommentsRelatedByUpdatedBy->setModel('\Propel\Models\Comment');
    }

    /**
     * Gets an array of ChildComment objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildComment[] List of ChildComment objects
     * @throws PropelException
     */
    public function getCommentsRelatedByUpdatedBy(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collCommentsRelatedByUpdatedByPartial && !$this->isNew();
        if (null === $this->collCommentsRelatedByUpdatedBy || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCommentsRelatedByUpdatedBy) {
                // return empty collection
                $this->initCommentsRelatedByUpdatedBy();
            } else {
                $collCommentsRelatedByUpdatedBy = ChildCommentQuery::create(null, $criteria)
                    ->filterByUserRelatedByUpdatedBy($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collCommentsRelatedByUpdatedByPartial && count($collCommentsRelatedByUpdatedBy)) {
                        $this->initCommentsRelatedByUpdatedBy(false);

                        foreach ($collCommentsRelatedByUpdatedBy as $obj) {
                            if (false == $this->collCommentsRelatedByUpdatedBy->contains($obj)) {
                                $this->collCommentsRelatedByUpdatedBy->append($obj);
                            }
                        }

                        $this->collCommentsRelatedByUpdatedByPartial = true;
                    }

                    return $collCommentsRelatedByUpdatedBy;
                }

                if ($partial && $this->collCommentsRelatedByUpdatedBy) {
                    foreach ($this->collCommentsRelatedByUpdatedBy as $obj) {
                        if ($obj->isNew()) {
                            $collCommentsRelatedByUpdatedBy[] = $obj;
                        }
                    }
                }

                $this->collCommentsRelatedByUpdatedBy = $collCommentsRelatedByUpdatedBy;
                $this->collCommentsRelatedByUpdatedByPartial = false;
            }
        }

        return $this->collCommentsRelatedByUpdatedBy;
    }

    /**
     * Sets a collection of ChildComment objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $commentsRelatedByUpdatedBy A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setCommentsRelatedByUpdatedBy(Collection $commentsRelatedByUpdatedBy, ConnectionInterface $con = null)
    {
        /** @var ChildComment[] $commentsRelatedByUpdatedByToDelete */
        $commentsRelatedByUpdatedByToDelete = $this->getCommentsRelatedByUpdatedBy(new Criteria(), $con)->diff($commentsRelatedByUpdatedBy);


        $this->commentsRelatedByUpdatedByScheduledForDeletion = $commentsRelatedByUpdatedByToDelete;

        foreach ($commentsRelatedByUpdatedByToDelete as $commentRelatedByUpdatedByRemoved) {
            $commentRelatedByUpdatedByRemoved->setUserRelatedByUpdatedBy(null);
        }

        $this->collCommentsRelatedByUpdatedBy = null;
        foreach ($commentsRelatedByUpdatedBy as $commentRelatedByUpdatedBy) {
            $this->addCommentRelatedByUpdatedBy($commentRelatedByUpdatedBy);
        }

        $this->collCommentsRelatedByUpdatedBy = $commentsRelatedByUpdatedBy;
        $this->collCommentsRelatedByUpdatedByPartial = false;

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
    public function countCommentsRelatedByUpdatedBy(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collCommentsRelatedByUpdatedByPartial && !$this->isNew();
        if (null === $this->collCommentsRelatedByUpdatedBy || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCommentsRelatedByUpdatedBy) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getCommentsRelatedByUpdatedBy());
            }

            $query = ChildCommentQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUserRelatedByUpdatedBy($this)
                ->count($con);
        }

        return count($this->collCommentsRelatedByUpdatedBy);
    }

    /**
     * Method called to associate a ChildComment object to this object
     * through the ChildComment foreign key attribute.
     *
     * @param  ChildComment $l ChildComment
     * @return $this|\Propel\Models\User The current object (for fluent API support)
     */
    public function addCommentRelatedByUpdatedBy(ChildComment $l)
    {
        if ($this->collCommentsRelatedByUpdatedBy === null) {
            $this->initCommentsRelatedByUpdatedBy();
            $this->collCommentsRelatedByUpdatedByPartial = true;
        }

        if (!$this->collCommentsRelatedByUpdatedBy->contains($l)) {
            $this->doAddCommentRelatedByUpdatedBy($l);

            if ($this->commentsRelatedByUpdatedByScheduledForDeletion and $this->commentsRelatedByUpdatedByScheduledForDeletion->contains($l)) {
                $this->commentsRelatedByUpdatedByScheduledForDeletion->remove($this->commentsRelatedByUpdatedByScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildComment $commentRelatedByUpdatedBy The ChildComment object to add.
     */
    protected function doAddCommentRelatedByUpdatedBy(ChildComment $commentRelatedByUpdatedBy)
    {
        $this->collCommentsRelatedByUpdatedBy[]= $commentRelatedByUpdatedBy;
        $commentRelatedByUpdatedBy->setUserRelatedByUpdatedBy($this);
    }

    /**
     * @param  ChildComment $commentRelatedByUpdatedBy The ChildComment object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removeCommentRelatedByUpdatedBy(ChildComment $commentRelatedByUpdatedBy)
    {
        if ($this->getCommentsRelatedByUpdatedBy()->contains($commentRelatedByUpdatedBy)) {
            $pos = $this->collCommentsRelatedByUpdatedBy->search($commentRelatedByUpdatedBy);
            $this->collCommentsRelatedByUpdatedBy->remove($pos);
            if (null === $this->commentsRelatedByUpdatedByScheduledForDeletion) {
                $this->commentsRelatedByUpdatedByScheduledForDeletion = clone $this->collCommentsRelatedByUpdatedBy;
                $this->commentsRelatedByUpdatedByScheduledForDeletion->clear();
            }
            $this->commentsRelatedByUpdatedByScheduledForDeletion[]= $commentRelatedByUpdatedBy;
            $commentRelatedByUpdatedBy->setUserRelatedByUpdatedBy(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related CommentsRelatedByUpdatedBy from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildComment[] List of ChildComment objects
     */
    public function getCommentsRelatedByUpdatedByJoinCommentRelatedByParentId(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCommentQuery::create(null, $criteria);
        $query->joinWith('CommentRelatedByParentId', $joinBehavior);

        return $this->getCommentsRelatedByUpdatedBy($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related CommentsRelatedByUpdatedBy from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildComment[] List of ChildComment objects
     */
    public function getCommentsRelatedByUpdatedByJoinPublication(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCommentQuery::create(null, $criteria);
        $query->joinWith('Publication', $joinBehavior);

        return $this->getCommentsRelatedByUpdatedBy($query, $con);
    }

    /**
     * Clears out the collCommentsRelatedByDeletedBy collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addCommentsRelatedByDeletedBy()
     */
    public function clearCommentsRelatedByDeletedBy()
    {
        $this->collCommentsRelatedByDeletedBy = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collCommentsRelatedByDeletedBy collection loaded partially.
     */
    public function resetPartialCommentsRelatedByDeletedBy($v = true)
    {
        $this->collCommentsRelatedByDeletedByPartial = $v;
    }

    /**
     * Initializes the collCommentsRelatedByDeletedBy collection.
     *
     * By default this just sets the collCommentsRelatedByDeletedBy collection to an empty array (like clearcollCommentsRelatedByDeletedBy());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCommentsRelatedByDeletedBy($overrideExisting = true)
    {
        if (null !== $this->collCommentsRelatedByDeletedBy && !$overrideExisting) {
            return;
        }

        $collectionClassName = CommentTableMap::getTableMap()->getCollectionClassName();

        $this->collCommentsRelatedByDeletedBy = new $collectionClassName;
        $this->collCommentsRelatedByDeletedBy->setModel('\Propel\Models\Comment');
    }

    /**
     * Gets an array of ChildComment objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildComment[] List of ChildComment objects
     * @throws PropelException
     */
    public function getCommentsRelatedByDeletedBy(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collCommentsRelatedByDeletedByPartial && !$this->isNew();
        if (null === $this->collCommentsRelatedByDeletedBy || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCommentsRelatedByDeletedBy) {
                // return empty collection
                $this->initCommentsRelatedByDeletedBy();
            } else {
                $collCommentsRelatedByDeletedBy = ChildCommentQuery::create(null, $criteria)
                    ->filterByUserRelatedByDeletedBy($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collCommentsRelatedByDeletedByPartial && count($collCommentsRelatedByDeletedBy)) {
                        $this->initCommentsRelatedByDeletedBy(false);

                        foreach ($collCommentsRelatedByDeletedBy as $obj) {
                            if (false == $this->collCommentsRelatedByDeletedBy->contains($obj)) {
                                $this->collCommentsRelatedByDeletedBy->append($obj);
                            }
                        }

                        $this->collCommentsRelatedByDeletedByPartial = true;
                    }

                    return $collCommentsRelatedByDeletedBy;
                }

                if ($partial && $this->collCommentsRelatedByDeletedBy) {
                    foreach ($this->collCommentsRelatedByDeletedBy as $obj) {
                        if ($obj->isNew()) {
                            $collCommentsRelatedByDeletedBy[] = $obj;
                        }
                    }
                }

                $this->collCommentsRelatedByDeletedBy = $collCommentsRelatedByDeletedBy;
                $this->collCommentsRelatedByDeletedByPartial = false;
            }
        }

        return $this->collCommentsRelatedByDeletedBy;
    }

    /**
     * Sets a collection of ChildComment objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $commentsRelatedByDeletedBy A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setCommentsRelatedByDeletedBy(Collection $commentsRelatedByDeletedBy, ConnectionInterface $con = null)
    {
        /** @var ChildComment[] $commentsRelatedByDeletedByToDelete */
        $commentsRelatedByDeletedByToDelete = $this->getCommentsRelatedByDeletedBy(new Criteria(), $con)->diff($commentsRelatedByDeletedBy);


        $this->commentsRelatedByDeletedByScheduledForDeletion = $commentsRelatedByDeletedByToDelete;

        foreach ($commentsRelatedByDeletedByToDelete as $commentRelatedByDeletedByRemoved) {
            $commentRelatedByDeletedByRemoved->setUserRelatedByDeletedBy(null);
        }

        $this->collCommentsRelatedByDeletedBy = null;
        foreach ($commentsRelatedByDeletedBy as $commentRelatedByDeletedBy) {
            $this->addCommentRelatedByDeletedBy($commentRelatedByDeletedBy);
        }

        $this->collCommentsRelatedByDeletedBy = $commentsRelatedByDeletedBy;
        $this->collCommentsRelatedByDeletedByPartial = false;

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
    public function countCommentsRelatedByDeletedBy(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collCommentsRelatedByDeletedByPartial && !$this->isNew();
        if (null === $this->collCommentsRelatedByDeletedBy || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCommentsRelatedByDeletedBy) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getCommentsRelatedByDeletedBy());
            }

            $query = ChildCommentQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUserRelatedByDeletedBy($this)
                ->count($con);
        }

        return count($this->collCommentsRelatedByDeletedBy);
    }

    /**
     * Method called to associate a ChildComment object to this object
     * through the ChildComment foreign key attribute.
     *
     * @param  ChildComment $l ChildComment
     * @return $this|\Propel\Models\User The current object (for fluent API support)
     */
    public function addCommentRelatedByDeletedBy(ChildComment $l)
    {
        if ($this->collCommentsRelatedByDeletedBy === null) {
            $this->initCommentsRelatedByDeletedBy();
            $this->collCommentsRelatedByDeletedByPartial = true;
        }

        if (!$this->collCommentsRelatedByDeletedBy->contains($l)) {
            $this->doAddCommentRelatedByDeletedBy($l);

            if ($this->commentsRelatedByDeletedByScheduledForDeletion and $this->commentsRelatedByDeletedByScheduledForDeletion->contains($l)) {
                $this->commentsRelatedByDeletedByScheduledForDeletion->remove($this->commentsRelatedByDeletedByScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildComment $commentRelatedByDeletedBy The ChildComment object to add.
     */
    protected function doAddCommentRelatedByDeletedBy(ChildComment $commentRelatedByDeletedBy)
    {
        $this->collCommentsRelatedByDeletedBy[]= $commentRelatedByDeletedBy;
        $commentRelatedByDeletedBy->setUserRelatedByDeletedBy($this);
    }

    /**
     * @param  ChildComment $commentRelatedByDeletedBy The ChildComment object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removeCommentRelatedByDeletedBy(ChildComment $commentRelatedByDeletedBy)
    {
        if ($this->getCommentsRelatedByDeletedBy()->contains($commentRelatedByDeletedBy)) {
            $pos = $this->collCommentsRelatedByDeletedBy->search($commentRelatedByDeletedBy);
            $this->collCommentsRelatedByDeletedBy->remove($pos);
            if (null === $this->commentsRelatedByDeletedByScheduledForDeletion) {
                $this->commentsRelatedByDeletedByScheduledForDeletion = clone $this->collCommentsRelatedByDeletedBy;
                $this->commentsRelatedByDeletedByScheduledForDeletion->clear();
            }
            $this->commentsRelatedByDeletedByScheduledForDeletion[]= $commentRelatedByDeletedBy;
            $commentRelatedByDeletedBy->setUserRelatedByDeletedBy(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related CommentsRelatedByDeletedBy from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildComment[] List of ChildComment objects
     */
    public function getCommentsRelatedByDeletedByJoinCommentRelatedByParentId(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCommentQuery::create(null, $criteria);
        $query->joinWith('CommentRelatedByParentId', $joinBehavior);

        return $this->getCommentsRelatedByDeletedBy($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related CommentsRelatedByDeletedBy from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildComment[] List of ChildComment objects
     */
    public function getCommentsRelatedByDeletedByJoinPublication(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCommentQuery::create(null, $criteria);
        $query->joinWith('Publication', $joinBehavior);

        return $this->getCommentsRelatedByDeletedBy($query, $con);
    }

    /**
     * Clears out the collFieldsRelatedByCreatedBy collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addFieldsRelatedByCreatedBy()
     */
    public function clearFieldsRelatedByCreatedBy()
    {
        $this->collFieldsRelatedByCreatedBy = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collFieldsRelatedByCreatedBy collection loaded partially.
     */
    public function resetPartialFieldsRelatedByCreatedBy($v = true)
    {
        $this->collFieldsRelatedByCreatedByPartial = $v;
    }

    /**
     * Initializes the collFieldsRelatedByCreatedBy collection.
     *
     * By default this just sets the collFieldsRelatedByCreatedBy collection to an empty array (like clearcollFieldsRelatedByCreatedBy());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initFieldsRelatedByCreatedBy($overrideExisting = true)
    {
        if (null !== $this->collFieldsRelatedByCreatedBy && !$overrideExisting) {
            return;
        }

        $collectionClassName = FieldTableMap::getTableMap()->getCollectionClassName();

        $this->collFieldsRelatedByCreatedBy = new $collectionClassName;
        $this->collFieldsRelatedByCreatedBy->setModel('\Propel\Models\Field');
    }

    /**
     * Gets an array of ChildField objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildField[] List of ChildField objects
     * @throws PropelException
     */
    public function getFieldsRelatedByCreatedBy(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collFieldsRelatedByCreatedByPartial && !$this->isNew();
        if (null === $this->collFieldsRelatedByCreatedBy || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collFieldsRelatedByCreatedBy) {
                // return empty collection
                $this->initFieldsRelatedByCreatedBy();
            } else {
                $collFieldsRelatedByCreatedBy = ChildFieldQuery::create(null, $criteria)
                    ->filterByUserRelatedByCreatedBy($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collFieldsRelatedByCreatedByPartial && count($collFieldsRelatedByCreatedBy)) {
                        $this->initFieldsRelatedByCreatedBy(false);

                        foreach ($collFieldsRelatedByCreatedBy as $obj) {
                            if (false == $this->collFieldsRelatedByCreatedBy->contains($obj)) {
                                $this->collFieldsRelatedByCreatedBy->append($obj);
                            }
                        }

                        $this->collFieldsRelatedByCreatedByPartial = true;
                    }

                    return $collFieldsRelatedByCreatedBy;
                }

                if ($partial && $this->collFieldsRelatedByCreatedBy) {
                    foreach ($this->collFieldsRelatedByCreatedBy as $obj) {
                        if ($obj->isNew()) {
                            $collFieldsRelatedByCreatedBy[] = $obj;
                        }
                    }
                }

                $this->collFieldsRelatedByCreatedBy = $collFieldsRelatedByCreatedBy;
                $this->collFieldsRelatedByCreatedByPartial = false;
            }
        }

        return $this->collFieldsRelatedByCreatedBy;
    }

    /**
     * Sets a collection of ChildField objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $fieldsRelatedByCreatedBy A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setFieldsRelatedByCreatedBy(Collection $fieldsRelatedByCreatedBy, ConnectionInterface $con = null)
    {
        /** @var ChildField[] $fieldsRelatedByCreatedByToDelete */
        $fieldsRelatedByCreatedByToDelete = $this->getFieldsRelatedByCreatedBy(new Criteria(), $con)->diff($fieldsRelatedByCreatedBy);


        $this->fieldsRelatedByCreatedByScheduledForDeletion = $fieldsRelatedByCreatedByToDelete;

        foreach ($fieldsRelatedByCreatedByToDelete as $fieldRelatedByCreatedByRemoved) {
            $fieldRelatedByCreatedByRemoved->setUserRelatedByCreatedBy(null);
        }

        $this->collFieldsRelatedByCreatedBy = null;
        foreach ($fieldsRelatedByCreatedBy as $fieldRelatedByCreatedBy) {
            $this->addFieldRelatedByCreatedBy($fieldRelatedByCreatedBy);
        }

        $this->collFieldsRelatedByCreatedBy = $fieldsRelatedByCreatedBy;
        $this->collFieldsRelatedByCreatedByPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Field objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Field objects.
     * @throws PropelException
     */
    public function countFieldsRelatedByCreatedBy(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collFieldsRelatedByCreatedByPartial && !$this->isNew();
        if (null === $this->collFieldsRelatedByCreatedBy || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collFieldsRelatedByCreatedBy) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getFieldsRelatedByCreatedBy());
            }

            $query = ChildFieldQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUserRelatedByCreatedBy($this)
                ->count($con);
        }

        return count($this->collFieldsRelatedByCreatedBy);
    }

    /**
     * Method called to associate a ChildField object to this object
     * through the ChildField foreign key attribute.
     *
     * @param  ChildField $l ChildField
     * @return $this|\Propel\Models\User The current object (for fluent API support)
     */
    public function addFieldRelatedByCreatedBy(ChildField $l)
    {
        if ($this->collFieldsRelatedByCreatedBy === null) {
            $this->initFieldsRelatedByCreatedBy();
            $this->collFieldsRelatedByCreatedByPartial = true;
        }

        if (!$this->collFieldsRelatedByCreatedBy->contains($l)) {
            $this->doAddFieldRelatedByCreatedBy($l);

            if ($this->fieldsRelatedByCreatedByScheduledForDeletion and $this->fieldsRelatedByCreatedByScheduledForDeletion->contains($l)) {
                $this->fieldsRelatedByCreatedByScheduledForDeletion->remove($this->fieldsRelatedByCreatedByScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildField $fieldRelatedByCreatedBy The ChildField object to add.
     */
    protected function doAddFieldRelatedByCreatedBy(ChildField $fieldRelatedByCreatedBy)
    {
        $this->collFieldsRelatedByCreatedBy[]= $fieldRelatedByCreatedBy;
        $fieldRelatedByCreatedBy->setUserRelatedByCreatedBy($this);
    }

    /**
     * @param  ChildField $fieldRelatedByCreatedBy The ChildField object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removeFieldRelatedByCreatedBy(ChildField $fieldRelatedByCreatedBy)
    {
        if ($this->getFieldsRelatedByCreatedBy()->contains($fieldRelatedByCreatedBy)) {
            $pos = $this->collFieldsRelatedByCreatedBy->search($fieldRelatedByCreatedBy);
            $this->collFieldsRelatedByCreatedBy->remove($pos);
            if (null === $this->fieldsRelatedByCreatedByScheduledForDeletion) {
                $this->fieldsRelatedByCreatedByScheduledForDeletion = clone $this->collFieldsRelatedByCreatedBy;
                $this->fieldsRelatedByCreatedByScheduledForDeletion->clear();
            }
            $this->fieldsRelatedByCreatedByScheduledForDeletion[]= $fieldRelatedByCreatedBy;
            $fieldRelatedByCreatedBy->setUserRelatedByCreatedBy(null);
        }

        return $this;
    }

    /**
     * Clears out the collFieldsRelatedByUpdatedBy collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addFieldsRelatedByUpdatedBy()
     */
    public function clearFieldsRelatedByUpdatedBy()
    {
        $this->collFieldsRelatedByUpdatedBy = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collFieldsRelatedByUpdatedBy collection loaded partially.
     */
    public function resetPartialFieldsRelatedByUpdatedBy($v = true)
    {
        $this->collFieldsRelatedByUpdatedByPartial = $v;
    }

    /**
     * Initializes the collFieldsRelatedByUpdatedBy collection.
     *
     * By default this just sets the collFieldsRelatedByUpdatedBy collection to an empty array (like clearcollFieldsRelatedByUpdatedBy());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initFieldsRelatedByUpdatedBy($overrideExisting = true)
    {
        if (null !== $this->collFieldsRelatedByUpdatedBy && !$overrideExisting) {
            return;
        }

        $collectionClassName = FieldTableMap::getTableMap()->getCollectionClassName();

        $this->collFieldsRelatedByUpdatedBy = new $collectionClassName;
        $this->collFieldsRelatedByUpdatedBy->setModel('\Propel\Models\Field');
    }

    /**
     * Gets an array of ChildField objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildField[] List of ChildField objects
     * @throws PropelException
     */
    public function getFieldsRelatedByUpdatedBy(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collFieldsRelatedByUpdatedByPartial && !$this->isNew();
        if (null === $this->collFieldsRelatedByUpdatedBy || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collFieldsRelatedByUpdatedBy) {
                // return empty collection
                $this->initFieldsRelatedByUpdatedBy();
            } else {
                $collFieldsRelatedByUpdatedBy = ChildFieldQuery::create(null, $criteria)
                    ->filterByUserRelatedByUpdatedBy($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collFieldsRelatedByUpdatedByPartial && count($collFieldsRelatedByUpdatedBy)) {
                        $this->initFieldsRelatedByUpdatedBy(false);

                        foreach ($collFieldsRelatedByUpdatedBy as $obj) {
                            if (false == $this->collFieldsRelatedByUpdatedBy->contains($obj)) {
                                $this->collFieldsRelatedByUpdatedBy->append($obj);
                            }
                        }

                        $this->collFieldsRelatedByUpdatedByPartial = true;
                    }

                    return $collFieldsRelatedByUpdatedBy;
                }

                if ($partial && $this->collFieldsRelatedByUpdatedBy) {
                    foreach ($this->collFieldsRelatedByUpdatedBy as $obj) {
                        if ($obj->isNew()) {
                            $collFieldsRelatedByUpdatedBy[] = $obj;
                        }
                    }
                }

                $this->collFieldsRelatedByUpdatedBy = $collFieldsRelatedByUpdatedBy;
                $this->collFieldsRelatedByUpdatedByPartial = false;
            }
        }

        return $this->collFieldsRelatedByUpdatedBy;
    }

    /**
     * Sets a collection of ChildField objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $fieldsRelatedByUpdatedBy A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setFieldsRelatedByUpdatedBy(Collection $fieldsRelatedByUpdatedBy, ConnectionInterface $con = null)
    {
        /** @var ChildField[] $fieldsRelatedByUpdatedByToDelete */
        $fieldsRelatedByUpdatedByToDelete = $this->getFieldsRelatedByUpdatedBy(new Criteria(), $con)->diff($fieldsRelatedByUpdatedBy);


        $this->fieldsRelatedByUpdatedByScheduledForDeletion = $fieldsRelatedByUpdatedByToDelete;

        foreach ($fieldsRelatedByUpdatedByToDelete as $fieldRelatedByUpdatedByRemoved) {
            $fieldRelatedByUpdatedByRemoved->setUserRelatedByUpdatedBy(null);
        }

        $this->collFieldsRelatedByUpdatedBy = null;
        foreach ($fieldsRelatedByUpdatedBy as $fieldRelatedByUpdatedBy) {
            $this->addFieldRelatedByUpdatedBy($fieldRelatedByUpdatedBy);
        }

        $this->collFieldsRelatedByUpdatedBy = $fieldsRelatedByUpdatedBy;
        $this->collFieldsRelatedByUpdatedByPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Field objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Field objects.
     * @throws PropelException
     */
    public function countFieldsRelatedByUpdatedBy(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collFieldsRelatedByUpdatedByPartial && !$this->isNew();
        if (null === $this->collFieldsRelatedByUpdatedBy || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collFieldsRelatedByUpdatedBy) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getFieldsRelatedByUpdatedBy());
            }

            $query = ChildFieldQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUserRelatedByUpdatedBy($this)
                ->count($con);
        }

        return count($this->collFieldsRelatedByUpdatedBy);
    }

    /**
     * Method called to associate a ChildField object to this object
     * through the ChildField foreign key attribute.
     *
     * @param  ChildField $l ChildField
     * @return $this|\Propel\Models\User The current object (for fluent API support)
     */
    public function addFieldRelatedByUpdatedBy(ChildField $l)
    {
        if ($this->collFieldsRelatedByUpdatedBy === null) {
            $this->initFieldsRelatedByUpdatedBy();
            $this->collFieldsRelatedByUpdatedByPartial = true;
        }

        if (!$this->collFieldsRelatedByUpdatedBy->contains($l)) {
            $this->doAddFieldRelatedByUpdatedBy($l);

            if ($this->fieldsRelatedByUpdatedByScheduledForDeletion and $this->fieldsRelatedByUpdatedByScheduledForDeletion->contains($l)) {
                $this->fieldsRelatedByUpdatedByScheduledForDeletion->remove($this->fieldsRelatedByUpdatedByScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildField $fieldRelatedByUpdatedBy The ChildField object to add.
     */
    protected function doAddFieldRelatedByUpdatedBy(ChildField $fieldRelatedByUpdatedBy)
    {
        $this->collFieldsRelatedByUpdatedBy[]= $fieldRelatedByUpdatedBy;
        $fieldRelatedByUpdatedBy->setUserRelatedByUpdatedBy($this);
    }

    /**
     * @param  ChildField $fieldRelatedByUpdatedBy The ChildField object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removeFieldRelatedByUpdatedBy(ChildField $fieldRelatedByUpdatedBy)
    {
        if ($this->getFieldsRelatedByUpdatedBy()->contains($fieldRelatedByUpdatedBy)) {
            $pos = $this->collFieldsRelatedByUpdatedBy->search($fieldRelatedByUpdatedBy);
            $this->collFieldsRelatedByUpdatedBy->remove($pos);
            if (null === $this->fieldsRelatedByUpdatedByScheduledForDeletion) {
                $this->fieldsRelatedByUpdatedByScheduledForDeletion = clone $this->collFieldsRelatedByUpdatedBy;
                $this->fieldsRelatedByUpdatedByScheduledForDeletion->clear();
            }
            $this->fieldsRelatedByUpdatedByScheduledForDeletion[]= $fieldRelatedByUpdatedBy;
            $fieldRelatedByUpdatedBy->setUserRelatedByUpdatedBy(null);
        }

        return $this;
    }

    /**
     * Clears out the collPollsRelatedByCreatedBy collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPollsRelatedByCreatedBy()
     */
    public function clearPollsRelatedByCreatedBy()
    {
        $this->collPollsRelatedByCreatedBy = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPollsRelatedByCreatedBy collection loaded partially.
     */
    public function resetPartialPollsRelatedByCreatedBy($v = true)
    {
        $this->collPollsRelatedByCreatedByPartial = $v;
    }

    /**
     * Initializes the collPollsRelatedByCreatedBy collection.
     *
     * By default this just sets the collPollsRelatedByCreatedBy collection to an empty array (like clearcollPollsRelatedByCreatedBy());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPollsRelatedByCreatedBy($overrideExisting = true)
    {
        if (null !== $this->collPollsRelatedByCreatedBy && !$overrideExisting) {
            return;
        }

        $collectionClassName = PollTableMap::getTableMap()->getCollectionClassName();

        $this->collPollsRelatedByCreatedBy = new $collectionClassName;
        $this->collPollsRelatedByCreatedBy->setModel('\Propel\Models\Poll');
    }

    /**
     * Gets an array of ChildPoll objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPoll[] List of ChildPoll objects
     * @throws PropelException
     */
    public function getPollsRelatedByCreatedBy(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPollsRelatedByCreatedByPartial && !$this->isNew();
        if (null === $this->collPollsRelatedByCreatedBy || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPollsRelatedByCreatedBy) {
                // return empty collection
                $this->initPollsRelatedByCreatedBy();
            } else {
                $collPollsRelatedByCreatedBy = ChildPollQuery::create(null, $criteria)
                    ->filterByUserRelatedByCreatedBy($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPollsRelatedByCreatedByPartial && count($collPollsRelatedByCreatedBy)) {
                        $this->initPollsRelatedByCreatedBy(false);

                        foreach ($collPollsRelatedByCreatedBy as $obj) {
                            if (false == $this->collPollsRelatedByCreatedBy->contains($obj)) {
                                $this->collPollsRelatedByCreatedBy->append($obj);
                            }
                        }

                        $this->collPollsRelatedByCreatedByPartial = true;
                    }

                    return $collPollsRelatedByCreatedBy;
                }

                if ($partial && $this->collPollsRelatedByCreatedBy) {
                    foreach ($this->collPollsRelatedByCreatedBy as $obj) {
                        if ($obj->isNew()) {
                            $collPollsRelatedByCreatedBy[] = $obj;
                        }
                    }
                }

                $this->collPollsRelatedByCreatedBy = $collPollsRelatedByCreatedBy;
                $this->collPollsRelatedByCreatedByPartial = false;
            }
        }

        return $this->collPollsRelatedByCreatedBy;
    }

    /**
     * Sets a collection of ChildPoll objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $pollsRelatedByCreatedBy A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setPollsRelatedByCreatedBy(Collection $pollsRelatedByCreatedBy, ConnectionInterface $con = null)
    {
        /** @var ChildPoll[] $pollsRelatedByCreatedByToDelete */
        $pollsRelatedByCreatedByToDelete = $this->getPollsRelatedByCreatedBy(new Criteria(), $con)->diff($pollsRelatedByCreatedBy);


        $this->pollsRelatedByCreatedByScheduledForDeletion = $pollsRelatedByCreatedByToDelete;

        foreach ($pollsRelatedByCreatedByToDelete as $pollRelatedByCreatedByRemoved) {
            $pollRelatedByCreatedByRemoved->setUserRelatedByCreatedBy(null);
        }

        $this->collPollsRelatedByCreatedBy = null;
        foreach ($pollsRelatedByCreatedBy as $pollRelatedByCreatedBy) {
            $this->addPollRelatedByCreatedBy($pollRelatedByCreatedBy);
        }

        $this->collPollsRelatedByCreatedBy = $pollsRelatedByCreatedBy;
        $this->collPollsRelatedByCreatedByPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Poll objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Poll objects.
     * @throws PropelException
     */
    public function countPollsRelatedByCreatedBy(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPollsRelatedByCreatedByPartial && !$this->isNew();
        if (null === $this->collPollsRelatedByCreatedBy || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPollsRelatedByCreatedBy) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPollsRelatedByCreatedBy());
            }

            $query = ChildPollQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUserRelatedByCreatedBy($this)
                ->count($con);
        }

        return count($this->collPollsRelatedByCreatedBy);
    }

    /**
     * Method called to associate a ChildPoll object to this object
     * through the ChildPoll foreign key attribute.
     *
     * @param  ChildPoll $l ChildPoll
     * @return $this|\Propel\Models\User The current object (for fluent API support)
     */
    public function addPollRelatedByCreatedBy(ChildPoll $l)
    {
        if ($this->collPollsRelatedByCreatedBy === null) {
            $this->initPollsRelatedByCreatedBy();
            $this->collPollsRelatedByCreatedByPartial = true;
        }

        if (!$this->collPollsRelatedByCreatedBy->contains($l)) {
            $this->doAddPollRelatedByCreatedBy($l);

            if ($this->pollsRelatedByCreatedByScheduledForDeletion and $this->pollsRelatedByCreatedByScheduledForDeletion->contains($l)) {
                $this->pollsRelatedByCreatedByScheduledForDeletion->remove($this->pollsRelatedByCreatedByScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildPoll $pollRelatedByCreatedBy The ChildPoll object to add.
     */
    protected function doAddPollRelatedByCreatedBy(ChildPoll $pollRelatedByCreatedBy)
    {
        $this->collPollsRelatedByCreatedBy[]= $pollRelatedByCreatedBy;
        $pollRelatedByCreatedBy->setUserRelatedByCreatedBy($this);
    }

    /**
     * @param  ChildPoll $pollRelatedByCreatedBy The ChildPoll object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removePollRelatedByCreatedBy(ChildPoll $pollRelatedByCreatedBy)
    {
        if ($this->getPollsRelatedByCreatedBy()->contains($pollRelatedByCreatedBy)) {
            $pos = $this->collPollsRelatedByCreatedBy->search($pollRelatedByCreatedBy);
            $this->collPollsRelatedByCreatedBy->remove($pos);
            if (null === $this->pollsRelatedByCreatedByScheduledForDeletion) {
                $this->pollsRelatedByCreatedByScheduledForDeletion = clone $this->collPollsRelatedByCreatedBy;
                $this->pollsRelatedByCreatedByScheduledForDeletion->clear();
            }
            $this->pollsRelatedByCreatedByScheduledForDeletion[]= $pollRelatedByCreatedBy;
            $pollRelatedByCreatedBy->setUserRelatedByCreatedBy(null);
        }

        return $this;
    }

    /**
     * Clears out the collPollsRelatedByUpdatedBy collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPollsRelatedByUpdatedBy()
     */
    public function clearPollsRelatedByUpdatedBy()
    {
        $this->collPollsRelatedByUpdatedBy = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPollsRelatedByUpdatedBy collection loaded partially.
     */
    public function resetPartialPollsRelatedByUpdatedBy($v = true)
    {
        $this->collPollsRelatedByUpdatedByPartial = $v;
    }

    /**
     * Initializes the collPollsRelatedByUpdatedBy collection.
     *
     * By default this just sets the collPollsRelatedByUpdatedBy collection to an empty array (like clearcollPollsRelatedByUpdatedBy());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPollsRelatedByUpdatedBy($overrideExisting = true)
    {
        if (null !== $this->collPollsRelatedByUpdatedBy && !$overrideExisting) {
            return;
        }

        $collectionClassName = PollTableMap::getTableMap()->getCollectionClassName();

        $this->collPollsRelatedByUpdatedBy = new $collectionClassName;
        $this->collPollsRelatedByUpdatedBy->setModel('\Propel\Models\Poll');
    }

    /**
     * Gets an array of ChildPoll objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPoll[] List of ChildPoll objects
     * @throws PropelException
     */
    public function getPollsRelatedByUpdatedBy(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPollsRelatedByUpdatedByPartial && !$this->isNew();
        if (null === $this->collPollsRelatedByUpdatedBy || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPollsRelatedByUpdatedBy) {
                // return empty collection
                $this->initPollsRelatedByUpdatedBy();
            } else {
                $collPollsRelatedByUpdatedBy = ChildPollQuery::create(null, $criteria)
                    ->filterByUserRelatedByUpdatedBy($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPollsRelatedByUpdatedByPartial && count($collPollsRelatedByUpdatedBy)) {
                        $this->initPollsRelatedByUpdatedBy(false);

                        foreach ($collPollsRelatedByUpdatedBy as $obj) {
                            if (false == $this->collPollsRelatedByUpdatedBy->contains($obj)) {
                                $this->collPollsRelatedByUpdatedBy->append($obj);
                            }
                        }

                        $this->collPollsRelatedByUpdatedByPartial = true;
                    }

                    return $collPollsRelatedByUpdatedBy;
                }

                if ($partial && $this->collPollsRelatedByUpdatedBy) {
                    foreach ($this->collPollsRelatedByUpdatedBy as $obj) {
                        if ($obj->isNew()) {
                            $collPollsRelatedByUpdatedBy[] = $obj;
                        }
                    }
                }

                $this->collPollsRelatedByUpdatedBy = $collPollsRelatedByUpdatedBy;
                $this->collPollsRelatedByUpdatedByPartial = false;
            }
        }

        return $this->collPollsRelatedByUpdatedBy;
    }

    /**
     * Sets a collection of ChildPoll objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $pollsRelatedByUpdatedBy A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setPollsRelatedByUpdatedBy(Collection $pollsRelatedByUpdatedBy, ConnectionInterface $con = null)
    {
        /** @var ChildPoll[] $pollsRelatedByUpdatedByToDelete */
        $pollsRelatedByUpdatedByToDelete = $this->getPollsRelatedByUpdatedBy(new Criteria(), $con)->diff($pollsRelatedByUpdatedBy);


        $this->pollsRelatedByUpdatedByScheduledForDeletion = $pollsRelatedByUpdatedByToDelete;

        foreach ($pollsRelatedByUpdatedByToDelete as $pollRelatedByUpdatedByRemoved) {
            $pollRelatedByUpdatedByRemoved->setUserRelatedByUpdatedBy(null);
        }

        $this->collPollsRelatedByUpdatedBy = null;
        foreach ($pollsRelatedByUpdatedBy as $pollRelatedByUpdatedBy) {
            $this->addPollRelatedByUpdatedBy($pollRelatedByUpdatedBy);
        }

        $this->collPollsRelatedByUpdatedBy = $pollsRelatedByUpdatedBy;
        $this->collPollsRelatedByUpdatedByPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Poll objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Poll objects.
     * @throws PropelException
     */
    public function countPollsRelatedByUpdatedBy(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPollsRelatedByUpdatedByPartial && !$this->isNew();
        if (null === $this->collPollsRelatedByUpdatedBy || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPollsRelatedByUpdatedBy) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPollsRelatedByUpdatedBy());
            }

            $query = ChildPollQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUserRelatedByUpdatedBy($this)
                ->count($con);
        }

        return count($this->collPollsRelatedByUpdatedBy);
    }

    /**
     * Method called to associate a ChildPoll object to this object
     * through the ChildPoll foreign key attribute.
     *
     * @param  ChildPoll $l ChildPoll
     * @return $this|\Propel\Models\User The current object (for fluent API support)
     */
    public function addPollRelatedByUpdatedBy(ChildPoll $l)
    {
        if ($this->collPollsRelatedByUpdatedBy === null) {
            $this->initPollsRelatedByUpdatedBy();
            $this->collPollsRelatedByUpdatedByPartial = true;
        }

        if (!$this->collPollsRelatedByUpdatedBy->contains($l)) {
            $this->doAddPollRelatedByUpdatedBy($l);

            if ($this->pollsRelatedByUpdatedByScheduledForDeletion and $this->pollsRelatedByUpdatedByScheduledForDeletion->contains($l)) {
                $this->pollsRelatedByUpdatedByScheduledForDeletion->remove($this->pollsRelatedByUpdatedByScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildPoll $pollRelatedByUpdatedBy The ChildPoll object to add.
     */
    protected function doAddPollRelatedByUpdatedBy(ChildPoll $pollRelatedByUpdatedBy)
    {
        $this->collPollsRelatedByUpdatedBy[]= $pollRelatedByUpdatedBy;
        $pollRelatedByUpdatedBy->setUserRelatedByUpdatedBy($this);
    }

    /**
     * @param  ChildPoll $pollRelatedByUpdatedBy The ChildPoll object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removePollRelatedByUpdatedBy(ChildPoll $pollRelatedByUpdatedBy)
    {
        if ($this->getPollsRelatedByUpdatedBy()->contains($pollRelatedByUpdatedBy)) {
            $pos = $this->collPollsRelatedByUpdatedBy->search($pollRelatedByUpdatedBy);
            $this->collPollsRelatedByUpdatedBy->remove($pos);
            if (null === $this->pollsRelatedByUpdatedByScheduledForDeletion) {
                $this->pollsRelatedByUpdatedByScheduledForDeletion = clone $this->collPollsRelatedByUpdatedBy;
                $this->pollsRelatedByUpdatedByScheduledForDeletion->clear();
            }
            $this->pollsRelatedByUpdatedByScheduledForDeletion[]= $pollRelatedByUpdatedBy;
            $pollRelatedByUpdatedBy->setUserRelatedByUpdatedBy(null);
        }

        return $this;
    }

    /**
     * Clears out the collPollVariantsRelatedByCreatedBy collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPollVariantsRelatedByCreatedBy()
     */
    public function clearPollVariantsRelatedByCreatedBy()
    {
        $this->collPollVariantsRelatedByCreatedBy = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPollVariantsRelatedByCreatedBy collection loaded partially.
     */
    public function resetPartialPollVariantsRelatedByCreatedBy($v = true)
    {
        $this->collPollVariantsRelatedByCreatedByPartial = $v;
    }

    /**
     * Initializes the collPollVariantsRelatedByCreatedBy collection.
     *
     * By default this just sets the collPollVariantsRelatedByCreatedBy collection to an empty array (like clearcollPollVariantsRelatedByCreatedBy());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPollVariantsRelatedByCreatedBy($overrideExisting = true)
    {
        if (null !== $this->collPollVariantsRelatedByCreatedBy && !$overrideExisting) {
            return;
        }

        $collectionClassName = PollVariantTableMap::getTableMap()->getCollectionClassName();

        $this->collPollVariantsRelatedByCreatedBy = new $collectionClassName;
        $this->collPollVariantsRelatedByCreatedBy->setModel('\Propel\Models\PollVariant');
    }

    /**
     * Gets an array of ChildPollVariant objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPollVariant[] List of ChildPollVariant objects
     * @throws PropelException
     */
    public function getPollVariantsRelatedByCreatedBy(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPollVariantsRelatedByCreatedByPartial && !$this->isNew();
        if (null === $this->collPollVariantsRelatedByCreatedBy || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPollVariantsRelatedByCreatedBy) {
                // return empty collection
                $this->initPollVariantsRelatedByCreatedBy();
            } else {
                $collPollVariantsRelatedByCreatedBy = ChildPollVariantQuery::create(null, $criteria)
                    ->filterByUserRelatedByCreatedBy($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPollVariantsRelatedByCreatedByPartial && count($collPollVariantsRelatedByCreatedBy)) {
                        $this->initPollVariantsRelatedByCreatedBy(false);

                        foreach ($collPollVariantsRelatedByCreatedBy as $obj) {
                            if (false == $this->collPollVariantsRelatedByCreatedBy->contains($obj)) {
                                $this->collPollVariantsRelatedByCreatedBy->append($obj);
                            }
                        }

                        $this->collPollVariantsRelatedByCreatedByPartial = true;
                    }

                    return $collPollVariantsRelatedByCreatedBy;
                }

                if ($partial && $this->collPollVariantsRelatedByCreatedBy) {
                    foreach ($this->collPollVariantsRelatedByCreatedBy as $obj) {
                        if ($obj->isNew()) {
                            $collPollVariantsRelatedByCreatedBy[] = $obj;
                        }
                    }
                }

                $this->collPollVariantsRelatedByCreatedBy = $collPollVariantsRelatedByCreatedBy;
                $this->collPollVariantsRelatedByCreatedByPartial = false;
            }
        }

        return $this->collPollVariantsRelatedByCreatedBy;
    }

    /**
     * Sets a collection of ChildPollVariant objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $pollVariantsRelatedByCreatedBy A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setPollVariantsRelatedByCreatedBy(Collection $pollVariantsRelatedByCreatedBy, ConnectionInterface $con = null)
    {
        /** @var ChildPollVariant[] $pollVariantsRelatedByCreatedByToDelete */
        $pollVariantsRelatedByCreatedByToDelete = $this->getPollVariantsRelatedByCreatedBy(new Criteria(), $con)->diff($pollVariantsRelatedByCreatedBy);


        $this->pollVariantsRelatedByCreatedByScheduledForDeletion = $pollVariantsRelatedByCreatedByToDelete;

        foreach ($pollVariantsRelatedByCreatedByToDelete as $pollVariantRelatedByCreatedByRemoved) {
            $pollVariantRelatedByCreatedByRemoved->setUserRelatedByCreatedBy(null);
        }

        $this->collPollVariantsRelatedByCreatedBy = null;
        foreach ($pollVariantsRelatedByCreatedBy as $pollVariantRelatedByCreatedBy) {
            $this->addPollVariantRelatedByCreatedBy($pollVariantRelatedByCreatedBy);
        }

        $this->collPollVariantsRelatedByCreatedBy = $pollVariantsRelatedByCreatedBy;
        $this->collPollVariantsRelatedByCreatedByPartial = false;

        return $this;
    }

    /**
     * Returns the number of related PollVariant objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related PollVariant objects.
     * @throws PropelException
     */
    public function countPollVariantsRelatedByCreatedBy(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPollVariantsRelatedByCreatedByPartial && !$this->isNew();
        if (null === $this->collPollVariantsRelatedByCreatedBy || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPollVariantsRelatedByCreatedBy) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPollVariantsRelatedByCreatedBy());
            }

            $query = ChildPollVariantQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUserRelatedByCreatedBy($this)
                ->count($con);
        }

        return count($this->collPollVariantsRelatedByCreatedBy);
    }

    /**
     * Method called to associate a ChildPollVariant object to this object
     * through the ChildPollVariant foreign key attribute.
     *
     * @param  ChildPollVariant $l ChildPollVariant
     * @return $this|\Propel\Models\User The current object (for fluent API support)
     */
    public function addPollVariantRelatedByCreatedBy(ChildPollVariant $l)
    {
        if ($this->collPollVariantsRelatedByCreatedBy === null) {
            $this->initPollVariantsRelatedByCreatedBy();
            $this->collPollVariantsRelatedByCreatedByPartial = true;
        }

        if (!$this->collPollVariantsRelatedByCreatedBy->contains($l)) {
            $this->doAddPollVariantRelatedByCreatedBy($l);

            if ($this->pollVariantsRelatedByCreatedByScheduledForDeletion and $this->pollVariantsRelatedByCreatedByScheduledForDeletion->contains($l)) {
                $this->pollVariantsRelatedByCreatedByScheduledForDeletion->remove($this->pollVariantsRelatedByCreatedByScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildPollVariant $pollVariantRelatedByCreatedBy The ChildPollVariant object to add.
     */
    protected function doAddPollVariantRelatedByCreatedBy(ChildPollVariant $pollVariantRelatedByCreatedBy)
    {
        $this->collPollVariantsRelatedByCreatedBy[]= $pollVariantRelatedByCreatedBy;
        $pollVariantRelatedByCreatedBy->setUserRelatedByCreatedBy($this);
    }

    /**
     * @param  ChildPollVariant $pollVariantRelatedByCreatedBy The ChildPollVariant object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removePollVariantRelatedByCreatedBy(ChildPollVariant $pollVariantRelatedByCreatedBy)
    {
        if ($this->getPollVariantsRelatedByCreatedBy()->contains($pollVariantRelatedByCreatedBy)) {
            $pos = $this->collPollVariantsRelatedByCreatedBy->search($pollVariantRelatedByCreatedBy);
            $this->collPollVariantsRelatedByCreatedBy->remove($pos);
            if (null === $this->pollVariantsRelatedByCreatedByScheduledForDeletion) {
                $this->pollVariantsRelatedByCreatedByScheduledForDeletion = clone $this->collPollVariantsRelatedByCreatedBy;
                $this->pollVariantsRelatedByCreatedByScheduledForDeletion->clear();
            }
            $this->pollVariantsRelatedByCreatedByScheduledForDeletion[]= $pollVariantRelatedByCreatedBy;
            $pollVariantRelatedByCreatedBy->setUserRelatedByCreatedBy(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related PollVariantsRelatedByCreatedBy from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPollVariant[] List of ChildPollVariant objects
     */
    public function getPollVariantsRelatedByCreatedByJoinPoll(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPollVariantQuery::create(null, $criteria);
        $query->joinWith('Poll', $joinBehavior);

        return $this->getPollVariantsRelatedByCreatedBy($query, $con);
    }

    /**
     * Clears out the collPollVariantsRelatedByUpdatedBy collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPollVariantsRelatedByUpdatedBy()
     */
    public function clearPollVariantsRelatedByUpdatedBy()
    {
        $this->collPollVariantsRelatedByUpdatedBy = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPollVariantsRelatedByUpdatedBy collection loaded partially.
     */
    public function resetPartialPollVariantsRelatedByUpdatedBy($v = true)
    {
        $this->collPollVariantsRelatedByUpdatedByPartial = $v;
    }

    /**
     * Initializes the collPollVariantsRelatedByUpdatedBy collection.
     *
     * By default this just sets the collPollVariantsRelatedByUpdatedBy collection to an empty array (like clearcollPollVariantsRelatedByUpdatedBy());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPollVariantsRelatedByUpdatedBy($overrideExisting = true)
    {
        if (null !== $this->collPollVariantsRelatedByUpdatedBy && !$overrideExisting) {
            return;
        }

        $collectionClassName = PollVariantTableMap::getTableMap()->getCollectionClassName();

        $this->collPollVariantsRelatedByUpdatedBy = new $collectionClassName;
        $this->collPollVariantsRelatedByUpdatedBy->setModel('\Propel\Models\PollVariant');
    }

    /**
     * Gets an array of ChildPollVariant objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPollVariant[] List of ChildPollVariant objects
     * @throws PropelException
     */
    public function getPollVariantsRelatedByUpdatedBy(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPollVariantsRelatedByUpdatedByPartial && !$this->isNew();
        if (null === $this->collPollVariantsRelatedByUpdatedBy || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPollVariantsRelatedByUpdatedBy) {
                // return empty collection
                $this->initPollVariantsRelatedByUpdatedBy();
            } else {
                $collPollVariantsRelatedByUpdatedBy = ChildPollVariantQuery::create(null, $criteria)
                    ->filterByUserRelatedByUpdatedBy($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPollVariantsRelatedByUpdatedByPartial && count($collPollVariantsRelatedByUpdatedBy)) {
                        $this->initPollVariantsRelatedByUpdatedBy(false);

                        foreach ($collPollVariantsRelatedByUpdatedBy as $obj) {
                            if (false == $this->collPollVariantsRelatedByUpdatedBy->contains($obj)) {
                                $this->collPollVariantsRelatedByUpdatedBy->append($obj);
                            }
                        }

                        $this->collPollVariantsRelatedByUpdatedByPartial = true;
                    }

                    return $collPollVariantsRelatedByUpdatedBy;
                }

                if ($partial && $this->collPollVariantsRelatedByUpdatedBy) {
                    foreach ($this->collPollVariantsRelatedByUpdatedBy as $obj) {
                        if ($obj->isNew()) {
                            $collPollVariantsRelatedByUpdatedBy[] = $obj;
                        }
                    }
                }

                $this->collPollVariantsRelatedByUpdatedBy = $collPollVariantsRelatedByUpdatedBy;
                $this->collPollVariantsRelatedByUpdatedByPartial = false;
            }
        }

        return $this->collPollVariantsRelatedByUpdatedBy;
    }

    /**
     * Sets a collection of ChildPollVariant objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $pollVariantsRelatedByUpdatedBy A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setPollVariantsRelatedByUpdatedBy(Collection $pollVariantsRelatedByUpdatedBy, ConnectionInterface $con = null)
    {
        /** @var ChildPollVariant[] $pollVariantsRelatedByUpdatedByToDelete */
        $pollVariantsRelatedByUpdatedByToDelete = $this->getPollVariantsRelatedByUpdatedBy(new Criteria(), $con)->diff($pollVariantsRelatedByUpdatedBy);


        $this->pollVariantsRelatedByUpdatedByScheduledForDeletion = $pollVariantsRelatedByUpdatedByToDelete;

        foreach ($pollVariantsRelatedByUpdatedByToDelete as $pollVariantRelatedByUpdatedByRemoved) {
            $pollVariantRelatedByUpdatedByRemoved->setUserRelatedByUpdatedBy(null);
        }

        $this->collPollVariantsRelatedByUpdatedBy = null;
        foreach ($pollVariantsRelatedByUpdatedBy as $pollVariantRelatedByUpdatedBy) {
            $this->addPollVariantRelatedByUpdatedBy($pollVariantRelatedByUpdatedBy);
        }

        $this->collPollVariantsRelatedByUpdatedBy = $pollVariantsRelatedByUpdatedBy;
        $this->collPollVariantsRelatedByUpdatedByPartial = false;

        return $this;
    }

    /**
     * Returns the number of related PollVariant objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related PollVariant objects.
     * @throws PropelException
     */
    public function countPollVariantsRelatedByUpdatedBy(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPollVariantsRelatedByUpdatedByPartial && !$this->isNew();
        if (null === $this->collPollVariantsRelatedByUpdatedBy || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPollVariantsRelatedByUpdatedBy) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPollVariantsRelatedByUpdatedBy());
            }

            $query = ChildPollVariantQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUserRelatedByUpdatedBy($this)
                ->count($con);
        }

        return count($this->collPollVariantsRelatedByUpdatedBy);
    }

    /**
     * Method called to associate a ChildPollVariant object to this object
     * through the ChildPollVariant foreign key attribute.
     *
     * @param  ChildPollVariant $l ChildPollVariant
     * @return $this|\Propel\Models\User The current object (for fluent API support)
     */
    public function addPollVariantRelatedByUpdatedBy(ChildPollVariant $l)
    {
        if ($this->collPollVariantsRelatedByUpdatedBy === null) {
            $this->initPollVariantsRelatedByUpdatedBy();
            $this->collPollVariantsRelatedByUpdatedByPartial = true;
        }

        if (!$this->collPollVariantsRelatedByUpdatedBy->contains($l)) {
            $this->doAddPollVariantRelatedByUpdatedBy($l);

            if ($this->pollVariantsRelatedByUpdatedByScheduledForDeletion and $this->pollVariantsRelatedByUpdatedByScheduledForDeletion->contains($l)) {
                $this->pollVariantsRelatedByUpdatedByScheduledForDeletion->remove($this->pollVariantsRelatedByUpdatedByScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildPollVariant $pollVariantRelatedByUpdatedBy The ChildPollVariant object to add.
     */
    protected function doAddPollVariantRelatedByUpdatedBy(ChildPollVariant $pollVariantRelatedByUpdatedBy)
    {
        $this->collPollVariantsRelatedByUpdatedBy[]= $pollVariantRelatedByUpdatedBy;
        $pollVariantRelatedByUpdatedBy->setUserRelatedByUpdatedBy($this);
    }

    /**
     * @param  ChildPollVariant $pollVariantRelatedByUpdatedBy The ChildPollVariant object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removePollVariantRelatedByUpdatedBy(ChildPollVariant $pollVariantRelatedByUpdatedBy)
    {
        if ($this->getPollVariantsRelatedByUpdatedBy()->contains($pollVariantRelatedByUpdatedBy)) {
            $pos = $this->collPollVariantsRelatedByUpdatedBy->search($pollVariantRelatedByUpdatedBy);
            $this->collPollVariantsRelatedByUpdatedBy->remove($pos);
            if (null === $this->pollVariantsRelatedByUpdatedByScheduledForDeletion) {
                $this->pollVariantsRelatedByUpdatedByScheduledForDeletion = clone $this->collPollVariantsRelatedByUpdatedBy;
                $this->pollVariantsRelatedByUpdatedByScheduledForDeletion->clear();
            }
            $this->pollVariantsRelatedByUpdatedByScheduledForDeletion[]= $pollVariantRelatedByUpdatedBy;
            $pollVariantRelatedByUpdatedBy->setUserRelatedByUpdatedBy(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related PollVariantsRelatedByUpdatedBy from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPollVariant[] List of ChildPollVariant objects
     */
    public function getPollVariantsRelatedByUpdatedByJoinPoll(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPollVariantQuery::create(null, $criteria);
        $query->joinWith('Poll', $joinBehavior);

        return $this->getPollVariantsRelatedByUpdatedBy($query, $con);
    }

    /**
     * Clears out the collSectionsRelatedByCreatedBy collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSectionsRelatedByCreatedBy()
     */
    public function clearSectionsRelatedByCreatedBy()
    {
        $this->collSectionsRelatedByCreatedBy = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collSectionsRelatedByCreatedBy collection loaded partially.
     */
    public function resetPartialSectionsRelatedByCreatedBy($v = true)
    {
        $this->collSectionsRelatedByCreatedByPartial = $v;
    }

    /**
     * Initializes the collSectionsRelatedByCreatedBy collection.
     *
     * By default this just sets the collSectionsRelatedByCreatedBy collection to an empty array (like clearcollSectionsRelatedByCreatedBy());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSectionsRelatedByCreatedBy($overrideExisting = true)
    {
        if (null !== $this->collSectionsRelatedByCreatedBy && !$overrideExisting) {
            return;
        }

        $collectionClassName = SectionTableMap::getTableMap()->getCollectionClassName();

        $this->collSectionsRelatedByCreatedBy = new $collectionClassName;
        $this->collSectionsRelatedByCreatedBy->setModel('\Propel\Models\Section');
    }

    /**
     * Gets an array of ChildSection objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSection[] List of ChildSection objects
     * @throws PropelException
     */
    public function getSectionsRelatedByCreatedBy(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSectionsRelatedByCreatedByPartial && !$this->isNew();
        if (null === $this->collSectionsRelatedByCreatedBy || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSectionsRelatedByCreatedBy) {
                // return empty collection
                $this->initSectionsRelatedByCreatedBy();
            } else {
                $collSectionsRelatedByCreatedBy = ChildSectionQuery::create(null, $criteria)
                    ->filterByUserRelatedByCreatedBy($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSectionsRelatedByCreatedByPartial && count($collSectionsRelatedByCreatedBy)) {
                        $this->initSectionsRelatedByCreatedBy(false);

                        foreach ($collSectionsRelatedByCreatedBy as $obj) {
                            if (false == $this->collSectionsRelatedByCreatedBy->contains($obj)) {
                                $this->collSectionsRelatedByCreatedBy->append($obj);
                            }
                        }

                        $this->collSectionsRelatedByCreatedByPartial = true;
                    }

                    return $collSectionsRelatedByCreatedBy;
                }

                if ($partial && $this->collSectionsRelatedByCreatedBy) {
                    foreach ($this->collSectionsRelatedByCreatedBy as $obj) {
                        if ($obj->isNew()) {
                            $collSectionsRelatedByCreatedBy[] = $obj;
                        }
                    }
                }

                $this->collSectionsRelatedByCreatedBy = $collSectionsRelatedByCreatedBy;
                $this->collSectionsRelatedByCreatedByPartial = false;
            }
        }

        return $this->collSectionsRelatedByCreatedBy;
    }

    /**
     * Sets a collection of ChildSection objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $sectionsRelatedByCreatedBy A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setSectionsRelatedByCreatedBy(Collection $sectionsRelatedByCreatedBy, ConnectionInterface $con = null)
    {
        /** @var ChildSection[] $sectionsRelatedByCreatedByToDelete */
        $sectionsRelatedByCreatedByToDelete = $this->getSectionsRelatedByCreatedBy(new Criteria(), $con)->diff($sectionsRelatedByCreatedBy);


        $this->sectionsRelatedByCreatedByScheduledForDeletion = $sectionsRelatedByCreatedByToDelete;

        foreach ($sectionsRelatedByCreatedByToDelete as $sectionRelatedByCreatedByRemoved) {
            $sectionRelatedByCreatedByRemoved->setUserRelatedByCreatedBy(null);
        }

        $this->collSectionsRelatedByCreatedBy = null;
        foreach ($sectionsRelatedByCreatedBy as $sectionRelatedByCreatedBy) {
            $this->addSectionRelatedByCreatedBy($sectionRelatedByCreatedBy);
        }

        $this->collSectionsRelatedByCreatedBy = $sectionsRelatedByCreatedBy;
        $this->collSectionsRelatedByCreatedByPartial = false;

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
    public function countSectionsRelatedByCreatedBy(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSectionsRelatedByCreatedByPartial && !$this->isNew();
        if (null === $this->collSectionsRelatedByCreatedBy || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSectionsRelatedByCreatedBy) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSectionsRelatedByCreatedBy());
            }

            $query = ChildSectionQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUserRelatedByCreatedBy($this)
                ->count($con);
        }

        return count($this->collSectionsRelatedByCreatedBy);
    }

    /**
     * Method called to associate a ChildSection object to this object
     * through the ChildSection foreign key attribute.
     *
     * @param  ChildSection $l ChildSection
     * @return $this|\Propel\Models\User The current object (for fluent API support)
     */
    public function addSectionRelatedByCreatedBy(ChildSection $l)
    {
        if ($this->collSectionsRelatedByCreatedBy === null) {
            $this->initSectionsRelatedByCreatedBy();
            $this->collSectionsRelatedByCreatedByPartial = true;
        }

        if (!$this->collSectionsRelatedByCreatedBy->contains($l)) {
            $this->doAddSectionRelatedByCreatedBy($l);

            if ($this->sectionsRelatedByCreatedByScheduledForDeletion and $this->sectionsRelatedByCreatedByScheduledForDeletion->contains($l)) {
                $this->sectionsRelatedByCreatedByScheduledForDeletion->remove($this->sectionsRelatedByCreatedByScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildSection $sectionRelatedByCreatedBy The ChildSection object to add.
     */
    protected function doAddSectionRelatedByCreatedBy(ChildSection $sectionRelatedByCreatedBy)
    {
        $this->collSectionsRelatedByCreatedBy[]= $sectionRelatedByCreatedBy;
        $sectionRelatedByCreatedBy->setUserRelatedByCreatedBy($this);
    }

    /**
     * @param  ChildSection $sectionRelatedByCreatedBy The ChildSection object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removeSectionRelatedByCreatedBy(ChildSection $sectionRelatedByCreatedBy)
    {
        if ($this->getSectionsRelatedByCreatedBy()->contains($sectionRelatedByCreatedBy)) {
            $pos = $this->collSectionsRelatedByCreatedBy->search($sectionRelatedByCreatedBy);
            $this->collSectionsRelatedByCreatedBy->remove($pos);
            if (null === $this->sectionsRelatedByCreatedByScheduledForDeletion) {
                $this->sectionsRelatedByCreatedByScheduledForDeletion = clone $this->collSectionsRelatedByCreatedBy;
                $this->sectionsRelatedByCreatedByScheduledForDeletion->clear();
            }
            $this->sectionsRelatedByCreatedByScheduledForDeletion[]= $sectionRelatedByCreatedBy;
            $sectionRelatedByCreatedBy->setUserRelatedByCreatedBy(null);
        }

        return $this;
    }

    /**
     * Clears out the collSectionsRelatedByUpdatedBy collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSectionsRelatedByUpdatedBy()
     */
    public function clearSectionsRelatedByUpdatedBy()
    {
        $this->collSectionsRelatedByUpdatedBy = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collSectionsRelatedByUpdatedBy collection loaded partially.
     */
    public function resetPartialSectionsRelatedByUpdatedBy($v = true)
    {
        $this->collSectionsRelatedByUpdatedByPartial = $v;
    }

    /**
     * Initializes the collSectionsRelatedByUpdatedBy collection.
     *
     * By default this just sets the collSectionsRelatedByUpdatedBy collection to an empty array (like clearcollSectionsRelatedByUpdatedBy());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSectionsRelatedByUpdatedBy($overrideExisting = true)
    {
        if (null !== $this->collSectionsRelatedByUpdatedBy && !$overrideExisting) {
            return;
        }

        $collectionClassName = SectionTableMap::getTableMap()->getCollectionClassName();

        $this->collSectionsRelatedByUpdatedBy = new $collectionClassName;
        $this->collSectionsRelatedByUpdatedBy->setModel('\Propel\Models\Section');
    }

    /**
     * Gets an array of ChildSection objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSection[] List of ChildSection objects
     * @throws PropelException
     */
    public function getSectionsRelatedByUpdatedBy(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSectionsRelatedByUpdatedByPartial && !$this->isNew();
        if (null === $this->collSectionsRelatedByUpdatedBy || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSectionsRelatedByUpdatedBy) {
                // return empty collection
                $this->initSectionsRelatedByUpdatedBy();
            } else {
                $collSectionsRelatedByUpdatedBy = ChildSectionQuery::create(null, $criteria)
                    ->filterByUserRelatedByUpdatedBy($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSectionsRelatedByUpdatedByPartial && count($collSectionsRelatedByUpdatedBy)) {
                        $this->initSectionsRelatedByUpdatedBy(false);

                        foreach ($collSectionsRelatedByUpdatedBy as $obj) {
                            if (false == $this->collSectionsRelatedByUpdatedBy->contains($obj)) {
                                $this->collSectionsRelatedByUpdatedBy->append($obj);
                            }
                        }

                        $this->collSectionsRelatedByUpdatedByPartial = true;
                    }

                    return $collSectionsRelatedByUpdatedBy;
                }

                if ($partial && $this->collSectionsRelatedByUpdatedBy) {
                    foreach ($this->collSectionsRelatedByUpdatedBy as $obj) {
                        if ($obj->isNew()) {
                            $collSectionsRelatedByUpdatedBy[] = $obj;
                        }
                    }
                }

                $this->collSectionsRelatedByUpdatedBy = $collSectionsRelatedByUpdatedBy;
                $this->collSectionsRelatedByUpdatedByPartial = false;
            }
        }

        return $this->collSectionsRelatedByUpdatedBy;
    }

    /**
     * Sets a collection of ChildSection objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $sectionsRelatedByUpdatedBy A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setSectionsRelatedByUpdatedBy(Collection $sectionsRelatedByUpdatedBy, ConnectionInterface $con = null)
    {
        /** @var ChildSection[] $sectionsRelatedByUpdatedByToDelete */
        $sectionsRelatedByUpdatedByToDelete = $this->getSectionsRelatedByUpdatedBy(new Criteria(), $con)->diff($sectionsRelatedByUpdatedBy);


        $this->sectionsRelatedByUpdatedByScheduledForDeletion = $sectionsRelatedByUpdatedByToDelete;

        foreach ($sectionsRelatedByUpdatedByToDelete as $sectionRelatedByUpdatedByRemoved) {
            $sectionRelatedByUpdatedByRemoved->setUserRelatedByUpdatedBy(null);
        }

        $this->collSectionsRelatedByUpdatedBy = null;
        foreach ($sectionsRelatedByUpdatedBy as $sectionRelatedByUpdatedBy) {
            $this->addSectionRelatedByUpdatedBy($sectionRelatedByUpdatedBy);
        }

        $this->collSectionsRelatedByUpdatedBy = $sectionsRelatedByUpdatedBy;
        $this->collSectionsRelatedByUpdatedByPartial = false;

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
    public function countSectionsRelatedByUpdatedBy(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSectionsRelatedByUpdatedByPartial && !$this->isNew();
        if (null === $this->collSectionsRelatedByUpdatedBy || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSectionsRelatedByUpdatedBy) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSectionsRelatedByUpdatedBy());
            }

            $query = ChildSectionQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUserRelatedByUpdatedBy($this)
                ->count($con);
        }

        return count($this->collSectionsRelatedByUpdatedBy);
    }

    /**
     * Method called to associate a ChildSection object to this object
     * through the ChildSection foreign key attribute.
     *
     * @param  ChildSection $l ChildSection
     * @return $this|\Propel\Models\User The current object (for fluent API support)
     */
    public function addSectionRelatedByUpdatedBy(ChildSection $l)
    {
        if ($this->collSectionsRelatedByUpdatedBy === null) {
            $this->initSectionsRelatedByUpdatedBy();
            $this->collSectionsRelatedByUpdatedByPartial = true;
        }

        if (!$this->collSectionsRelatedByUpdatedBy->contains($l)) {
            $this->doAddSectionRelatedByUpdatedBy($l);

            if ($this->sectionsRelatedByUpdatedByScheduledForDeletion and $this->sectionsRelatedByUpdatedByScheduledForDeletion->contains($l)) {
                $this->sectionsRelatedByUpdatedByScheduledForDeletion->remove($this->sectionsRelatedByUpdatedByScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildSection $sectionRelatedByUpdatedBy The ChildSection object to add.
     */
    protected function doAddSectionRelatedByUpdatedBy(ChildSection $sectionRelatedByUpdatedBy)
    {
        $this->collSectionsRelatedByUpdatedBy[]= $sectionRelatedByUpdatedBy;
        $sectionRelatedByUpdatedBy->setUserRelatedByUpdatedBy($this);
    }

    /**
     * @param  ChildSection $sectionRelatedByUpdatedBy The ChildSection object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removeSectionRelatedByUpdatedBy(ChildSection $sectionRelatedByUpdatedBy)
    {
        if ($this->getSectionsRelatedByUpdatedBy()->contains($sectionRelatedByUpdatedBy)) {
            $pos = $this->collSectionsRelatedByUpdatedBy->search($sectionRelatedByUpdatedBy);
            $this->collSectionsRelatedByUpdatedBy->remove($pos);
            if (null === $this->sectionsRelatedByUpdatedByScheduledForDeletion) {
                $this->sectionsRelatedByUpdatedByScheduledForDeletion = clone $this->collSectionsRelatedByUpdatedBy;
                $this->sectionsRelatedByUpdatedByScheduledForDeletion->clear();
            }
            $this->sectionsRelatedByUpdatedByScheduledForDeletion[]= $sectionRelatedByUpdatedBy;
            $sectionRelatedByUpdatedBy->setUserRelatedByUpdatedBy(null);
        }

        return $this;
    }

    /**
     * Clears out the collPublicationsRelatedByCreatedBy collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPublicationsRelatedByCreatedBy()
     */
    public function clearPublicationsRelatedByCreatedBy()
    {
        $this->collPublicationsRelatedByCreatedBy = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPublicationsRelatedByCreatedBy collection loaded partially.
     */
    public function resetPartialPublicationsRelatedByCreatedBy($v = true)
    {
        $this->collPublicationsRelatedByCreatedByPartial = $v;
    }

    /**
     * Initializes the collPublicationsRelatedByCreatedBy collection.
     *
     * By default this just sets the collPublicationsRelatedByCreatedBy collection to an empty array (like clearcollPublicationsRelatedByCreatedBy());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPublicationsRelatedByCreatedBy($overrideExisting = true)
    {
        if (null !== $this->collPublicationsRelatedByCreatedBy && !$overrideExisting) {
            return;
        }

        $collectionClassName = PublicationTableMap::getTableMap()->getCollectionClassName();

        $this->collPublicationsRelatedByCreatedBy = new $collectionClassName;
        $this->collPublicationsRelatedByCreatedBy->setModel('\Propel\Models\Publication');
    }

    /**
     * Gets an array of ChildPublication objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPublication[] List of ChildPublication objects
     * @throws PropelException
     */
    public function getPublicationsRelatedByCreatedBy(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPublicationsRelatedByCreatedByPartial && !$this->isNew();
        if (null === $this->collPublicationsRelatedByCreatedBy || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPublicationsRelatedByCreatedBy) {
                // return empty collection
                $this->initPublicationsRelatedByCreatedBy();
            } else {
                $collPublicationsRelatedByCreatedBy = ChildPublicationQuery::create(null, $criteria)
                    ->filterByUserRelatedByCreatedBy($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPublicationsRelatedByCreatedByPartial && count($collPublicationsRelatedByCreatedBy)) {
                        $this->initPublicationsRelatedByCreatedBy(false);

                        foreach ($collPublicationsRelatedByCreatedBy as $obj) {
                            if (false == $this->collPublicationsRelatedByCreatedBy->contains($obj)) {
                                $this->collPublicationsRelatedByCreatedBy->append($obj);
                            }
                        }

                        $this->collPublicationsRelatedByCreatedByPartial = true;
                    }

                    return $collPublicationsRelatedByCreatedBy;
                }

                if ($partial && $this->collPublicationsRelatedByCreatedBy) {
                    foreach ($this->collPublicationsRelatedByCreatedBy as $obj) {
                        if ($obj->isNew()) {
                            $collPublicationsRelatedByCreatedBy[] = $obj;
                        }
                    }
                }

                $this->collPublicationsRelatedByCreatedBy = $collPublicationsRelatedByCreatedBy;
                $this->collPublicationsRelatedByCreatedByPartial = false;
            }
        }

        return $this->collPublicationsRelatedByCreatedBy;
    }

    /**
     * Sets a collection of ChildPublication objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $publicationsRelatedByCreatedBy A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setPublicationsRelatedByCreatedBy(Collection $publicationsRelatedByCreatedBy, ConnectionInterface $con = null)
    {
        /** @var ChildPublication[] $publicationsRelatedByCreatedByToDelete */
        $publicationsRelatedByCreatedByToDelete = $this->getPublicationsRelatedByCreatedBy(new Criteria(), $con)->diff($publicationsRelatedByCreatedBy);


        $this->publicationsRelatedByCreatedByScheduledForDeletion = $publicationsRelatedByCreatedByToDelete;

        foreach ($publicationsRelatedByCreatedByToDelete as $publicationRelatedByCreatedByRemoved) {
            $publicationRelatedByCreatedByRemoved->setUserRelatedByCreatedBy(null);
        }

        $this->collPublicationsRelatedByCreatedBy = null;
        foreach ($publicationsRelatedByCreatedBy as $publicationRelatedByCreatedBy) {
            $this->addPublicationRelatedByCreatedBy($publicationRelatedByCreatedBy);
        }

        $this->collPublicationsRelatedByCreatedBy = $publicationsRelatedByCreatedBy;
        $this->collPublicationsRelatedByCreatedByPartial = false;

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
    public function countPublicationsRelatedByCreatedBy(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPublicationsRelatedByCreatedByPartial && !$this->isNew();
        if (null === $this->collPublicationsRelatedByCreatedBy || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPublicationsRelatedByCreatedBy) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPublicationsRelatedByCreatedBy());
            }

            $query = ChildPublicationQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUserRelatedByCreatedBy($this)
                ->count($con);
        }

        return count($this->collPublicationsRelatedByCreatedBy);
    }

    /**
     * Method called to associate a ChildPublication object to this object
     * through the ChildPublication foreign key attribute.
     *
     * @param  ChildPublication $l ChildPublication
     * @return $this|\Propel\Models\User The current object (for fluent API support)
     */
    public function addPublicationRelatedByCreatedBy(ChildPublication $l)
    {
        if ($this->collPublicationsRelatedByCreatedBy === null) {
            $this->initPublicationsRelatedByCreatedBy();
            $this->collPublicationsRelatedByCreatedByPartial = true;
        }

        if (!$this->collPublicationsRelatedByCreatedBy->contains($l)) {
            $this->doAddPublicationRelatedByCreatedBy($l);

            if ($this->publicationsRelatedByCreatedByScheduledForDeletion and $this->publicationsRelatedByCreatedByScheduledForDeletion->contains($l)) {
                $this->publicationsRelatedByCreatedByScheduledForDeletion->remove($this->publicationsRelatedByCreatedByScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildPublication $publicationRelatedByCreatedBy The ChildPublication object to add.
     */
    protected function doAddPublicationRelatedByCreatedBy(ChildPublication $publicationRelatedByCreatedBy)
    {
        $this->collPublicationsRelatedByCreatedBy[]= $publicationRelatedByCreatedBy;
        $publicationRelatedByCreatedBy->setUserRelatedByCreatedBy($this);
    }

    /**
     * @param  ChildPublication $publicationRelatedByCreatedBy The ChildPublication object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removePublicationRelatedByCreatedBy(ChildPublication $publicationRelatedByCreatedBy)
    {
        if ($this->getPublicationsRelatedByCreatedBy()->contains($publicationRelatedByCreatedBy)) {
            $pos = $this->collPublicationsRelatedByCreatedBy->search($publicationRelatedByCreatedBy);
            $this->collPublicationsRelatedByCreatedBy->remove($pos);
            if (null === $this->publicationsRelatedByCreatedByScheduledForDeletion) {
                $this->publicationsRelatedByCreatedByScheduledForDeletion = clone $this->collPublicationsRelatedByCreatedBy;
                $this->publicationsRelatedByCreatedByScheduledForDeletion->clear();
            }
            $this->publicationsRelatedByCreatedByScheduledForDeletion[]= $publicationRelatedByCreatedBy;
            $publicationRelatedByCreatedBy->setUserRelatedByCreatedBy(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related PublicationsRelatedByCreatedBy from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPublication[] List of ChildPublication objects
     */
    public function getPublicationsRelatedByCreatedByJoinSection(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPublicationQuery::create(null, $criteria);
        $query->joinWith('Section', $joinBehavior);

        return $this->getPublicationsRelatedByCreatedBy($query, $con);
    }

    /**
     * Clears out the collPublicationsRelatedByUpdatedBy collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPublicationsRelatedByUpdatedBy()
     */
    public function clearPublicationsRelatedByUpdatedBy()
    {
        $this->collPublicationsRelatedByUpdatedBy = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPublicationsRelatedByUpdatedBy collection loaded partially.
     */
    public function resetPartialPublicationsRelatedByUpdatedBy($v = true)
    {
        $this->collPublicationsRelatedByUpdatedByPartial = $v;
    }

    /**
     * Initializes the collPublicationsRelatedByUpdatedBy collection.
     *
     * By default this just sets the collPublicationsRelatedByUpdatedBy collection to an empty array (like clearcollPublicationsRelatedByUpdatedBy());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPublicationsRelatedByUpdatedBy($overrideExisting = true)
    {
        if (null !== $this->collPublicationsRelatedByUpdatedBy && !$overrideExisting) {
            return;
        }

        $collectionClassName = PublicationTableMap::getTableMap()->getCollectionClassName();

        $this->collPublicationsRelatedByUpdatedBy = new $collectionClassName;
        $this->collPublicationsRelatedByUpdatedBy->setModel('\Propel\Models\Publication');
    }

    /**
     * Gets an array of ChildPublication objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPublication[] List of ChildPublication objects
     * @throws PropelException
     */
    public function getPublicationsRelatedByUpdatedBy(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPublicationsRelatedByUpdatedByPartial && !$this->isNew();
        if (null === $this->collPublicationsRelatedByUpdatedBy || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPublicationsRelatedByUpdatedBy) {
                // return empty collection
                $this->initPublicationsRelatedByUpdatedBy();
            } else {
                $collPublicationsRelatedByUpdatedBy = ChildPublicationQuery::create(null, $criteria)
                    ->filterByUserRelatedByUpdatedBy($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPublicationsRelatedByUpdatedByPartial && count($collPublicationsRelatedByUpdatedBy)) {
                        $this->initPublicationsRelatedByUpdatedBy(false);

                        foreach ($collPublicationsRelatedByUpdatedBy as $obj) {
                            if (false == $this->collPublicationsRelatedByUpdatedBy->contains($obj)) {
                                $this->collPublicationsRelatedByUpdatedBy->append($obj);
                            }
                        }

                        $this->collPublicationsRelatedByUpdatedByPartial = true;
                    }

                    return $collPublicationsRelatedByUpdatedBy;
                }

                if ($partial && $this->collPublicationsRelatedByUpdatedBy) {
                    foreach ($this->collPublicationsRelatedByUpdatedBy as $obj) {
                        if ($obj->isNew()) {
                            $collPublicationsRelatedByUpdatedBy[] = $obj;
                        }
                    }
                }

                $this->collPublicationsRelatedByUpdatedBy = $collPublicationsRelatedByUpdatedBy;
                $this->collPublicationsRelatedByUpdatedByPartial = false;
            }
        }

        return $this->collPublicationsRelatedByUpdatedBy;
    }

    /**
     * Sets a collection of ChildPublication objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $publicationsRelatedByUpdatedBy A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setPublicationsRelatedByUpdatedBy(Collection $publicationsRelatedByUpdatedBy, ConnectionInterface $con = null)
    {
        /** @var ChildPublication[] $publicationsRelatedByUpdatedByToDelete */
        $publicationsRelatedByUpdatedByToDelete = $this->getPublicationsRelatedByUpdatedBy(new Criteria(), $con)->diff($publicationsRelatedByUpdatedBy);


        $this->publicationsRelatedByUpdatedByScheduledForDeletion = $publicationsRelatedByUpdatedByToDelete;

        foreach ($publicationsRelatedByUpdatedByToDelete as $publicationRelatedByUpdatedByRemoved) {
            $publicationRelatedByUpdatedByRemoved->setUserRelatedByUpdatedBy(null);
        }

        $this->collPublicationsRelatedByUpdatedBy = null;
        foreach ($publicationsRelatedByUpdatedBy as $publicationRelatedByUpdatedBy) {
            $this->addPublicationRelatedByUpdatedBy($publicationRelatedByUpdatedBy);
        }

        $this->collPublicationsRelatedByUpdatedBy = $publicationsRelatedByUpdatedBy;
        $this->collPublicationsRelatedByUpdatedByPartial = false;

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
    public function countPublicationsRelatedByUpdatedBy(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPublicationsRelatedByUpdatedByPartial && !$this->isNew();
        if (null === $this->collPublicationsRelatedByUpdatedBy || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPublicationsRelatedByUpdatedBy) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPublicationsRelatedByUpdatedBy());
            }

            $query = ChildPublicationQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUserRelatedByUpdatedBy($this)
                ->count($con);
        }

        return count($this->collPublicationsRelatedByUpdatedBy);
    }

    /**
     * Method called to associate a ChildPublication object to this object
     * through the ChildPublication foreign key attribute.
     *
     * @param  ChildPublication $l ChildPublication
     * @return $this|\Propel\Models\User The current object (for fluent API support)
     */
    public function addPublicationRelatedByUpdatedBy(ChildPublication $l)
    {
        if ($this->collPublicationsRelatedByUpdatedBy === null) {
            $this->initPublicationsRelatedByUpdatedBy();
            $this->collPublicationsRelatedByUpdatedByPartial = true;
        }

        if (!$this->collPublicationsRelatedByUpdatedBy->contains($l)) {
            $this->doAddPublicationRelatedByUpdatedBy($l);

            if ($this->publicationsRelatedByUpdatedByScheduledForDeletion and $this->publicationsRelatedByUpdatedByScheduledForDeletion->contains($l)) {
                $this->publicationsRelatedByUpdatedByScheduledForDeletion->remove($this->publicationsRelatedByUpdatedByScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildPublication $publicationRelatedByUpdatedBy The ChildPublication object to add.
     */
    protected function doAddPublicationRelatedByUpdatedBy(ChildPublication $publicationRelatedByUpdatedBy)
    {
        $this->collPublicationsRelatedByUpdatedBy[]= $publicationRelatedByUpdatedBy;
        $publicationRelatedByUpdatedBy->setUserRelatedByUpdatedBy($this);
    }

    /**
     * @param  ChildPublication $publicationRelatedByUpdatedBy The ChildPublication object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removePublicationRelatedByUpdatedBy(ChildPublication $publicationRelatedByUpdatedBy)
    {
        if ($this->getPublicationsRelatedByUpdatedBy()->contains($publicationRelatedByUpdatedBy)) {
            $pos = $this->collPublicationsRelatedByUpdatedBy->search($publicationRelatedByUpdatedBy);
            $this->collPublicationsRelatedByUpdatedBy->remove($pos);
            if (null === $this->publicationsRelatedByUpdatedByScheduledForDeletion) {
                $this->publicationsRelatedByUpdatedByScheduledForDeletion = clone $this->collPublicationsRelatedByUpdatedBy;
                $this->publicationsRelatedByUpdatedByScheduledForDeletion->clear();
            }
            $this->publicationsRelatedByUpdatedByScheduledForDeletion[]= $publicationRelatedByUpdatedBy;
            $publicationRelatedByUpdatedBy->setUserRelatedByUpdatedBy(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related PublicationsRelatedByUpdatedBy from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPublication[] List of ChildPublication objects
     */
    public function getPublicationsRelatedByUpdatedByJoinSection(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPublicationQuery::create(null, $criteria);
        $query->joinWith('Section', $joinBehavior);

        return $this->getPublicationsRelatedByUpdatedBy($query, $con);
    }

    /**
     * Clears out the collPublicationPhotosRelatedByCreatedBy collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPublicationPhotosRelatedByCreatedBy()
     */
    public function clearPublicationPhotosRelatedByCreatedBy()
    {
        $this->collPublicationPhotosRelatedByCreatedBy = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPublicationPhotosRelatedByCreatedBy collection loaded partially.
     */
    public function resetPartialPublicationPhotosRelatedByCreatedBy($v = true)
    {
        $this->collPublicationPhotosRelatedByCreatedByPartial = $v;
    }

    /**
     * Initializes the collPublicationPhotosRelatedByCreatedBy collection.
     *
     * By default this just sets the collPublicationPhotosRelatedByCreatedBy collection to an empty array (like clearcollPublicationPhotosRelatedByCreatedBy());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPublicationPhotosRelatedByCreatedBy($overrideExisting = true)
    {
        if (null !== $this->collPublicationPhotosRelatedByCreatedBy && !$overrideExisting) {
            return;
        }

        $collectionClassName = PublicationPhotoTableMap::getTableMap()->getCollectionClassName();

        $this->collPublicationPhotosRelatedByCreatedBy = new $collectionClassName;
        $this->collPublicationPhotosRelatedByCreatedBy->setModel('\Propel\Models\PublicationPhoto');
    }

    /**
     * Gets an array of ChildPublicationPhoto objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPublicationPhoto[] List of ChildPublicationPhoto objects
     * @throws PropelException
     */
    public function getPublicationPhotosRelatedByCreatedBy(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPublicationPhotosRelatedByCreatedByPartial && !$this->isNew();
        if (null === $this->collPublicationPhotosRelatedByCreatedBy || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPublicationPhotosRelatedByCreatedBy) {
                // return empty collection
                $this->initPublicationPhotosRelatedByCreatedBy();
            } else {
                $collPublicationPhotosRelatedByCreatedBy = ChildPublicationPhotoQuery::create(null, $criteria)
                    ->filterByUserRelatedByCreatedBy($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPublicationPhotosRelatedByCreatedByPartial && count($collPublicationPhotosRelatedByCreatedBy)) {
                        $this->initPublicationPhotosRelatedByCreatedBy(false);

                        foreach ($collPublicationPhotosRelatedByCreatedBy as $obj) {
                            if (false == $this->collPublicationPhotosRelatedByCreatedBy->contains($obj)) {
                                $this->collPublicationPhotosRelatedByCreatedBy->append($obj);
                            }
                        }

                        $this->collPublicationPhotosRelatedByCreatedByPartial = true;
                    }

                    return $collPublicationPhotosRelatedByCreatedBy;
                }

                if ($partial && $this->collPublicationPhotosRelatedByCreatedBy) {
                    foreach ($this->collPublicationPhotosRelatedByCreatedBy as $obj) {
                        if ($obj->isNew()) {
                            $collPublicationPhotosRelatedByCreatedBy[] = $obj;
                        }
                    }
                }

                $this->collPublicationPhotosRelatedByCreatedBy = $collPublicationPhotosRelatedByCreatedBy;
                $this->collPublicationPhotosRelatedByCreatedByPartial = false;
            }
        }

        return $this->collPublicationPhotosRelatedByCreatedBy;
    }

    /**
     * Sets a collection of ChildPublicationPhoto objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $publicationPhotosRelatedByCreatedBy A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setPublicationPhotosRelatedByCreatedBy(Collection $publicationPhotosRelatedByCreatedBy, ConnectionInterface $con = null)
    {
        /** @var ChildPublicationPhoto[] $publicationPhotosRelatedByCreatedByToDelete */
        $publicationPhotosRelatedByCreatedByToDelete = $this->getPublicationPhotosRelatedByCreatedBy(new Criteria(), $con)->diff($publicationPhotosRelatedByCreatedBy);


        $this->publicationPhotosRelatedByCreatedByScheduledForDeletion = $publicationPhotosRelatedByCreatedByToDelete;

        foreach ($publicationPhotosRelatedByCreatedByToDelete as $publicationPhotoRelatedByCreatedByRemoved) {
            $publicationPhotoRelatedByCreatedByRemoved->setUserRelatedByCreatedBy(null);
        }

        $this->collPublicationPhotosRelatedByCreatedBy = null;
        foreach ($publicationPhotosRelatedByCreatedBy as $publicationPhotoRelatedByCreatedBy) {
            $this->addPublicationPhotoRelatedByCreatedBy($publicationPhotoRelatedByCreatedBy);
        }

        $this->collPublicationPhotosRelatedByCreatedBy = $publicationPhotosRelatedByCreatedBy;
        $this->collPublicationPhotosRelatedByCreatedByPartial = false;

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
    public function countPublicationPhotosRelatedByCreatedBy(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPublicationPhotosRelatedByCreatedByPartial && !$this->isNew();
        if (null === $this->collPublicationPhotosRelatedByCreatedBy || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPublicationPhotosRelatedByCreatedBy) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPublicationPhotosRelatedByCreatedBy());
            }

            $query = ChildPublicationPhotoQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUserRelatedByCreatedBy($this)
                ->count($con);
        }

        return count($this->collPublicationPhotosRelatedByCreatedBy);
    }

    /**
     * Method called to associate a ChildPublicationPhoto object to this object
     * through the ChildPublicationPhoto foreign key attribute.
     *
     * @param  ChildPublicationPhoto $l ChildPublicationPhoto
     * @return $this|\Propel\Models\User The current object (for fluent API support)
     */
    public function addPublicationPhotoRelatedByCreatedBy(ChildPublicationPhoto $l)
    {
        if ($this->collPublicationPhotosRelatedByCreatedBy === null) {
            $this->initPublicationPhotosRelatedByCreatedBy();
            $this->collPublicationPhotosRelatedByCreatedByPartial = true;
        }

        if (!$this->collPublicationPhotosRelatedByCreatedBy->contains($l)) {
            $this->doAddPublicationPhotoRelatedByCreatedBy($l);

            if ($this->publicationPhotosRelatedByCreatedByScheduledForDeletion and $this->publicationPhotosRelatedByCreatedByScheduledForDeletion->contains($l)) {
                $this->publicationPhotosRelatedByCreatedByScheduledForDeletion->remove($this->publicationPhotosRelatedByCreatedByScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildPublicationPhoto $publicationPhotoRelatedByCreatedBy The ChildPublicationPhoto object to add.
     */
    protected function doAddPublicationPhotoRelatedByCreatedBy(ChildPublicationPhoto $publicationPhotoRelatedByCreatedBy)
    {
        $this->collPublicationPhotosRelatedByCreatedBy[]= $publicationPhotoRelatedByCreatedBy;
        $publicationPhotoRelatedByCreatedBy->setUserRelatedByCreatedBy($this);
    }

    /**
     * @param  ChildPublicationPhoto $publicationPhotoRelatedByCreatedBy The ChildPublicationPhoto object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removePublicationPhotoRelatedByCreatedBy(ChildPublicationPhoto $publicationPhotoRelatedByCreatedBy)
    {
        if ($this->getPublicationPhotosRelatedByCreatedBy()->contains($publicationPhotoRelatedByCreatedBy)) {
            $pos = $this->collPublicationPhotosRelatedByCreatedBy->search($publicationPhotoRelatedByCreatedBy);
            $this->collPublicationPhotosRelatedByCreatedBy->remove($pos);
            if (null === $this->publicationPhotosRelatedByCreatedByScheduledForDeletion) {
                $this->publicationPhotosRelatedByCreatedByScheduledForDeletion = clone $this->collPublicationPhotosRelatedByCreatedBy;
                $this->publicationPhotosRelatedByCreatedByScheduledForDeletion->clear();
            }
            $this->publicationPhotosRelatedByCreatedByScheduledForDeletion[]= $publicationPhotoRelatedByCreatedBy;
            $publicationPhotoRelatedByCreatedBy->setUserRelatedByCreatedBy(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related PublicationPhotosRelatedByCreatedBy from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPublicationPhoto[] List of ChildPublicationPhoto objects
     */
    public function getPublicationPhotosRelatedByCreatedByJoinPublication(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPublicationPhotoQuery::create(null, $criteria);
        $query->joinWith('Publication', $joinBehavior);

        return $this->getPublicationPhotosRelatedByCreatedBy($query, $con);
    }

    /**
     * Clears out the collPublicationPhotosRelatedByUpdatedBy collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPublicationPhotosRelatedByUpdatedBy()
     */
    public function clearPublicationPhotosRelatedByUpdatedBy()
    {
        $this->collPublicationPhotosRelatedByUpdatedBy = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPublicationPhotosRelatedByUpdatedBy collection loaded partially.
     */
    public function resetPartialPublicationPhotosRelatedByUpdatedBy($v = true)
    {
        $this->collPublicationPhotosRelatedByUpdatedByPartial = $v;
    }

    /**
     * Initializes the collPublicationPhotosRelatedByUpdatedBy collection.
     *
     * By default this just sets the collPublicationPhotosRelatedByUpdatedBy collection to an empty array (like clearcollPublicationPhotosRelatedByUpdatedBy());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPublicationPhotosRelatedByUpdatedBy($overrideExisting = true)
    {
        if (null !== $this->collPublicationPhotosRelatedByUpdatedBy && !$overrideExisting) {
            return;
        }

        $collectionClassName = PublicationPhotoTableMap::getTableMap()->getCollectionClassName();

        $this->collPublicationPhotosRelatedByUpdatedBy = new $collectionClassName;
        $this->collPublicationPhotosRelatedByUpdatedBy->setModel('\Propel\Models\PublicationPhoto');
    }

    /**
     * Gets an array of ChildPublicationPhoto objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPublicationPhoto[] List of ChildPublicationPhoto objects
     * @throws PropelException
     */
    public function getPublicationPhotosRelatedByUpdatedBy(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPublicationPhotosRelatedByUpdatedByPartial && !$this->isNew();
        if (null === $this->collPublicationPhotosRelatedByUpdatedBy || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPublicationPhotosRelatedByUpdatedBy) {
                // return empty collection
                $this->initPublicationPhotosRelatedByUpdatedBy();
            } else {
                $collPublicationPhotosRelatedByUpdatedBy = ChildPublicationPhotoQuery::create(null, $criteria)
                    ->filterByUserRelatedByUpdatedBy($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPublicationPhotosRelatedByUpdatedByPartial && count($collPublicationPhotosRelatedByUpdatedBy)) {
                        $this->initPublicationPhotosRelatedByUpdatedBy(false);

                        foreach ($collPublicationPhotosRelatedByUpdatedBy as $obj) {
                            if (false == $this->collPublicationPhotosRelatedByUpdatedBy->contains($obj)) {
                                $this->collPublicationPhotosRelatedByUpdatedBy->append($obj);
                            }
                        }

                        $this->collPublicationPhotosRelatedByUpdatedByPartial = true;
                    }

                    return $collPublicationPhotosRelatedByUpdatedBy;
                }

                if ($partial && $this->collPublicationPhotosRelatedByUpdatedBy) {
                    foreach ($this->collPublicationPhotosRelatedByUpdatedBy as $obj) {
                        if ($obj->isNew()) {
                            $collPublicationPhotosRelatedByUpdatedBy[] = $obj;
                        }
                    }
                }

                $this->collPublicationPhotosRelatedByUpdatedBy = $collPublicationPhotosRelatedByUpdatedBy;
                $this->collPublicationPhotosRelatedByUpdatedByPartial = false;
            }
        }

        return $this->collPublicationPhotosRelatedByUpdatedBy;
    }

    /**
     * Sets a collection of ChildPublicationPhoto objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $publicationPhotosRelatedByUpdatedBy A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setPublicationPhotosRelatedByUpdatedBy(Collection $publicationPhotosRelatedByUpdatedBy, ConnectionInterface $con = null)
    {
        /** @var ChildPublicationPhoto[] $publicationPhotosRelatedByUpdatedByToDelete */
        $publicationPhotosRelatedByUpdatedByToDelete = $this->getPublicationPhotosRelatedByUpdatedBy(new Criteria(), $con)->diff($publicationPhotosRelatedByUpdatedBy);


        $this->publicationPhotosRelatedByUpdatedByScheduledForDeletion = $publicationPhotosRelatedByUpdatedByToDelete;

        foreach ($publicationPhotosRelatedByUpdatedByToDelete as $publicationPhotoRelatedByUpdatedByRemoved) {
            $publicationPhotoRelatedByUpdatedByRemoved->setUserRelatedByUpdatedBy(null);
        }

        $this->collPublicationPhotosRelatedByUpdatedBy = null;
        foreach ($publicationPhotosRelatedByUpdatedBy as $publicationPhotoRelatedByUpdatedBy) {
            $this->addPublicationPhotoRelatedByUpdatedBy($publicationPhotoRelatedByUpdatedBy);
        }

        $this->collPublicationPhotosRelatedByUpdatedBy = $publicationPhotosRelatedByUpdatedBy;
        $this->collPublicationPhotosRelatedByUpdatedByPartial = false;

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
    public function countPublicationPhotosRelatedByUpdatedBy(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPublicationPhotosRelatedByUpdatedByPartial && !$this->isNew();
        if (null === $this->collPublicationPhotosRelatedByUpdatedBy || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPublicationPhotosRelatedByUpdatedBy) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPublicationPhotosRelatedByUpdatedBy());
            }

            $query = ChildPublicationPhotoQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUserRelatedByUpdatedBy($this)
                ->count($con);
        }

        return count($this->collPublicationPhotosRelatedByUpdatedBy);
    }

    /**
     * Method called to associate a ChildPublicationPhoto object to this object
     * through the ChildPublicationPhoto foreign key attribute.
     *
     * @param  ChildPublicationPhoto $l ChildPublicationPhoto
     * @return $this|\Propel\Models\User The current object (for fluent API support)
     */
    public function addPublicationPhotoRelatedByUpdatedBy(ChildPublicationPhoto $l)
    {
        if ($this->collPublicationPhotosRelatedByUpdatedBy === null) {
            $this->initPublicationPhotosRelatedByUpdatedBy();
            $this->collPublicationPhotosRelatedByUpdatedByPartial = true;
        }

        if (!$this->collPublicationPhotosRelatedByUpdatedBy->contains($l)) {
            $this->doAddPublicationPhotoRelatedByUpdatedBy($l);

            if ($this->publicationPhotosRelatedByUpdatedByScheduledForDeletion and $this->publicationPhotosRelatedByUpdatedByScheduledForDeletion->contains($l)) {
                $this->publicationPhotosRelatedByUpdatedByScheduledForDeletion->remove($this->publicationPhotosRelatedByUpdatedByScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildPublicationPhoto $publicationPhotoRelatedByUpdatedBy The ChildPublicationPhoto object to add.
     */
    protected function doAddPublicationPhotoRelatedByUpdatedBy(ChildPublicationPhoto $publicationPhotoRelatedByUpdatedBy)
    {
        $this->collPublicationPhotosRelatedByUpdatedBy[]= $publicationPhotoRelatedByUpdatedBy;
        $publicationPhotoRelatedByUpdatedBy->setUserRelatedByUpdatedBy($this);
    }

    /**
     * @param  ChildPublicationPhoto $publicationPhotoRelatedByUpdatedBy The ChildPublicationPhoto object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removePublicationPhotoRelatedByUpdatedBy(ChildPublicationPhoto $publicationPhotoRelatedByUpdatedBy)
    {
        if ($this->getPublicationPhotosRelatedByUpdatedBy()->contains($publicationPhotoRelatedByUpdatedBy)) {
            $pos = $this->collPublicationPhotosRelatedByUpdatedBy->search($publicationPhotoRelatedByUpdatedBy);
            $this->collPublicationPhotosRelatedByUpdatedBy->remove($pos);
            if (null === $this->publicationPhotosRelatedByUpdatedByScheduledForDeletion) {
                $this->publicationPhotosRelatedByUpdatedByScheduledForDeletion = clone $this->collPublicationPhotosRelatedByUpdatedBy;
                $this->publicationPhotosRelatedByUpdatedByScheduledForDeletion->clear();
            }
            $this->publicationPhotosRelatedByUpdatedByScheduledForDeletion[]= $publicationPhotoRelatedByUpdatedBy;
            $publicationPhotoRelatedByUpdatedBy->setUserRelatedByUpdatedBy(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related PublicationPhotosRelatedByUpdatedBy from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPublicationPhoto[] List of ChildPublicationPhoto objects
     */
    public function getPublicationPhotosRelatedByUpdatedByJoinPublication(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPublicationPhotoQuery::create(null, $criteria);
        $query->joinWith('Publication', $joinBehavior);

        return $this->getPublicationPhotosRelatedByUpdatedBy($query, $con);
    }

    /**
     * Clears out the collRadiosRelatedByCreatedBy collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRadiosRelatedByCreatedBy()
     */
    public function clearRadiosRelatedByCreatedBy()
    {
        $this->collRadiosRelatedByCreatedBy = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collRadiosRelatedByCreatedBy collection loaded partially.
     */
    public function resetPartialRadiosRelatedByCreatedBy($v = true)
    {
        $this->collRadiosRelatedByCreatedByPartial = $v;
    }

    /**
     * Initializes the collRadiosRelatedByCreatedBy collection.
     *
     * By default this just sets the collRadiosRelatedByCreatedBy collection to an empty array (like clearcollRadiosRelatedByCreatedBy());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRadiosRelatedByCreatedBy($overrideExisting = true)
    {
        if (null !== $this->collRadiosRelatedByCreatedBy && !$overrideExisting) {
            return;
        }

        $collectionClassName = RadioTableMap::getTableMap()->getCollectionClassName();

        $this->collRadiosRelatedByCreatedBy = new $collectionClassName;
        $this->collRadiosRelatedByCreatedBy->setModel('\Propel\Models\Radio');
    }

    /**
     * Gets an array of ChildRadio objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildRadio[] List of ChildRadio objects
     * @throws PropelException
     */
    public function getRadiosRelatedByCreatedBy(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRadiosRelatedByCreatedByPartial && !$this->isNew();
        if (null === $this->collRadiosRelatedByCreatedBy || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collRadiosRelatedByCreatedBy) {
                // return empty collection
                $this->initRadiosRelatedByCreatedBy();
            } else {
                $collRadiosRelatedByCreatedBy = ChildRadioQuery::create(null, $criteria)
                    ->filterByUserRelatedByCreatedBy($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collRadiosRelatedByCreatedByPartial && count($collRadiosRelatedByCreatedBy)) {
                        $this->initRadiosRelatedByCreatedBy(false);

                        foreach ($collRadiosRelatedByCreatedBy as $obj) {
                            if (false == $this->collRadiosRelatedByCreatedBy->contains($obj)) {
                                $this->collRadiosRelatedByCreatedBy->append($obj);
                            }
                        }

                        $this->collRadiosRelatedByCreatedByPartial = true;
                    }

                    return $collRadiosRelatedByCreatedBy;
                }

                if ($partial && $this->collRadiosRelatedByCreatedBy) {
                    foreach ($this->collRadiosRelatedByCreatedBy as $obj) {
                        if ($obj->isNew()) {
                            $collRadiosRelatedByCreatedBy[] = $obj;
                        }
                    }
                }

                $this->collRadiosRelatedByCreatedBy = $collRadiosRelatedByCreatedBy;
                $this->collRadiosRelatedByCreatedByPartial = false;
            }
        }

        return $this->collRadiosRelatedByCreatedBy;
    }

    /**
     * Sets a collection of ChildRadio objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $radiosRelatedByCreatedBy A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setRadiosRelatedByCreatedBy(Collection $radiosRelatedByCreatedBy, ConnectionInterface $con = null)
    {
        /** @var ChildRadio[] $radiosRelatedByCreatedByToDelete */
        $radiosRelatedByCreatedByToDelete = $this->getRadiosRelatedByCreatedBy(new Criteria(), $con)->diff($radiosRelatedByCreatedBy);


        $this->radiosRelatedByCreatedByScheduledForDeletion = $radiosRelatedByCreatedByToDelete;

        foreach ($radiosRelatedByCreatedByToDelete as $radioRelatedByCreatedByRemoved) {
            $radioRelatedByCreatedByRemoved->setUserRelatedByCreatedBy(null);
        }

        $this->collRadiosRelatedByCreatedBy = null;
        foreach ($radiosRelatedByCreatedBy as $radioRelatedByCreatedBy) {
            $this->addRadioRelatedByCreatedBy($radioRelatedByCreatedBy);
        }

        $this->collRadiosRelatedByCreatedBy = $radiosRelatedByCreatedBy;
        $this->collRadiosRelatedByCreatedByPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Radio objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Radio objects.
     * @throws PropelException
     */
    public function countRadiosRelatedByCreatedBy(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRadiosRelatedByCreatedByPartial && !$this->isNew();
        if (null === $this->collRadiosRelatedByCreatedBy || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRadiosRelatedByCreatedBy) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRadiosRelatedByCreatedBy());
            }

            $query = ChildRadioQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUserRelatedByCreatedBy($this)
                ->count($con);
        }

        return count($this->collRadiosRelatedByCreatedBy);
    }

    /**
     * Method called to associate a ChildRadio object to this object
     * through the ChildRadio foreign key attribute.
     *
     * @param  ChildRadio $l ChildRadio
     * @return $this|\Propel\Models\User The current object (for fluent API support)
     */
    public function addRadioRelatedByCreatedBy(ChildRadio $l)
    {
        if ($this->collRadiosRelatedByCreatedBy === null) {
            $this->initRadiosRelatedByCreatedBy();
            $this->collRadiosRelatedByCreatedByPartial = true;
        }

        if (!$this->collRadiosRelatedByCreatedBy->contains($l)) {
            $this->doAddRadioRelatedByCreatedBy($l);

            if ($this->radiosRelatedByCreatedByScheduledForDeletion and $this->radiosRelatedByCreatedByScheduledForDeletion->contains($l)) {
                $this->radiosRelatedByCreatedByScheduledForDeletion->remove($this->radiosRelatedByCreatedByScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildRadio $radioRelatedByCreatedBy The ChildRadio object to add.
     */
    protected function doAddRadioRelatedByCreatedBy(ChildRadio $radioRelatedByCreatedBy)
    {
        $this->collRadiosRelatedByCreatedBy[]= $radioRelatedByCreatedBy;
        $radioRelatedByCreatedBy->setUserRelatedByCreatedBy($this);
    }

    /**
     * @param  ChildRadio $radioRelatedByCreatedBy The ChildRadio object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removeRadioRelatedByCreatedBy(ChildRadio $radioRelatedByCreatedBy)
    {
        if ($this->getRadiosRelatedByCreatedBy()->contains($radioRelatedByCreatedBy)) {
            $pos = $this->collRadiosRelatedByCreatedBy->search($radioRelatedByCreatedBy);
            $this->collRadiosRelatedByCreatedBy->remove($pos);
            if (null === $this->radiosRelatedByCreatedByScheduledForDeletion) {
                $this->radiosRelatedByCreatedByScheduledForDeletion = clone $this->collRadiosRelatedByCreatedBy;
                $this->radiosRelatedByCreatedByScheduledForDeletion->clear();
            }
            $this->radiosRelatedByCreatedByScheduledForDeletion[]= $radioRelatedByCreatedBy;
            $radioRelatedByCreatedBy->setUserRelatedByCreatedBy(null);
        }

        return $this;
    }

    /**
     * Clears out the collRadiosRelatedByUpdatedBy collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRadiosRelatedByUpdatedBy()
     */
    public function clearRadiosRelatedByUpdatedBy()
    {
        $this->collRadiosRelatedByUpdatedBy = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collRadiosRelatedByUpdatedBy collection loaded partially.
     */
    public function resetPartialRadiosRelatedByUpdatedBy($v = true)
    {
        $this->collRadiosRelatedByUpdatedByPartial = $v;
    }

    /**
     * Initializes the collRadiosRelatedByUpdatedBy collection.
     *
     * By default this just sets the collRadiosRelatedByUpdatedBy collection to an empty array (like clearcollRadiosRelatedByUpdatedBy());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRadiosRelatedByUpdatedBy($overrideExisting = true)
    {
        if (null !== $this->collRadiosRelatedByUpdatedBy && !$overrideExisting) {
            return;
        }

        $collectionClassName = RadioTableMap::getTableMap()->getCollectionClassName();

        $this->collRadiosRelatedByUpdatedBy = new $collectionClassName;
        $this->collRadiosRelatedByUpdatedBy->setModel('\Propel\Models\Radio');
    }

    /**
     * Gets an array of ChildRadio objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildRadio[] List of ChildRadio objects
     * @throws PropelException
     */
    public function getRadiosRelatedByUpdatedBy(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRadiosRelatedByUpdatedByPartial && !$this->isNew();
        if (null === $this->collRadiosRelatedByUpdatedBy || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collRadiosRelatedByUpdatedBy) {
                // return empty collection
                $this->initRadiosRelatedByUpdatedBy();
            } else {
                $collRadiosRelatedByUpdatedBy = ChildRadioQuery::create(null, $criteria)
                    ->filterByUserRelatedByUpdatedBy($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collRadiosRelatedByUpdatedByPartial && count($collRadiosRelatedByUpdatedBy)) {
                        $this->initRadiosRelatedByUpdatedBy(false);

                        foreach ($collRadiosRelatedByUpdatedBy as $obj) {
                            if (false == $this->collRadiosRelatedByUpdatedBy->contains($obj)) {
                                $this->collRadiosRelatedByUpdatedBy->append($obj);
                            }
                        }

                        $this->collRadiosRelatedByUpdatedByPartial = true;
                    }

                    return $collRadiosRelatedByUpdatedBy;
                }

                if ($partial && $this->collRadiosRelatedByUpdatedBy) {
                    foreach ($this->collRadiosRelatedByUpdatedBy as $obj) {
                        if ($obj->isNew()) {
                            $collRadiosRelatedByUpdatedBy[] = $obj;
                        }
                    }
                }

                $this->collRadiosRelatedByUpdatedBy = $collRadiosRelatedByUpdatedBy;
                $this->collRadiosRelatedByUpdatedByPartial = false;
            }
        }

        return $this->collRadiosRelatedByUpdatedBy;
    }

    /**
     * Sets a collection of ChildRadio objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $radiosRelatedByUpdatedBy A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setRadiosRelatedByUpdatedBy(Collection $radiosRelatedByUpdatedBy, ConnectionInterface $con = null)
    {
        /** @var ChildRadio[] $radiosRelatedByUpdatedByToDelete */
        $radiosRelatedByUpdatedByToDelete = $this->getRadiosRelatedByUpdatedBy(new Criteria(), $con)->diff($radiosRelatedByUpdatedBy);


        $this->radiosRelatedByUpdatedByScheduledForDeletion = $radiosRelatedByUpdatedByToDelete;

        foreach ($radiosRelatedByUpdatedByToDelete as $radioRelatedByUpdatedByRemoved) {
            $radioRelatedByUpdatedByRemoved->setUserRelatedByUpdatedBy(null);
        }

        $this->collRadiosRelatedByUpdatedBy = null;
        foreach ($radiosRelatedByUpdatedBy as $radioRelatedByUpdatedBy) {
            $this->addRadioRelatedByUpdatedBy($radioRelatedByUpdatedBy);
        }

        $this->collRadiosRelatedByUpdatedBy = $radiosRelatedByUpdatedBy;
        $this->collRadiosRelatedByUpdatedByPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Radio objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Radio objects.
     * @throws PropelException
     */
    public function countRadiosRelatedByUpdatedBy(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRadiosRelatedByUpdatedByPartial && !$this->isNew();
        if (null === $this->collRadiosRelatedByUpdatedBy || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRadiosRelatedByUpdatedBy) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRadiosRelatedByUpdatedBy());
            }

            $query = ChildRadioQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUserRelatedByUpdatedBy($this)
                ->count($con);
        }

        return count($this->collRadiosRelatedByUpdatedBy);
    }

    /**
     * Method called to associate a ChildRadio object to this object
     * through the ChildRadio foreign key attribute.
     *
     * @param  ChildRadio $l ChildRadio
     * @return $this|\Propel\Models\User The current object (for fluent API support)
     */
    public function addRadioRelatedByUpdatedBy(ChildRadio $l)
    {
        if ($this->collRadiosRelatedByUpdatedBy === null) {
            $this->initRadiosRelatedByUpdatedBy();
            $this->collRadiosRelatedByUpdatedByPartial = true;
        }

        if (!$this->collRadiosRelatedByUpdatedBy->contains($l)) {
            $this->doAddRadioRelatedByUpdatedBy($l);

            if ($this->radiosRelatedByUpdatedByScheduledForDeletion and $this->radiosRelatedByUpdatedByScheduledForDeletion->contains($l)) {
                $this->radiosRelatedByUpdatedByScheduledForDeletion->remove($this->radiosRelatedByUpdatedByScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildRadio $radioRelatedByUpdatedBy The ChildRadio object to add.
     */
    protected function doAddRadioRelatedByUpdatedBy(ChildRadio $radioRelatedByUpdatedBy)
    {
        $this->collRadiosRelatedByUpdatedBy[]= $radioRelatedByUpdatedBy;
        $radioRelatedByUpdatedBy->setUserRelatedByUpdatedBy($this);
    }

    /**
     * @param  ChildRadio $radioRelatedByUpdatedBy The ChildRadio object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removeRadioRelatedByUpdatedBy(ChildRadio $radioRelatedByUpdatedBy)
    {
        if ($this->getRadiosRelatedByUpdatedBy()->contains($radioRelatedByUpdatedBy)) {
            $pos = $this->collRadiosRelatedByUpdatedBy->search($radioRelatedByUpdatedBy);
            $this->collRadiosRelatedByUpdatedBy->remove($pos);
            if (null === $this->radiosRelatedByUpdatedByScheduledForDeletion) {
                $this->radiosRelatedByUpdatedByScheduledForDeletion = clone $this->collRadiosRelatedByUpdatedBy;
                $this->radiosRelatedByUpdatedByScheduledForDeletion->clear();
            }
            $this->radiosRelatedByUpdatedByScheduledForDeletion[]= $radioRelatedByUpdatedBy;
            $radioRelatedByUpdatedBy->setUserRelatedByUpdatedBy(null);
        }

        return $this;
    }

    /**
     * Clears out the collSnippetsRelatedByCreatedBy collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSnippetsRelatedByCreatedBy()
     */
    public function clearSnippetsRelatedByCreatedBy()
    {
        $this->collSnippetsRelatedByCreatedBy = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collSnippetsRelatedByCreatedBy collection loaded partially.
     */
    public function resetPartialSnippetsRelatedByCreatedBy($v = true)
    {
        $this->collSnippetsRelatedByCreatedByPartial = $v;
    }

    /**
     * Initializes the collSnippetsRelatedByCreatedBy collection.
     *
     * By default this just sets the collSnippetsRelatedByCreatedBy collection to an empty array (like clearcollSnippetsRelatedByCreatedBy());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSnippetsRelatedByCreatedBy($overrideExisting = true)
    {
        if (null !== $this->collSnippetsRelatedByCreatedBy && !$overrideExisting) {
            return;
        }

        $collectionClassName = SnippetTableMap::getTableMap()->getCollectionClassName();

        $this->collSnippetsRelatedByCreatedBy = new $collectionClassName;
        $this->collSnippetsRelatedByCreatedBy->setModel('\Propel\Models\Snippet');
    }

    /**
     * Gets an array of ChildSnippet objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSnippet[] List of ChildSnippet objects
     * @throws PropelException
     */
    public function getSnippetsRelatedByCreatedBy(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSnippetsRelatedByCreatedByPartial && !$this->isNew();
        if (null === $this->collSnippetsRelatedByCreatedBy || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSnippetsRelatedByCreatedBy) {
                // return empty collection
                $this->initSnippetsRelatedByCreatedBy();
            } else {
                $collSnippetsRelatedByCreatedBy = ChildSnippetQuery::create(null, $criteria)
                    ->filterByUserRelatedByCreatedBy($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSnippetsRelatedByCreatedByPartial && count($collSnippetsRelatedByCreatedBy)) {
                        $this->initSnippetsRelatedByCreatedBy(false);

                        foreach ($collSnippetsRelatedByCreatedBy as $obj) {
                            if (false == $this->collSnippetsRelatedByCreatedBy->contains($obj)) {
                                $this->collSnippetsRelatedByCreatedBy->append($obj);
                            }
                        }

                        $this->collSnippetsRelatedByCreatedByPartial = true;
                    }

                    return $collSnippetsRelatedByCreatedBy;
                }

                if ($partial && $this->collSnippetsRelatedByCreatedBy) {
                    foreach ($this->collSnippetsRelatedByCreatedBy as $obj) {
                        if ($obj->isNew()) {
                            $collSnippetsRelatedByCreatedBy[] = $obj;
                        }
                    }
                }

                $this->collSnippetsRelatedByCreatedBy = $collSnippetsRelatedByCreatedBy;
                $this->collSnippetsRelatedByCreatedByPartial = false;
            }
        }

        return $this->collSnippetsRelatedByCreatedBy;
    }

    /**
     * Sets a collection of ChildSnippet objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $snippetsRelatedByCreatedBy A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setSnippetsRelatedByCreatedBy(Collection $snippetsRelatedByCreatedBy, ConnectionInterface $con = null)
    {
        /** @var ChildSnippet[] $snippetsRelatedByCreatedByToDelete */
        $snippetsRelatedByCreatedByToDelete = $this->getSnippetsRelatedByCreatedBy(new Criteria(), $con)->diff($snippetsRelatedByCreatedBy);


        $this->snippetsRelatedByCreatedByScheduledForDeletion = $snippetsRelatedByCreatedByToDelete;

        foreach ($snippetsRelatedByCreatedByToDelete as $snippetRelatedByCreatedByRemoved) {
            $snippetRelatedByCreatedByRemoved->setUserRelatedByCreatedBy(null);
        }

        $this->collSnippetsRelatedByCreatedBy = null;
        foreach ($snippetsRelatedByCreatedBy as $snippetRelatedByCreatedBy) {
            $this->addSnippetRelatedByCreatedBy($snippetRelatedByCreatedBy);
        }

        $this->collSnippetsRelatedByCreatedBy = $snippetsRelatedByCreatedBy;
        $this->collSnippetsRelatedByCreatedByPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Snippet objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Snippet objects.
     * @throws PropelException
     */
    public function countSnippetsRelatedByCreatedBy(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSnippetsRelatedByCreatedByPartial && !$this->isNew();
        if (null === $this->collSnippetsRelatedByCreatedBy || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSnippetsRelatedByCreatedBy) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSnippetsRelatedByCreatedBy());
            }

            $query = ChildSnippetQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUserRelatedByCreatedBy($this)
                ->count($con);
        }

        return count($this->collSnippetsRelatedByCreatedBy);
    }

    /**
     * Method called to associate a ChildSnippet object to this object
     * through the ChildSnippet foreign key attribute.
     *
     * @param  ChildSnippet $l ChildSnippet
     * @return $this|\Propel\Models\User The current object (for fluent API support)
     */
    public function addSnippetRelatedByCreatedBy(ChildSnippet $l)
    {
        if ($this->collSnippetsRelatedByCreatedBy === null) {
            $this->initSnippetsRelatedByCreatedBy();
            $this->collSnippetsRelatedByCreatedByPartial = true;
        }

        if (!$this->collSnippetsRelatedByCreatedBy->contains($l)) {
            $this->doAddSnippetRelatedByCreatedBy($l);

            if ($this->snippetsRelatedByCreatedByScheduledForDeletion and $this->snippetsRelatedByCreatedByScheduledForDeletion->contains($l)) {
                $this->snippetsRelatedByCreatedByScheduledForDeletion->remove($this->snippetsRelatedByCreatedByScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildSnippet $snippetRelatedByCreatedBy The ChildSnippet object to add.
     */
    protected function doAddSnippetRelatedByCreatedBy(ChildSnippet $snippetRelatedByCreatedBy)
    {
        $this->collSnippetsRelatedByCreatedBy[]= $snippetRelatedByCreatedBy;
        $snippetRelatedByCreatedBy->setUserRelatedByCreatedBy($this);
    }

    /**
     * @param  ChildSnippet $snippetRelatedByCreatedBy The ChildSnippet object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removeSnippetRelatedByCreatedBy(ChildSnippet $snippetRelatedByCreatedBy)
    {
        if ($this->getSnippetsRelatedByCreatedBy()->contains($snippetRelatedByCreatedBy)) {
            $pos = $this->collSnippetsRelatedByCreatedBy->search($snippetRelatedByCreatedBy);
            $this->collSnippetsRelatedByCreatedBy->remove($pos);
            if (null === $this->snippetsRelatedByCreatedByScheduledForDeletion) {
                $this->snippetsRelatedByCreatedByScheduledForDeletion = clone $this->collSnippetsRelatedByCreatedBy;
                $this->snippetsRelatedByCreatedByScheduledForDeletion->clear();
            }
            $this->snippetsRelatedByCreatedByScheduledForDeletion[]= $snippetRelatedByCreatedBy;
            $snippetRelatedByCreatedBy->setUserRelatedByCreatedBy(null);
        }

        return $this;
    }

    /**
     * Clears out the collSnippetsRelatedByUpdatedBy collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSnippetsRelatedByUpdatedBy()
     */
    public function clearSnippetsRelatedByUpdatedBy()
    {
        $this->collSnippetsRelatedByUpdatedBy = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collSnippetsRelatedByUpdatedBy collection loaded partially.
     */
    public function resetPartialSnippetsRelatedByUpdatedBy($v = true)
    {
        $this->collSnippetsRelatedByUpdatedByPartial = $v;
    }

    /**
     * Initializes the collSnippetsRelatedByUpdatedBy collection.
     *
     * By default this just sets the collSnippetsRelatedByUpdatedBy collection to an empty array (like clearcollSnippetsRelatedByUpdatedBy());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSnippetsRelatedByUpdatedBy($overrideExisting = true)
    {
        if (null !== $this->collSnippetsRelatedByUpdatedBy && !$overrideExisting) {
            return;
        }

        $collectionClassName = SnippetTableMap::getTableMap()->getCollectionClassName();

        $this->collSnippetsRelatedByUpdatedBy = new $collectionClassName;
        $this->collSnippetsRelatedByUpdatedBy->setModel('\Propel\Models\Snippet');
    }

    /**
     * Gets an array of ChildSnippet objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSnippet[] List of ChildSnippet objects
     * @throws PropelException
     */
    public function getSnippetsRelatedByUpdatedBy(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSnippetsRelatedByUpdatedByPartial && !$this->isNew();
        if (null === $this->collSnippetsRelatedByUpdatedBy || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSnippetsRelatedByUpdatedBy) {
                // return empty collection
                $this->initSnippetsRelatedByUpdatedBy();
            } else {
                $collSnippetsRelatedByUpdatedBy = ChildSnippetQuery::create(null, $criteria)
                    ->filterByUserRelatedByUpdatedBy($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSnippetsRelatedByUpdatedByPartial && count($collSnippetsRelatedByUpdatedBy)) {
                        $this->initSnippetsRelatedByUpdatedBy(false);

                        foreach ($collSnippetsRelatedByUpdatedBy as $obj) {
                            if (false == $this->collSnippetsRelatedByUpdatedBy->contains($obj)) {
                                $this->collSnippetsRelatedByUpdatedBy->append($obj);
                            }
                        }

                        $this->collSnippetsRelatedByUpdatedByPartial = true;
                    }

                    return $collSnippetsRelatedByUpdatedBy;
                }

                if ($partial && $this->collSnippetsRelatedByUpdatedBy) {
                    foreach ($this->collSnippetsRelatedByUpdatedBy as $obj) {
                        if ($obj->isNew()) {
                            $collSnippetsRelatedByUpdatedBy[] = $obj;
                        }
                    }
                }

                $this->collSnippetsRelatedByUpdatedBy = $collSnippetsRelatedByUpdatedBy;
                $this->collSnippetsRelatedByUpdatedByPartial = false;
            }
        }

        return $this->collSnippetsRelatedByUpdatedBy;
    }

    /**
     * Sets a collection of ChildSnippet objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $snippetsRelatedByUpdatedBy A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setSnippetsRelatedByUpdatedBy(Collection $snippetsRelatedByUpdatedBy, ConnectionInterface $con = null)
    {
        /** @var ChildSnippet[] $snippetsRelatedByUpdatedByToDelete */
        $snippetsRelatedByUpdatedByToDelete = $this->getSnippetsRelatedByUpdatedBy(new Criteria(), $con)->diff($snippetsRelatedByUpdatedBy);


        $this->snippetsRelatedByUpdatedByScheduledForDeletion = $snippetsRelatedByUpdatedByToDelete;

        foreach ($snippetsRelatedByUpdatedByToDelete as $snippetRelatedByUpdatedByRemoved) {
            $snippetRelatedByUpdatedByRemoved->setUserRelatedByUpdatedBy(null);
        }

        $this->collSnippetsRelatedByUpdatedBy = null;
        foreach ($snippetsRelatedByUpdatedBy as $snippetRelatedByUpdatedBy) {
            $this->addSnippetRelatedByUpdatedBy($snippetRelatedByUpdatedBy);
        }

        $this->collSnippetsRelatedByUpdatedBy = $snippetsRelatedByUpdatedBy;
        $this->collSnippetsRelatedByUpdatedByPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Snippet objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Snippet objects.
     * @throws PropelException
     */
    public function countSnippetsRelatedByUpdatedBy(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSnippetsRelatedByUpdatedByPartial && !$this->isNew();
        if (null === $this->collSnippetsRelatedByUpdatedBy || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSnippetsRelatedByUpdatedBy) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSnippetsRelatedByUpdatedBy());
            }

            $query = ChildSnippetQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUserRelatedByUpdatedBy($this)
                ->count($con);
        }

        return count($this->collSnippetsRelatedByUpdatedBy);
    }

    /**
     * Method called to associate a ChildSnippet object to this object
     * through the ChildSnippet foreign key attribute.
     *
     * @param  ChildSnippet $l ChildSnippet
     * @return $this|\Propel\Models\User The current object (for fluent API support)
     */
    public function addSnippetRelatedByUpdatedBy(ChildSnippet $l)
    {
        if ($this->collSnippetsRelatedByUpdatedBy === null) {
            $this->initSnippetsRelatedByUpdatedBy();
            $this->collSnippetsRelatedByUpdatedByPartial = true;
        }

        if (!$this->collSnippetsRelatedByUpdatedBy->contains($l)) {
            $this->doAddSnippetRelatedByUpdatedBy($l);

            if ($this->snippetsRelatedByUpdatedByScheduledForDeletion and $this->snippetsRelatedByUpdatedByScheduledForDeletion->contains($l)) {
                $this->snippetsRelatedByUpdatedByScheduledForDeletion->remove($this->snippetsRelatedByUpdatedByScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildSnippet $snippetRelatedByUpdatedBy The ChildSnippet object to add.
     */
    protected function doAddSnippetRelatedByUpdatedBy(ChildSnippet $snippetRelatedByUpdatedBy)
    {
        $this->collSnippetsRelatedByUpdatedBy[]= $snippetRelatedByUpdatedBy;
        $snippetRelatedByUpdatedBy->setUserRelatedByUpdatedBy($this);
    }

    /**
     * @param  ChildSnippet $snippetRelatedByUpdatedBy The ChildSnippet object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removeSnippetRelatedByUpdatedBy(ChildSnippet $snippetRelatedByUpdatedBy)
    {
        if ($this->getSnippetsRelatedByUpdatedBy()->contains($snippetRelatedByUpdatedBy)) {
            $pos = $this->collSnippetsRelatedByUpdatedBy->search($snippetRelatedByUpdatedBy);
            $this->collSnippetsRelatedByUpdatedBy->remove($pos);
            if (null === $this->snippetsRelatedByUpdatedByScheduledForDeletion) {
                $this->snippetsRelatedByUpdatedByScheduledForDeletion = clone $this->collSnippetsRelatedByUpdatedBy;
                $this->snippetsRelatedByUpdatedByScheduledForDeletion->clear();
            }
            $this->snippetsRelatedByUpdatedByScheduledForDeletion[]= $snippetRelatedByUpdatedBy;
            $snippetRelatedByUpdatedBy->setUserRelatedByUpdatedBy(null);
        }

        return $this;
    }

    /**
     * Clears out the collTagsRelatedByCreatedBy collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addTagsRelatedByCreatedBy()
     */
    public function clearTagsRelatedByCreatedBy()
    {
        $this->collTagsRelatedByCreatedBy = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collTagsRelatedByCreatedBy collection loaded partially.
     */
    public function resetPartialTagsRelatedByCreatedBy($v = true)
    {
        $this->collTagsRelatedByCreatedByPartial = $v;
    }

    /**
     * Initializes the collTagsRelatedByCreatedBy collection.
     *
     * By default this just sets the collTagsRelatedByCreatedBy collection to an empty array (like clearcollTagsRelatedByCreatedBy());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initTagsRelatedByCreatedBy($overrideExisting = true)
    {
        if (null !== $this->collTagsRelatedByCreatedBy && !$overrideExisting) {
            return;
        }

        $collectionClassName = TagTableMap::getTableMap()->getCollectionClassName();

        $this->collTagsRelatedByCreatedBy = new $collectionClassName;
        $this->collTagsRelatedByCreatedBy->setModel('\Propel\Models\Tag');
    }

    /**
     * Gets an array of ChildTag objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildTag[] List of ChildTag objects
     * @throws PropelException
     */
    public function getTagsRelatedByCreatedBy(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collTagsRelatedByCreatedByPartial && !$this->isNew();
        if (null === $this->collTagsRelatedByCreatedBy || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collTagsRelatedByCreatedBy) {
                // return empty collection
                $this->initTagsRelatedByCreatedBy();
            } else {
                $collTagsRelatedByCreatedBy = ChildTagQuery::create(null, $criteria)
                    ->filterByUserRelatedByCreatedBy($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collTagsRelatedByCreatedByPartial && count($collTagsRelatedByCreatedBy)) {
                        $this->initTagsRelatedByCreatedBy(false);

                        foreach ($collTagsRelatedByCreatedBy as $obj) {
                            if (false == $this->collTagsRelatedByCreatedBy->contains($obj)) {
                                $this->collTagsRelatedByCreatedBy->append($obj);
                            }
                        }

                        $this->collTagsRelatedByCreatedByPartial = true;
                    }

                    return $collTagsRelatedByCreatedBy;
                }

                if ($partial && $this->collTagsRelatedByCreatedBy) {
                    foreach ($this->collTagsRelatedByCreatedBy as $obj) {
                        if ($obj->isNew()) {
                            $collTagsRelatedByCreatedBy[] = $obj;
                        }
                    }
                }

                $this->collTagsRelatedByCreatedBy = $collTagsRelatedByCreatedBy;
                $this->collTagsRelatedByCreatedByPartial = false;
            }
        }

        return $this->collTagsRelatedByCreatedBy;
    }

    /**
     * Sets a collection of ChildTag objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $tagsRelatedByCreatedBy A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setTagsRelatedByCreatedBy(Collection $tagsRelatedByCreatedBy, ConnectionInterface $con = null)
    {
        /** @var ChildTag[] $tagsRelatedByCreatedByToDelete */
        $tagsRelatedByCreatedByToDelete = $this->getTagsRelatedByCreatedBy(new Criteria(), $con)->diff($tagsRelatedByCreatedBy);


        $this->tagsRelatedByCreatedByScheduledForDeletion = $tagsRelatedByCreatedByToDelete;

        foreach ($tagsRelatedByCreatedByToDelete as $tagRelatedByCreatedByRemoved) {
            $tagRelatedByCreatedByRemoved->setUserRelatedByCreatedBy(null);
        }

        $this->collTagsRelatedByCreatedBy = null;
        foreach ($tagsRelatedByCreatedBy as $tagRelatedByCreatedBy) {
            $this->addTagRelatedByCreatedBy($tagRelatedByCreatedBy);
        }

        $this->collTagsRelatedByCreatedBy = $tagsRelatedByCreatedBy;
        $this->collTagsRelatedByCreatedByPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Tag objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Tag objects.
     * @throws PropelException
     */
    public function countTagsRelatedByCreatedBy(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collTagsRelatedByCreatedByPartial && !$this->isNew();
        if (null === $this->collTagsRelatedByCreatedBy || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTagsRelatedByCreatedBy) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getTagsRelatedByCreatedBy());
            }

            $query = ChildTagQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUserRelatedByCreatedBy($this)
                ->count($con);
        }

        return count($this->collTagsRelatedByCreatedBy);
    }

    /**
     * Method called to associate a ChildTag object to this object
     * through the ChildTag foreign key attribute.
     *
     * @param  ChildTag $l ChildTag
     * @return $this|\Propel\Models\User The current object (for fluent API support)
     */
    public function addTagRelatedByCreatedBy(ChildTag $l)
    {
        if ($this->collTagsRelatedByCreatedBy === null) {
            $this->initTagsRelatedByCreatedBy();
            $this->collTagsRelatedByCreatedByPartial = true;
        }

        if (!$this->collTagsRelatedByCreatedBy->contains($l)) {
            $this->doAddTagRelatedByCreatedBy($l);

            if ($this->tagsRelatedByCreatedByScheduledForDeletion and $this->tagsRelatedByCreatedByScheduledForDeletion->contains($l)) {
                $this->tagsRelatedByCreatedByScheduledForDeletion->remove($this->tagsRelatedByCreatedByScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildTag $tagRelatedByCreatedBy The ChildTag object to add.
     */
    protected function doAddTagRelatedByCreatedBy(ChildTag $tagRelatedByCreatedBy)
    {
        $this->collTagsRelatedByCreatedBy[]= $tagRelatedByCreatedBy;
        $tagRelatedByCreatedBy->setUserRelatedByCreatedBy($this);
    }

    /**
     * @param  ChildTag $tagRelatedByCreatedBy The ChildTag object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removeTagRelatedByCreatedBy(ChildTag $tagRelatedByCreatedBy)
    {
        if ($this->getTagsRelatedByCreatedBy()->contains($tagRelatedByCreatedBy)) {
            $pos = $this->collTagsRelatedByCreatedBy->search($tagRelatedByCreatedBy);
            $this->collTagsRelatedByCreatedBy->remove($pos);
            if (null === $this->tagsRelatedByCreatedByScheduledForDeletion) {
                $this->tagsRelatedByCreatedByScheduledForDeletion = clone $this->collTagsRelatedByCreatedBy;
                $this->tagsRelatedByCreatedByScheduledForDeletion->clear();
            }
            $this->tagsRelatedByCreatedByScheduledForDeletion[]= $tagRelatedByCreatedBy;
            $tagRelatedByCreatedBy->setUserRelatedByCreatedBy(null);
        }

        return $this;
    }

    /**
     * Clears out the collTagsRelatedByUpdatedBy collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addTagsRelatedByUpdatedBy()
     */
    public function clearTagsRelatedByUpdatedBy()
    {
        $this->collTagsRelatedByUpdatedBy = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collTagsRelatedByUpdatedBy collection loaded partially.
     */
    public function resetPartialTagsRelatedByUpdatedBy($v = true)
    {
        $this->collTagsRelatedByUpdatedByPartial = $v;
    }

    /**
     * Initializes the collTagsRelatedByUpdatedBy collection.
     *
     * By default this just sets the collTagsRelatedByUpdatedBy collection to an empty array (like clearcollTagsRelatedByUpdatedBy());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initTagsRelatedByUpdatedBy($overrideExisting = true)
    {
        if (null !== $this->collTagsRelatedByUpdatedBy && !$overrideExisting) {
            return;
        }

        $collectionClassName = TagTableMap::getTableMap()->getCollectionClassName();

        $this->collTagsRelatedByUpdatedBy = new $collectionClassName;
        $this->collTagsRelatedByUpdatedBy->setModel('\Propel\Models\Tag');
    }

    /**
     * Gets an array of ChildTag objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildTag[] List of ChildTag objects
     * @throws PropelException
     */
    public function getTagsRelatedByUpdatedBy(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collTagsRelatedByUpdatedByPartial && !$this->isNew();
        if (null === $this->collTagsRelatedByUpdatedBy || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collTagsRelatedByUpdatedBy) {
                // return empty collection
                $this->initTagsRelatedByUpdatedBy();
            } else {
                $collTagsRelatedByUpdatedBy = ChildTagQuery::create(null, $criteria)
                    ->filterByUserRelatedByUpdatedBy($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collTagsRelatedByUpdatedByPartial && count($collTagsRelatedByUpdatedBy)) {
                        $this->initTagsRelatedByUpdatedBy(false);

                        foreach ($collTagsRelatedByUpdatedBy as $obj) {
                            if (false == $this->collTagsRelatedByUpdatedBy->contains($obj)) {
                                $this->collTagsRelatedByUpdatedBy->append($obj);
                            }
                        }

                        $this->collTagsRelatedByUpdatedByPartial = true;
                    }

                    return $collTagsRelatedByUpdatedBy;
                }

                if ($partial && $this->collTagsRelatedByUpdatedBy) {
                    foreach ($this->collTagsRelatedByUpdatedBy as $obj) {
                        if ($obj->isNew()) {
                            $collTagsRelatedByUpdatedBy[] = $obj;
                        }
                    }
                }

                $this->collTagsRelatedByUpdatedBy = $collTagsRelatedByUpdatedBy;
                $this->collTagsRelatedByUpdatedByPartial = false;
            }
        }

        return $this->collTagsRelatedByUpdatedBy;
    }

    /**
     * Sets a collection of ChildTag objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $tagsRelatedByUpdatedBy A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setTagsRelatedByUpdatedBy(Collection $tagsRelatedByUpdatedBy, ConnectionInterface $con = null)
    {
        /** @var ChildTag[] $tagsRelatedByUpdatedByToDelete */
        $tagsRelatedByUpdatedByToDelete = $this->getTagsRelatedByUpdatedBy(new Criteria(), $con)->diff($tagsRelatedByUpdatedBy);


        $this->tagsRelatedByUpdatedByScheduledForDeletion = $tagsRelatedByUpdatedByToDelete;

        foreach ($tagsRelatedByUpdatedByToDelete as $tagRelatedByUpdatedByRemoved) {
            $tagRelatedByUpdatedByRemoved->setUserRelatedByUpdatedBy(null);
        }

        $this->collTagsRelatedByUpdatedBy = null;
        foreach ($tagsRelatedByUpdatedBy as $tagRelatedByUpdatedBy) {
            $this->addTagRelatedByUpdatedBy($tagRelatedByUpdatedBy);
        }

        $this->collTagsRelatedByUpdatedBy = $tagsRelatedByUpdatedBy;
        $this->collTagsRelatedByUpdatedByPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Tag objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Tag objects.
     * @throws PropelException
     */
    public function countTagsRelatedByUpdatedBy(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collTagsRelatedByUpdatedByPartial && !$this->isNew();
        if (null === $this->collTagsRelatedByUpdatedBy || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTagsRelatedByUpdatedBy) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getTagsRelatedByUpdatedBy());
            }

            $query = ChildTagQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUserRelatedByUpdatedBy($this)
                ->count($con);
        }

        return count($this->collTagsRelatedByUpdatedBy);
    }

    /**
     * Method called to associate a ChildTag object to this object
     * through the ChildTag foreign key attribute.
     *
     * @param  ChildTag $l ChildTag
     * @return $this|\Propel\Models\User The current object (for fluent API support)
     */
    public function addTagRelatedByUpdatedBy(ChildTag $l)
    {
        if ($this->collTagsRelatedByUpdatedBy === null) {
            $this->initTagsRelatedByUpdatedBy();
            $this->collTagsRelatedByUpdatedByPartial = true;
        }

        if (!$this->collTagsRelatedByUpdatedBy->contains($l)) {
            $this->doAddTagRelatedByUpdatedBy($l);

            if ($this->tagsRelatedByUpdatedByScheduledForDeletion and $this->tagsRelatedByUpdatedByScheduledForDeletion->contains($l)) {
                $this->tagsRelatedByUpdatedByScheduledForDeletion->remove($this->tagsRelatedByUpdatedByScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildTag $tagRelatedByUpdatedBy The ChildTag object to add.
     */
    protected function doAddTagRelatedByUpdatedBy(ChildTag $tagRelatedByUpdatedBy)
    {
        $this->collTagsRelatedByUpdatedBy[]= $tagRelatedByUpdatedBy;
        $tagRelatedByUpdatedBy->setUserRelatedByUpdatedBy($this);
    }

    /**
     * @param  ChildTag $tagRelatedByUpdatedBy The ChildTag object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removeTagRelatedByUpdatedBy(ChildTag $tagRelatedByUpdatedBy)
    {
        if ($this->getTagsRelatedByUpdatedBy()->contains($tagRelatedByUpdatedBy)) {
            $pos = $this->collTagsRelatedByUpdatedBy->search($tagRelatedByUpdatedBy);
            $this->collTagsRelatedByUpdatedBy->remove($pos);
            if (null === $this->tagsRelatedByUpdatedByScheduledForDeletion) {
                $this->tagsRelatedByUpdatedByScheduledForDeletion = clone $this->collTagsRelatedByUpdatedBy;
                $this->tagsRelatedByUpdatedByScheduledForDeletion->clear();
            }
            $this->tagsRelatedByUpdatedByScheduledForDeletion[]= $tagRelatedByUpdatedBy;
            $tagRelatedByUpdatedBy->setUserRelatedByUpdatedBy(null);
        }

        return $this;
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
     * If this ChildUser is new, it will return
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
                    ->filterByUser($this)
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
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setUserFavorites(Collection $userFavorites, ConnectionInterface $con = null)
    {
        /** @var ChildUserFavorite[] $userFavoritesToDelete */
        $userFavoritesToDelete = $this->getUserFavorites(new Criteria(), $con)->diff($userFavorites);


        $this->userFavoritesScheduledForDeletion = $userFavoritesToDelete;

        foreach ($userFavoritesToDelete as $userFavoriteRemoved) {
            $userFavoriteRemoved->setUser(null);
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
                ->filterByUser($this)
                ->count($con);
        }

        return count($this->collUserFavorites);
    }

    /**
     * Method called to associate a ChildUserFavorite object to this object
     * through the ChildUserFavorite foreign key attribute.
     *
     * @param  ChildUserFavorite $l ChildUserFavorite
     * @return $this|\Propel\Models\User The current object (for fluent API support)
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
        $userFavorite->setUser($this);
    }

    /**
     * @param  ChildUserFavorite $userFavorite The ChildUserFavorite object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
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
            $userFavorite->setUser(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related UserFavorites from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildUserFavorite[] List of ChildUserFavorite objects
     */
    public function getUserFavoritesJoinPublication(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildUserFavoriteQuery::create(null, $criteria);
        $query->joinWith('Publication', $joinBehavior);

        return $this->getUserFavorites($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id = null;
        $this->role = null;
        $this->email = null;
        $this->username = null;
        $this->password = null;
        $this->password_isLoaded = false;
        $this->photo = null;
        $this->firstname = null;
        $this->lastname = null;
        $this->gender = null;
        $this->birthday = null;
        $this->about = null;
        $this->about_isLoaded = false;
        $this->params = null;
        $this->params_isLoaded = false;
        $this->registration_at = null;
        $this->registration_ip = null;
        $this->registration_confirmed = null;
        $this->registration_confirmed_at = null;
        $this->registration_confirmed_ip = null;
        $this->registration_confirmation_code = null;
        $this->registration_confirmation_code_isLoaded = false;
        $this->authentication_at = null;
        $this->authentication_ip = null;
        $this->authentication_key = null;
        $this->authentication_key_isLoaded = false;
        $this->authentication_token = null;
        $this->authentication_token_isLoaded = false;
        $this->authentication_token_at = null;
        $this->authentication_token_ip = null;
        $this->authentication_attempt_count = null;
        $this->track_at = null;
        $this->track_ip = null;
        $this->track_url = null;
        $this->ban_from = null;
        $this->ban_until = null;
        $this->ban_reason = null;
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
            if ($this->collBannersRelatedByCreatedBy) {
                foreach ($this->collBannersRelatedByCreatedBy as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collBannersRelatedByUpdatedBy) {
                foreach ($this->collBannersRelatedByUpdatedBy as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collBannerGroupsRelatedByCreatedBy) {
                foreach ($this->collBannerGroupsRelatedByCreatedBy as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collBannerGroupsRelatedByUpdatedBy) {
                foreach ($this->collBannerGroupsRelatedByUpdatedBy as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collBannerClientsRelatedByCreatedBy) {
                foreach ($this->collBannerClientsRelatedByCreatedBy as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collBannerClientsRelatedByUpdatedBy) {
                foreach ($this->collBannerClientsRelatedByUpdatedBy as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collCommentsRelatedByCreatedBy) {
                foreach ($this->collCommentsRelatedByCreatedBy as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collCommentsRelatedByUpdatedBy) {
                foreach ($this->collCommentsRelatedByUpdatedBy as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collCommentsRelatedByDeletedBy) {
                foreach ($this->collCommentsRelatedByDeletedBy as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collFieldsRelatedByCreatedBy) {
                foreach ($this->collFieldsRelatedByCreatedBy as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collFieldsRelatedByUpdatedBy) {
                foreach ($this->collFieldsRelatedByUpdatedBy as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPollsRelatedByCreatedBy) {
                foreach ($this->collPollsRelatedByCreatedBy as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPollsRelatedByUpdatedBy) {
                foreach ($this->collPollsRelatedByUpdatedBy as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPollVariantsRelatedByCreatedBy) {
                foreach ($this->collPollVariantsRelatedByCreatedBy as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPollVariantsRelatedByUpdatedBy) {
                foreach ($this->collPollVariantsRelatedByUpdatedBy as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSectionsRelatedByCreatedBy) {
                foreach ($this->collSectionsRelatedByCreatedBy as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSectionsRelatedByUpdatedBy) {
                foreach ($this->collSectionsRelatedByUpdatedBy as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPublicationsRelatedByCreatedBy) {
                foreach ($this->collPublicationsRelatedByCreatedBy as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPublicationsRelatedByUpdatedBy) {
                foreach ($this->collPublicationsRelatedByUpdatedBy as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPublicationPhotosRelatedByCreatedBy) {
                foreach ($this->collPublicationPhotosRelatedByCreatedBy as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPublicationPhotosRelatedByUpdatedBy) {
                foreach ($this->collPublicationPhotosRelatedByUpdatedBy as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRadiosRelatedByCreatedBy) {
                foreach ($this->collRadiosRelatedByCreatedBy as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRadiosRelatedByUpdatedBy) {
                foreach ($this->collRadiosRelatedByUpdatedBy as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSnippetsRelatedByCreatedBy) {
                foreach ($this->collSnippetsRelatedByCreatedBy as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSnippetsRelatedByUpdatedBy) {
                foreach ($this->collSnippetsRelatedByUpdatedBy as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collTagsRelatedByCreatedBy) {
                foreach ($this->collTagsRelatedByCreatedBy as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collTagsRelatedByUpdatedBy) {
                foreach ($this->collTagsRelatedByUpdatedBy as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collUserFavorites) {
                foreach ($this->collUserFavorites as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collBannersRelatedByCreatedBy = null;
        $this->collBannersRelatedByUpdatedBy = null;
        $this->collBannerGroupsRelatedByCreatedBy = null;
        $this->collBannerGroupsRelatedByUpdatedBy = null;
        $this->collBannerClientsRelatedByCreatedBy = null;
        $this->collBannerClientsRelatedByUpdatedBy = null;
        $this->collCommentsRelatedByCreatedBy = null;
        $this->collCommentsRelatedByUpdatedBy = null;
        $this->collCommentsRelatedByDeletedBy = null;
        $this->collFieldsRelatedByCreatedBy = null;
        $this->collFieldsRelatedByUpdatedBy = null;
        $this->collPollsRelatedByCreatedBy = null;
        $this->collPollsRelatedByUpdatedBy = null;
        $this->collPollVariantsRelatedByCreatedBy = null;
        $this->collPollVariantsRelatedByUpdatedBy = null;
        $this->collSectionsRelatedByCreatedBy = null;
        $this->collSectionsRelatedByUpdatedBy = null;
        $this->collPublicationsRelatedByCreatedBy = null;
        $this->collPublicationsRelatedByUpdatedBy = null;
        $this->collPublicationPhotosRelatedByCreatedBy = null;
        $this->collPublicationPhotosRelatedByUpdatedBy = null;
        $this->collRadiosRelatedByCreatedBy = null;
        $this->collRadiosRelatedByUpdatedBy = null;
        $this->collSnippetsRelatedByCreatedBy = null;
        $this->collSnippetsRelatedByUpdatedBy = null;
        $this->collTagsRelatedByCreatedBy = null;
        $this->collTagsRelatedByUpdatedBy = null;
        $this->collUserFavorites = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string The value of the 'username' column
     */
    public function __toString()
    {
        return (string) $this->getUsername();
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
        $metadata->addPropertyConstraint('role', new NotBlank(array ('message' => 'Роль не может быть пустой.',)));
        $metadata->addPropertyConstraint('role', new Length(array ('max' => 64,'maxMessage' => 'Максимально допустимая длина роли 64 символа.',)));
        $metadata->addPropertyConstraint('email', new NotBlank(array ('message' => 'Электронный адрес не может быть пустым.',)));
        $metadata->addPropertyConstraint('email', new Length(array ('max' => 128,'maxMessage' => 'Максимально допустимая длина электронного адреса 128 символов.',)));
        $metadata->addPropertyConstraint('email', new Email(array ('message' => 'Некорректный электронный адрес.',)));
        $metadata->addPropertyConstraint('email', new Unique(array ('message' => 'Электронный адрес привязан к другой учетной записи.',)));
        $metadata->addPropertyConstraint('username', new NotBlank(array ('message' => 'Имя учетной записи не может быть пустым.',)));
        $metadata->addPropertyConstraint('username', new Length(array ('min' => 2,'max' => 48,'minMessage' => 'Минимально возможная длина имени учетной записи 2 символа.','maxMessage' => 'Максимально допустимая длина имени учетной записи 48 символов.',)));
        $metadata->addPropertyConstraint('username', new Regex(array ('pattern' => '/^[a-zA-Z0-9]+$/','message' => 'Имя учетной записи должно состоять только из букв английского алфавита и арабских цифр.',)));
        $metadata->addPropertyConstraint('username', new Unique(array ('message' => 'Имя учетной записи закреплено за другой учетной записью.',)));
        $metadata->addPropertyConstraint('password', new NotBlank(array ('message' => 'Пароль не может быть пустым.',)));
        $metadata->addPropertyConstraint('password', new Length(array ('min' => 6,'max' => 256,'minMessage' => 'Минимально возможная длина пароля 6 символов.','maxMessage' => 'Максимально допустимая длина пароля 256 символов.',)));
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


            $retval = $validator->validate($this);
            if (count($retval) > 0) {
                $failureMap->addAll($retval);
            }

            if (null !== $this->collBannersRelatedByCreatedBy) {
                foreach ($this->collBannersRelatedByCreatedBy as $referrerFK) {
                    if (method_exists($referrerFK, 'validate')) {
                        if (!$referrerFK->validate($validator)) {
                            $failureMap->addAll($referrerFK->getValidationFailures());
                        }
                    }
                }
            }
            if (null !== $this->collBannersRelatedByUpdatedBy) {
                foreach ($this->collBannersRelatedByUpdatedBy as $referrerFK) {
                    if (method_exists($referrerFK, 'validate')) {
                        if (!$referrerFK->validate($validator)) {
                            $failureMap->addAll($referrerFK->getValidationFailures());
                        }
                    }
                }
            }
            if (null !== $this->collBannerGroupsRelatedByCreatedBy) {
                foreach ($this->collBannerGroupsRelatedByCreatedBy as $referrerFK) {
                    if (method_exists($referrerFK, 'validate')) {
                        if (!$referrerFK->validate($validator)) {
                            $failureMap->addAll($referrerFK->getValidationFailures());
                        }
                    }
                }
            }
            if (null !== $this->collBannerGroupsRelatedByUpdatedBy) {
                foreach ($this->collBannerGroupsRelatedByUpdatedBy as $referrerFK) {
                    if (method_exists($referrerFK, 'validate')) {
                        if (!$referrerFK->validate($validator)) {
                            $failureMap->addAll($referrerFK->getValidationFailures());
                        }
                    }
                }
            }
            if (null !== $this->collBannerClientsRelatedByCreatedBy) {
                foreach ($this->collBannerClientsRelatedByCreatedBy as $referrerFK) {
                    if (method_exists($referrerFK, 'validate')) {
                        if (!$referrerFK->validate($validator)) {
                            $failureMap->addAll($referrerFK->getValidationFailures());
                        }
                    }
                }
            }
            if (null !== $this->collBannerClientsRelatedByUpdatedBy) {
                foreach ($this->collBannerClientsRelatedByUpdatedBy as $referrerFK) {
                    if (method_exists($referrerFK, 'validate')) {
                        if (!$referrerFK->validate($validator)) {
                            $failureMap->addAll($referrerFK->getValidationFailures());
                        }
                    }
                }
            }
            if (null !== $this->collCommentsRelatedByCreatedBy) {
                foreach ($this->collCommentsRelatedByCreatedBy as $referrerFK) {
                    if (method_exists($referrerFK, 'validate')) {
                        if (!$referrerFK->validate($validator)) {
                            $failureMap->addAll($referrerFK->getValidationFailures());
                        }
                    }
                }
            }
            if (null !== $this->collCommentsRelatedByUpdatedBy) {
                foreach ($this->collCommentsRelatedByUpdatedBy as $referrerFK) {
                    if (method_exists($referrerFK, 'validate')) {
                        if (!$referrerFK->validate($validator)) {
                            $failureMap->addAll($referrerFK->getValidationFailures());
                        }
                    }
                }
            }
            if (null !== $this->collCommentsRelatedByDeletedBy) {
                foreach ($this->collCommentsRelatedByDeletedBy as $referrerFK) {
                    if (method_exists($referrerFK, 'validate')) {
                        if (!$referrerFK->validate($validator)) {
                            $failureMap->addAll($referrerFK->getValidationFailures());
                        }
                    }
                }
            }
            if (null !== $this->collFieldsRelatedByCreatedBy) {
                foreach ($this->collFieldsRelatedByCreatedBy as $referrerFK) {
                    if (method_exists($referrerFK, 'validate')) {
                        if (!$referrerFK->validate($validator)) {
                            $failureMap->addAll($referrerFK->getValidationFailures());
                        }
                    }
                }
            }
            if (null !== $this->collFieldsRelatedByUpdatedBy) {
                foreach ($this->collFieldsRelatedByUpdatedBy as $referrerFK) {
                    if (method_exists($referrerFK, 'validate')) {
                        if (!$referrerFK->validate($validator)) {
                            $failureMap->addAll($referrerFK->getValidationFailures());
                        }
                    }
                }
            }
            if (null !== $this->collPollsRelatedByCreatedBy) {
                foreach ($this->collPollsRelatedByCreatedBy as $referrerFK) {
                    if (method_exists($referrerFK, 'validate')) {
                        if (!$referrerFK->validate($validator)) {
                            $failureMap->addAll($referrerFK->getValidationFailures());
                        }
                    }
                }
            }
            if (null !== $this->collPollsRelatedByUpdatedBy) {
                foreach ($this->collPollsRelatedByUpdatedBy as $referrerFK) {
                    if (method_exists($referrerFK, 'validate')) {
                        if (!$referrerFK->validate($validator)) {
                            $failureMap->addAll($referrerFK->getValidationFailures());
                        }
                    }
                }
            }
            if (null !== $this->collPollVariantsRelatedByCreatedBy) {
                foreach ($this->collPollVariantsRelatedByCreatedBy as $referrerFK) {
                    if (method_exists($referrerFK, 'validate')) {
                        if (!$referrerFK->validate($validator)) {
                            $failureMap->addAll($referrerFK->getValidationFailures());
                        }
                    }
                }
            }
            if (null !== $this->collPollVariantsRelatedByUpdatedBy) {
                foreach ($this->collPollVariantsRelatedByUpdatedBy as $referrerFK) {
                    if (method_exists($referrerFK, 'validate')) {
                        if (!$referrerFK->validate($validator)) {
                            $failureMap->addAll($referrerFK->getValidationFailures());
                        }
                    }
                }
            }
            if (null !== $this->collSectionsRelatedByCreatedBy) {
                foreach ($this->collSectionsRelatedByCreatedBy as $referrerFK) {
                    if (method_exists($referrerFK, 'validate')) {
                        if (!$referrerFK->validate($validator)) {
                            $failureMap->addAll($referrerFK->getValidationFailures());
                        }
                    }
                }
            }
            if (null !== $this->collSectionsRelatedByUpdatedBy) {
                foreach ($this->collSectionsRelatedByUpdatedBy as $referrerFK) {
                    if (method_exists($referrerFK, 'validate')) {
                        if (!$referrerFK->validate($validator)) {
                            $failureMap->addAll($referrerFK->getValidationFailures());
                        }
                    }
                }
            }
            if (null !== $this->collPublicationsRelatedByCreatedBy) {
                foreach ($this->collPublicationsRelatedByCreatedBy as $referrerFK) {
                    if (method_exists($referrerFK, 'validate')) {
                        if (!$referrerFK->validate($validator)) {
                            $failureMap->addAll($referrerFK->getValidationFailures());
                        }
                    }
                }
            }
            if (null !== $this->collPublicationsRelatedByUpdatedBy) {
                foreach ($this->collPublicationsRelatedByUpdatedBy as $referrerFK) {
                    if (method_exists($referrerFK, 'validate')) {
                        if (!$referrerFK->validate($validator)) {
                            $failureMap->addAll($referrerFK->getValidationFailures());
                        }
                    }
                }
            }
            if (null !== $this->collPublicationPhotosRelatedByCreatedBy) {
                foreach ($this->collPublicationPhotosRelatedByCreatedBy as $referrerFK) {
                    if (method_exists($referrerFK, 'validate')) {
                        if (!$referrerFK->validate($validator)) {
                            $failureMap->addAll($referrerFK->getValidationFailures());
                        }
                    }
                }
            }
            if (null !== $this->collPublicationPhotosRelatedByUpdatedBy) {
                foreach ($this->collPublicationPhotosRelatedByUpdatedBy as $referrerFK) {
                    if (method_exists($referrerFK, 'validate')) {
                        if (!$referrerFK->validate($validator)) {
                            $failureMap->addAll($referrerFK->getValidationFailures());
                        }
                    }
                }
            }
            if (null !== $this->collRadiosRelatedByCreatedBy) {
                foreach ($this->collRadiosRelatedByCreatedBy as $referrerFK) {
                    if (method_exists($referrerFK, 'validate')) {
                        if (!$referrerFK->validate($validator)) {
                            $failureMap->addAll($referrerFK->getValidationFailures());
                        }
                    }
                }
            }
            if (null !== $this->collRadiosRelatedByUpdatedBy) {
                foreach ($this->collRadiosRelatedByUpdatedBy as $referrerFK) {
                    if (method_exists($referrerFK, 'validate')) {
                        if (!$referrerFK->validate($validator)) {
                            $failureMap->addAll($referrerFK->getValidationFailures());
                        }
                    }
                }
            }
            if (null !== $this->collSnippetsRelatedByCreatedBy) {
                foreach ($this->collSnippetsRelatedByCreatedBy as $referrerFK) {
                    if (method_exists($referrerFK, 'validate')) {
                        if (!$referrerFK->validate($validator)) {
                            $failureMap->addAll($referrerFK->getValidationFailures());
                        }
                    }
                }
            }
            if (null !== $this->collSnippetsRelatedByUpdatedBy) {
                foreach ($this->collSnippetsRelatedByUpdatedBy as $referrerFK) {
                    if (method_exists($referrerFK, 'validate')) {
                        if (!$referrerFK->validate($validator)) {
                            $failureMap->addAll($referrerFK->getValidationFailures());
                        }
                    }
                }
            }
            if (null !== $this->collTagsRelatedByCreatedBy) {
                foreach ($this->collTagsRelatedByCreatedBy as $referrerFK) {
                    if (method_exists($referrerFK, 'validate')) {
                        if (!$referrerFK->validate($validator)) {
                            $failureMap->addAll($referrerFK->getValidationFailures());
                        }
                    }
                }
            }
            if (null !== $this->collTagsRelatedByUpdatedBy) {
                foreach ($this->collTagsRelatedByUpdatedBy as $referrerFK) {
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
