<?php

namespace Propel\Models\Base;

use \Exception;
use \PDO;
use Propel\Models\Banner as ChildBanner;
use Propel\Models\BannerQuery as ChildBannerQuery;
use Propel\Models\Map\BannerTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'fenric_banner' table.
 *
 *
 *
 * @method     ChildBannerQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildBannerQuery orderByBannerGroupId($order = Criteria::ASC) Order by the banner_group_id column
 * @method     ChildBannerQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method     ChildBannerQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method     ChildBannerQuery orderByPicture($order = Criteria::ASC) Order by the picture column
 * @method     ChildBannerQuery orderByPictureAlt($order = Criteria::ASC) Order by the picture_alt column
 * @method     ChildBannerQuery orderByPictureTitle($order = Criteria::ASC) Order by the picture_title column
 * @method     ChildBannerQuery orderByHyperlinkUrl($order = Criteria::ASC) Order by the hyperlink_url column
 * @method     ChildBannerQuery orderByHyperlinkTitle($order = Criteria::ASC) Order by the hyperlink_title column
 * @method     ChildBannerQuery orderByHyperlinkTarget($order = Criteria::ASC) Order by the hyperlink_target column
 * @method     ChildBannerQuery orderByShowStart($order = Criteria::ASC) Order by the show_start column
 * @method     ChildBannerQuery orderByShowEnd($order = Criteria::ASC) Order by the show_end column
 * @method     ChildBannerQuery orderByShows($order = Criteria::ASC) Order by the shows column
 * @method     ChildBannerQuery orderByShowsLimit($order = Criteria::ASC) Order by the shows_limit column
 * @method     ChildBannerQuery orderByClicks($order = Criteria::ASC) Order by the clicks column
 * @method     ChildBannerQuery orderByClicksLimit($order = Criteria::ASC) Order by the clicks_limit column
 * @method     ChildBannerQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildBannerQuery orderByCreatedBy($order = Criteria::ASC) Order by the created_by column
 * @method     ChildBannerQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 * @method     ChildBannerQuery orderByUpdatedBy($order = Criteria::ASC) Order by the updated_by column
 *
 * @method     ChildBannerQuery groupById() Group by the id column
 * @method     ChildBannerQuery groupByBannerGroupId() Group by the banner_group_id column
 * @method     ChildBannerQuery groupByTitle() Group by the title column
 * @method     ChildBannerQuery groupByDescription() Group by the description column
 * @method     ChildBannerQuery groupByPicture() Group by the picture column
 * @method     ChildBannerQuery groupByPictureAlt() Group by the picture_alt column
 * @method     ChildBannerQuery groupByPictureTitle() Group by the picture_title column
 * @method     ChildBannerQuery groupByHyperlinkUrl() Group by the hyperlink_url column
 * @method     ChildBannerQuery groupByHyperlinkTitle() Group by the hyperlink_title column
 * @method     ChildBannerQuery groupByHyperlinkTarget() Group by the hyperlink_target column
 * @method     ChildBannerQuery groupByShowStart() Group by the show_start column
 * @method     ChildBannerQuery groupByShowEnd() Group by the show_end column
 * @method     ChildBannerQuery groupByShows() Group by the shows column
 * @method     ChildBannerQuery groupByShowsLimit() Group by the shows_limit column
 * @method     ChildBannerQuery groupByClicks() Group by the clicks column
 * @method     ChildBannerQuery groupByClicksLimit() Group by the clicks_limit column
 * @method     ChildBannerQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildBannerQuery groupByCreatedBy() Group by the created_by column
 * @method     ChildBannerQuery groupByUpdatedAt() Group by the updated_at column
 * @method     ChildBannerQuery groupByUpdatedBy() Group by the updated_by column
 *
 * @method     ChildBannerQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildBannerQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildBannerQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildBannerQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildBannerQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildBannerQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildBannerQuery leftJoinBannerGroup($relationAlias = null) Adds a LEFT JOIN clause to the query using the BannerGroup relation
 * @method     ChildBannerQuery rightJoinBannerGroup($relationAlias = null) Adds a RIGHT JOIN clause to the query using the BannerGroup relation
 * @method     ChildBannerQuery innerJoinBannerGroup($relationAlias = null) Adds a INNER JOIN clause to the query using the BannerGroup relation
 *
 * @method     ChildBannerQuery joinWithBannerGroup($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the BannerGroup relation
 *
 * @method     ChildBannerQuery leftJoinWithBannerGroup() Adds a LEFT JOIN clause and with to the query using the BannerGroup relation
 * @method     ChildBannerQuery rightJoinWithBannerGroup() Adds a RIGHT JOIN clause and with to the query using the BannerGroup relation
 * @method     ChildBannerQuery innerJoinWithBannerGroup() Adds a INNER JOIN clause and with to the query using the BannerGroup relation
 *
 * @method     ChildBannerQuery leftJoinUserRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserRelatedByCreatedBy relation
 * @method     ChildBannerQuery rightJoinUserRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserRelatedByCreatedBy relation
 * @method     ChildBannerQuery innerJoinUserRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the UserRelatedByCreatedBy relation
 *
 * @method     ChildBannerQuery joinWithUserRelatedByCreatedBy($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the UserRelatedByCreatedBy relation
 *
 * @method     ChildBannerQuery leftJoinWithUserRelatedByCreatedBy() Adds a LEFT JOIN clause and with to the query using the UserRelatedByCreatedBy relation
 * @method     ChildBannerQuery rightJoinWithUserRelatedByCreatedBy() Adds a RIGHT JOIN clause and with to the query using the UserRelatedByCreatedBy relation
 * @method     ChildBannerQuery innerJoinWithUserRelatedByCreatedBy() Adds a INNER JOIN clause and with to the query using the UserRelatedByCreatedBy relation
 *
 * @method     ChildBannerQuery leftJoinUserRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserRelatedByUpdatedBy relation
 * @method     ChildBannerQuery rightJoinUserRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserRelatedByUpdatedBy relation
 * @method     ChildBannerQuery innerJoinUserRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the UserRelatedByUpdatedBy relation
 *
 * @method     ChildBannerQuery joinWithUserRelatedByUpdatedBy($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the UserRelatedByUpdatedBy relation
 *
 * @method     ChildBannerQuery leftJoinWithUserRelatedByUpdatedBy() Adds a LEFT JOIN clause and with to the query using the UserRelatedByUpdatedBy relation
 * @method     ChildBannerQuery rightJoinWithUserRelatedByUpdatedBy() Adds a RIGHT JOIN clause and with to the query using the UserRelatedByUpdatedBy relation
 * @method     ChildBannerQuery innerJoinWithUserRelatedByUpdatedBy() Adds a INNER JOIN clause and with to the query using the UserRelatedByUpdatedBy relation
 *
 * @method     \Propel\Models\BannerGroupQuery|\Propel\Models\UserQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildBanner findOne(ConnectionInterface $con = null) Return the first ChildBanner matching the query
 * @method     ChildBanner findOneOrCreate(ConnectionInterface $con = null) Return the first ChildBanner matching the query, or a new ChildBanner object populated from the query conditions when no match is found
 *
 * @method     ChildBanner findOneById(int $id) Return the first ChildBanner filtered by the id column
 * @method     ChildBanner findOneByBannerGroupId(int $banner_group_id) Return the first ChildBanner filtered by the banner_group_id column
 * @method     ChildBanner findOneByTitle(string $title) Return the first ChildBanner filtered by the title column
 * @method     ChildBanner findOneByDescription(string $description) Return the first ChildBanner filtered by the description column
 * @method     ChildBanner findOneByPicture(string $picture) Return the first ChildBanner filtered by the picture column
 * @method     ChildBanner findOneByPictureAlt(string $picture_alt) Return the first ChildBanner filtered by the picture_alt column
 * @method     ChildBanner findOneByPictureTitle(string $picture_title) Return the first ChildBanner filtered by the picture_title column
 * @method     ChildBanner findOneByHyperlinkUrl(string $hyperlink_url) Return the first ChildBanner filtered by the hyperlink_url column
 * @method     ChildBanner findOneByHyperlinkTitle(string $hyperlink_title) Return the first ChildBanner filtered by the hyperlink_title column
 * @method     ChildBanner findOneByHyperlinkTarget(string $hyperlink_target) Return the first ChildBanner filtered by the hyperlink_target column
 * @method     ChildBanner findOneByShowStart(string $show_start) Return the first ChildBanner filtered by the show_start column
 * @method     ChildBanner findOneByShowEnd(string $show_end) Return the first ChildBanner filtered by the show_end column
 * @method     ChildBanner findOneByShows(string $shows) Return the first ChildBanner filtered by the shows column
 * @method     ChildBanner findOneByShowsLimit(string $shows_limit) Return the first ChildBanner filtered by the shows_limit column
 * @method     ChildBanner findOneByClicks(string $clicks) Return the first ChildBanner filtered by the clicks column
 * @method     ChildBanner findOneByClicksLimit(string $clicks_limit) Return the first ChildBanner filtered by the clicks_limit column
 * @method     ChildBanner findOneByCreatedAt(string $created_at) Return the first ChildBanner filtered by the created_at column
 * @method     ChildBanner findOneByCreatedBy(int $created_by) Return the first ChildBanner filtered by the created_by column
 * @method     ChildBanner findOneByUpdatedAt(string $updated_at) Return the first ChildBanner filtered by the updated_at column
 * @method     ChildBanner findOneByUpdatedBy(int $updated_by) Return the first ChildBanner filtered by the updated_by column *

 * @method     ChildBanner requirePk($key, ConnectionInterface $con = null) Return the ChildBanner by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBanner requireOne(ConnectionInterface $con = null) Return the first ChildBanner matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildBanner requireOneById(int $id) Return the first ChildBanner filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBanner requireOneByBannerGroupId(int $banner_group_id) Return the first ChildBanner filtered by the banner_group_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBanner requireOneByTitle(string $title) Return the first ChildBanner filtered by the title column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBanner requireOneByDescription(string $description) Return the first ChildBanner filtered by the description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBanner requireOneByPicture(string $picture) Return the first ChildBanner filtered by the picture column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBanner requireOneByPictureAlt(string $picture_alt) Return the first ChildBanner filtered by the picture_alt column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBanner requireOneByPictureTitle(string $picture_title) Return the first ChildBanner filtered by the picture_title column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBanner requireOneByHyperlinkUrl(string $hyperlink_url) Return the first ChildBanner filtered by the hyperlink_url column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBanner requireOneByHyperlinkTitle(string $hyperlink_title) Return the first ChildBanner filtered by the hyperlink_title column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBanner requireOneByHyperlinkTarget(string $hyperlink_target) Return the first ChildBanner filtered by the hyperlink_target column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBanner requireOneByShowStart(string $show_start) Return the first ChildBanner filtered by the show_start column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBanner requireOneByShowEnd(string $show_end) Return the first ChildBanner filtered by the show_end column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBanner requireOneByShows(string $shows) Return the first ChildBanner filtered by the shows column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBanner requireOneByShowsLimit(string $shows_limit) Return the first ChildBanner filtered by the shows_limit column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBanner requireOneByClicks(string $clicks) Return the first ChildBanner filtered by the clicks column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBanner requireOneByClicksLimit(string $clicks_limit) Return the first ChildBanner filtered by the clicks_limit column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBanner requireOneByCreatedAt(string $created_at) Return the first ChildBanner filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBanner requireOneByCreatedBy(int $created_by) Return the first ChildBanner filtered by the created_by column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBanner requireOneByUpdatedAt(string $updated_at) Return the first ChildBanner filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBanner requireOneByUpdatedBy(int $updated_by) Return the first ChildBanner filtered by the updated_by column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildBanner[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildBanner objects based on current ModelCriteria
 * @method     ChildBanner[]|ObjectCollection findById(int $id) Return ChildBanner objects filtered by the id column
 * @method     ChildBanner[]|ObjectCollection findByBannerGroupId(int $banner_group_id) Return ChildBanner objects filtered by the banner_group_id column
 * @method     ChildBanner[]|ObjectCollection findByTitle(string $title) Return ChildBanner objects filtered by the title column
 * @method     ChildBanner[]|ObjectCollection findByDescription(string $description) Return ChildBanner objects filtered by the description column
 * @method     ChildBanner[]|ObjectCollection findByPicture(string $picture) Return ChildBanner objects filtered by the picture column
 * @method     ChildBanner[]|ObjectCollection findByPictureAlt(string $picture_alt) Return ChildBanner objects filtered by the picture_alt column
 * @method     ChildBanner[]|ObjectCollection findByPictureTitle(string $picture_title) Return ChildBanner objects filtered by the picture_title column
 * @method     ChildBanner[]|ObjectCollection findByHyperlinkUrl(string $hyperlink_url) Return ChildBanner objects filtered by the hyperlink_url column
 * @method     ChildBanner[]|ObjectCollection findByHyperlinkTitle(string $hyperlink_title) Return ChildBanner objects filtered by the hyperlink_title column
 * @method     ChildBanner[]|ObjectCollection findByHyperlinkTarget(string $hyperlink_target) Return ChildBanner objects filtered by the hyperlink_target column
 * @method     ChildBanner[]|ObjectCollection findByShowStart(string $show_start) Return ChildBanner objects filtered by the show_start column
 * @method     ChildBanner[]|ObjectCollection findByShowEnd(string $show_end) Return ChildBanner objects filtered by the show_end column
 * @method     ChildBanner[]|ObjectCollection findByShows(string $shows) Return ChildBanner objects filtered by the shows column
 * @method     ChildBanner[]|ObjectCollection findByShowsLimit(string $shows_limit) Return ChildBanner objects filtered by the shows_limit column
 * @method     ChildBanner[]|ObjectCollection findByClicks(string $clicks) Return ChildBanner objects filtered by the clicks column
 * @method     ChildBanner[]|ObjectCollection findByClicksLimit(string $clicks_limit) Return ChildBanner objects filtered by the clicks_limit column
 * @method     ChildBanner[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildBanner objects filtered by the created_at column
 * @method     ChildBanner[]|ObjectCollection findByCreatedBy(int $created_by) Return ChildBanner objects filtered by the created_by column
 * @method     ChildBanner[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildBanner objects filtered by the updated_at column
 * @method     ChildBanner[]|ObjectCollection findByUpdatedBy(int $updated_by) Return ChildBanner objects filtered by the updated_by column
 * @method     ChildBanner[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class BannerQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Propel\Models\Base\BannerQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Propel\\Models\\Banner', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildBannerQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildBannerQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildBannerQuery) {
            return $criteria;
        }
        $query = new ChildBannerQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildBanner|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(BannerTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = BannerTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
            // the object is already in the instance pool
            return $obj;
        }

        return $this->findPkSimple($key, $con);
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildBanner A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, banner_group_id, title, description, picture, picture_alt, picture_title, hyperlink_url, hyperlink_title, hyperlink_target, show_start, show_end, shows, shows_limit, clicks, clicks_limit, created_at, created_by, updated_at, updated_by FROM fenric_banner WHERE id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildBanner $obj */
            $obj = new ChildBanner();
            $obj->hydrate($row);
            BannerTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildBanner|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildBannerQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(BannerTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildBannerQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(BannerTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBannerQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(BannerTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(BannerTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BannerTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the banner_group_id column
     *
     * Example usage:
     * <code>
     * $query->filterByBannerGroupId(1234); // WHERE banner_group_id = 1234
     * $query->filterByBannerGroupId(array(12, 34)); // WHERE banner_group_id IN (12, 34)
     * $query->filterByBannerGroupId(array('min' => 12)); // WHERE banner_group_id > 12
     * </code>
     *
     * @see       filterByBannerGroup()
     *
     * @param     mixed $bannerGroupId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBannerQuery The current query, for fluid interface
     */
    public function filterByBannerGroupId($bannerGroupId = null, $comparison = null)
    {
        if (is_array($bannerGroupId)) {
            $useMinMax = false;
            if (isset($bannerGroupId['min'])) {
                $this->addUsingAlias(BannerTableMap::COL_BANNER_GROUP_ID, $bannerGroupId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($bannerGroupId['max'])) {
                $this->addUsingAlias(BannerTableMap::COL_BANNER_GROUP_ID, $bannerGroupId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BannerTableMap::COL_BANNER_GROUP_ID, $bannerGroupId, $comparison);
    }

    /**
     * Filter the query on the title column
     *
     * Example usage:
     * <code>
     * $query->filterByTitle('fooValue');   // WHERE title = 'fooValue'
     * $query->filterByTitle('%fooValue%', Criteria::LIKE); // WHERE title LIKE '%fooValue%'
     * </code>
     *
     * @param     string $title The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBannerQuery The current query, for fluid interface
     */
    public function filterByTitle($title = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($title)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BannerTableMap::COL_TITLE, $title, $comparison);
    }

    /**
     * Filter the query on the description column
     *
     * Example usage:
     * <code>
     * $query->filterByDescription('fooValue');   // WHERE description = 'fooValue'
     * $query->filterByDescription('%fooValue%', Criteria::LIKE); // WHERE description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $description The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBannerQuery The current query, for fluid interface
     */
    public function filterByDescription($description = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($description)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BannerTableMap::COL_DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query on the picture column
     *
     * Example usage:
     * <code>
     * $query->filterByPicture('fooValue');   // WHERE picture = 'fooValue'
     * $query->filterByPicture('%fooValue%', Criteria::LIKE); // WHERE picture LIKE '%fooValue%'
     * </code>
     *
     * @param     string $picture The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBannerQuery The current query, for fluid interface
     */
    public function filterByPicture($picture = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($picture)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BannerTableMap::COL_PICTURE, $picture, $comparison);
    }

    /**
     * Filter the query on the picture_alt column
     *
     * Example usage:
     * <code>
     * $query->filterByPictureAlt('fooValue');   // WHERE picture_alt = 'fooValue'
     * $query->filterByPictureAlt('%fooValue%', Criteria::LIKE); // WHERE picture_alt LIKE '%fooValue%'
     * </code>
     *
     * @param     string $pictureAlt The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBannerQuery The current query, for fluid interface
     */
    public function filterByPictureAlt($pictureAlt = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($pictureAlt)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BannerTableMap::COL_PICTURE_ALT, $pictureAlt, $comparison);
    }

    /**
     * Filter the query on the picture_title column
     *
     * Example usage:
     * <code>
     * $query->filterByPictureTitle('fooValue');   // WHERE picture_title = 'fooValue'
     * $query->filterByPictureTitle('%fooValue%', Criteria::LIKE); // WHERE picture_title LIKE '%fooValue%'
     * </code>
     *
     * @param     string $pictureTitle The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBannerQuery The current query, for fluid interface
     */
    public function filterByPictureTitle($pictureTitle = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($pictureTitle)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BannerTableMap::COL_PICTURE_TITLE, $pictureTitle, $comparison);
    }

    /**
     * Filter the query on the hyperlink_url column
     *
     * Example usage:
     * <code>
     * $query->filterByHyperlinkUrl('fooValue');   // WHERE hyperlink_url = 'fooValue'
     * $query->filterByHyperlinkUrl('%fooValue%', Criteria::LIKE); // WHERE hyperlink_url LIKE '%fooValue%'
     * </code>
     *
     * @param     string $hyperlinkUrl The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBannerQuery The current query, for fluid interface
     */
    public function filterByHyperlinkUrl($hyperlinkUrl = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($hyperlinkUrl)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BannerTableMap::COL_HYPERLINK_URL, $hyperlinkUrl, $comparison);
    }

    /**
     * Filter the query on the hyperlink_title column
     *
     * Example usage:
     * <code>
     * $query->filterByHyperlinkTitle('fooValue');   // WHERE hyperlink_title = 'fooValue'
     * $query->filterByHyperlinkTitle('%fooValue%', Criteria::LIKE); // WHERE hyperlink_title LIKE '%fooValue%'
     * </code>
     *
     * @param     string $hyperlinkTitle The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBannerQuery The current query, for fluid interface
     */
    public function filterByHyperlinkTitle($hyperlinkTitle = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($hyperlinkTitle)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BannerTableMap::COL_HYPERLINK_TITLE, $hyperlinkTitle, $comparison);
    }

    /**
     * Filter the query on the hyperlink_target column
     *
     * Example usage:
     * <code>
     * $query->filterByHyperlinkTarget('fooValue');   // WHERE hyperlink_target = 'fooValue'
     * $query->filterByHyperlinkTarget('%fooValue%', Criteria::LIKE); // WHERE hyperlink_target LIKE '%fooValue%'
     * </code>
     *
     * @param     string $hyperlinkTarget The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBannerQuery The current query, for fluid interface
     */
    public function filterByHyperlinkTarget($hyperlinkTarget = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($hyperlinkTarget)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BannerTableMap::COL_HYPERLINK_TARGET, $hyperlinkTarget, $comparison);
    }

    /**
     * Filter the query on the show_start column
     *
     * Example usage:
     * <code>
     * $query->filterByShowStart('2011-03-14'); // WHERE show_start = '2011-03-14'
     * $query->filterByShowStart('now'); // WHERE show_start = '2011-03-14'
     * $query->filterByShowStart(array('max' => 'yesterday')); // WHERE show_start > '2011-03-13'
     * </code>
     *
     * @param     mixed $showStart The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBannerQuery The current query, for fluid interface
     */
    public function filterByShowStart($showStart = null, $comparison = null)
    {
        if (is_array($showStart)) {
            $useMinMax = false;
            if (isset($showStart['min'])) {
                $this->addUsingAlias(BannerTableMap::COL_SHOW_START, $showStart['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($showStart['max'])) {
                $this->addUsingAlias(BannerTableMap::COL_SHOW_START, $showStart['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BannerTableMap::COL_SHOW_START, $showStart, $comparison);
    }

    /**
     * Filter the query on the show_end column
     *
     * Example usage:
     * <code>
     * $query->filterByShowEnd('2011-03-14'); // WHERE show_end = '2011-03-14'
     * $query->filterByShowEnd('now'); // WHERE show_end = '2011-03-14'
     * $query->filterByShowEnd(array('max' => 'yesterday')); // WHERE show_end > '2011-03-13'
     * </code>
     *
     * @param     mixed $showEnd The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBannerQuery The current query, for fluid interface
     */
    public function filterByShowEnd($showEnd = null, $comparison = null)
    {
        if (is_array($showEnd)) {
            $useMinMax = false;
            if (isset($showEnd['min'])) {
                $this->addUsingAlias(BannerTableMap::COL_SHOW_END, $showEnd['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($showEnd['max'])) {
                $this->addUsingAlias(BannerTableMap::COL_SHOW_END, $showEnd['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BannerTableMap::COL_SHOW_END, $showEnd, $comparison);
    }

    /**
     * Filter the query on the shows column
     *
     * Example usage:
     * <code>
     * $query->filterByShows(1234); // WHERE shows = 1234
     * $query->filterByShows(array(12, 34)); // WHERE shows IN (12, 34)
     * $query->filterByShows(array('min' => 12)); // WHERE shows > 12
     * </code>
     *
     * @param     mixed $shows The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBannerQuery The current query, for fluid interface
     */
    public function filterByShows($shows = null, $comparison = null)
    {
        if (is_array($shows)) {
            $useMinMax = false;
            if (isset($shows['min'])) {
                $this->addUsingAlias(BannerTableMap::COL_SHOWS, $shows['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($shows['max'])) {
                $this->addUsingAlias(BannerTableMap::COL_SHOWS, $shows['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BannerTableMap::COL_SHOWS, $shows, $comparison);
    }

    /**
     * Filter the query on the shows_limit column
     *
     * Example usage:
     * <code>
     * $query->filterByShowsLimit(1234); // WHERE shows_limit = 1234
     * $query->filterByShowsLimit(array(12, 34)); // WHERE shows_limit IN (12, 34)
     * $query->filterByShowsLimit(array('min' => 12)); // WHERE shows_limit > 12
     * </code>
     *
     * @param     mixed $showsLimit The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBannerQuery The current query, for fluid interface
     */
    public function filterByShowsLimit($showsLimit = null, $comparison = null)
    {
        if (is_array($showsLimit)) {
            $useMinMax = false;
            if (isset($showsLimit['min'])) {
                $this->addUsingAlias(BannerTableMap::COL_SHOWS_LIMIT, $showsLimit['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($showsLimit['max'])) {
                $this->addUsingAlias(BannerTableMap::COL_SHOWS_LIMIT, $showsLimit['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BannerTableMap::COL_SHOWS_LIMIT, $showsLimit, $comparison);
    }

    /**
     * Filter the query on the clicks column
     *
     * Example usage:
     * <code>
     * $query->filterByClicks(1234); // WHERE clicks = 1234
     * $query->filterByClicks(array(12, 34)); // WHERE clicks IN (12, 34)
     * $query->filterByClicks(array('min' => 12)); // WHERE clicks > 12
     * </code>
     *
     * @param     mixed $clicks The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBannerQuery The current query, for fluid interface
     */
    public function filterByClicks($clicks = null, $comparison = null)
    {
        if (is_array($clicks)) {
            $useMinMax = false;
            if (isset($clicks['min'])) {
                $this->addUsingAlias(BannerTableMap::COL_CLICKS, $clicks['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($clicks['max'])) {
                $this->addUsingAlias(BannerTableMap::COL_CLICKS, $clicks['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BannerTableMap::COL_CLICKS, $clicks, $comparison);
    }

    /**
     * Filter the query on the clicks_limit column
     *
     * Example usage:
     * <code>
     * $query->filterByClicksLimit(1234); // WHERE clicks_limit = 1234
     * $query->filterByClicksLimit(array(12, 34)); // WHERE clicks_limit IN (12, 34)
     * $query->filterByClicksLimit(array('min' => 12)); // WHERE clicks_limit > 12
     * </code>
     *
     * @param     mixed $clicksLimit The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBannerQuery The current query, for fluid interface
     */
    public function filterByClicksLimit($clicksLimit = null, $comparison = null)
    {
        if (is_array($clicksLimit)) {
            $useMinMax = false;
            if (isset($clicksLimit['min'])) {
                $this->addUsingAlias(BannerTableMap::COL_CLICKS_LIMIT, $clicksLimit['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($clicksLimit['max'])) {
                $this->addUsingAlias(BannerTableMap::COL_CLICKS_LIMIT, $clicksLimit['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BannerTableMap::COL_CLICKS_LIMIT, $clicksLimit, $comparison);
    }

    /**
     * Filter the query on the created_at column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatedAt('2011-03-14'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt('now'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt(array('max' => 'yesterday')); // WHERE created_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $createdAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBannerQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(BannerTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(BannerTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BannerTableMap::COL_CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query on the created_by column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatedBy(1234); // WHERE created_by = 1234
     * $query->filterByCreatedBy(array(12, 34)); // WHERE created_by IN (12, 34)
     * $query->filterByCreatedBy(array('min' => 12)); // WHERE created_by > 12
     * </code>
     *
     * @see       filterByUserRelatedByCreatedBy()
     *
     * @param     mixed $createdBy The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBannerQuery The current query, for fluid interface
     */
    public function filterByCreatedBy($createdBy = null, $comparison = null)
    {
        if (is_array($createdBy)) {
            $useMinMax = false;
            if (isset($createdBy['min'])) {
                $this->addUsingAlias(BannerTableMap::COL_CREATED_BY, $createdBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdBy['max'])) {
                $this->addUsingAlias(BannerTableMap::COL_CREATED_BY, $createdBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BannerTableMap::COL_CREATED_BY, $createdBy, $comparison);
    }

    /**
     * Filter the query on the updated_at column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdatedAt('2011-03-14'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt('now'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt(array('max' => 'yesterday')); // WHERE updated_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $updatedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBannerQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(BannerTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(BannerTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BannerTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query on the updated_by column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdatedBy(1234); // WHERE updated_by = 1234
     * $query->filterByUpdatedBy(array(12, 34)); // WHERE updated_by IN (12, 34)
     * $query->filterByUpdatedBy(array('min' => 12)); // WHERE updated_by > 12
     * </code>
     *
     * @see       filterByUserRelatedByUpdatedBy()
     *
     * @param     mixed $updatedBy The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBannerQuery The current query, for fluid interface
     */
    public function filterByUpdatedBy($updatedBy = null, $comparison = null)
    {
        if (is_array($updatedBy)) {
            $useMinMax = false;
            if (isset($updatedBy['min'])) {
                $this->addUsingAlias(BannerTableMap::COL_UPDATED_BY, $updatedBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedBy['max'])) {
                $this->addUsingAlias(BannerTableMap::COL_UPDATED_BY, $updatedBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BannerTableMap::COL_UPDATED_BY, $updatedBy, $comparison);
    }

    /**
     * Filter the query by a related \Propel\Models\BannerGroup object
     *
     * @param \Propel\Models\BannerGroup|ObjectCollection $bannerGroup The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildBannerQuery The current query, for fluid interface
     */
    public function filterByBannerGroup($bannerGroup, $comparison = null)
    {
        if ($bannerGroup instanceof \Propel\Models\BannerGroup) {
            return $this
                ->addUsingAlias(BannerTableMap::COL_BANNER_GROUP_ID, $bannerGroup->getId(), $comparison);
        } elseif ($bannerGroup instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(BannerTableMap::COL_BANNER_GROUP_ID, $bannerGroup->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByBannerGroup() only accepts arguments of type \Propel\Models\BannerGroup or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the BannerGroup relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildBannerQuery The current query, for fluid interface
     */
    public function joinBannerGroup($relationAlias = null, $joinType = 'INNER JOIN')
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('BannerGroup');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'BannerGroup');
        }

        return $this;
    }

    /**
     * Use the BannerGroup relation BannerGroup object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Propel\Models\BannerGroupQuery A secondary query class using the current class as primary query
     */
    public function useBannerGroupQuery($relationAlias = null, $joinType = 'INNER JOIN')
    {
        return $this
            ->joinBannerGroup($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'BannerGroup', '\Propel\Models\BannerGroupQuery');
    }

    /**
     * Filter the query by a related \Propel\Models\User object
     *
     * @param \Propel\Models\User|ObjectCollection $user The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildBannerQuery The current query, for fluid interface
     */
    public function filterByUserRelatedByCreatedBy($user, $comparison = null)
    {
        if ($user instanceof \Propel\Models\User) {
            return $this
                ->addUsingAlias(BannerTableMap::COL_CREATED_BY, $user->getId(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(BannerTableMap::COL_CREATED_BY, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByUserRelatedByCreatedBy() only accepts arguments of type \Propel\Models\User or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UserRelatedByCreatedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildBannerQuery The current query, for fluid interface
     */
    public function joinUserRelatedByCreatedBy($relationAlias = null, $joinType = 'INNER JOIN')
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UserRelatedByCreatedBy');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'UserRelatedByCreatedBy');
        }

        return $this;
    }

    /**
     * Use the UserRelatedByCreatedBy relation User object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Propel\Models\UserQuery A secondary query class using the current class as primary query
     */
    public function useUserRelatedByCreatedByQuery($relationAlias = null, $joinType = 'INNER JOIN')
    {
        return $this
            ->joinUserRelatedByCreatedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UserRelatedByCreatedBy', '\Propel\Models\UserQuery');
    }

    /**
     * Filter the query by a related \Propel\Models\User object
     *
     * @param \Propel\Models\User|ObjectCollection $user The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildBannerQuery The current query, for fluid interface
     */
    public function filterByUserRelatedByUpdatedBy($user, $comparison = null)
    {
        if ($user instanceof \Propel\Models\User) {
            return $this
                ->addUsingAlias(BannerTableMap::COL_UPDATED_BY, $user->getId(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(BannerTableMap::COL_UPDATED_BY, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByUserRelatedByUpdatedBy() only accepts arguments of type \Propel\Models\User or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UserRelatedByUpdatedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildBannerQuery The current query, for fluid interface
     */
    public function joinUserRelatedByUpdatedBy($relationAlias = null, $joinType = 'INNER JOIN')
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UserRelatedByUpdatedBy');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'UserRelatedByUpdatedBy');
        }

        return $this;
    }

    /**
     * Use the UserRelatedByUpdatedBy relation User object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Propel\Models\UserQuery A secondary query class using the current class as primary query
     */
    public function useUserRelatedByUpdatedByQuery($relationAlias = null, $joinType = 'INNER JOIN')
    {
        return $this
            ->joinUserRelatedByUpdatedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UserRelatedByUpdatedBy', '\Propel\Models\UserQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildBanner $banner Object to remove from the list of results
     *
     * @return $this|ChildBannerQuery The current query, for fluid interface
     */
    public function prune($banner = null)
    {
        if ($banner) {
            $this->addUsingAlias(BannerTableMap::COL_ID, $banner->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the fenric_banner table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(BannerTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            BannerTableMap::clearInstancePool();
            BannerTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(BannerTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(BannerTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            BannerTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            BannerTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // BannerQuery
