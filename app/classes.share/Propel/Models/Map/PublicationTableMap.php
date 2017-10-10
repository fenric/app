<?php

namespace Propel\Models\Map;

use Propel\Models\Publication;
use Propel\Models\PublicationQuery;
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
 * This class defines the structure of the 'fenric_publication' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class PublicationTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Propel.Models.Map.PublicationTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'fenric_publication';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Propel\\Models\\Publication';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Propel.Models.Publication';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 21;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 1;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 20;

    /**
     * the column name for the id field
     */
    const COL_ID = 'fenric_publication.id';

    /**
     * the column name for the section_id field
     */
    const COL_SECTION_ID = 'fenric_publication.section_id';

    /**
     * the column name for the code field
     */
    const COL_CODE = 'fenric_publication.code';

    /**
     * the column name for the header field
     */
    const COL_HEADER = 'fenric_publication.header';

    /**
     * the column name for the picture field
     */
    const COL_PICTURE = 'fenric_publication.picture';

    /**
     * the column name for the picture_signature field
     */
    const COL_PICTURE_SIGNATURE = 'fenric_publication.picture_signature';

    /**
     * the column name for the anons field
     */
    const COL_ANONS = 'fenric_publication.anons';

    /**
     * the column name for the content field
     */
    const COL_CONTENT = 'fenric_publication.content';

    /**
     * the column name for the meta_title field
     */
    const COL_META_TITLE = 'fenric_publication.meta_title';

    /**
     * the column name for the meta_author field
     */
    const COL_META_AUTHOR = 'fenric_publication.meta_author';

    /**
     * the column name for the meta_keywords field
     */
    const COL_META_KEYWORDS = 'fenric_publication.meta_keywords';

    /**
     * the column name for the meta_description field
     */
    const COL_META_DESCRIPTION = 'fenric_publication.meta_description';

    /**
     * the column name for the meta_canonical field
     */
    const COL_META_CANONICAL = 'fenric_publication.meta_canonical';

    /**
     * the column name for the meta_robots field
     */
    const COL_META_ROBOTS = 'fenric_publication.meta_robots';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'fenric_publication.created_at';

    /**
     * the column name for the created_by field
     */
    const COL_CREATED_BY = 'fenric_publication.created_by';

    /**
     * the column name for the updated_at field
     */
    const COL_UPDATED_AT = 'fenric_publication.updated_at';

    /**
     * the column name for the updated_by field
     */
    const COL_UPDATED_BY = 'fenric_publication.updated_by';

    /**
     * the column name for the show_at field
     */
    const COL_SHOW_AT = 'fenric_publication.show_at';

    /**
     * the column name for the hide_at field
     */
    const COL_HIDE_AT = 'fenric_publication.hide_at';

    /**
     * the column name for the hits field
     */
    const COL_HITS = 'fenric_publication.hits';

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
        self::TYPE_PHPNAME       => array('Id', 'SectionId', 'Code', 'Header', 'Picture', 'PictureSignature', 'Anons', 'Content', 'MetaTitle', 'MetaAuthor', 'MetaKeywords', 'MetaDescription', 'MetaCanonical', 'MetaRobots', 'CreatedAt', 'CreatedBy', 'UpdatedAt', 'UpdatedBy', 'ShowAt', 'HideAt', 'Hits', ),
        self::TYPE_CAMELNAME     => array('id', 'sectionId', 'code', 'header', 'picture', 'pictureSignature', 'anons', 'content', 'metaTitle', 'metaAuthor', 'metaKeywords', 'metaDescription', 'metaCanonical', 'metaRobots', 'createdAt', 'createdBy', 'updatedAt', 'updatedBy', 'showAt', 'hideAt', 'hits', ),
        self::TYPE_COLNAME       => array(PublicationTableMap::COL_ID, PublicationTableMap::COL_SECTION_ID, PublicationTableMap::COL_CODE, PublicationTableMap::COL_HEADER, PublicationTableMap::COL_PICTURE, PublicationTableMap::COL_PICTURE_SIGNATURE, PublicationTableMap::COL_ANONS, PublicationTableMap::COL_CONTENT, PublicationTableMap::COL_META_TITLE, PublicationTableMap::COL_META_AUTHOR, PublicationTableMap::COL_META_KEYWORDS, PublicationTableMap::COL_META_DESCRIPTION, PublicationTableMap::COL_META_CANONICAL, PublicationTableMap::COL_META_ROBOTS, PublicationTableMap::COL_CREATED_AT, PublicationTableMap::COL_CREATED_BY, PublicationTableMap::COL_UPDATED_AT, PublicationTableMap::COL_UPDATED_BY, PublicationTableMap::COL_SHOW_AT, PublicationTableMap::COL_HIDE_AT, PublicationTableMap::COL_HITS, ),
        self::TYPE_FIELDNAME     => array('id', 'section_id', 'code', 'header', 'picture', 'picture_signature', 'anons', 'content', 'meta_title', 'meta_author', 'meta_keywords', 'meta_description', 'meta_canonical', 'meta_robots', 'created_at', 'created_by', 'updated_at', 'updated_by', 'show_at', 'hide_at', 'hits', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'SectionId' => 1, 'Code' => 2, 'Header' => 3, 'Picture' => 4, 'PictureSignature' => 5, 'Anons' => 6, 'Content' => 7, 'MetaTitle' => 8, 'MetaAuthor' => 9, 'MetaKeywords' => 10, 'MetaDescription' => 11, 'MetaCanonical' => 12, 'MetaRobots' => 13, 'CreatedAt' => 14, 'CreatedBy' => 15, 'UpdatedAt' => 16, 'UpdatedBy' => 17, 'ShowAt' => 18, 'HideAt' => 19, 'Hits' => 20, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'sectionId' => 1, 'code' => 2, 'header' => 3, 'picture' => 4, 'pictureSignature' => 5, 'anons' => 6, 'content' => 7, 'metaTitle' => 8, 'metaAuthor' => 9, 'metaKeywords' => 10, 'metaDescription' => 11, 'metaCanonical' => 12, 'metaRobots' => 13, 'createdAt' => 14, 'createdBy' => 15, 'updatedAt' => 16, 'updatedBy' => 17, 'showAt' => 18, 'hideAt' => 19, 'hits' => 20, ),
        self::TYPE_COLNAME       => array(PublicationTableMap::COL_ID => 0, PublicationTableMap::COL_SECTION_ID => 1, PublicationTableMap::COL_CODE => 2, PublicationTableMap::COL_HEADER => 3, PublicationTableMap::COL_PICTURE => 4, PublicationTableMap::COL_PICTURE_SIGNATURE => 5, PublicationTableMap::COL_ANONS => 6, PublicationTableMap::COL_CONTENT => 7, PublicationTableMap::COL_META_TITLE => 8, PublicationTableMap::COL_META_AUTHOR => 9, PublicationTableMap::COL_META_KEYWORDS => 10, PublicationTableMap::COL_META_DESCRIPTION => 11, PublicationTableMap::COL_META_CANONICAL => 12, PublicationTableMap::COL_META_ROBOTS => 13, PublicationTableMap::COL_CREATED_AT => 14, PublicationTableMap::COL_CREATED_BY => 15, PublicationTableMap::COL_UPDATED_AT => 16, PublicationTableMap::COL_UPDATED_BY => 17, PublicationTableMap::COL_SHOW_AT => 18, PublicationTableMap::COL_HIDE_AT => 19, PublicationTableMap::COL_HITS => 20, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'section_id' => 1, 'code' => 2, 'header' => 3, 'picture' => 4, 'picture_signature' => 5, 'anons' => 6, 'content' => 7, 'meta_title' => 8, 'meta_author' => 9, 'meta_keywords' => 10, 'meta_description' => 11, 'meta_canonical' => 12, 'meta_robots' => 13, 'created_at' => 14, 'created_by' => 15, 'updated_at' => 16, 'updated_by' => 17, 'show_at' => 18, 'hide_at' => 19, 'hits' => 20, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, )
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
        $this->setName('fenric_publication');
        $this->setPhpName('Publication');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Propel\\Models\\Publication');
        $this->setPackage('Propel.Models');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('section_id', 'SectionId', 'INTEGER', 'fenric_section', 'id', false, null, null);
        $this->addColumn('code', 'Code', 'VARCHAR', true, 255, null);
        $this->addColumn('header', 'Header', 'VARCHAR', true, 255, null);
        $this->getColumn('header')->setPrimaryString(true);
        $this->addColumn('picture', 'Picture', 'VARCHAR', false, 255, null);
        $this->addColumn('picture_signature', 'PictureSignature', 'VARCHAR', false, 255, null);
        $this->addColumn('anons', 'Anons', 'LONGVARCHAR', true, null, null);
        $this->addColumn('content', 'Content', 'LONGVARCHAR', false, null, null);
        $this->addColumn('meta_title', 'MetaTitle', 'VARCHAR', false, 255, null);
        $this->addColumn('meta_author', 'MetaAuthor', 'VARCHAR', false, 255, null);
        $this->addColumn('meta_keywords', 'MetaKeywords', 'VARCHAR', false, 255, null);
        $this->addColumn('meta_description', 'MetaDescription', 'VARCHAR', false, 255, null);
        $this->addColumn('meta_canonical', 'MetaCanonical', 'VARCHAR', false, 255, null);
        $this->addColumn('meta_robots', 'MetaRobots', 'VARCHAR', false, 255, null);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addForeignKey('created_by', 'CreatedBy', 'INTEGER', 'fenric_user', 'id', false, null, null);
        $this->addColumn('updated_at', 'UpdatedAt', 'TIMESTAMP', false, null, null);
        $this->addForeignKey('updated_by', 'UpdatedBy', 'INTEGER', 'fenric_user', 'id', false, null, null);
        $this->addColumn('show_at', 'ShowAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('hide_at', 'HideAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('hits', 'Hits', 'NUMERIC', false, null, 0);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Section', '\\Propel\\Models\\Section', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':section_id',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', null, false);
        $this->addRelation('UserRelatedByCreatedBy', '\\Propel\\Models\\User', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':created_by',
    1 => ':id',
  ),
), 'SET NULL', 'CASCADE', null, false);
        $this->addRelation('UserRelatedByUpdatedBy', '\\Propel\\Models\\User', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':updated_by',
    1 => ':id',
  ),
), 'SET NULL', 'CASCADE', null, false);
        $this->addRelation('PublicationField', '\\Propel\\Models\\PublicationField', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':publication_id',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'PublicationFields', false);
        $this->addRelation('PublicationPhoto', '\\Propel\\Models\\PublicationPhoto', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':publication_id',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'PublicationPhotos', false);
        $this->addRelation('PublicationRelation', '\\Propel\\Models\\PublicationRelation', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':publication_id',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'PublicationRelations', false);
        $this->addRelation('PublicationTag', '\\Propel\\Models\\PublicationTag', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':publication_id',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'PublicationTags', false);
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
            'Fenric\Propel\Behaviors\Authorable' => array('create_enable' => 'true', 'create_column' => 'created_by', 'update_enable' => 'true', 'update_column' => 'updated_by', ),
            'Fenric\Propel\Behaviors\Timestampable' => array('create_enable' => 'true', 'create_column' => 'created_at', 'update_enable' => 'true', 'update_column' => 'updated_at', ),
            'validate' => array('afc9cd67-3404-433d-a31c-64f70667e860' => array ('column' => 'section_id','validator' => 'NotBlank',), '6551e8ac-ba0e-437d-8119-383d1416b2be' => array ('column' => 'code','validator' => 'NotBlank',), 'f77ae358-102a-4463-ac6d-6c272fbf1436' => array ('column' => 'code','validator' => 'Length','options' => array ('max' => 255,),), 'ee29298c-b48b-439f-9092-bee3a5413621' => array ('column' => 'code','validator' => 'Regex','options' => array ('pattern' => '/^[a-z0-9-]+$/',),), 'bf904dba-1e43-4acb-b264-65780e592451' => array ('column' => 'code','validator' => 'Unique',), 'b0f5c375-4f19-46e8-ac86-6ff4155ea81b' => array ('column' => 'header','validator' => 'NotBlank',), '9402ba43-e119-42bb-b8ca-2a0222cdbabd' => array ('column' => 'header','validator' => 'Length','options' => array ('max' => 255,),), '23b4a998-69ea-4678-894d-709f8b90b9d3' => array ('column' => 'anons','validator' => 'NotBlank',), '5d9cda19-883c-42a0-a755-8bfe9b72e34b' => array ('column' => 'show_at','validator' => 'NotBlank',), '24158573-10ca-4ff3-8dee-588f2ade0cec' => array ('column' => 'show_at','validator' => 'Date',), '4c2760cf-8773-4747-a3e6-52f9fd5d9e60' => array ('column' => 'hide_at','validator' => 'Date',), ),
        );
    } // getBehaviors()
    /**
     * Method to invalidate the instance pool of all tables related to fenric_publication     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        PublicationFieldTableMap::clearInstancePool();
        PublicationPhotoTableMap::clearInstancePool();
        PublicationRelationTableMap::clearInstancePool();
        PublicationTagTableMap::clearInstancePool();
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
        return $withPrefix ? PublicationTableMap::CLASS_DEFAULT : PublicationTableMap::OM_CLASS;
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
     * @return array           (Publication object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = PublicationTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = PublicationTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + PublicationTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PublicationTableMap::OM_CLASS;
            /** @var Publication $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            PublicationTableMap::addInstanceToPool($obj, $key);
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
            $key = PublicationTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = PublicationTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Publication $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                PublicationTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(PublicationTableMap::COL_ID);
            $criteria->addSelectColumn(PublicationTableMap::COL_SECTION_ID);
            $criteria->addSelectColumn(PublicationTableMap::COL_CODE);
            $criteria->addSelectColumn(PublicationTableMap::COL_HEADER);
            $criteria->addSelectColumn(PublicationTableMap::COL_PICTURE);
            $criteria->addSelectColumn(PublicationTableMap::COL_PICTURE_SIGNATURE);
            $criteria->addSelectColumn(PublicationTableMap::COL_ANONS);
            $criteria->addSelectColumn(PublicationTableMap::COL_META_TITLE);
            $criteria->addSelectColumn(PublicationTableMap::COL_META_AUTHOR);
            $criteria->addSelectColumn(PublicationTableMap::COL_META_KEYWORDS);
            $criteria->addSelectColumn(PublicationTableMap::COL_META_DESCRIPTION);
            $criteria->addSelectColumn(PublicationTableMap::COL_META_CANONICAL);
            $criteria->addSelectColumn(PublicationTableMap::COL_META_ROBOTS);
            $criteria->addSelectColumn(PublicationTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(PublicationTableMap::COL_CREATED_BY);
            $criteria->addSelectColumn(PublicationTableMap::COL_UPDATED_AT);
            $criteria->addSelectColumn(PublicationTableMap::COL_UPDATED_BY);
            $criteria->addSelectColumn(PublicationTableMap::COL_SHOW_AT);
            $criteria->addSelectColumn(PublicationTableMap::COL_HIDE_AT);
            $criteria->addSelectColumn(PublicationTableMap::COL_HITS);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.section_id');
            $criteria->addSelectColumn($alias . '.code');
            $criteria->addSelectColumn($alias . '.header');
            $criteria->addSelectColumn($alias . '.picture');
            $criteria->addSelectColumn($alias . '.picture_signature');
            $criteria->addSelectColumn($alias . '.anons');
            $criteria->addSelectColumn($alias . '.meta_title');
            $criteria->addSelectColumn($alias . '.meta_author');
            $criteria->addSelectColumn($alias . '.meta_keywords');
            $criteria->addSelectColumn($alias . '.meta_description');
            $criteria->addSelectColumn($alias . '.meta_canonical');
            $criteria->addSelectColumn($alias . '.meta_robots');
            $criteria->addSelectColumn($alias . '.created_at');
            $criteria->addSelectColumn($alias . '.created_by');
            $criteria->addSelectColumn($alias . '.updated_at');
            $criteria->addSelectColumn($alias . '.updated_by');
            $criteria->addSelectColumn($alias . '.show_at');
            $criteria->addSelectColumn($alias . '.hide_at');
            $criteria->addSelectColumn($alias . '.hits');
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
        return Propel::getServiceContainer()->getDatabaseMap(PublicationTableMap::DATABASE_NAME)->getTable(PublicationTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(PublicationTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(PublicationTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new PublicationTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Publication or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Publication object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(PublicationTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Propel\Models\Publication) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PublicationTableMap::DATABASE_NAME);
            $criteria->add(PublicationTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = PublicationQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            PublicationTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                PublicationTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the fenric_publication table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return PublicationQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Publication or Criteria object.
     *
     * @param mixed               $criteria Criteria or Publication object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PublicationTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Publication object
        }

        if ($criteria->containsKey(PublicationTableMap::COL_ID) && $criteria->keyContainsValue(PublicationTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.PublicationTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = PublicationQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // PublicationTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
PublicationTableMap::buildTableMap();
