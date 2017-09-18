<?php

namespace Propel\Models\Map;

use Propel\Models\Tag;
use Propel\Models\TagQuery;
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
 * This class defines the structure of the 'tag' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class TagTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Propel.Models.Map.TagTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'tag';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Propel\\Models\\Tag';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Propel.Models.Tag';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 14;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 1;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 13;

    /**
     * the column name for the id field
     */
    const COL_ID = 'tag.id';

    /**
     * the column name for the code field
     */
    const COL_CODE = 'tag.code';

    /**
     * the column name for the header field
     */
    const COL_HEADER = 'tag.header';

    /**
     * the column name for the content field
     */
    const COL_CONTENT = 'tag.content';

    /**
     * the column name for the meta_title field
     */
    const COL_META_TITLE = 'tag.meta_title';

    /**
     * the column name for the meta_author field
     */
    const COL_META_AUTHOR = 'tag.meta_author';

    /**
     * the column name for the meta_keywords field
     */
    const COL_META_KEYWORDS = 'tag.meta_keywords';

    /**
     * the column name for the meta_description field
     */
    const COL_META_DESCRIPTION = 'tag.meta_description';

    /**
     * the column name for the meta_canonical field
     */
    const COL_META_CANONICAL = 'tag.meta_canonical';

    /**
     * the column name for the meta_robots field
     */
    const COL_META_ROBOTS = 'tag.meta_robots';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'tag.created_at';

    /**
     * the column name for the created_by field
     */
    const COL_CREATED_BY = 'tag.created_by';

    /**
     * the column name for the updated_at field
     */
    const COL_UPDATED_AT = 'tag.updated_at';

    /**
     * the column name for the updated_by field
     */
    const COL_UPDATED_BY = 'tag.updated_by';

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
        self::TYPE_PHPNAME       => array('Id', 'Code', 'Header', 'Content', 'MetaTitle', 'MetaAuthor', 'MetaKeywords', 'MetaDescription', 'MetaCanonical', 'MetaRobots', 'CreatedAt', 'CreatedBy', 'UpdatedAt', 'UpdatedBy', ),
        self::TYPE_CAMELNAME     => array('id', 'code', 'header', 'content', 'metaTitle', 'metaAuthor', 'metaKeywords', 'metaDescription', 'metaCanonical', 'metaRobots', 'createdAt', 'createdBy', 'updatedAt', 'updatedBy', ),
        self::TYPE_COLNAME       => array(TagTableMap::COL_ID, TagTableMap::COL_CODE, TagTableMap::COL_HEADER, TagTableMap::COL_CONTENT, TagTableMap::COL_META_TITLE, TagTableMap::COL_META_AUTHOR, TagTableMap::COL_META_KEYWORDS, TagTableMap::COL_META_DESCRIPTION, TagTableMap::COL_META_CANONICAL, TagTableMap::COL_META_ROBOTS, TagTableMap::COL_CREATED_AT, TagTableMap::COL_CREATED_BY, TagTableMap::COL_UPDATED_AT, TagTableMap::COL_UPDATED_BY, ),
        self::TYPE_FIELDNAME     => array('id', 'code', 'header', 'content', 'meta_title', 'meta_author', 'meta_keywords', 'meta_description', 'meta_canonical', 'meta_robots', 'created_at', 'created_by', 'updated_at', 'updated_by', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Code' => 1, 'Header' => 2, 'Content' => 3, 'MetaTitle' => 4, 'MetaAuthor' => 5, 'MetaKeywords' => 6, 'MetaDescription' => 7, 'MetaCanonical' => 8, 'MetaRobots' => 9, 'CreatedAt' => 10, 'CreatedBy' => 11, 'UpdatedAt' => 12, 'UpdatedBy' => 13, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'code' => 1, 'header' => 2, 'content' => 3, 'metaTitle' => 4, 'metaAuthor' => 5, 'metaKeywords' => 6, 'metaDescription' => 7, 'metaCanonical' => 8, 'metaRobots' => 9, 'createdAt' => 10, 'createdBy' => 11, 'updatedAt' => 12, 'updatedBy' => 13, ),
        self::TYPE_COLNAME       => array(TagTableMap::COL_ID => 0, TagTableMap::COL_CODE => 1, TagTableMap::COL_HEADER => 2, TagTableMap::COL_CONTENT => 3, TagTableMap::COL_META_TITLE => 4, TagTableMap::COL_META_AUTHOR => 5, TagTableMap::COL_META_KEYWORDS => 6, TagTableMap::COL_META_DESCRIPTION => 7, TagTableMap::COL_META_CANONICAL => 8, TagTableMap::COL_META_ROBOTS => 9, TagTableMap::COL_CREATED_AT => 10, TagTableMap::COL_CREATED_BY => 11, TagTableMap::COL_UPDATED_AT => 12, TagTableMap::COL_UPDATED_BY => 13, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'code' => 1, 'header' => 2, 'content' => 3, 'meta_title' => 4, 'meta_author' => 5, 'meta_keywords' => 6, 'meta_description' => 7, 'meta_canonical' => 8, 'meta_robots' => 9, 'created_at' => 10, 'created_by' => 11, 'updated_at' => 12, 'updated_by' => 13, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, )
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
        $this->setName('tag');
        $this->setPhpName('Tag');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Propel\\Models\\Tag');
        $this->setPackage('Propel.Models');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('code', 'Code', 'VARCHAR', true, 255, null);
        $this->addColumn('header', 'Header', 'VARCHAR', true, 255, null);
        $this->getColumn('header')->setPrimaryString(true);
        $this->addColumn('content', 'Content', 'LONGVARCHAR', false, null, null);
        $this->addColumn('meta_title', 'MetaTitle', 'VARCHAR', false, 255, null);
        $this->addColumn('meta_author', 'MetaAuthor', 'VARCHAR', false, 255, null);
        $this->addColumn('meta_keywords', 'MetaKeywords', 'VARCHAR', false, 255, null);
        $this->addColumn('meta_description', 'MetaDescription', 'VARCHAR', false, 255, null);
        $this->addColumn('meta_canonical', 'MetaCanonical', 'VARCHAR', false, 255, null);
        $this->addColumn('meta_robots', 'MetaRobots', 'VARCHAR', false, 255, null);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addForeignKey('created_by', 'CreatedBy', 'INTEGER', 'user', 'id', false, null, null);
        $this->addColumn('updated_at', 'UpdatedAt', 'TIMESTAMP', false, null, null);
        $this->addForeignKey('updated_by', 'UpdatedBy', 'INTEGER', 'user', 'id', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
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
        $this->addRelation('PublicationTag', '\\Propel\\Models\\PublicationTag', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':tag_id',
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
            'validate' => array('269881de-eb0a-4c8a-aae9-f842cbb64f27' => array ('column' => 'code','validator' => 'NotBlank',), 'bab9e053-b39e-40f1-9d3e-0f61c95f48b5' => array ('column' => 'code','validator' => 'Length','options' => array ('max' => 255,),), 'd24970a2-4e2e-4335-91f0-e84dbec8e782' => array ('column' => 'code','validator' => 'Regex','options' => array ('pattern' => '/^[a-z0-9-]+$/',),), '56334d18-e8be-4eb1-8a49-36e3471e5d2e' => array ('column' => 'code','validator' => 'Unique',), '5dd01197-843e-48c9-a637-67703bd4c230' => array ('column' => 'header','validator' => 'NotBlank',), 'a8224fe8-8e25-445d-8af4-0d00e361c89f' => array ('column' => 'header','validator' => 'Length','options' => array ('max' => 255,),), ),
        );
    } // getBehaviors()
    /**
     * Method to invalidate the instance pool of all tables related to tag     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
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
        return $withPrefix ? TagTableMap::CLASS_DEFAULT : TagTableMap::OM_CLASS;
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
     * @return array           (Tag object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = TagTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = TagTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + TagTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = TagTableMap::OM_CLASS;
            /** @var Tag $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            TagTableMap::addInstanceToPool($obj, $key);
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
            $key = TagTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = TagTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Tag $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                TagTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(TagTableMap::COL_ID);
            $criteria->addSelectColumn(TagTableMap::COL_CODE);
            $criteria->addSelectColumn(TagTableMap::COL_HEADER);
            $criteria->addSelectColumn(TagTableMap::COL_META_TITLE);
            $criteria->addSelectColumn(TagTableMap::COL_META_AUTHOR);
            $criteria->addSelectColumn(TagTableMap::COL_META_KEYWORDS);
            $criteria->addSelectColumn(TagTableMap::COL_META_DESCRIPTION);
            $criteria->addSelectColumn(TagTableMap::COL_META_CANONICAL);
            $criteria->addSelectColumn(TagTableMap::COL_META_ROBOTS);
            $criteria->addSelectColumn(TagTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(TagTableMap::COL_CREATED_BY);
            $criteria->addSelectColumn(TagTableMap::COL_UPDATED_AT);
            $criteria->addSelectColumn(TagTableMap::COL_UPDATED_BY);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.code');
            $criteria->addSelectColumn($alias . '.header');
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
        return Propel::getServiceContainer()->getDatabaseMap(TagTableMap::DATABASE_NAME)->getTable(TagTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(TagTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(TagTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new TagTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Tag or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Tag object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(TagTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Propel\Models\Tag) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(TagTableMap::DATABASE_NAME);
            $criteria->add(TagTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = TagQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            TagTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                TagTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the tag table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return TagQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Tag or Criteria object.
     *
     * @param mixed               $criteria Criteria or Tag object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TagTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Tag object
        }

        if ($criteria->containsKey(TagTableMap::COL_ID) && $criteria->keyContainsValue(TagTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.TagTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = TagQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // TagTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
TagTableMap::buildTableMap();
