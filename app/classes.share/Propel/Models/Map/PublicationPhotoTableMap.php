<?php

namespace Propel\Models\Map;

use Propel\Models\PublicationPhoto;
use Propel\Models\PublicationPhotoQuery;
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
 * This class defines the structure of the 'publication_photo' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class PublicationPhotoTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Propel.Models.Map.PublicationPhotoTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'publication_photo';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Propel\\Models\\PublicationPhoto';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Propel.Models.PublicationPhoto';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 9;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 9;

    /**
     * the column name for the id field
     */
    const COL_ID = 'publication_photo.id';

    /**
     * the column name for the publication_id field
     */
    const COL_PUBLICATION_ID = 'publication_photo.publication_id';

    /**
     * the column name for the file field
     */
    const COL_FILE = 'publication_photo.file';

    /**
     * the column name for the display field
     */
    const COL_DISPLAY = 'publication_photo.display';

    /**
     * the column name for the sequence field
     */
    const COL_SEQUENCE = 'publication_photo.sequence';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'publication_photo.created_at';

    /**
     * the column name for the created_by field
     */
    const COL_CREATED_BY = 'publication_photo.created_by';

    /**
     * the column name for the updated_at field
     */
    const COL_UPDATED_AT = 'publication_photo.updated_at';

    /**
     * the column name for the updated_by field
     */
    const COL_UPDATED_BY = 'publication_photo.updated_by';

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
        self::TYPE_PHPNAME       => array('Id', 'PublicationId', 'File', 'Display', 'Sequence', 'CreatedAt', 'CreatedBy', 'UpdatedAt', 'UpdatedBy', ),
        self::TYPE_CAMELNAME     => array('id', 'publicationId', 'file', 'display', 'sequence', 'createdAt', 'createdBy', 'updatedAt', 'updatedBy', ),
        self::TYPE_COLNAME       => array(PublicationPhotoTableMap::COL_ID, PublicationPhotoTableMap::COL_PUBLICATION_ID, PublicationPhotoTableMap::COL_FILE, PublicationPhotoTableMap::COL_DISPLAY, PublicationPhotoTableMap::COL_SEQUENCE, PublicationPhotoTableMap::COL_CREATED_AT, PublicationPhotoTableMap::COL_CREATED_BY, PublicationPhotoTableMap::COL_UPDATED_AT, PublicationPhotoTableMap::COL_UPDATED_BY, ),
        self::TYPE_FIELDNAME     => array('id', 'publication_id', 'file', 'display', 'sequence', 'created_at', 'created_by', 'updated_at', 'updated_by', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'PublicationId' => 1, 'File' => 2, 'Display' => 3, 'Sequence' => 4, 'CreatedAt' => 5, 'CreatedBy' => 6, 'UpdatedAt' => 7, 'UpdatedBy' => 8, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'publicationId' => 1, 'file' => 2, 'display' => 3, 'sequence' => 4, 'createdAt' => 5, 'createdBy' => 6, 'updatedAt' => 7, 'updatedBy' => 8, ),
        self::TYPE_COLNAME       => array(PublicationPhotoTableMap::COL_ID => 0, PublicationPhotoTableMap::COL_PUBLICATION_ID => 1, PublicationPhotoTableMap::COL_FILE => 2, PublicationPhotoTableMap::COL_DISPLAY => 3, PublicationPhotoTableMap::COL_SEQUENCE => 4, PublicationPhotoTableMap::COL_CREATED_AT => 5, PublicationPhotoTableMap::COL_CREATED_BY => 6, PublicationPhotoTableMap::COL_UPDATED_AT => 7, PublicationPhotoTableMap::COL_UPDATED_BY => 8, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'publication_id' => 1, 'file' => 2, 'display' => 3, 'sequence' => 4, 'created_at' => 5, 'created_by' => 6, 'updated_at' => 7, 'updated_by' => 8, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, )
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
        $this->setName('publication_photo');
        $this->setPhpName('PublicationPhoto');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Propel\\Models\\PublicationPhoto');
        $this->setPackage('Propel.Models');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('publication_id', 'PublicationId', 'INTEGER', 'publication', 'id', false, null, null);
        $this->addColumn('file', 'File', 'VARCHAR', true, 255, null);
        $this->getColumn('file')->setPrimaryString(true);
        $this->addColumn('display', 'Display', 'BOOLEAN', true, 1, true);
        $this->addColumn('sequence', 'Sequence', 'NUMERIC', true, null, 0);
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
        $this->addRelation('Publication', '\\Propel\\Models\\Publication', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':publication_id',
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
        return $withPrefix ? PublicationPhotoTableMap::CLASS_DEFAULT : PublicationPhotoTableMap::OM_CLASS;
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
     * @return array           (PublicationPhoto object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = PublicationPhotoTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = PublicationPhotoTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + PublicationPhotoTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PublicationPhotoTableMap::OM_CLASS;
            /** @var PublicationPhoto $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            PublicationPhotoTableMap::addInstanceToPool($obj, $key);
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
            $key = PublicationPhotoTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = PublicationPhotoTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var PublicationPhoto $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                PublicationPhotoTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(PublicationPhotoTableMap::COL_ID);
            $criteria->addSelectColumn(PublicationPhotoTableMap::COL_PUBLICATION_ID);
            $criteria->addSelectColumn(PublicationPhotoTableMap::COL_FILE);
            $criteria->addSelectColumn(PublicationPhotoTableMap::COL_DISPLAY);
            $criteria->addSelectColumn(PublicationPhotoTableMap::COL_SEQUENCE);
            $criteria->addSelectColumn(PublicationPhotoTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(PublicationPhotoTableMap::COL_CREATED_BY);
            $criteria->addSelectColumn(PublicationPhotoTableMap::COL_UPDATED_AT);
            $criteria->addSelectColumn(PublicationPhotoTableMap::COL_UPDATED_BY);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.publication_id');
            $criteria->addSelectColumn($alias . '.file');
            $criteria->addSelectColumn($alias . '.display');
            $criteria->addSelectColumn($alias . '.sequence');
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
        return Propel::getServiceContainer()->getDatabaseMap(PublicationPhotoTableMap::DATABASE_NAME)->getTable(PublicationPhotoTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(PublicationPhotoTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(PublicationPhotoTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new PublicationPhotoTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a PublicationPhoto or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or PublicationPhoto object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(PublicationPhotoTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Propel\Models\PublicationPhoto) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PublicationPhotoTableMap::DATABASE_NAME);
            $criteria->add(PublicationPhotoTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = PublicationPhotoQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            PublicationPhotoTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                PublicationPhotoTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the publication_photo table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return PublicationPhotoQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a PublicationPhoto or Criteria object.
     *
     * @param mixed               $criteria Criteria or PublicationPhoto object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PublicationPhotoTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from PublicationPhoto object
        }

        if ($criteria->containsKey(PublicationPhotoTableMap::COL_ID) && $criteria->keyContainsValue(PublicationPhotoTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.PublicationPhotoTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = PublicationPhotoQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // PublicationPhotoTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
PublicationPhotoTableMap::buildTableMap();
