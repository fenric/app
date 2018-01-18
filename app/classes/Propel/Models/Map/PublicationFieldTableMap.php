<?php

namespace Propel\Models\Map;

use Propel\Models\PublicationField;
use Propel\Models\PublicationFieldQuery;
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
 * This class defines the structure of the 'fenric_publication_field' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class PublicationFieldTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Propel.Models.Map.PublicationFieldTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'fenric_publication_field';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Propel\\Models\\PublicationField';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Propel.Models.PublicationField';

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
    const COL_ID = 'fenric_publication_field.id';

    /**
     * the column name for the publication_id field
     */
    const COL_PUBLICATION_ID = 'fenric_publication_field.publication_id';

    /**
     * the column name for the section_field_id field
     */
    const COL_SECTION_FIELD_ID = 'fenric_publication_field.section_field_id';

    /**
     * the column name for the int_value field
     */
    const COL_INT_VALUE = 'fenric_publication_field.int_value';

    /**
     * the column name for the bool_value field
     */
    const COL_BOOL_VALUE = 'fenric_publication_field.bool_value';

    /**
     * the column name for the number_value field
     */
    const COL_NUMBER_VALUE = 'fenric_publication_field.number_value';

    /**
     * the column name for the datetime_value field
     */
    const COL_DATETIME_VALUE = 'fenric_publication_field.datetime_value';

    /**
     * the column name for the string_value field
     */
    const COL_STRING_VALUE = 'fenric_publication_field.string_value';

    /**
     * the column name for the text_value field
     */
    const COL_TEXT_VALUE = 'fenric_publication_field.text_value';

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
        self::TYPE_PHPNAME       => array('Id', 'PublicationId', 'SectionFieldId', 'IntValue', 'BoolValue', 'NumberValue', 'DatetimeValue', 'StringValue', 'TextValue', ),
        self::TYPE_CAMELNAME     => array('id', 'publicationId', 'sectionFieldId', 'intValue', 'boolValue', 'numberValue', 'datetimeValue', 'stringValue', 'textValue', ),
        self::TYPE_COLNAME       => array(PublicationFieldTableMap::COL_ID, PublicationFieldTableMap::COL_PUBLICATION_ID, PublicationFieldTableMap::COL_SECTION_FIELD_ID, PublicationFieldTableMap::COL_INT_VALUE, PublicationFieldTableMap::COL_BOOL_VALUE, PublicationFieldTableMap::COL_NUMBER_VALUE, PublicationFieldTableMap::COL_DATETIME_VALUE, PublicationFieldTableMap::COL_STRING_VALUE, PublicationFieldTableMap::COL_TEXT_VALUE, ),
        self::TYPE_FIELDNAME     => array('id', 'publication_id', 'section_field_id', 'int_value', 'bool_value', 'number_value', 'datetime_value', 'string_value', 'text_value', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'PublicationId' => 1, 'SectionFieldId' => 2, 'IntValue' => 3, 'BoolValue' => 4, 'NumberValue' => 5, 'DatetimeValue' => 6, 'StringValue' => 7, 'TextValue' => 8, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'publicationId' => 1, 'sectionFieldId' => 2, 'intValue' => 3, 'boolValue' => 4, 'numberValue' => 5, 'datetimeValue' => 6, 'stringValue' => 7, 'textValue' => 8, ),
        self::TYPE_COLNAME       => array(PublicationFieldTableMap::COL_ID => 0, PublicationFieldTableMap::COL_PUBLICATION_ID => 1, PublicationFieldTableMap::COL_SECTION_FIELD_ID => 2, PublicationFieldTableMap::COL_INT_VALUE => 3, PublicationFieldTableMap::COL_BOOL_VALUE => 4, PublicationFieldTableMap::COL_NUMBER_VALUE => 5, PublicationFieldTableMap::COL_DATETIME_VALUE => 6, PublicationFieldTableMap::COL_STRING_VALUE => 7, PublicationFieldTableMap::COL_TEXT_VALUE => 8, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'publication_id' => 1, 'section_field_id' => 2, 'int_value' => 3, 'bool_value' => 4, 'number_value' => 5, 'datetime_value' => 6, 'string_value' => 7, 'text_value' => 8, ),
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
        $this->setName('fenric_publication_field');
        $this->setPhpName('PublicationField');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Propel\\Models\\PublicationField');
        $this->setPackage('Propel.Models');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('publication_id', 'PublicationId', 'INTEGER', 'fenric_publication', 'id', false, null, null);
        $this->addForeignKey('section_field_id', 'SectionFieldId', 'INTEGER', 'fenric_section_field', 'id', false, null, null);
        $this->addColumn('int_value', 'IntValue', 'INTEGER', false, null, null);
        $this->addColumn('bool_value', 'BoolValue', 'BOOLEAN', false, 1, null);
        $this->addColumn('number_value', 'NumberValue', 'NUMERIC', false, 65, null);
        $this->addColumn('datetime_value', 'DatetimeValue', 'TIMESTAMP', false, null, null);
        $this->addColumn('string_value', 'StringValue', 'VARCHAR', false, 255, null);
        $this->addColumn('text_value', 'TextValue', 'LONGVARCHAR', false, null, null);
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
        $this->addRelation('SectionField', '\\Propel\\Models\\SectionField', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':section_field_id',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', null, false);
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
            'validate' => array('1d842519-e5cd-4eb1-bba5-92dac0f8a837' => array ('column' => 'publication_id','validator' => 'NotBlank',), '2a94a5a9-a00f-4c44-8b21-75c0f7fd9aa5' => array ('column' => 'section_field_id','validator' => 'NotBlank',), ),
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
        return $withPrefix ? PublicationFieldTableMap::CLASS_DEFAULT : PublicationFieldTableMap::OM_CLASS;
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
     * @return array           (PublicationField object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = PublicationFieldTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = PublicationFieldTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + PublicationFieldTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PublicationFieldTableMap::OM_CLASS;
            /** @var PublicationField $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            PublicationFieldTableMap::addInstanceToPool($obj, $key);
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
            $key = PublicationFieldTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = PublicationFieldTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var PublicationField $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                PublicationFieldTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(PublicationFieldTableMap::COL_ID);
            $criteria->addSelectColumn(PublicationFieldTableMap::COL_PUBLICATION_ID);
            $criteria->addSelectColumn(PublicationFieldTableMap::COL_SECTION_FIELD_ID);
            $criteria->addSelectColumn(PublicationFieldTableMap::COL_INT_VALUE);
            $criteria->addSelectColumn(PublicationFieldTableMap::COL_BOOL_VALUE);
            $criteria->addSelectColumn(PublicationFieldTableMap::COL_NUMBER_VALUE);
            $criteria->addSelectColumn(PublicationFieldTableMap::COL_DATETIME_VALUE);
            $criteria->addSelectColumn(PublicationFieldTableMap::COL_STRING_VALUE);
            $criteria->addSelectColumn(PublicationFieldTableMap::COL_TEXT_VALUE);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.publication_id');
            $criteria->addSelectColumn($alias . '.section_field_id');
            $criteria->addSelectColumn($alias . '.int_value');
            $criteria->addSelectColumn($alias . '.bool_value');
            $criteria->addSelectColumn($alias . '.number_value');
            $criteria->addSelectColumn($alias . '.datetime_value');
            $criteria->addSelectColumn($alias . '.string_value');
            $criteria->addSelectColumn($alias . '.text_value');
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
        return Propel::getServiceContainer()->getDatabaseMap(PublicationFieldTableMap::DATABASE_NAME)->getTable(PublicationFieldTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(PublicationFieldTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(PublicationFieldTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new PublicationFieldTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a PublicationField or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or PublicationField object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(PublicationFieldTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Propel\Models\PublicationField) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PublicationFieldTableMap::DATABASE_NAME);
            $criteria->add(PublicationFieldTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = PublicationFieldQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            PublicationFieldTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                PublicationFieldTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the fenric_publication_field table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return PublicationFieldQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a PublicationField or Criteria object.
     *
     * @param mixed               $criteria Criteria or PublicationField object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PublicationFieldTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from PublicationField object
        }

        if ($criteria->containsKey(PublicationFieldTableMap::COL_ID) && $criteria->keyContainsValue(PublicationFieldTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.PublicationFieldTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = PublicationFieldQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // PublicationFieldTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
PublicationFieldTableMap::buildTableMap();
