<?php

namespace Propel\Models\Map;

use Propel\Models\BannerClient;
use Propel\Models\BannerClientQuery;
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
 * This class defines the structure of the 'fenric_banner_client' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class BannerClientTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Propel.Models.Map.BannerClientTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'fenric_banner_client';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Propel\\Models\\BannerClient';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Propel.Models.BannerClient';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 8;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 8;

    /**
     * the column name for the id field
     */
    const COL_ID = 'fenric_banner_client.id';

    /**
     * the column name for the contact_name field
     */
    const COL_CONTACT_NAME = 'fenric_banner_client.contact_name';

    /**
     * the column name for the contact_email field
     */
    const COL_CONTACT_EMAIL = 'fenric_banner_client.contact_email';

    /**
     * the column name for the description field
     */
    const COL_DESCRIPTION = 'fenric_banner_client.description';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'fenric_banner_client.created_at';

    /**
     * the column name for the created_by field
     */
    const COL_CREATED_BY = 'fenric_banner_client.created_by';

    /**
     * the column name for the updated_at field
     */
    const COL_UPDATED_AT = 'fenric_banner_client.updated_at';

    /**
     * the column name for the updated_by field
     */
    const COL_UPDATED_BY = 'fenric_banner_client.updated_by';

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
        self::TYPE_PHPNAME       => array('Id', 'ContactName', 'ContactEmail', 'Description', 'CreatedAt', 'CreatedBy', 'UpdatedAt', 'UpdatedBy', ),
        self::TYPE_CAMELNAME     => array('id', 'contactName', 'contactEmail', 'description', 'createdAt', 'createdBy', 'updatedAt', 'updatedBy', ),
        self::TYPE_COLNAME       => array(BannerClientTableMap::COL_ID, BannerClientTableMap::COL_CONTACT_NAME, BannerClientTableMap::COL_CONTACT_EMAIL, BannerClientTableMap::COL_DESCRIPTION, BannerClientTableMap::COL_CREATED_AT, BannerClientTableMap::COL_CREATED_BY, BannerClientTableMap::COL_UPDATED_AT, BannerClientTableMap::COL_UPDATED_BY, ),
        self::TYPE_FIELDNAME     => array('id', 'contact_name', 'contact_email', 'description', 'created_at', 'created_by', 'updated_at', 'updated_by', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'ContactName' => 1, 'ContactEmail' => 2, 'Description' => 3, 'CreatedAt' => 4, 'CreatedBy' => 5, 'UpdatedAt' => 6, 'UpdatedBy' => 7, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'contactName' => 1, 'contactEmail' => 2, 'description' => 3, 'createdAt' => 4, 'createdBy' => 5, 'updatedAt' => 6, 'updatedBy' => 7, ),
        self::TYPE_COLNAME       => array(BannerClientTableMap::COL_ID => 0, BannerClientTableMap::COL_CONTACT_NAME => 1, BannerClientTableMap::COL_CONTACT_EMAIL => 2, BannerClientTableMap::COL_DESCRIPTION => 3, BannerClientTableMap::COL_CREATED_AT => 4, BannerClientTableMap::COL_CREATED_BY => 5, BannerClientTableMap::COL_UPDATED_AT => 6, BannerClientTableMap::COL_UPDATED_BY => 7, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'contact_name' => 1, 'contact_email' => 2, 'description' => 3, 'created_at' => 4, 'created_by' => 5, 'updated_at' => 6, 'updated_by' => 7, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
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
        $this->setName('fenric_banner_client');
        $this->setPhpName('BannerClient');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Propel\\Models\\BannerClient');
        $this->setPackage('Propel.Models');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('contact_name', 'ContactName', 'VARCHAR', true, 255, null);
        $this->getColumn('contact_name')->setPrimaryString(true);
        $this->addColumn('contact_email', 'ContactEmail', 'VARCHAR', true, 255, null);
        $this->addColumn('description', 'Description', 'LONGVARCHAR', false, null, null);
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
    0 => ':banner_client_id',
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
            'validate' => array('4c620812-c2e0-11e7-9e78-bbe4dc2aa351' => array ('column' => 'contact_name','validator' => 'NotBlank',), '4c62edea-c2e0-11e7-b240-73730e8304a9' => array ('column' => 'contact_name','validator' => 'Length','options' => array ('max' => 255,),), '4c636e3c-c2e0-11e7-a7d6-2f53cb3d1b38' => array ('column' => 'contact_email','validator' => 'NotBlank',), '4c63f5dc-c2e0-11e7-9c52-4b0773c3338e' => array ('column' => 'contact_email','validator' => 'Email',), '4c64e992-c2e0-11e7-861c-a3de0e5d9ed7' => array ('column' => 'contact_email','validator' => 'Length','options' => array ('max' => 255,),), '4b07a2bb-245c-4f2b-81cc-56e9725dcda7' => array ('column' => 'contact_email','validator' => 'Unique',), ),
            'Fenric\Propel\Behaviors\Eventable' => array(),
        );
    } // getBehaviors()
    /**
     * Method to invalidate the instance pool of all tables related to fenric_banner_client     * by a foreign key with ON DELETE CASCADE
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
        return $withPrefix ? BannerClientTableMap::CLASS_DEFAULT : BannerClientTableMap::OM_CLASS;
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
     * @return array           (BannerClient object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = BannerClientTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = BannerClientTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + BannerClientTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = BannerClientTableMap::OM_CLASS;
            /** @var BannerClient $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            BannerClientTableMap::addInstanceToPool($obj, $key);
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
            $key = BannerClientTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = BannerClientTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var BannerClient $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                BannerClientTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(BannerClientTableMap::COL_ID);
            $criteria->addSelectColumn(BannerClientTableMap::COL_CONTACT_NAME);
            $criteria->addSelectColumn(BannerClientTableMap::COL_CONTACT_EMAIL);
            $criteria->addSelectColumn(BannerClientTableMap::COL_DESCRIPTION);
            $criteria->addSelectColumn(BannerClientTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(BannerClientTableMap::COL_CREATED_BY);
            $criteria->addSelectColumn(BannerClientTableMap::COL_UPDATED_AT);
            $criteria->addSelectColumn(BannerClientTableMap::COL_UPDATED_BY);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.contact_name');
            $criteria->addSelectColumn($alias . '.contact_email');
            $criteria->addSelectColumn($alias . '.description');
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
        return Propel::getServiceContainer()->getDatabaseMap(BannerClientTableMap::DATABASE_NAME)->getTable(BannerClientTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(BannerClientTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(BannerClientTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new BannerClientTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a BannerClient or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or BannerClient object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(BannerClientTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Propel\Models\BannerClient) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(BannerClientTableMap::DATABASE_NAME);
            $criteria->add(BannerClientTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = BannerClientQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            BannerClientTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                BannerClientTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the fenric_banner_client table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return BannerClientQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a BannerClient or Criteria object.
     *
     * @param mixed               $criteria Criteria or BannerClient object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(BannerClientTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from BannerClient object
        }

        if ($criteria->containsKey(BannerClientTableMap::COL_ID) && $criteria->keyContainsValue(BannerClientTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.BannerClientTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = BannerClientQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // BannerClientTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BannerClientTableMap::buildTableMap();
