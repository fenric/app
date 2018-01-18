<?php

namespace Propel\Models\Map;

use Propel\Models\BannerGroup;
use Propel\Models\BannerGroupQuery;
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
 * This class defines the structure of the 'fenric_banner_group' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class BannerGroupTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Propel.Models.Map.BannerGroupTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'fenric_banner_group';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Propel\\Models\\BannerGroup';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Propel.Models.BannerGroup';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 7;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 7;

    /**
     * the column name for the id field
     */
    const COL_ID = 'fenric_banner_group.id';

    /**
     * the column name for the code field
     */
    const COL_CODE = 'fenric_banner_group.code';

    /**
     * the column name for the title field
     */
    const COL_TITLE = 'fenric_banner_group.title';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'fenric_banner_group.created_at';

    /**
     * the column name for the created_by field
     */
    const COL_CREATED_BY = 'fenric_banner_group.created_by';

    /**
     * the column name for the updated_at field
     */
    const COL_UPDATED_AT = 'fenric_banner_group.updated_at';

    /**
     * the column name for the updated_by field
     */
    const COL_UPDATED_BY = 'fenric_banner_group.updated_by';

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
        self::TYPE_PHPNAME       => array('Id', 'Code', 'Title', 'CreatedAt', 'CreatedBy', 'UpdatedAt', 'UpdatedBy', ),
        self::TYPE_CAMELNAME     => array('id', 'code', 'title', 'createdAt', 'createdBy', 'updatedAt', 'updatedBy', ),
        self::TYPE_COLNAME       => array(BannerGroupTableMap::COL_ID, BannerGroupTableMap::COL_CODE, BannerGroupTableMap::COL_TITLE, BannerGroupTableMap::COL_CREATED_AT, BannerGroupTableMap::COL_CREATED_BY, BannerGroupTableMap::COL_UPDATED_AT, BannerGroupTableMap::COL_UPDATED_BY, ),
        self::TYPE_FIELDNAME     => array('id', 'code', 'title', 'created_at', 'created_by', 'updated_at', 'updated_by', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Code' => 1, 'Title' => 2, 'CreatedAt' => 3, 'CreatedBy' => 4, 'UpdatedAt' => 5, 'UpdatedBy' => 6, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'code' => 1, 'title' => 2, 'createdAt' => 3, 'createdBy' => 4, 'updatedAt' => 5, 'updatedBy' => 6, ),
        self::TYPE_COLNAME       => array(BannerGroupTableMap::COL_ID => 0, BannerGroupTableMap::COL_CODE => 1, BannerGroupTableMap::COL_TITLE => 2, BannerGroupTableMap::COL_CREATED_AT => 3, BannerGroupTableMap::COL_CREATED_BY => 4, BannerGroupTableMap::COL_UPDATED_AT => 5, BannerGroupTableMap::COL_UPDATED_BY => 6, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'code' => 1, 'title' => 2, 'created_at' => 3, 'created_by' => 4, 'updated_at' => 5, 'updated_by' => 6, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
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
        $this->setName('fenric_banner_group');
        $this->setPhpName('BannerGroup');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Propel\\Models\\BannerGroup');
        $this->setPackage('Propel.Models');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('code', 'Code', 'VARCHAR', true, 255, null);
        $this->addColumn('title', 'Title', 'VARCHAR', true, 255, null);
        $this->getColumn('title')->setPrimaryString(true);
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
        $this->addRelation('Banner', '\\Propel\\Models\\Banner', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':banner_group_id',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'Banners', false);
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
            'validate' => array('1d46277a-bf5c-11e7-bd0e-2b86cb806a6a' => array ('column' => 'code','validator' => 'NotBlank',), '1d46f876-bf5c-11e7-8c5b-d39bae1c7247' => array ('column' => 'code','validator' => 'Length','options' => array ('max' => 255,),), '1d480ad6-bf5c-11e7-9b8b-c3f7d691a5b1' => array ('column' => 'code','validator' => 'Regex','options' => array ('pattern' => '/^[a-z0-9-]+$/',),), '1d494ba8-bf5c-11e7-8fbd-7f5457ebecc4' => array ('column' => 'code','validator' => 'Unique',), '1d4d0964-bf5c-11e7-bbde-7fae13bc21c4' => array ('column' => 'title','validator' => 'NotBlank',), '1d4c3c00-bf5c-11e7-bd97-9348d134984b' => array ('column' => 'title','validator' => 'Length','options' => array ('max' => 255,),), ),
            'Fenric\Propel\Behaviors\Eventable' => array(),
        );
    } // getBehaviors()
    /**
     * Method to invalidate the instance pool of all tables related to fenric_banner_group     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        BannerTableMap::clearInstancePool();
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
        return $withPrefix ? BannerGroupTableMap::CLASS_DEFAULT : BannerGroupTableMap::OM_CLASS;
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
     * @return array           (BannerGroup object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = BannerGroupTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = BannerGroupTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + BannerGroupTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = BannerGroupTableMap::OM_CLASS;
            /** @var BannerGroup $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            BannerGroupTableMap::addInstanceToPool($obj, $key);
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
            $key = BannerGroupTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = BannerGroupTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var BannerGroup $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                BannerGroupTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(BannerGroupTableMap::COL_ID);
            $criteria->addSelectColumn(BannerGroupTableMap::COL_CODE);
            $criteria->addSelectColumn(BannerGroupTableMap::COL_TITLE);
            $criteria->addSelectColumn(BannerGroupTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(BannerGroupTableMap::COL_CREATED_BY);
            $criteria->addSelectColumn(BannerGroupTableMap::COL_UPDATED_AT);
            $criteria->addSelectColumn(BannerGroupTableMap::COL_UPDATED_BY);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.code');
            $criteria->addSelectColumn($alias . '.title');
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
        return Propel::getServiceContainer()->getDatabaseMap(BannerGroupTableMap::DATABASE_NAME)->getTable(BannerGroupTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(BannerGroupTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(BannerGroupTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new BannerGroupTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a BannerGroup or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or BannerGroup object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(BannerGroupTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Propel\Models\BannerGroup) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(BannerGroupTableMap::DATABASE_NAME);
            $criteria->add(BannerGroupTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = BannerGroupQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            BannerGroupTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                BannerGroupTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the fenric_banner_group table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return BannerGroupQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a BannerGroup or Criteria object.
     *
     * @param mixed               $criteria Criteria or BannerGroup object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(BannerGroupTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from BannerGroup object
        }

        if ($criteria->containsKey(BannerGroupTableMap::COL_ID) && $criteria->keyContainsValue(BannerGroupTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.BannerGroupTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = BannerGroupQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // BannerGroupTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BannerGroupTableMap::buildTableMap();
