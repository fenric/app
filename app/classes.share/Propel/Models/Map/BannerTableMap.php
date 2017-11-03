<?php

namespace Propel\Models\Map;

use Propel\Models\Banner;
use Propel\Models\BannerQuery;
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
 * This class defines the structure of the 'fenric_banner' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class BannerTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Propel.Models.Map.BannerTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'fenric_banner';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Propel\\Models\\Banner';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Propel.Models.Banner';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 20;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 20;

    /**
     * the column name for the id field
     */
    const COL_ID = 'fenric_banner.id';

    /**
     * the column name for the banner_group_id field
     */
    const COL_BANNER_GROUP_ID = 'fenric_banner.banner_group_id';

    /**
     * the column name for the title field
     */
    const COL_TITLE = 'fenric_banner.title';

    /**
     * the column name for the description field
     */
    const COL_DESCRIPTION = 'fenric_banner.description';

    /**
     * the column name for the picture field
     */
    const COL_PICTURE = 'fenric_banner.picture';

    /**
     * the column name for the picture_alt field
     */
    const COL_PICTURE_ALT = 'fenric_banner.picture_alt';

    /**
     * the column name for the picture_title field
     */
    const COL_PICTURE_TITLE = 'fenric_banner.picture_title';

    /**
     * the column name for the hyperlink_url field
     */
    const COL_HYPERLINK_URL = 'fenric_banner.hyperlink_url';

    /**
     * the column name for the hyperlink_title field
     */
    const COL_HYPERLINK_TITLE = 'fenric_banner.hyperlink_title';

    /**
     * the column name for the hyperlink_target field
     */
    const COL_HYPERLINK_TARGET = 'fenric_banner.hyperlink_target';

    /**
     * the column name for the show_start field
     */
    const COL_SHOW_START = 'fenric_banner.show_start';

    /**
     * the column name for the show_end field
     */
    const COL_SHOW_END = 'fenric_banner.show_end';

    /**
     * the column name for the shows field
     */
    const COL_SHOWS = 'fenric_banner.shows';

    /**
     * the column name for the shows_limit field
     */
    const COL_SHOWS_LIMIT = 'fenric_banner.shows_limit';

    /**
     * the column name for the clicks field
     */
    const COL_CLICKS = 'fenric_banner.clicks';

    /**
     * the column name for the clicks_limit field
     */
    const COL_CLICKS_LIMIT = 'fenric_banner.clicks_limit';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'fenric_banner.created_at';

    /**
     * the column name for the created_by field
     */
    const COL_CREATED_BY = 'fenric_banner.created_by';

    /**
     * the column name for the updated_at field
     */
    const COL_UPDATED_AT = 'fenric_banner.updated_at';

    /**
     * the column name for the updated_by field
     */
    const COL_UPDATED_BY = 'fenric_banner.updated_by';

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
        self::TYPE_PHPNAME       => array('Id', 'BannerGroupId', 'Title', 'Description', 'Picture', 'PictureAlt', 'PictureTitle', 'HyperlinkUrl', 'HyperlinkTitle', 'HyperlinkTarget', 'ShowStart', 'ShowEnd', 'Shows', 'ShowsLimit', 'Clicks', 'ClicksLimit', 'CreatedAt', 'CreatedBy', 'UpdatedAt', 'UpdatedBy', ),
        self::TYPE_CAMELNAME     => array('id', 'bannerGroupId', 'title', 'description', 'picture', 'pictureAlt', 'pictureTitle', 'hyperlinkUrl', 'hyperlinkTitle', 'hyperlinkTarget', 'showStart', 'showEnd', 'shows', 'showsLimit', 'clicks', 'clicksLimit', 'createdAt', 'createdBy', 'updatedAt', 'updatedBy', ),
        self::TYPE_COLNAME       => array(BannerTableMap::COL_ID, BannerTableMap::COL_BANNER_GROUP_ID, BannerTableMap::COL_TITLE, BannerTableMap::COL_DESCRIPTION, BannerTableMap::COL_PICTURE, BannerTableMap::COL_PICTURE_ALT, BannerTableMap::COL_PICTURE_TITLE, BannerTableMap::COL_HYPERLINK_URL, BannerTableMap::COL_HYPERLINK_TITLE, BannerTableMap::COL_HYPERLINK_TARGET, BannerTableMap::COL_SHOW_START, BannerTableMap::COL_SHOW_END, BannerTableMap::COL_SHOWS, BannerTableMap::COL_SHOWS_LIMIT, BannerTableMap::COL_CLICKS, BannerTableMap::COL_CLICKS_LIMIT, BannerTableMap::COL_CREATED_AT, BannerTableMap::COL_CREATED_BY, BannerTableMap::COL_UPDATED_AT, BannerTableMap::COL_UPDATED_BY, ),
        self::TYPE_FIELDNAME     => array('id', 'banner_group_id', 'title', 'description', 'picture', 'picture_alt', 'picture_title', 'hyperlink_url', 'hyperlink_title', 'hyperlink_target', 'show_start', 'show_end', 'shows', 'shows_limit', 'clicks', 'clicks_limit', 'created_at', 'created_by', 'updated_at', 'updated_by', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'BannerGroupId' => 1, 'Title' => 2, 'Description' => 3, 'Picture' => 4, 'PictureAlt' => 5, 'PictureTitle' => 6, 'HyperlinkUrl' => 7, 'HyperlinkTitle' => 8, 'HyperlinkTarget' => 9, 'ShowStart' => 10, 'ShowEnd' => 11, 'Shows' => 12, 'ShowsLimit' => 13, 'Clicks' => 14, 'ClicksLimit' => 15, 'CreatedAt' => 16, 'CreatedBy' => 17, 'UpdatedAt' => 18, 'UpdatedBy' => 19, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'bannerGroupId' => 1, 'title' => 2, 'description' => 3, 'picture' => 4, 'pictureAlt' => 5, 'pictureTitle' => 6, 'hyperlinkUrl' => 7, 'hyperlinkTitle' => 8, 'hyperlinkTarget' => 9, 'showStart' => 10, 'showEnd' => 11, 'shows' => 12, 'showsLimit' => 13, 'clicks' => 14, 'clicksLimit' => 15, 'createdAt' => 16, 'createdBy' => 17, 'updatedAt' => 18, 'updatedBy' => 19, ),
        self::TYPE_COLNAME       => array(BannerTableMap::COL_ID => 0, BannerTableMap::COL_BANNER_GROUP_ID => 1, BannerTableMap::COL_TITLE => 2, BannerTableMap::COL_DESCRIPTION => 3, BannerTableMap::COL_PICTURE => 4, BannerTableMap::COL_PICTURE_ALT => 5, BannerTableMap::COL_PICTURE_TITLE => 6, BannerTableMap::COL_HYPERLINK_URL => 7, BannerTableMap::COL_HYPERLINK_TITLE => 8, BannerTableMap::COL_HYPERLINK_TARGET => 9, BannerTableMap::COL_SHOW_START => 10, BannerTableMap::COL_SHOW_END => 11, BannerTableMap::COL_SHOWS => 12, BannerTableMap::COL_SHOWS_LIMIT => 13, BannerTableMap::COL_CLICKS => 14, BannerTableMap::COL_CLICKS_LIMIT => 15, BannerTableMap::COL_CREATED_AT => 16, BannerTableMap::COL_CREATED_BY => 17, BannerTableMap::COL_UPDATED_AT => 18, BannerTableMap::COL_UPDATED_BY => 19, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'banner_group_id' => 1, 'title' => 2, 'description' => 3, 'picture' => 4, 'picture_alt' => 5, 'picture_title' => 6, 'hyperlink_url' => 7, 'hyperlink_title' => 8, 'hyperlink_target' => 9, 'show_start' => 10, 'show_end' => 11, 'shows' => 12, 'shows_limit' => 13, 'clicks' => 14, 'clicks_limit' => 15, 'created_at' => 16, 'created_by' => 17, 'updated_at' => 18, 'updated_by' => 19, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, )
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
        $this->setName('fenric_banner');
        $this->setPhpName('Banner');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Propel\\Models\\Banner');
        $this->setPackage('Propel.Models');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('banner_group_id', 'BannerGroupId', 'INTEGER', 'fenric_banner_group', 'id', false, null, null);
        $this->addColumn('title', 'Title', 'VARCHAR', true, 255, null);
        $this->getColumn('title')->setPrimaryString(true);
        $this->addColumn('description', 'Description', 'LONGVARCHAR', false, null, null);
        $this->addColumn('picture', 'Picture', 'VARCHAR', true, 255, null);
        $this->addColumn('picture_alt', 'PictureAlt', 'VARCHAR', false, 255, null);
        $this->addColumn('picture_title', 'PictureTitle', 'VARCHAR', false, 255, null);
        $this->addColumn('hyperlink_url', 'HyperlinkUrl', 'VARCHAR', true, 255, null);
        $this->addColumn('hyperlink_title', 'HyperlinkTitle', 'VARCHAR', false, 255, null);
        $this->addColumn('hyperlink_target', 'HyperlinkTarget', 'VARCHAR', false, 255, null);
        $this->addColumn('show_start', 'ShowStart', 'TIMESTAMP', false, null, null);
        $this->addColumn('show_end', 'ShowEnd', 'TIMESTAMP', false, null, null);
        $this->addColumn('shows', 'Shows', 'NUMERIC', false, null, 0);
        $this->addColumn('shows_limit', 'ShowsLimit', 'NUMERIC', false, null, null);
        $this->addColumn('clicks', 'Clicks', 'NUMERIC', false, null, 0);
        $this->addColumn('clicks_limit', 'ClicksLimit', 'NUMERIC', false, null, null);
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
        $this->addRelation('BannerGroup', '\\Propel\\Models\\BannerGroup', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':banner_group_id',
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
            'validate' => array('1d3cf254-bf5c-11e7-a782-6f777aef7709' => array ('column' => 'banner_group_id','validator' => 'NotBlank',), '1d3dc652-bf5c-11e7-ac3d-47555fd33204' => array ('column' => 'title','validator' => 'NotBlank',), '1d4377c8-bf5c-11e7-84fa-bb42a22d1de0' => array ('column' => 'title','validator' => 'Length','options' => array ('max' => 255,),), '1d3e9d02-bf5c-11e7-93f9-974d7c705bad' => array ('column' => 'picture','validator' => 'NotBlank',), '1d4488de-bf5c-11e7-98b4-c3783a0b48eb' => array ('column' => 'picture','validator' => 'Length','options' => array ('max' => 255,),), '1d3f77e0-bf5c-11e7-ab38-7f1c828bf35a' => array ('column' => 'hyperlink_url','validator' => 'NotBlank',), '1d455944-bf5c-11e7-957d-c7614bf20b11' => array ('column' => 'hyperlink_url','validator' => 'Length','options' => array ('max' => 255,),), '1d40771c-bf5c-11e7-9ac6-eb1cbef867b4' => array ('column' => 'hyperlink_url','validator' => 'Url',), '1d415ca4-bf5c-11e7-afd6-f751a5797087' => array ('column' => 'shows_limit','validator' => 'Range','options' => array ('min' => 1,),), '1d42490c-bf5c-11e7-8e24-c7aeabc5ebe1' => array ('column' => 'clicks_limit','validator' => 'Range','options' => array ('min' => 1,),), ),
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
        return $withPrefix ? BannerTableMap::CLASS_DEFAULT : BannerTableMap::OM_CLASS;
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
     * @return array           (Banner object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = BannerTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = BannerTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + BannerTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = BannerTableMap::OM_CLASS;
            /** @var Banner $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            BannerTableMap::addInstanceToPool($obj, $key);
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
            $key = BannerTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = BannerTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Banner $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                BannerTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(BannerTableMap::COL_ID);
            $criteria->addSelectColumn(BannerTableMap::COL_BANNER_GROUP_ID);
            $criteria->addSelectColumn(BannerTableMap::COL_TITLE);
            $criteria->addSelectColumn(BannerTableMap::COL_DESCRIPTION);
            $criteria->addSelectColumn(BannerTableMap::COL_PICTURE);
            $criteria->addSelectColumn(BannerTableMap::COL_PICTURE_ALT);
            $criteria->addSelectColumn(BannerTableMap::COL_PICTURE_TITLE);
            $criteria->addSelectColumn(BannerTableMap::COL_HYPERLINK_URL);
            $criteria->addSelectColumn(BannerTableMap::COL_HYPERLINK_TITLE);
            $criteria->addSelectColumn(BannerTableMap::COL_HYPERLINK_TARGET);
            $criteria->addSelectColumn(BannerTableMap::COL_SHOW_START);
            $criteria->addSelectColumn(BannerTableMap::COL_SHOW_END);
            $criteria->addSelectColumn(BannerTableMap::COL_SHOWS);
            $criteria->addSelectColumn(BannerTableMap::COL_SHOWS_LIMIT);
            $criteria->addSelectColumn(BannerTableMap::COL_CLICKS);
            $criteria->addSelectColumn(BannerTableMap::COL_CLICKS_LIMIT);
            $criteria->addSelectColumn(BannerTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(BannerTableMap::COL_CREATED_BY);
            $criteria->addSelectColumn(BannerTableMap::COL_UPDATED_AT);
            $criteria->addSelectColumn(BannerTableMap::COL_UPDATED_BY);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.banner_group_id');
            $criteria->addSelectColumn($alias . '.title');
            $criteria->addSelectColumn($alias . '.description');
            $criteria->addSelectColumn($alias . '.picture');
            $criteria->addSelectColumn($alias . '.picture_alt');
            $criteria->addSelectColumn($alias . '.picture_title');
            $criteria->addSelectColumn($alias . '.hyperlink_url');
            $criteria->addSelectColumn($alias . '.hyperlink_title');
            $criteria->addSelectColumn($alias . '.hyperlink_target');
            $criteria->addSelectColumn($alias . '.show_start');
            $criteria->addSelectColumn($alias . '.show_end');
            $criteria->addSelectColumn($alias . '.shows');
            $criteria->addSelectColumn($alias . '.shows_limit');
            $criteria->addSelectColumn($alias . '.clicks');
            $criteria->addSelectColumn($alias . '.clicks_limit');
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
        return Propel::getServiceContainer()->getDatabaseMap(BannerTableMap::DATABASE_NAME)->getTable(BannerTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(BannerTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(BannerTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new BannerTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Banner or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Banner object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(BannerTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Propel\Models\Banner) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(BannerTableMap::DATABASE_NAME);
            $criteria->add(BannerTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = BannerQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            BannerTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                BannerTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the fenric_banner table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return BannerQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Banner or Criteria object.
     *
     * @param mixed               $criteria Criteria or Banner object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(BannerTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Banner object
        }

        if ($criteria->containsKey(BannerTableMap::COL_ID) && $criteria->keyContainsValue(BannerTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.BannerTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = BannerQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // BannerTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BannerTableMap::buildTableMap();
