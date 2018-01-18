<?php

namespace Propel\Models\Map;

use Propel\Models\Snippet;
use Propel\Models\SnippetQuery;
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
 * This class defines the structure of the 'fenric_snippet' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class SnippetTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Propel.Models.Map.SnippetTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'fenric_snippet';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Propel\\Models\\Snippet';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Propel.Models.Snippet';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 8;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 1;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 7;

    /**
     * the column name for the id field
     */
    const COL_ID = 'fenric_snippet.id';

    /**
     * the column name for the code field
     */
    const COL_CODE = 'fenric_snippet.code';

    /**
     * the column name for the title field
     */
    const COL_TITLE = 'fenric_snippet.title';

    /**
     * the column name for the value field
     */
    const COL_VALUE = 'fenric_snippet.value';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'fenric_snippet.created_at';

    /**
     * the column name for the created_by field
     */
    const COL_CREATED_BY = 'fenric_snippet.created_by';

    /**
     * the column name for the updated_at field
     */
    const COL_UPDATED_AT = 'fenric_snippet.updated_at';

    /**
     * the column name for the updated_by field
     */
    const COL_UPDATED_BY = 'fenric_snippet.updated_by';

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
        self::TYPE_PHPNAME       => array('Id', 'Code', 'Title', 'Value', 'CreatedAt', 'CreatedBy', 'UpdatedAt', 'UpdatedBy', ),
        self::TYPE_CAMELNAME     => array('id', 'code', 'title', 'value', 'createdAt', 'createdBy', 'updatedAt', 'updatedBy', ),
        self::TYPE_COLNAME       => array(SnippetTableMap::COL_ID, SnippetTableMap::COL_CODE, SnippetTableMap::COL_TITLE, SnippetTableMap::COL_VALUE, SnippetTableMap::COL_CREATED_AT, SnippetTableMap::COL_CREATED_BY, SnippetTableMap::COL_UPDATED_AT, SnippetTableMap::COL_UPDATED_BY, ),
        self::TYPE_FIELDNAME     => array('id', 'code', 'title', 'value', 'created_at', 'created_by', 'updated_at', 'updated_by', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Code' => 1, 'Title' => 2, 'Value' => 3, 'CreatedAt' => 4, 'CreatedBy' => 5, 'UpdatedAt' => 6, 'UpdatedBy' => 7, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'code' => 1, 'title' => 2, 'value' => 3, 'createdAt' => 4, 'createdBy' => 5, 'updatedAt' => 6, 'updatedBy' => 7, ),
        self::TYPE_COLNAME       => array(SnippetTableMap::COL_ID => 0, SnippetTableMap::COL_CODE => 1, SnippetTableMap::COL_TITLE => 2, SnippetTableMap::COL_VALUE => 3, SnippetTableMap::COL_CREATED_AT => 4, SnippetTableMap::COL_CREATED_BY => 5, SnippetTableMap::COL_UPDATED_AT => 6, SnippetTableMap::COL_UPDATED_BY => 7, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'code' => 1, 'title' => 2, 'value' => 3, 'created_at' => 4, 'created_by' => 5, 'updated_at' => 6, 'updated_by' => 7, ),
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
        $this->setName('fenric_snippet');
        $this->setPhpName('Snippet');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Propel\\Models\\Snippet');
        $this->setPackage('Propel.Models');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('code', 'Code', 'VARCHAR', true, 255, null);
        $this->addColumn('title', 'Title', 'VARCHAR', true, 255, null);
        $this->getColumn('title')->setPrimaryString(true);
        $this->addColumn('value', 'Value', 'LONGVARCHAR', true, null, null);
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
            'validate' => array('d2bad3f1-85ca-4433-838c-bcea033f8f0b' => array ('column' => 'code','validator' => 'NotBlank',), 'e78b233f-16e7-4129-98f9-c8e5bd520ae7' => array ('column' => 'code','validator' => 'Length','options' => array ('max' => 255,),), 'c3defbdb-8117-4eb5-9382-4a0a5bd139e1' => array ('column' => 'code','validator' => 'Regex','options' => array ('pattern' => '/^[a-zA-Z0-9-]+$/',),), '2f46574b-1252-4807-a2e0-dc0c2861be2b' => array ('column' => 'code','validator' => 'Unique',), '93fadc8e-05f4-4c89-ab4d-e6bd48cafa73' => array ('column' => 'title','validator' => 'NotBlank',), 'cc4c48ec-9470-4299-b26c-982d0c331670' => array ('column' => 'title','validator' => 'Length','options' => array ('max' => 255,),), '34e450fc-fb3b-4c4f-a082-dc6f6a892b38' => array ('column' => 'value','validator' => 'NotBlank',), ),
            'Fenric\Propel\Behaviors\Eventable' => array(),
        );
    } // getBehaviors()

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
        return $withPrefix ? SnippetTableMap::CLASS_DEFAULT : SnippetTableMap::OM_CLASS;
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
     * @return array           (Snippet object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = SnippetTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = SnippetTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + SnippetTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = SnippetTableMap::OM_CLASS;
            /** @var Snippet $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            SnippetTableMap::addInstanceToPool($obj, $key);
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
            $key = SnippetTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = SnippetTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Snippet $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                SnippetTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(SnippetTableMap::COL_ID);
            $criteria->addSelectColumn(SnippetTableMap::COL_CODE);
            $criteria->addSelectColumn(SnippetTableMap::COL_TITLE);
            $criteria->addSelectColumn(SnippetTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(SnippetTableMap::COL_CREATED_BY);
            $criteria->addSelectColumn(SnippetTableMap::COL_UPDATED_AT);
            $criteria->addSelectColumn(SnippetTableMap::COL_UPDATED_BY);
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
        return Propel::getServiceContainer()->getDatabaseMap(SnippetTableMap::DATABASE_NAME)->getTable(SnippetTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(SnippetTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(SnippetTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new SnippetTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Snippet or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Snippet object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(SnippetTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Propel\Models\Snippet) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(SnippetTableMap::DATABASE_NAME);
            $criteria->add(SnippetTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = SnippetQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            SnippetTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                SnippetTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the fenric_snippet table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return SnippetQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Snippet or Criteria object.
     *
     * @param mixed               $criteria Criteria or Snippet object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SnippetTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Snippet object
        }

        if ($criteria->containsKey(SnippetTableMap::COL_ID) && $criteria->keyContainsValue(SnippetTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.SnippetTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = SnippetQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // SnippetTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
SnippetTableMap::buildTableMap();
