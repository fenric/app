<?php

namespace Propel\Models\Map;

use Propel\Models\Field;
use Propel\Models\FieldQuery;
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
 * This class defines the structure of the 'fenric_field' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class FieldTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Propel.Models.Map.FieldTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'fenric_field';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Propel\\Models\\Field';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Propel.Models.Field';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 15;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 15;

    /**
     * the column name for the id field
     */
    const COL_ID = 'fenric_field.id';

    /**
     * the column name for the type field
     */
    const COL_TYPE = 'fenric_field.type';

    /**
     * the column name for the name field
     */
    const COL_NAME = 'fenric_field.name';

    /**
     * the column name for the label field
     */
    const COL_LABEL = 'fenric_field.label';

    /**
     * the column name for the tooltip field
     */
    const COL_TOOLTIP = 'fenric_field.tooltip';

    /**
     * the column name for the default_value field
     */
    const COL_DEFAULT_VALUE = 'fenric_field.default_value';

    /**
     * the column name for the validation_regex field
     */
    const COL_VALIDATION_REGEX = 'fenric_field.validation_regex';

    /**
     * the column name for the validation_error field
     */
    const COL_VALIDATION_ERROR = 'fenric_field.validation_error';

    /**
     * the column name for the is_unique field
     */
    const COL_IS_UNIQUE = 'fenric_field.is_unique';

    /**
     * the column name for the is_required field
     */
    const COL_IS_REQUIRED = 'fenric_field.is_required';

    /**
     * the column name for the is_searchable field
     */
    const COL_IS_SEARCHABLE = 'fenric_field.is_searchable';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'fenric_field.created_at';

    /**
     * the column name for the created_by field
     */
    const COL_CREATED_BY = 'fenric_field.created_by';

    /**
     * the column name for the updated_at field
     */
    const COL_UPDATED_AT = 'fenric_field.updated_at';

    /**
     * the column name for the updated_by field
     */
    const COL_UPDATED_BY = 'fenric_field.updated_by';

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
        self::TYPE_PHPNAME       => array('Id', 'Type', 'Name', 'Label', 'Tooltip', 'DefaultValue', 'ValidationRegex', 'ValidationError', 'IsUnique', 'IsRequired', 'IsSearchable', 'CreatedAt', 'CreatedBy', 'UpdatedAt', 'UpdatedBy', ),
        self::TYPE_CAMELNAME     => array('id', 'type', 'name', 'label', 'tooltip', 'defaultValue', 'validationRegex', 'validationError', 'isUnique', 'isRequired', 'isSearchable', 'createdAt', 'createdBy', 'updatedAt', 'updatedBy', ),
        self::TYPE_COLNAME       => array(FieldTableMap::COL_ID, FieldTableMap::COL_TYPE, FieldTableMap::COL_NAME, FieldTableMap::COL_LABEL, FieldTableMap::COL_TOOLTIP, FieldTableMap::COL_DEFAULT_VALUE, FieldTableMap::COL_VALIDATION_REGEX, FieldTableMap::COL_VALIDATION_ERROR, FieldTableMap::COL_IS_UNIQUE, FieldTableMap::COL_IS_REQUIRED, FieldTableMap::COL_IS_SEARCHABLE, FieldTableMap::COL_CREATED_AT, FieldTableMap::COL_CREATED_BY, FieldTableMap::COL_UPDATED_AT, FieldTableMap::COL_UPDATED_BY, ),
        self::TYPE_FIELDNAME     => array('id', 'type', 'name', 'label', 'tooltip', 'default_value', 'validation_regex', 'validation_error', 'is_unique', 'is_required', 'is_searchable', 'created_at', 'created_by', 'updated_at', 'updated_by', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Type' => 1, 'Name' => 2, 'Label' => 3, 'Tooltip' => 4, 'DefaultValue' => 5, 'ValidationRegex' => 6, 'ValidationError' => 7, 'IsUnique' => 8, 'IsRequired' => 9, 'IsSearchable' => 10, 'CreatedAt' => 11, 'CreatedBy' => 12, 'UpdatedAt' => 13, 'UpdatedBy' => 14, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'type' => 1, 'name' => 2, 'label' => 3, 'tooltip' => 4, 'defaultValue' => 5, 'validationRegex' => 6, 'validationError' => 7, 'isUnique' => 8, 'isRequired' => 9, 'isSearchable' => 10, 'createdAt' => 11, 'createdBy' => 12, 'updatedAt' => 13, 'updatedBy' => 14, ),
        self::TYPE_COLNAME       => array(FieldTableMap::COL_ID => 0, FieldTableMap::COL_TYPE => 1, FieldTableMap::COL_NAME => 2, FieldTableMap::COL_LABEL => 3, FieldTableMap::COL_TOOLTIP => 4, FieldTableMap::COL_DEFAULT_VALUE => 5, FieldTableMap::COL_VALIDATION_REGEX => 6, FieldTableMap::COL_VALIDATION_ERROR => 7, FieldTableMap::COL_IS_UNIQUE => 8, FieldTableMap::COL_IS_REQUIRED => 9, FieldTableMap::COL_IS_SEARCHABLE => 10, FieldTableMap::COL_CREATED_AT => 11, FieldTableMap::COL_CREATED_BY => 12, FieldTableMap::COL_UPDATED_AT => 13, FieldTableMap::COL_UPDATED_BY => 14, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'type' => 1, 'name' => 2, 'label' => 3, 'tooltip' => 4, 'default_value' => 5, 'validation_regex' => 6, 'validation_error' => 7, 'is_unique' => 8, 'is_required' => 9, 'is_searchable' => 10, 'created_at' => 11, 'created_by' => 12, 'updated_at' => 13, 'updated_by' => 14, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, )
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
        $this->setName('fenric_field');
        $this->setPhpName('Field');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Propel\\Models\\Field');
        $this->setPackage('Propel.Models');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('type', 'Type', 'VARCHAR', true, 255, null);
        $this->addColumn('name', 'Name', 'VARCHAR', true, 255, null);
        $this->addColumn('label', 'Label', 'VARCHAR', true, 255, null);
        $this->getColumn('label')->setPrimaryString(true);
        $this->addColumn('tooltip', 'Tooltip', 'VARCHAR', false, 255, null);
        $this->addColumn('default_value', 'DefaultValue', 'LONGVARCHAR', false, null, null);
        $this->addColumn('validation_regex', 'ValidationRegex', 'VARCHAR', false, 255, null);
        $this->addColumn('validation_error', 'ValidationError', 'VARCHAR', false, 255, null);
        $this->addColumn('is_unique', 'IsUnique', 'BOOLEAN', true, 1, false);
        $this->addColumn('is_required', 'IsRequired', 'BOOLEAN', true, 1, false);
        $this->addColumn('is_searchable', 'IsSearchable', 'BOOLEAN', true, 1, false);
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
        $this->addRelation('SectionField', '\\Propel\\Models\\SectionField', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':field_id',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'SectionFields', false);
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
            'validate' => array('5a3fcff5-a737-490e-bc3e-74af8d926534' => array ('column' => 'type','validator' => 'NotBlank',), 'b28e9d4b-4600-41e8-818f-9544625efbe0' => array ('column' => 'type','validator' => 'Length','options' => array ('max' => 255,),), '5f07aeed-9ee9-4537-812b-186cc3ed301d' => array ('column' => 'type','validator' => 'Regex','options' => array ('pattern' => '/^(?:flag|number|string|text|html|year|date|datetime|time|ip|url|email|image)$/',),), '8bb6551c-8380-477c-8f6e-911afb7e8a27' => array ('column' => 'name','validator' => 'NotBlank',), '953f7f06-08ae-4ad1-9e1f-84a3085536d2' => array ('column' => 'name','validator' => 'Length','options' => array ('max' => 255,),), '3202e56f-8fb5-49c6-970d-f2481308b3fa' => array ('column' => 'name','validator' => 'Regex','options' => array ('pattern' => '/^[a-z0-9_]+$/',),), 'c5d64b08-df0e-4773-be77-f901d5df766c' => array ('column' => 'name','validator' => 'Unique',), '065f7758-266c-4016-ae28-182bcbfa2df8' => array ('column' => 'label','validator' => 'NotBlank',), '167651d4-fb4c-4d40-8a42-503e5d241071' => array ('column' => 'label','validator' => 'Length','options' => array ('max' => 255,),), ),
            'Fenric\Propel\Behaviors\Eventable' => array(),
        );
    } // getBehaviors()
    /**
     * Method to invalidate the instance pool of all tables related to fenric_field     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        SectionFieldTableMap::clearInstancePool();
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
        return $withPrefix ? FieldTableMap::CLASS_DEFAULT : FieldTableMap::OM_CLASS;
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
     * @return array           (Field object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = FieldTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = FieldTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + FieldTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = FieldTableMap::OM_CLASS;
            /** @var Field $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            FieldTableMap::addInstanceToPool($obj, $key);
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
            $key = FieldTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = FieldTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Field $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                FieldTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(FieldTableMap::COL_ID);
            $criteria->addSelectColumn(FieldTableMap::COL_TYPE);
            $criteria->addSelectColumn(FieldTableMap::COL_NAME);
            $criteria->addSelectColumn(FieldTableMap::COL_LABEL);
            $criteria->addSelectColumn(FieldTableMap::COL_TOOLTIP);
            $criteria->addSelectColumn(FieldTableMap::COL_DEFAULT_VALUE);
            $criteria->addSelectColumn(FieldTableMap::COL_VALIDATION_REGEX);
            $criteria->addSelectColumn(FieldTableMap::COL_VALIDATION_ERROR);
            $criteria->addSelectColumn(FieldTableMap::COL_IS_UNIQUE);
            $criteria->addSelectColumn(FieldTableMap::COL_IS_REQUIRED);
            $criteria->addSelectColumn(FieldTableMap::COL_IS_SEARCHABLE);
            $criteria->addSelectColumn(FieldTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(FieldTableMap::COL_CREATED_BY);
            $criteria->addSelectColumn(FieldTableMap::COL_UPDATED_AT);
            $criteria->addSelectColumn(FieldTableMap::COL_UPDATED_BY);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.type');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.label');
            $criteria->addSelectColumn($alias . '.tooltip');
            $criteria->addSelectColumn($alias . '.default_value');
            $criteria->addSelectColumn($alias . '.validation_regex');
            $criteria->addSelectColumn($alias . '.validation_error');
            $criteria->addSelectColumn($alias . '.is_unique');
            $criteria->addSelectColumn($alias . '.is_required');
            $criteria->addSelectColumn($alias . '.is_searchable');
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
        return Propel::getServiceContainer()->getDatabaseMap(FieldTableMap::DATABASE_NAME)->getTable(FieldTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(FieldTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(FieldTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new FieldTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Field or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Field object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(FieldTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Propel\Models\Field) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(FieldTableMap::DATABASE_NAME);
            $criteria->add(FieldTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = FieldQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            FieldTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                FieldTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the fenric_field table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return FieldQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Field or Criteria object.
     *
     * @param mixed               $criteria Criteria or Field object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(FieldTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Field object
        }

        if ($criteria->containsKey(FieldTableMap::COL_ID) && $criteria->keyContainsValue(FieldTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.FieldTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = FieldQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // FieldTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
FieldTableMap::buildTableMap();
