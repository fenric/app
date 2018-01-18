<?php

namespace Propel\Models\Map;

use Propel\Models\User;
use Propel\Models\UserQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'fenric_user' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class UserTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Propel.Models.Map.UserTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'fenric_user';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Propel\\Models\\User';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Propel.Models.User';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 31;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 6;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 25;

    /**
     * the column name for the id field
     */
    const COL_ID = 'fenric_user.id';

    /**
     * the column name for the role field
     */
    const COL_ROLE = 'fenric_user.role';

    /**
     * the column name for the email field
     */
    const COL_EMAIL = 'fenric_user.email';

    /**
     * the column name for the username field
     */
    const COL_USERNAME = 'fenric_user.username';

    /**
     * the column name for the password field
     */
    const COL_PASSWORD = 'fenric_user.password';

    /**
     * the column name for the photo field
     */
    const COL_PHOTO = 'fenric_user.photo';

    /**
     * the column name for the firstname field
     */
    const COL_FIRSTNAME = 'fenric_user.firstname';

    /**
     * the column name for the lastname field
     */
    const COL_LASTNAME = 'fenric_user.lastname';

    /**
     * the column name for the gender field
     */
    const COL_GENDER = 'fenric_user.gender';

    /**
     * the column name for the birthday field
     */
    const COL_BIRTHDAY = 'fenric_user.birthday';

    /**
     * the column name for the about field
     */
    const COL_ABOUT = 'fenric_user.about';

    /**
     * the column name for the params field
     */
    const COL_PARAMS = 'fenric_user.params';

    /**
     * the column name for the registration_at field
     */
    const COL_REGISTRATION_AT = 'fenric_user.registration_at';

    /**
     * the column name for the registration_ip field
     */
    const COL_REGISTRATION_IP = 'fenric_user.registration_ip';

    /**
     * the column name for the registration_confirmed field
     */
    const COL_REGISTRATION_CONFIRMED = 'fenric_user.registration_confirmed';

    /**
     * the column name for the registration_confirmed_at field
     */
    const COL_REGISTRATION_CONFIRMED_AT = 'fenric_user.registration_confirmed_at';

    /**
     * the column name for the registration_confirmed_ip field
     */
    const COL_REGISTRATION_CONFIRMED_IP = 'fenric_user.registration_confirmed_ip';

    /**
     * the column name for the registration_confirmation_code field
     */
    const COL_REGISTRATION_CONFIRMATION_CODE = 'fenric_user.registration_confirmation_code';

    /**
     * the column name for the authentication_at field
     */
    const COL_AUTHENTICATION_AT = 'fenric_user.authentication_at';

    /**
     * the column name for the authentication_ip field
     */
    const COL_AUTHENTICATION_IP = 'fenric_user.authentication_ip';

    /**
     * the column name for the authentication_key field
     */
    const COL_AUTHENTICATION_KEY = 'fenric_user.authentication_key';

    /**
     * the column name for the authentication_token field
     */
    const COL_AUTHENTICATION_TOKEN = 'fenric_user.authentication_token';

    /**
     * the column name for the authentication_token_at field
     */
    const COL_AUTHENTICATION_TOKEN_AT = 'fenric_user.authentication_token_at';

    /**
     * the column name for the authentication_token_ip field
     */
    const COL_AUTHENTICATION_TOKEN_IP = 'fenric_user.authentication_token_ip';

    /**
     * the column name for the authentication_attempt_count field
     */
    const COL_AUTHENTICATION_ATTEMPT_COUNT = 'fenric_user.authentication_attempt_count';

    /**
     * the column name for the track_at field
     */
    const COL_TRACK_AT = 'fenric_user.track_at';

    /**
     * the column name for the track_ip field
     */
    const COL_TRACK_IP = 'fenric_user.track_ip';

    /**
     * the column name for the track_url field
     */
    const COL_TRACK_URL = 'fenric_user.track_url';

    /**
     * the column name for the ban_from field
     */
    const COL_BAN_FROM = 'fenric_user.ban_from';

    /**
     * the column name for the ban_until field
     */
    const COL_BAN_UNTIL = 'fenric_user.ban_until';

    /**
     * the column name for the ban_reason field
     */
    const COL_BAN_REASON = 'fenric_user.ban_reason';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'Role', 'Email', 'Username', 'Password', 'Photo', 'Firstname', 'Lastname', 'Gender', 'Birthday', 'About', 'Params', 'RegistrationAt', 'RegistrationIp', 'RegistrationConfirmed', 'RegistrationConfirmedAt', 'RegistrationConfirmedIp', 'RegistrationConfirmationCode', 'AuthenticationAt', 'AuthenticationIp', 'AuthenticationKey', 'AuthenticationToken', 'AuthenticationTokenAt', 'AuthenticationTokenIp', 'AuthenticationAttemptCount', 'TrackAt', 'TrackIp', 'TrackUrl', 'BanFrom', 'BanUntil', 'BanReason', ),
        self::TYPE_CAMELNAME     => array('id', 'role', 'email', 'username', 'password', 'photo', 'firstname', 'lastname', 'gender', 'birthday', 'about', 'params', 'registrationAt', 'registrationIp', 'registrationConfirmed', 'registrationConfirmedAt', 'registrationConfirmedIp', 'registrationConfirmationCode', 'authenticationAt', 'authenticationIp', 'authenticationKey', 'authenticationToken', 'authenticationTokenAt', 'authenticationTokenIp', 'authenticationAttemptCount', 'trackAt', 'trackIp', 'trackUrl', 'banFrom', 'banUntil', 'banReason', ),
        self::TYPE_COLNAME       => array(UserTableMap::COL_ID, UserTableMap::COL_ROLE, UserTableMap::COL_EMAIL, UserTableMap::COL_USERNAME, UserTableMap::COL_PASSWORD, UserTableMap::COL_PHOTO, UserTableMap::COL_FIRSTNAME, UserTableMap::COL_LASTNAME, UserTableMap::COL_GENDER, UserTableMap::COL_BIRTHDAY, UserTableMap::COL_ABOUT, UserTableMap::COL_PARAMS, UserTableMap::COL_REGISTRATION_AT, UserTableMap::COL_REGISTRATION_IP, UserTableMap::COL_REGISTRATION_CONFIRMED, UserTableMap::COL_REGISTRATION_CONFIRMED_AT, UserTableMap::COL_REGISTRATION_CONFIRMED_IP, UserTableMap::COL_REGISTRATION_CONFIRMATION_CODE, UserTableMap::COL_AUTHENTICATION_AT, UserTableMap::COL_AUTHENTICATION_IP, UserTableMap::COL_AUTHENTICATION_KEY, UserTableMap::COL_AUTHENTICATION_TOKEN, UserTableMap::COL_AUTHENTICATION_TOKEN_AT, UserTableMap::COL_AUTHENTICATION_TOKEN_IP, UserTableMap::COL_AUTHENTICATION_ATTEMPT_COUNT, UserTableMap::COL_TRACK_AT, UserTableMap::COL_TRACK_IP, UserTableMap::COL_TRACK_URL, UserTableMap::COL_BAN_FROM, UserTableMap::COL_BAN_UNTIL, UserTableMap::COL_BAN_REASON, ),
        self::TYPE_FIELDNAME     => array('id', 'role', 'email', 'username', 'password', 'photo', 'firstname', 'lastname', 'gender', 'birthday', 'about', 'params', 'registration_at', 'registration_ip', 'registration_confirmed', 'registration_confirmed_at', 'registration_confirmed_ip', 'registration_confirmation_code', 'authentication_at', 'authentication_ip', 'authentication_key', 'authentication_token', 'authentication_token_at', 'authentication_token_ip', 'authentication_attempt_count', 'track_at', 'track_ip', 'track_url', 'ban_from', 'ban_until', 'ban_reason', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Role' => 1, 'Email' => 2, 'Username' => 3, 'Password' => 4, 'Photo' => 5, 'Firstname' => 6, 'Lastname' => 7, 'Gender' => 8, 'Birthday' => 9, 'About' => 10, 'Params' => 11, 'RegistrationAt' => 12, 'RegistrationIp' => 13, 'RegistrationConfirmed' => 14, 'RegistrationConfirmedAt' => 15, 'RegistrationConfirmedIp' => 16, 'RegistrationConfirmationCode' => 17, 'AuthenticationAt' => 18, 'AuthenticationIp' => 19, 'AuthenticationKey' => 20, 'AuthenticationToken' => 21, 'AuthenticationTokenAt' => 22, 'AuthenticationTokenIp' => 23, 'AuthenticationAttemptCount' => 24, 'TrackAt' => 25, 'TrackIp' => 26, 'TrackUrl' => 27, 'BanFrom' => 28, 'BanUntil' => 29, 'BanReason' => 30, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'role' => 1, 'email' => 2, 'username' => 3, 'password' => 4, 'photo' => 5, 'firstname' => 6, 'lastname' => 7, 'gender' => 8, 'birthday' => 9, 'about' => 10, 'params' => 11, 'registrationAt' => 12, 'registrationIp' => 13, 'registrationConfirmed' => 14, 'registrationConfirmedAt' => 15, 'registrationConfirmedIp' => 16, 'registrationConfirmationCode' => 17, 'authenticationAt' => 18, 'authenticationIp' => 19, 'authenticationKey' => 20, 'authenticationToken' => 21, 'authenticationTokenAt' => 22, 'authenticationTokenIp' => 23, 'authenticationAttemptCount' => 24, 'trackAt' => 25, 'trackIp' => 26, 'trackUrl' => 27, 'banFrom' => 28, 'banUntil' => 29, 'banReason' => 30, ),
        self::TYPE_COLNAME       => array(UserTableMap::COL_ID => 0, UserTableMap::COL_ROLE => 1, UserTableMap::COL_EMAIL => 2, UserTableMap::COL_USERNAME => 3, UserTableMap::COL_PASSWORD => 4, UserTableMap::COL_PHOTO => 5, UserTableMap::COL_FIRSTNAME => 6, UserTableMap::COL_LASTNAME => 7, UserTableMap::COL_GENDER => 8, UserTableMap::COL_BIRTHDAY => 9, UserTableMap::COL_ABOUT => 10, UserTableMap::COL_PARAMS => 11, UserTableMap::COL_REGISTRATION_AT => 12, UserTableMap::COL_REGISTRATION_IP => 13, UserTableMap::COL_REGISTRATION_CONFIRMED => 14, UserTableMap::COL_REGISTRATION_CONFIRMED_AT => 15, UserTableMap::COL_REGISTRATION_CONFIRMED_IP => 16, UserTableMap::COL_REGISTRATION_CONFIRMATION_CODE => 17, UserTableMap::COL_AUTHENTICATION_AT => 18, UserTableMap::COL_AUTHENTICATION_IP => 19, UserTableMap::COL_AUTHENTICATION_KEY => 20, UserTableMap::COL_AUTHENTICATION_TOKEN => 21, UserTableMap::COL_AUTHENTICATION_TOKEN_AT => 22, UserTableMap::COL_AUTHENTICATION_TOKEN_IP => 23, UserTableMap::COL_AUTHENTICATION_ATTEMPT_COUNT => 24, UserTableMap::COL_TRACK_AT => 25, UserTableMap::COL_TRACK_IP => 26, UserTableMap::COL_TRACK_URL => 27, UserTableMap::COL_BAN_FROM => 28, UserTableMap::COL_BAN_UNTIL => 29, UserTableMap::COL_BAN_REASON => 30, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'role' => 1, 'email' => 2, 'username' => 3, 'password' => 4, 'photo' => 5, 'firstname' => 6, 'lastname' => 7, 'gender' => 8, 'birthday' => 9, 'about' => 10, 'params' => 11, 'registration_at' => 12, 'registration_ip' => 13, 'registration_confirmed' => 14, 'registration_confirmed_at' => 15, 'registration_confirmed_ip' => 16, 'registration_confirmation_code' => 17, 'authentication_at' => 18, 'authentication_ip' => 19, 'authentication_key' => 20, 'authentication_token' => 21, 'authentication_token_at' => 22, 'authentication_token_ip' => 23, 'authentication_attempt_count' => 24, 'track_at' => 25, 'track_ip' => 26, 'track_url' => 27, 'ban_from' => 28, 'ban_until' => 29, 'ban_reason' => 30, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('fenric_user');
        $this->setPhpName('User');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Propel\\Models\\User');
        $this->setPackage('Propel.Models');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('role', 'Role', 'VARCHAR', true, 64, 'user');
        $this->addColumn('email', 'Email', 'VARCHAR', true, 128, null);
        $this->addColumn('username', 'Username', 'VARCHAR', true, 48, null);
        $this->getColumn('username')->setPrimaryString(true);
        $this->addColumn('password', 'Password', 'VARCHAR', true, 60, null);
        $this->addColumn('photo', 'Photo', 'VARCHAR', false, 255, null);
        $this->addColumn('firstname', 'Firstname', 'VARCHAR', false, 64, null);
        $this->addColumn('lastname', 'Lastname', 'VARCHAR', false, 64, null);
        $this->addColumn('gender', 'Gender', 'VARCHAR', false, 16, null);
        $this->addColumn('birthday', 'Birthday', 'TIMESTAMP', false, null, null);
        $this->addColumn('about', 'About', 'LONGVARCHAR', false, null, null);
        $this->addColumn('params', 'Params', 'LONGVARCHAR', false, null, null);
        $this->addColumn('registration_at', 'RegistrationAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('registration_ip', 'RegistrationIp', 'VARCHAR', false, 45, null);
        $this->addColumn('registration_confirmed', 'RegistrationConfirmed', 'BOOLEAN', false, 1, false);
        $this->addColumn('registration_confirmed_at', 'RegistrationConfirmedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('registration_confirmed_ip', 'RegistrationConfirmedIp', 'VARCHAR', false, 45, null);
        $this->addColumn('registration_confirmation_code', 'RegistrationConfirmationCode', 'VARCHAR', false, 40, null);
        $this->addColumn('authentication_at', 'AuthenticationAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('authentication_ip', 'AuthenticationIp', 'VARCHAR', false, 45, null);
        $this->addColumn('authentication_key', 'AuthenticationKey', 'VARCHAR', false, 255, null);
        $this->addColumn('authentication_token', 'AuthenticationToken', 'VARCHAR', false, 40, null);
        $this->addColumn('authentication_token_at', 'AuthenticationTokenAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('authentication_token_ip', 'AuthenticationTokenIp', 'VARCHAR', false, 45, null);
        $this->addColumn('authentication_attempt_count', 'AuthenticationAttemptCount', 'NUMERIC', false, null, 0);
        $this->addColumn('track_at', 'TrackAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('track_ip', 'TrackIp', 'VARCHAR', false, 45, null);
        $this->addColumn('track_url', 'TrackUrl', 'VARCHAR', false, 255, null);
        $this->addColumn('ban_from', 'BanFrom', 'TIMESTAMP', false, null, null);
        $this->addColumn('ban_until', 'BanUntil', 'TIMESTAMP', false, null, null);
        $this->addColumn('ban_reason', 'BanReason', 'VARCHAR', false, 255, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('BannerRelatedByCreatedBy', '\\Propel\\Models\\Banner', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':created_by',
    1 => ':id',
  ),
), 'SET NULL', 'CASCADE', 'BannersRelatedByCreatedBy', false);
        $this->addRelation('BannerRelatedByUpdatedBy', '\\Propel\\Models\\Banner', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':updated_by',
    1 => ':id',
  ),
), 'SET NULL', 'CASCADE', 'BannersRelatedByUpdatedBy', false);
        $this->addRelation('BannerGroupRelatedByCreatedBy', '\\Propel\\Models\\BannerGroup', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':created_by',
    1 => ':id',
  ),
), 'SET NULL', 'CASCADE', 'BannerGroupsRelatedByCreatedBy', false);
        $this->addRelation('BannerGroupRelatedByUpdatedBy', '\\Propel\\Models\\BannerGroup', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':updated_by',
    1 => ':id',
  ),
), 'SET NULL', 'CASCADE', 'BannerGroupsRelatedByUpdatedBy', false);
        $this->addRelation('BannerClientRelatedByCreatedBy', '\\Propel\\Models\\BannerClient', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':created_by',
    1 => ':id',
  ),
), 'SET NULL', 'CASCADE', 'BannerClientsRelatedByCreatedBy', false);
        $this->addRelation('BannerClientRelatedByUpdatedBy', '\\Propel\\Models\\BannerClient', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':updated_by',
    1 => ':id',
  ),
), 'SET NULL', 'CASCADE', 'BannerClientsRelatedByUpdatedBy', false);
        $this->addRelation('CommentRelatedByCreatedBy', '\\Propel\\Models\\Comment', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':created_by',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'CommentsRelatedByCreatedBy', false);
        $this->addRelation('CommentRelatedByUpdatedBy', '\\Propel\\Models\\Comment', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':updated_by',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'CommentsRelatedByUpdatedBy', false);
        $this->addRelation('CommentRelatedByDeletedBy', '\\Propel\\Models\\Comment', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':deleted_by',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'CommentsRelatedByDeletedBy', false);
        $this->addRelation('CommentRelatedByVerifiedBy', '\\Propel\\Models\\Comment', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':verified_by',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'CommentsRelatedByVerifiedBy', false);
        $this->addRelation('FieldRelatedByCreatedBy', '\\Propel\\Models\\Field', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':created_by',
    1 => ':id',
  ),
), 'SET NULL', 'CASCADE', 'FieldsRelatedByCreatedBy', false);
        $this->addRelation('FieldRelatedByUpdatedBy', '\\Propel\\Models\\Field', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':updated_by',
    1 => ':id',
  ),
), 'SET NULL', 'CASCADE', 'FieldsRelatedByUpdatedBy', false);
        $this->addRelation('PollRelatedByCreatedBy', '\\Propel\\Models\\Poll', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':created_by',
    1 => ':id',
  ),
), 'SET NULL', 'CASCADE', 'PollsRelatedByCreatedBy', false);
        $this->addRelation('PollRelatedByUpdatedBy', '\\Propel\\Models\\Poll', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':updated_by',
    1 => ':id',
  ),
), 'SET NULL', 'CASCADE', 'PollsRelatedByUpdatedBy', false);
        $this->addRelation('PollVariantRelatedByCreatedBy', '\\Propel\\Models\\PollVariant', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':created_by',
    1 => ':id',
  ),
), 'SET NULL', 'CASCADE', 'PollVariantsRelatedByCreatedBy', false);
        $this->addRelation('PollVariantRelatedByUpdatedBy', '\\Propel\\Models\\PollVariant', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':updated_by',
    1 => ':id',
  ),
), 'SET NULL', 'CASCADE', 'PollVariantsRelatedByUpdatedBy', false);
        $this->addRelation('SectionRelatedByCreatedBy', '\\Propel\\Models\\Section', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':created_by',
    1 => ':id',
  ),
), 'SET NULL', 'CASCADE', 'SectionsRelatedByCreatedBy', false);
        $this->addRelation('SectionRelatedByUpdatedBy', '\\Propel\\Models\\Section', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':updated_by',
    1 => ':id',
  ),
), 'SET NULL', 'CASCADE', 'SectionsRelatedByUpdatedBy', false);
        $this->addRelation('PublicationRelatedByCreatedBy', '\\Propel\\Models\\Publication', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':created_by',
    1 => ':id',
  ),
), 'SET NULL', 'CASCADE', 'PublicationsRelatedByCreatedBy', false);
        $this->addRelation('PublicationRelatedByUpdatedBy', '\\Propel\\Models\\Publication', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':updated_by',
    1 => ':id',
  ),
), 'SET NULL', 'CASCADE', 'PublicationsRelatedByUpdatedBy', false);
        $this->addRelation('PublicationPhotoRelatedByCreatedBy', '\\Propel\\Models\\PublicationPhoto', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':created_by',
    1 => ':id',
  ),
), 'SET NULL', 'CASCADE', 'PublicationPhotosRelatedByCreatedBy', false);
        $this->addRelation('PublicationPhotoRelatedByUpdatedBy', '\\Propel\\Models\\PublicationPhoto', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':updated_by',
    1 => ':id',
  ),
), 'SET NULL', 'CASCADE', 'PublicationPhotosRelatedByUpdatedBy', false);
        $this->addRelation('RadioRelatedByCreatedBy', '\\Propel\\Models\\Radio', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':created_by',
    1 => ':id',
  ),
), 'SET NULL', 'CASCADE', 'RadiosRelatedByCreatedBy', false);
        $this->addRelation('RadioRelatedByUpdatedBy', '\\Propel\\Models\\Radio', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':updated_by',
    1 => ':id',
  ),
), 'SET NULL', 'CASCADE', 'RadiosRelatedByUpdatedBy', false);
        $this->addRelation('SnippetRelatedByCreatedBy', '\\Propel\\Models\\Snippet', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':created_by',
    1 => ':id',
  ),
), 'SET NULL', 'CASCADE', 'SnippetsRelatedByCreatedBy', false);
        $this->addRelation('SnippetRelatedByUpdatedBy', '\\Propel\\Models\\Snippet', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':updated_by',
    1 => ':id',
  ),
), 'SET NULL', 'CASCADE', 'SnippetsRelatedByUpdatedBy', false);
        $this->addRelation('TagRelatedByCreatedBy', '\\Propel\\Models\\Tag', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':created_by',
    1 => ':id',
  ),
), 'SET NULL', 'CASCADE', 'TagsRelatedByCreatedBy', false);
        $this->addRelation('TagRelatedByUpdatedBy', '\\Propel\\Models\\Tag', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':updated_by',
    1 => ':id',
  ),
), 'SET NULL', 'CASCADE', 'TagsRelatedByUpdatedBy', false);
        $this->addRelation('UserFavorite', '\\Propel\\Models\\UserFavorite', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':user_id',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'UserFavorites', false);
    } // buildRelations()

    /**
     *
     * Gets the list of behaviors registered for this table
     *
     * @return array Associative array (name => parameters) of behaviors
     */
    public function getBehaviors()
    {
        return array(
            'validate' => array('4905c5f6-35b7-4e44-bff7-640642d90f6e' => array ('column' => 'role','validator' => 'NotBlank','options' => array ('message' => 'Роль не может быть пустой.',),), '39397f77-119a-4c88-8600-31d303e5208d' => array ('column' => 'role','validator' => 'Length','options' => array ('max' => 64,'maxMessage' => 'Максимально допустимая длина роли 64 символа.',),), 'af2a0485-1686-4495-9753-51eda53b9dde' => array ('column' => 'email','validator' => 'NotBlank','options' => array ('message' => 'Электронный адрес не может быть пустым.',),), 'd6144f7d-3f88-4c29-867a-0223ce4b5941' => array ('column' => 'email','validator' => 'Length','options' => array ('max' => 128,'maxMessage' => 'Максимально допустимая длина электронного адреса 128 символов.',),), 'effd5adc-be53-4ff5-a2ae-991715fe0e25' => array ('column' => 'email','validator' => 'Email','options' => array ('message' => 'Некорректный электронный адрес.',),), 'dff955bc-b724-4db5-8345-4a0afe52c446' => array ('column' => 'email','validator' => 'Unique','options' => array ('message' => 'Электронный адрес привязан к другой учетной записи.',),), '0f1d8b9e-586e-475f-846d-5642d7889bf3' => array ('column' => 'username','validator' => 'NotBlank','options' => array ('message' => 'Имя учетной записи не может быть пустым.',),), '66de4cd0-e428-4ff2-939a-9d7e499604eb' => array ('column' => 'username','validator' => 'Length','options' => array ('min' => 2,'max' => 48,'minMessage' => 'Минимально возможная длина имени учетной записи 2 символа.','maxMessage' => 'Максимально допустимая длина имени учетной записи 48 символов.',),), 'a391d8b6-7b27-4f7a-a4c3-9c23dd1c4b43' => array ('column' => 'username','validator' => 'Regex','options' => array ('pattern' => '/^[a-zA-Z0-9]+$/','message' => 'Имя учетной записи должно состоять только из букв английского алфавита и арабских цифр.',),), 'bd1544af-f1b3-4be0-b1c9-53c39da12763' => array ('column' => 'username','validator' => 'Unique','options' => array ('message' => 'Имя учетной записи закреплено за другой учетной записью.',),), '6340bbf4-4754-47b8-bb7d-14e569f6ef77' => array ('column' => 'password','validator' => 'NotBlank','options' => array ('message' => 'Пароль не может быть пустым.',),), 'bc8f3a10-55a1-4081-8112-300abdd78a1d' => array ('column' => 'password','validator' => 'Length','options' => array ('min' => 6,'max' => 256,'minMessage' => 'Минимально возможная длина пароля 6 символов.','maxMessage' => 'Максимально допустимая длина пароля 256 символов.',),), ),
            'Fenric\Propel\Behaviors\Eventable' => array(),
        );
    } // getBehaviors()
    /**
     * Method to invalidate the instance pool of all tables related to fenric_user     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        BannerTableMap::clearInstancePool();
        BannerGroupTableMap::clearInstancePool();
        BannerClientTableMap::clearInstancePool();
        CommentTableMap::clearInstancePool();
        FieldTableMap::clearInstancePool();
        PollTableMap::clearInstancePool();
        PollVariantTableMap::clearInstancePool();
        SectionTableMap::clearInstancePool();
        PublicationTableMap::clearInstancePool();
        PublicationPhotoTableMap::clearInstancePool();
        RadioTableMap::clearInstancePool();
        SnippetTableMap::clearInstancePool();
        TagTableMap::clearInstancePool();
        UserFavoriteTableMap::clearInstancePool();
    }

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? UserTableMap::CLASS_DEFAULT : UserTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (User object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = UserTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = UserTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + UserTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = UserTableMap::OM_CLASS;
            /** @var User $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            UserTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = UserTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = UserTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var User $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                UserTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(UserTableMap::COL_ID);
            $criteria->addSelectColumn(UserTableMap::COL_ROLE);
            $criteria->addSelectColumn(UserTableMap::COL_EMAIL);
            $criteria->addSelectColumn(UserTableMap::COL_USERNAME);
            $criteria->addSelectColumn(UserTableMap::COL_PHOTO);
            $criteria->addSelectColumn(UserTableMap::COL_FIRSTNAME);
            $criteria->addSelectColumn(UserTableMap::COL_LASTNAME);
            $criteria->addSelectColumn(UserTableMap::COL_GENDER);
            $criteria->addSelectColumn(UserTableMap::COL_BIRTHDAY);
            $criteria->addSelectColumn(UserTableMap::COL_REGISTRATION_AT);
            $criteria->addSelectColumn(UserTableMap::COL_REGISTRATION_IP);
            $criteria->addSelectColumn(UserTableMap::COL_REGISTRATION_CONFIRMED);
            $criteria->addSelectColumn(UserTableMap::COL_REGISTRATION_CONFIRMED_AT);
            $criteria->addSelectColumn(UserTableMap::COL_REGISTRATION_CONFIRMED_IP);
            $criteria->addSelectColumn(UserTableMap::COL_AUTHENTICATION_AT);
            $criteria->addSelectColumn(UserTableMap::COL_AUTHENTICATION_IP);
            $criteria->addSelectColumn(UserTableMap::COL_AUTHENTICATION_TOKEN_AT);
            $criteria->addSelectColumn(UserTableMap::COL_AUTHENTICATION_TOKEN_IP);
            $criteria->addSelectColumn(UserTableMap::COL_AUTHENTICATION_ATTEMPT_COUNT);
            $criteria->addSelectColumn(UserTableMap::COL_TRACK_AT);
            $criteria->addSelectColumn(UserTableMap::COL_TRACK_IP);
            $criteria->addSelectColumn(UserTableMap::COL_TRACK_URL);
            $criteria->addSelectColumn(UserTableMap::COL_BAN_FROM);
            $criteria->addSelectColumn(UserTableMap::COL_BAN_UNTIL);
            $criteria->addSelectColumn(UserTableMap::COL_BAN_REASON);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.role');
            $criteria->addSelectColumn($alias . '.email');
            $criteria->addSelectColumn($alias . '.username');
            $criteria->addSelectColumn($alias . '.photo');
            $criteria->addSelectColumn($alias . '.firstname');
            $criteria->addSelectColumn($alias . '.lastname');
            $criteria->addSelectColumn($alias . '.gender');
            $criteria->addSelectColumn($alias . '.birthday');
            $criteria->addSelectColumn($alias . '.registration_at');
            $criteria->addSelectColumn($alias . '.registration_ip');
            $criteria->addSelectColumn($alias . '.registration_confirmed');
            $criteria->addSelectColumn($alias . '.registration_confirmed_at');
            $criteria->addSelectColumn($alias . '.registration_confirmed_ip');
            $criteria->addSelectColumn($alias . '.authentication_at');
            $criteria->addSelectColumn($alias . '.authentication_ip');
            $criteria->addSelectColumn($alias . '.authentication_token_at');
            $criteria->addSelectColumn($alias . '.authentication_token_ip');
            $criteria->addSelectColumn($alias . '.authentication_attempt_count');
            $criteria->addSelectColumn($alias . '.track_at');
            $criteria->addSelectColumn($alias . '.track_ip');
            $criteria->addSelectColumn($alias . '.track_url');
            $criteria->addSelectColumn($alias . '.ban_from');
            $criteria->addSelectColumn($alias . '.ban_until');
            $criteria->addSelectColumn($alias . '.ban_reason');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(UserTableMap::DATABASE_NAME)->getTable(UserTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(UserTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(UserTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new UserTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a User or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or User object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Propel\Models\User) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(UserTableMap::DATABASE_NAME);
            $criteria->add(UserTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = UserQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            UserTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                UserTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the fenric_user table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return UserQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a User or Criteria object.
     *
     * @param mixed               $criteria Criteria or User object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from User object
        }

        if ($criteria->containsKey(UserTableMap::COL_ID) && $criteria->keyContainsValue(UserTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.UserTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = UserQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // UserTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
UserTableMap::buildTableMap();
