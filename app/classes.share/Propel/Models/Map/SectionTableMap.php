<?php

namespace Propel\Models\Map;

use Propel\Models\Section;
use Propel\Models\SectionQuery;
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
 * This class defines the structure of the 'fenric_section' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class SectionTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Propel.Models.Map.SectionTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'fenric_section';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Propel\\Models\\Section';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Propel.Models.Section';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 16;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 1;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 15;

    /**
     * the column name for the id field
     */
    const COL_ID = 'fenric_section.id';

    /**
     * the column name for the parent_id field
     */
    const COL_PARENT_ID = 'fenric_section.parent_id';

    /**
     * the column name for the code field
     */
    const COL_CODE = 'fenric_section.code';

    /**
     * the column name for the header field
     */
    const COL_HEADER = 'fenric_section.header';

    /**
     * the column name for the picture field
     */
    const COL_PICTURE = 'fenric_section.picture';

    /**
     * the column name for the content field
     */
    const COL_CONTENT = 'fenric_section.content';

    /**
     * the column name for the meta_title field
     */
    const COL_META_TITLE = 'fenric_section.meta_title';

    /**
     * the column name for the meta_author field
     */
    const COL_META_AUTHOR = 'fenric_section.meta_author';

    /**
     * the column name for the meta_keywords field
     */
    const COL_META_KEYWORDS = 'fenric_section.meta_keywords';

    /**
     * the column name for the meta_description field
     */
    const COL_META_DESCRIPTION = 'fenric_section.meta_description';

    /**
     * the column name for the meta_canonical field
     */
    const COL_META_CANONICAL = 'fenric_section.meta_canonical';

    /**
     * the column name for the meta_robots field
     */
    const COL_META_ROBOTS = 'fenric_section.meta_robots';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'fenric_section.created_at';

    /**
     * the column name for the created_by field
     */
    const COL_CREATED_BY = 'fenric_section.created_by';

    /**
     * the column name for the updated_at field
     */
    const COL_UPDATED_AT = 'fenric_section.updated_at';

    /**
     * the column name for the updated_by field
     */
    const COL_UPDATED_BY = 'fenric_section.updated_by';

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
        self::TYPE_PHPNAME       => array('Id', 'ParentId', 'Code', 'Header', 'Picture', 'Content', 'MetaTitle', 'MetaAuthor', 'MetaKeywords', 'MetaDescription', 'MetaCanonical', 'MetaRobots', 'CreatedAt', 'CreatedBy', 'UpdatedAt', 'UpdatedBy', ),
        self::TYPE_CAMELNAME     => array('id', 'parentId', 'code', 'header', 'picture', 'content', 'metaTitle', 'metaAuthor', 'metaKeywords', 'metaDescription', 'metaCanonical', 'metaRobots', 'createdAt', 'createdBy', 'updatedAt', 'updatedBy', ),
        self::TYPE_COLNAME       => array(SectionTableMap::COL_ID, SectionTableMap::COL_PARENT_ID, SectionTableMap::COL_CODE, SectionTableMap::COL_HEADER, SectionTableMap::COL_PICTURE, SectionTableMap::COL_CONTENT, SectionTableMap::COL_META_TITLE, SectionTableMap::COL_META_AUTHOR, SectionTableMap::COL_META_KEYWORDS, SectionTableMap::COL_META_DESCRIPTION, SectionTableMap::COL_META_CANONICAL, SectionTableMap::COL_META_ROBOTS, SectionTableMap::COL_CREATED_AT, SectionTableMap::COL_CREATED_BY, SectionTableMap::COL_UPDATED_AT, SectionTableMap::COL_UPDATED_BY, ),
        self::TYPE_FIELDNAME     => array('id', 'parent_id', 'code', 'header', 'picture', 'content', 'meta_title', 'meta_author', 'meta_keywords', 'meta_description', 'meta_canonical', 'meta_robots', 'created_at', 'created_by', 'updated_at', 'updated_by', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'ParentId' => 1, 'Code' => 2, 'Header' => 3, 'Picture' => 4, 'Content' => 5, 'MetaTitle' => 6, 'MetaAuthor' => 7, 'MetaKeywords' => 8, 'MetaDescription' => 9, 'MetaCanonical' => 10, 'MetaRobots' => 11, 'CreatedAt' => 12, 'CreatedBy' => 13, 'UpdatedAt' => 14, 'UpdatedBy' => 15, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'parentId' => 1, 'code' => 2, 'header' => 3, 'picture' => 4, 'content' => 5, 'metaTitle' => 6, 'metaAuthor' => 7, 'metaKeywords' => 8, 'metaDescription' => 9, 'metaCanonical' => 10, 'metaRobots' => 11, 'createdAt' => 12, 'createdBy' => 13, 'updatedAt' => 14, 'updatedBy' => 15, ),
        self::TYPE_COLNAME       => array(SectionTableMap::COL_ID => 0, SectionTableMap::COL_PARENT_ID => 1, SectionTableMap::COL_CODE => 2, SectionTableMap::COL_HEADER => 3, SectionTableMap::COL_PICTURE => 4, SectionTableMap::COL_CONTENT => 5, SectionTableMap::COL_META_TITLE => 6, SectionTableMap::COL_META_AUTHOR => 7, SectionTableMap::COL_META_KEYWORDS => 8, SectionTableMap::COL_META_DESCRIPTION => 9, SectionTableMap::COL_META_CANONICAL => 10, SectionTableMap::COL_META_ROBOTS => 11, SectionTableMap::COL_CREATED_AT => 12, SectionTableMap::COL_CREATED_BY => 13, SectionTableMap::COL_UPDATED_AT => 14, SectionTableMap::COL_UPDATED_BY => 15, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'parent_id' => 1, 'code' => 2, 'header' => 3, 'picture' => 4, 'content' => 5, 'meta_title' => 6, 'meta_author' => 7, 'meta_keywords' => 8, 'meta_description' => 9, 'meta_canonical' => 10, 'meta_robots' => 11, 'created_at' => 12, 'created_by' => 13, 'updated_at' => 14, 'updated_by' => 15, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, )
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
        $this->setName('fenric_section');
        $this->setPhpName('Section');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Propel\\Models\\Section');
        $this->setPackage('Propel.Models');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('parent_id', 'ParentId', 'INTEGER', 'fenric_section', 'id', false, null, null);
        $this->addColumn('code', 'Code', 'VARCHAR', true, 255, null);
        $this->addColumn('header', 'Header', 'VARCHAR', true, 255, null);
        $this->getColumn('header')->setPrimaryString(true);
        $this->addColumn('picture', 'Picture', 'VARCHAR', false, 255, null);
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
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Parent', '\\Propel\\Models\\Section', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':parent_id',
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
        $this->addRelation('SectionRelatedById', '\\Propel\\Models\\Section', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':parent_id',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'SectionsRelatedById', false);
        $this->addRelation('SectionField', '\\Propel\\Models\\SectionField', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':section_id',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'SectionFields', false);
        $this->addRelation('Publication', '\\Propel\\Models\\Publication', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':section_id',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'Publications', false);
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
            'validate' => array('676a1cf1-6709-4a19-b9f6-d01d0fd08754' => array ('column' => 'code','validator' => 'NotBlank',), '49017c8c-c622-487d-b07f-de57a123ee57' => array ('column' => 'code','validator' => 'Length','options' => array ('max' => 255,),), '66306ec4-3d80-418d-96a8-21a8b23a2ec6' => array ('column' => 'code','validator' => 'Regex','options' => array ('pattern' => '/^[a-z0-9-]+$/',),), 'f682b300-404a-4360-ab9b-f95319e88778' => array ('column' => 'code','validator' => 'Unique',), 'e181d836-1742-42ec-9017-ee98b44da1f4' => array ('column' => 'header','validator' => 'NotBlank',), 'f271845e-ee03-4fe4-9442-9b695c0470ac' => array ('column' => 'header','validator' => 'Length','options' => array ('max' => 255,),), ),
        );
    } // getBehaviors()
    /**
     * Method to invalidate the instance pool of all tables related to fenric_section     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        SectionTableMap::clearInstancePool();
        SectionFieldTableMap::clearInstancePool();
        PublicationTableMap::clearInstancePool();
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
        return $withPrefix ? SectionTableMap::CLASS_DEFAULT : SectionTableMap::OM_CLASS;
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
     * @return array           (Section object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = SectionTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = SectionTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + SectionTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = SectionTableMap::OM_CLASS;
            /** @var Section $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            SectionTableMap::addInstanceToPool($obj, $key);
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
            $key = SectionTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = SectionTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Section $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                SectionTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(SectionTableMap::COL_ID);
            $criteria->addSelectColumn(SectionTableMap::COL_PARENT_ID);
            $criteria->addSelectColumn(SectionTableMap::COL_CODE);
            $criteria->addSelectColumn(SectionTableMap::COL_HEADER);
            $criteria->addSelectColumn(SectionTableMap::COL_PICTURE);
            $criteria->addSelectColumn(SectionTableMap::COL_META_TITLE);
            $criteria->addSelectColumn(SectionTableMap::COL_META_AUTHOR);
            $criteria->addSelectColumn(SectionTableMap::COL_META_KEYWORDS);
            $criteria->addSelectColumn(SectionTableMap::COL_META_DESCRIPTION);
            $criteria->addSelectColumn(SectionTableMap::COL_META_CANONICAL);
            $criteria->addSelectColumn(SectionTableMap::COL_META_ROBOTS);
            $criteria->addSelectColumn(SectionTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(SectionTableMap::COL_CREATED_BY);
            $criteria->addSelectColumn(SectionTableMap::COL_UPDATED_AT);
            $criteria->addSelectColumn(SectionTableMap::COL_UPDATED_BY);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.parent_id');
            $criteria->addSelectColumn($alias . '.code');
            $criteria->addSelectColumn($alias . '.header');
            $criteria->addSelectColumn($alias . '.picture');
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
        return Propel::getServiceContainer()->getDatabaseMap(SectionTableMap::DATABASE_NAME)->getTable(SectionTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(SectionTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(SectionTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new SectionTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Section or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Section object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(SectionTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Propel\Models\Section) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(SectionTableMap::DATABASE_NAME);
            $criteria->add(SectionTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = SectionQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            SectionTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                SectionTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the fenric_section table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return SectionQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Section or Criteria object.
     *
     * @param mixed               $criteria Criteria or Section object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SectionTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Section object
        }

        if ($criteria->containsKey(SectionTableMap::COL_ID) && $criteria->keyContainsValue(SectionTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.SectionTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = SectionQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // SectionTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
SectionTableMap::buildTableMap();
