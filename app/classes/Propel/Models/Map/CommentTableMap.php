<?php

namespace Propel\Models\Map;

use Propel\Models\Comment;
use Propel\Models\CommentQuery;
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
 * This class defines the structure of the 'fenric_comment' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class CommentTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Propel.Models.Map.CommentTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'fenric_comment';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Propel\\Models\\Comment';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Propel.Models.Comment';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 17;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 17;

    /**
     * the column name for the id field
     */
    const COL_ID = 'fenric_comment.id';

    /**
     * the column name for the parent_id field
     */
    const COL_PARENT_ID = 'fenric_comment.parent_id';

    /**
     * the column name for the publication_id field
     */
    const COL_PUBLICATION_ID = 'fenric_comment.publication_id';

    /**
     * the column name for the picture field
     */
    const COL_PICTURE = 'fenric_comment.picture';

    /**
     * the column name for the content field
     */
    const COL_CONTENT = 'fenric_comment.content';

    /**
     * the column name for the is_deleted field
     */
    const COL_IS_DELETED = 'fenric_comment.is_deleted';

    /**
     * the column name for the is_verified field
     */
    const COL_IS_VERIFIED = 'fenric_comment.is_verified';

    /**
     * the column name for the updating_reason field
     */
    const COL_UPDATING_REASON = 'fenric_comment.updating_reason';

    /**
     * the column name for the deleting_reason field
     */
    const COL_DELETING_REASON = 'fenric_comment.deleting_reason';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'fenric_comment.created_at';

    /**
     * the column name for the created_by field
     */
    const COL_CREATED_BY = 'fenric_comment.created_by';

    /**
     * the column name for the updated_at field
     */
    const COL_UPDATED_AT = 'fenric_comment.updated_at';

    /**
     * the column name for the updated_by field
     */
    const COL_UPDATED_BY = 'fenric_comment.updated_by';

    /**
     * the column name for the deleted_at field
     */
    const COL_DELETED_AT = 'fenric_comment.deleted_at';

    /**
     * the column name for the deleted_by field
     */
    const COL_DELETED_BY = 'fenric_comment.deleted_by';

    /**
     * the column name for the verified_at field
     */
    const COL_VERIFIED_AT = 'fenric_comment.verified_at';

    /**
     * the column name for the verified_by field
     */
    const COL_VERIFIED_BY = 'fenric_comment.verified_by';

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
        self::TYPE_PHPNAME       => array('Id', 'ParentId', 'PublicationId', 'Picture', 'Content', 'IsDeleted', 'IsVerified', 'UpdatingReason', 'DeletingReason', 'CreatedAt', 'CreatedBy', 'UpdatedAt', 'UpdatedBy', 'DeletedAt', 'DeletedBy', 'VerifiedAt', 'VerifiedBy', ),
        self::TYPE_CAMELNAME     => array('id', 'parentId', 'publicationId', 'picture', 'content', 'isDeleted', 'isVerified', 'updatingReason', 'deletingReason', 'createdAt', 'createdBy', 'updatedAt', 'updatedBy', 'deletedAt', 'deletedBy', 'verifiedAt', 'verifiedBy', ),
        self::TYPE_COLNAME       => array(CommentTableMap::COL_ID, CommentTableMap::COL_PARENT_ID, CommentTableMap::COL_PUBLICATION_ID, CommentTableMap::COL_PICTURE, CommentTableMap::COL_CONTENT, CommentTableMap::COL_IS_DELETED, CommentTableMap::COL_IS_VERIFIED, CommentTableMap::COL_UPDATING_REASON, CommentTableMap::COL_DELETING_REASON, CommentTableMap::COL_CREATED_AT, CommentTableMap::COL_CREATED_BY, CommentTableMap::COL_UPDATED_AT, CommentTableMap::COL_UPDATED_BY, CommentTableMap::COL_DELETED_AT, CommentTableMap::COL_DELETED_BY, CommentTableMap::COL_VERIFIED_AT, CommentTableMap::COL_VERIFIED_BY, ),
        self::TYPE_FIELDNAME     => array('id', 'parent_id', 'publication_id', 'picture', 'content', 'is_deleted', 'is_verified', 'updating_reason', 'deleting_reason', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_at', 'deleted_by', 'verified_at', 'verified_by', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'ParentId' => 1, 'PublicationId' => 2, 'Picture' => 3, 'Content' => 4, 'IsDeleted' => 5, 'IsVerified' => 6, 'UpdatingReason' => 7, 'DeletingReason' => 8, 'CreatedAt' => 9, 'CreatedBy' => 10, 'UpdatedAt' => 11, 'UpdatedBy' => 12, 'DeletedAt' => 13, 'DeletedBy' => 14, 'VerifiedAt' => 15, 'VerifiedBy' => 16, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'parentId' => 1, 'publicationId' => 2, 'picture' => 3, 'content' => 4, 'isDeleted' => 5, 'isVerified' => 6, 'updatingReason' => 7, 'deletingReason' => 8, 'createdAt' => 9, 'createdBy' => 10, 'updatedAt' => 11, 'updatedBy' => 12, 'deletedAt' => 13, 'deletedBy' => 14, 'verifiedAt' => 15, 'verifiedBy' => 16, ),
        self::TYPE_COLNAME       => array(CommentTableMap::COL_ID => 0, CommentTableMap::COL_PARENT_ID => 1, CommentTableMap::COL_PUBLICATION_ID => 2, CommentTableMap::COL_PICTURE => 3, CommentTableMap::COL_CONTENT => 4, CommentTableMap::COL_IS_DELETED => 5, CommentTableMap::COL_IS_VERIFIED => 6, CommentTableMap::COL_UPDATING_REASON => 7, CommentTableMap::COL_DELETING_REASON => 8, CommentTableMap::COL_CREATED_AT => 9, CommentTableMap::COL_CREATED_BY => 10, CommentTableMap::COL_UPDATED_AT => 11, CommentTableMap::COL_UPDATED_BY => 12, CommentTableMap::COL_DELETED_AT => 13, CommentTableMap::COL_DELETED_BY => 14, CommentTableMap::COL_VERIFIED_AT => 15, CommentTableMap::COL_VERIFIED_BY => 16, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'parent_id' => 1, 'publication_id' => 2, 'picture' => 3, 'content' => 4, 'is_deleted' => 5, 'is_verified' => 6, 'updating_reason' => 7, 'deleting_reason' => 8, 'created_at' => 9, 'created_by' => 10, 'updated_at' => 11, 'updated_by' => 12, 'deleted_at' => 13, 'deleted_by' => 14, 'verified_at' => 15, 'verified_by' => 16, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, )
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
        $this->setName('fenric_comment');
        $this->setPhpName('Comment');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Propel\\Models\\Comment');
        $this->setPackage('Propel.Models');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('parent_id', 'ParentId', 'INTEGER', 'fenric_comment', 'id', false, null, null);
        $this->addForeignKey('publication_id', 'PublicationId', 'INTEGER', 'fenric_publication', 'id', false, null, null);
        $this->addColumn('picture', 'Picture', 'VARCHAR', false, 255, null);
        $this->addColumn('content', 'Content', 'LONGVARCHAR', false, null, null);
        $this->addColumn('is_deleted', 'IsDeleted', 'BOOLEAN', true, 1, false);
        $this->addColumn('is_verified', 'IsVerified', 'BOOLEAN', true, 1, false);
        $this->addColumn('updating_reason', 'UpdatingReason', 'VARCHAR', false, 255, null);
        $this->addColumn('deleting_reason', 'DeletingReason', 'VARCHAR', false, 255, null);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addForeignKey('created_by', 'CreatedBy', 'INTEGER', 'fenric_user', 'id', false, null, null);
        $this->addColumn('updated_at', 'UpdatedAt', 'TIMESTAMP', false, null, null);
        $this->addForeignKey('updated_by', 'UpdatedBy', 'INTEGER', 'fenric_user', 'id', false, null, null);
        $this->addColumn('deleted_at', 'DeletedAt', 'TIMESTAMP', false, null, null);
        $this->addForeignKey('deleted_by', 'DeletedBy', 'INTEGER', 'fenric_user', 'id', false, null, null);
        $this->addColumn('verified_at', 'VerifiedAt', 'TIMESTAMP', false, null, null);
        $this->addForeignKey('verified_by', 'VerifiedBy', 'INTEGER', 'fenric_user', 'id', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Parent', '\\Propel\\Models\\Comment', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':parent_id',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', null, false);
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
), 'CASCADE', 'CASCADE', null, false);
        $this->addRelation('UserRelatedByUpdatedBy', '\\Propel\\Models\\User', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':updated_by',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', null, false);
        $this->addRelation('UserRelatedByDeletedBy', '\\Propel\\Models\\User', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':deleted_by',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', null, false);
        $this->addRelation('UserRelatedByVerifiedBy', '\\Propel\\Models\\User', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':verified_by',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', null, false);
        $this->addRelation('CommentRelatedById', '\\Propel\\Models\\Comment', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':parent_id',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'CommentsRelatedById', false);
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
            'validate' => array('0451f320-527a-4d09-bdbb-d28a5485ab11' => array ('column' => 'content','validator' => 'NotNull',), '05397fd6-d575-4545-89af-2a2e471513b4' => array ('column' => 'content','validator' => 'NotBlank',), ),
            'Fenric\Propel\Behaviors\Eventable' => array(),
        );
    } // getBehaviors()
    /**
     * Method to invalidate the instance pool of all tables related to fenric_comment     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        CommentTableMap::clearInstancePool();
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
        return $withPrefix ? CommentTableMap::CLASS_DEFAULT : CommentTableMap::OM_CLASS;
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
     * @return array           (Comment object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = CommentTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = CommentTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + CommentTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = CommentTableMap::OM_CLASS;
            /** @var Comment $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            CommentTableMap::addInstanceToPool($obj, $key);
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
            $key = CommentTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = CommentTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Comment $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                CommentTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(CommentTableMap::COL_ID);
            $criteria->addSelectColumn(CommentTableMap::COL_PARENT_ID);
            $criteria->addSelectColumn(CommentTableMap::COL_PUBLICATION_ID);
            $criteria->addSelectColumn(CommentTableMap::COL_PICTURE);
            $criteria->addSelectColumn(CommentTableMap::COL_CONTENT);
            $criteria->addSelectColumn(CommentTableMap::COL_IS_DELETED);
            $criteria->addSelectColumn(CommentTableMap::COL_IS_VERIFIED);
            $criteria->addSelectColumn(CommentTableMap::COL_UPDATING_REASON);
            $criteria->addSelectColumn(CommentTableMap::COL_DELETING_REASON);
            $criteria->addSelectColumn(CommentTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(CommentTableMap::COL_CREATED_BY);
            $criteria->addSelectColumn(CommentTableMap::COL_UPDATED_AT);
            $criteria->addSelectColumn(CommentTableMap::COL_UPDATED_BY);
            $criteria->addSelectColumn(CommentTableMap::COL_DELETED_AT);
            $criteria->addSelectColumn(CommentTableMap::COL_DELETED_BY);
            $criteria->addSelectColumn(CommentTableMap::COL_VERIFIED_AT);
            $criteria->addSelectColumn(CommentTableMap::COL_VERIFIED_BY);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.parent_id');
            $criteria->addSelectColumn($alias . '.publication_id');
            $criteria->addSelectColumn($alias . '.picture');
            $criteria->addSelectColumn($alias . '.content');
            $criteria->addSelectColumn($alias . '.is_deleted');
            $criteria->addSelectColumn($alias . '.is_verified');
            $criteria->addSelectColumn($alias . '.updating_reason');
            $criteria->addSelectColumn($alias . '.deleting_reason');
            $criteria->addSelectColumn($alias . '.created_at');
            $criteria->addSelectColumn($alias . '.created_by');
            $criteria->addSelectColumn($alias . '.updated_at');
            $criteria->addSelectColumn($alias . '.updated_by');
            $criteria->addSelectColumn($alias . '.deleted_at');
            $criteria->addSelectColumn($alias . '.deleted_by');
            $criteria->addSelectColumn($alias . '.verified_at');
            $criteria->addSelectColumn($alias . '.verified_by');
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
        return Propel::getServiceContainer()->getDatabaseMap(CommentTableMap::DATABASE_NAME)->getTable(CommentTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(CommentTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(CommentTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new CommentTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Comment or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Comment object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(CommentTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Propel\Models\Comment) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(CommentTableMap::DATABASE_NAME);
            $criteria->add(CommentTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = CommentQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            CommentTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                CommentTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the fenric_comment table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return CommentQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Comment or Criteria object.
     *
     * @param mixed               $criteria Criteria or Comment object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CommentTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Comment object
        }

        if ($criteria->containsKey(CommentTableMap::COL_ID) && $criteria->keyContainsValue(CommentTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.CommentTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = CommentQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // CommentTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
CommentTableMap::buildTableMap();
