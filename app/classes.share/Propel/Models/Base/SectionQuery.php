<?php

namespace Propel\Models\Base;

use \Exception;
use \PDO;
use Propel\Models\Section as ChildSection;
use Propel\Models\SectionQuery as ChildSectionQuery;
use Propel\Models\Map\SectionTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'fenric_section' table.
 *
 *
 *
 * @method     ChildSectionQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildSectionQuery orderByCode($order = Criteria::ASC) Order by the code column
 * @method     ChildSectionQuery orderByHeader($order = Criteria::ASC) Order by the header column
 * @method     ChildSectionQuery orderByPicture($order = Criteria::ASC) Order by the picture column
 * @method     ChildSectionQuery orderByContent($order = Criteria::ASC) Order by the content column
 * @method     ChildSectionQuery orderByMetaTitle($order = Criteria::ASC) Order by the meta_title column
 * @method     ChildSectionQuery orderByMetaAuthor($order = Criteria::ASC) Order by the meta_author column
 * @method     ChildSectionQuery orderByMetaKeywords($order = Criteria::ASC) Order by the meta_keywords column
 * @method     ChildSectionQuery orderByMetaDescription($order = Criteria::ASC) Order by the meta_description column
 * @method     ChildSectionQuery orderByMetaCanonical($order = Criteria::ASC) Order by the meta_canonical column
 * @method     ChildSectionQuery orderByMetaRobots($order = Criteria::ASC) Order by the meta_robots column
 * @method     ChildSectionQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildSectionQuery orderByCreatedBy($order = Criteria::ASC) Order by the created_by column
 * @method     ChildSectionQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 * @method     ChildSectionQuery orderByUpdatedBy($order = Criteria::ASC) Order by the updated_by column
 *
 * @method     ChildSectionQuery groupById() Group by the id column
 * @method     ChildSectionQuery groupByCode() Group by the code column
 * @method     ChildSectionQuery groupByHeader() Group by the header column
 * @method     ChildSectionQuery groupByPicture() Group by the picture column
 * @method     ChildSectionQuery groupByContent() Group by the content column
 * @method     ChildSectionQuery groupByMetaTitle() Group by the meta_title column
 * @method     ChildSectionQuery groupByMetaAuthor() Group by the meta_author column
 * @method     ChildSectionQuery groupByMetaKeywords() Group by the meta_keywords column
 * @method     ChildSectionQuery groupByMetaDescription() Group by the meta_description column
 * @method     ChildSectionQuery groupByMetaCanonical() Group by the meta_canonical column
 * @method     ChildSectionQuery groupByMetaRobots() Group by the meta_robots column
 * @method     ChildSectionQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildSectionQuery groupByCreatedBy() Group by the created_by column
 * @method     ChildSectionQuery groupByUpdatedAt() Group by the updated_at column
 * @method     ChildSectionQuery groupByUpdatedBy() Group by the updated_by column
 *
 * @method     ChildSectionQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSectionQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSectionQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSectionQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildSectionQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildSectionQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildSectionQuery leftJoinUserRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserRelatedByCreatedBy relation
 * @method     ChildSectionQuery rightJoinUserRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserRelatedByCreatedBy relation
 * @method     ChildSectionQuery innerJoinUserRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the UserRelatedByCreatedBy relation
 *
 * @method     ChildSectionQuery joinWithUserRelatedByCreatedBy($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the UserRelatedByCreatedBy relation
 *
 * @method     ChildSectionQuery leftJoinWithUserRelatedByCreatedBy() Adds a LEFT JOIN clause and with to the query using the UserRelatedByCreatedBy relation
 * @method     ChildSectionQuery rightJoinWithUserRelatedByCreatedBy() Adds a RIGHT JOIN clause and with to the query using the UserRelatedByCreatedBy relation
 * @method     ChildSectionQuery innerJoinWithUserRelatedByCreatedBy() Adds a INNER JOIN clause and with to the query using the UserRelatedByCreatedBy relation
 *
 * @method     ChildSectionQuery leftJoinUserRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserRelatedByUpdatedBy relation
 * @method     ChildSectionQuery rightJoinUserRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserRelatedByUpdatedBy relation
 * @method     ChildSectionQuery innerJoinUserRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the UserRelatedByUpdatedBy relation
 *
 * @method     ChildSectionQuery joinWithUserRelatedByUpdatedBy($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the UserRelatedByUpdatedBy relation
 *
 * @method     ChildSectionQuery leftJoinWithUserRelatedByUpdatedBy() Adds a LEFT JOIN clause and with to the query using the UserRelatedByUpdatedBy relation
 * @method     ChildSectionQuery rightJoinWithUserRelatedByUpdatedBy() Adds a RIGHT JOIN clause and with to the query using the UserRelatedByUpdatedBy relation
 * @method     ChildSectionQuery innerJoinWithUserRelatedByUpdatedBy() Adds a INNER JOIN clause and with to the query using the UserRelatedByUpdatedBy relation
 *
 * @method     ChildSectionQuery leftJoinSectionField($relationAlias = null) Adds a LEFT JOIN clause to the query using the SectionField relation
 * @method     ChildSectionQuery rightJoinSectionField($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SectionField relation
 * @method     ChildSectionQuery innerJoinSectionField($relationAlias = null) Adds a INNER JOIN clause to the query using the SectionField relation
 *
 * @method     ChildSectionQuery joinWithSectionField($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the SectionField relation
 *
 * @method     ChildSectionQuery leftJoinWithSectionField() Adds a LEFT JOIN clause and with to the query using the SectionField relation
 * @method     ChildSectionQuery rightJoinWithSectionField() Adds a RIGHT JOIN clause and with to the query using the SectionField relation
 * @method     ChildSectionQuery innerJoinWithSectionField() Adds a INNER JOIN clause and with to the query using the SectionField relation
 *
 * @method     ChildSectionQuery leftJoinPublication($relationAlias = null) Adds a LEFT JOIN clause to the query using the Publication relation
 * @method     ChildSectionQuery rightJoinPublication($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Publication relation
 * @method     ChildSectionQuery innerJoinPublication($relationAlias = null) Adds a INNER JOIN clause to the query using the Publication relation
 *
 * @method     ChildSectionQuery joinWithPublication($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Publication relation
 *
 * @method     ChildSectionQuery leftJoinWithPublication() Adds a LEFT JOIN clause and with to the query using the Publication relation
 * @method     ChildSectionQuery rightJoinWithPublication() Adds a RIGHT JOIN clause and with to the query using the Publication relation
 * @method     ChildSectionQuery innerJoinWithPublication() Adds a INNER JOIN clause and with to the query using the Publication relation
 *
 * @method     \Propel\Models\UserQuery|\Propel\Models\SectionFieldQuery|\Propel\Models\PublicationQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildSection findOne(ConnectionInterface $con = null) Return the first ChildSection matching the query
 * @method     ChildSection findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSection matching the query, or a new ChildSection object populated from the query conditions when no match is found
 *
 * @method     ChildSection findOneById(int $id) Return the first ChildSection filtered by the id column
 * @method     ChildSection findOneByCode(string $code) Return the first ChildSection filtered by the code column
 * @method     ChildSection findOneByHeader(string $header) Return the first ChildSection filtered by the header column
 * @method     ChildSection findOneByPicture(string $picture) Return the first ChildSection filtered by the picture column
 * @method     ChildSection findOneByContent(string $content) Return the first ChildSection filtered by the content column
 * @method     ChildSection findOneByMetaTitle(string $meta_title) Return the first ChildSection filtered by the meta_title column
 * @method     ChildSection findOneByMetaAuthor(string $meta_author) Return the first ChildSection filtered by the meta_author column
 * @method     ChildSection findOneByMetaKeywords(string $meta_keywords) Return the first ChildSection filtered by the meta_keywords column
 * @method     ChildSection findOneByMetaDescription(string $meta_description) Return the first ChildSection filtered by the meta_description column
 * @method     ChildSection findOneByMetaCanonical(string $meta_canonical) Return the first ChildSection filtered by the meta_canonical column
 * @method     ChildSection findOneByMetaRobots(string $meta_robots) Return the first ChildSection filtered by the meta_robots column
 * @method     ChildSection findOneByCreatedAt(string $created_at) Return the first ChildSection filtered by the created_at column
 * @method     ChildSection findOneByCreatedBy(int $created_by) Return the first ChildSection filtered by the created_by column
 * @method     ChildSection findOneByUpdatedAt(string $updated_at) Return the first ChildSection filtered by the updated_at column
 * @method     ChildSection findOneByUpdatedBy(int $updated_by) Return the first ChildSection filtered by the updated_by column *

 * @method     ChildSection requirePk($key, ConnectionInterface $con = null) Return the ChildSection by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSection requireOne(ConnectionInterface $con = null) Return the first ChildSection matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSection requireOneById(int $id) Return the first ChildSection filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSection requireOneByCode(string $code) Return the first ChildSection filtered by the code column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSection requireOneByHeader(string $header) Return the first ChildSection filtered by the header column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSection requireOneByPicture(string $picture) Return the first ChildSection filtered by the picture column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSection requireOneByContent(string $content) Return the first ChildSection filtered by the content column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSection requireOneByMetaTitle(string $meta_title) Return the first ChildSection filtered by the meta_title column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSection requireOneByMetaAuthor(string $meta_author) Return the first ChildSection filtered by the meta_author column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSection requireOneByMetaKeywords(string $meta_keywords) Return the first ChildSection filtered by the meta_keywords column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSection requireOneByMetaDescription(string $meta_description) Return the first ChildSection filtered by the meta_description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSection requireOneByMetaCanonical(string $meta_canonical) Return the first ChildSection filtered by the meta_canonical column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSection requireOneByMetaRobots(string $meta_robots) Return the first ChildSection filtered by the meta_robots column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSection requireOneByCreatedAt(string $created_at) Return the first ChildSection filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSection requireOneByCreatedBy(int $created_by) Return the first ChildSection filtered by the created_by column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSection requireOneByUpdatedAt(string $updated_at) Return the first ChildSection filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSection requireOneByUpdatedBy(int $updated_by) Return the first ChildSection filtered by the updated_by column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSection[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSection objects based on current ModelCriteria
 * @method     ChildSection[]|ObjectCollection findById(int $id) Return ChildSection objects filtered by the id column
 * @method     ChildSection[]|ObjectCollection findByCode(string $code) Return ChildSection objects filtered by the code column
 * @method     ChildSection[]|ObjectCollection findByHeader(string $header) Return ChildSection objects filtered by the header column
 * @method     ChildSection[]|ObjectCollection findByPicture(string $picture) Return ChildSection objects filtered by the picture column
 * @method     ChildSection[]|ObjectCollection findByContent(string $content) Return ChildSection objects filtered by the content column
 * @method     ChildSection[]|ObjectCollection findByMetaTitle(string $meta_title) Return ChildSection objects filtered by the meta_title column
 * @method     ChildSection[]|ObjectCollection findByMetaAuthor(string $meta_author) Return ChildSection objects filtered by the meta_author column
 * @method     ChildSection[]|ObjectCollection findByMetaKeywords(string $meta_keywords) Return ChildSection objects filtered by the meta_keywords column
 * @method     ChildSection[]|ObjectCollection findByMetaDescription(string $meta_description) Return ChildSection objects filtered by the meta_description column
 * @method     ChildSection[]|ObjectCollection findByMetaCanonical(string $meta_canonical) Return ChildSection objects filtered by the meta_canonical column
 * @method     ChildSection[]|ObjectCollection findByMetaRobots(string $meta_robots) Return ChildSection objects filtered by the meta_robots column
 * @method     ChildSection[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildSection objects filtered by the created_at column
 * @method     ChildSection[]|ObjectCollection findByCreatedBy(int $created_by) Return ChildSection objects filtered by the created_by column
 * @method     ChildSection[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildSection objects filtered by the updated_at column
 * @method     ChildSection[]|ObjectCollection findByUpdatedBy(int $updated_by) Return ChildSection objects filtered by the updated_by column
 * @method     ChildSection[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SectionQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Propel\Models\Base\SectionQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Propel\\Models\\Section', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSectionQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSectionQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSectionQuery) {
            return $criteria;
        }
        $query = new ChildSectionQuery();
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
     * @return ChildSection|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SectionTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = SectionTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildSection A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, code, header, picture, meta_title, meta_author, meta_keywords, meta_description, meta_canonical, meta_robots, created_at, created_by, updated_at, updated_by FROM fenric_section WHERE id = :p0';
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
            /** @var ChildSection $obj */
            $obj = new ChildSection();
            $obj->hydrate($row);
            SectionTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildSection|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildSectionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SectionTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSectionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SectionTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildSectionQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(SectionTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(SectionTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SectionTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the code column
     *
     * Example usage:
     * <code>
     * $query->filterByCode('fooValue');   // WHERE code = 'fooValue'
     * $query->filterByCode('%fooValue%', Criteria::LIKE); // WHERE code LIKE '%fooValue%'
     * </code>
     *
     * @param     string $code The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSectionQuery The current query, for fluid interface
     */
    public function filterByCode($code = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($code)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SectionTableMap::COL_CODE, $code, $comparison);
    }

    /**
     * Filter the query on the header column
     *
     * Example usage:
     * <code>
     * $query->filterByHeader('fooValue');   // WHERE header = 'fooValue'
     * $query->filterByHeader('%fooValue%', Criteria::LIKE); // WHERE header LIKE '%fooValue%'
     * </code>
     *
     * @param     string $header The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSectionQuery The current query, for fluid interface
     */
    public function filterByHeader($header = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($header)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SectionTableMap::COL_HEADER, $header, $comparison);
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
     * @return $this|ChildSectionQuery The current query, for fluid interface
     */
    public function filterByPicture($picture = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($picture)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SectionTableMap::COL_PICTURE, $picture, $comparison);
    }

    /**
     * Filter the query on the content column
     *
     * Example usage:
     * <code>
     * $query->filterByContent('fooValue');   // WHERE content = 'fooValue'
     * $query->filterByContent('%fooValue%', Criteria::LIKE); // WHERE content LIKE '%fooValue%'
     * </code>
     *
     * @param     string $content The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSectionQuery The current query, for fluid interface
     */
    public function filterByContent($content = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($content)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SectionTableMap::COL_CONTENT, $content, $comparison);
    }

    /**
     * Filter the query on the meta_title column
     *
     * Example usage:
     * <code>
     * $query->filterByMetaTitle('fooValue');   // WHERE meta_title = 'fooValue'
     * $query->filterByMetaTitle('%fooValue%', Criteria::LIKE); // WHERE meta_title LIKE '%fooValue%'
     * </code>
     *
     * @param     string $metaTitle The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSectionQuery The current query, for fluid interface
     */
    public function filterByMetaTitle($metaTitle = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($metaTitle)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SectionTableMap::COL_META_TITLE, $metaTitle, $comparison);
    }

    /**
     * Filter the query on the meta_author column
     *
     * Example usage:
     * <code>
     * $query->filterByMetaAuthor('fooValue');   // WHERE meta_author = 'fooValue'
     * $query->filterByMetaAuthor('%fooValue%', Criteria::LIKE); // WHERE meta_author LIKE '%fooValue%'
     * </code>
     *
     * @param     string $metaAuthor The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSectionQuery The current query, for fluid interface
     */
    public function filterByMetaAuthor($metaAuthor = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($metaAuthor)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SectionTableMap::COL_META_AUTHOR, $metaAuthor, $comparison);
    }

    /**
     * Filter the query on the meta_keywords column
     *
     * Example usage:
     * <code>
     * $query->filterByMetaKeywords('fooValue');   // WHERE meta_keywords = 'fooValue'
     * $query->filterByMetaKeywords('%fooValue%', Criteria::LIKE); // WHERE meta_keywords LIKE '%fooValue%'
     * </code>
     *
     * @param     string $metaKeywords The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSectionQuery The current query, for fluid interface
     */
    public function filterByMetaKeywords($metaKeywords = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($metaKeywords)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SectionTableMap::COL_META_KEYWORDS, $metaKeywords, $comparison);
    }

    /**
     * Filter the query on the meta_description column
     *
     * Example usage:
     * <code>
     * $query->filterByMetaDescription('fooValue');   // WHERE meta_description = 'fooValue'
     * $query->filterByMetaDescription('%fooValue%', Criteria::LIKE); // WHERE meta_description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $metaDescription The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSectionQuery The current query, for fluid interface
     */
    public function filterByMetaDescription($metaDescription = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($metaDescription)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SectionTableMap::COL_META_DESCRIPTION, $metaDescription, $comparison);
    }

    /**
     * Filter the query on the meta_canonical column
     *
     * Example usage:
     * <code>
     * $query->filterByMetaCanonical('fooValue');   // WHERE meta_canonical = 'fooValue'
     * $query->filterByMetaCanonical('%fooValue%', Criteria::LIKE); // WHERE meta_canonical LIKE '%fooValue%'
     * </code>
     *
     * @param     string $metaCanonical The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSectionQuery The current query, for fluid interface
     */
    public function filterByMetaCanonical($metaCanonical = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($metaCanonical)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SectionTableMap::COL_META_CANONICAL, $metaCanonical, $comparison);
    }

    /**
     * Filter the query on the meta_robots column
     *
     * Example usage:
     * <code>
     * $query->filterByMetaRobots('fooValue');   // WHERE meta_robots = 'fooValue'
     * $query->filterByMetaRobots('%fooValue%', Criteria::LIKE); // WHERE meta_robots LIKE '%fooValue%'
     * </code>
     *
     * @param     string $metaRobots The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSectionQuery The current query, for fluid interface
     */
    public function filterByMetaRobots($metaRobots = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($metaRobots)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SectionTableMap::COL_META_ROBOTS, $metaRobots, $comparison);
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
     * @return $this|ChildSectionQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(SectionTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(SectionTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SectionTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildSectionQuery The current query, for fluid interface
     */
    public function filterByCreatedBy($createdBy = null, $comparison = null)
    {
        if (is_array($createdBy)) {
            $useMinMax = false;
            if (isset($createdBy['min'])) {
                $this->addUsingAlias(SectionTableMap::COL_CREATED_BY, $createdBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdBy['max'])) {
                $this->addUsingAlias(SectionTableMap::COL_CREATED_BY, $createdBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SectionTableMap::COL_CREATED_BY, $createdBy, $comparison);
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
     * @return $this|ChildSectionQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(SectionTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(SectionTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SectionTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
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
     * @return $this|ChildSectionQuery The current query, for fluid interface
     */
    public function filterByUpdatedBy($updatedBy = null, $comparison = null)
    {
        if (is_array($updatedBy)) {
            $useMinMax = false;
            if (isset($updatedBy['min'])) {
                $this->addUsingAlias(SectionTableMap::COL_UPDATED_BY, $updatedBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedBy['max'])) {
                $this->addUsingAlias(SectionTableMap::COL_UPDATED_BY, $updatedBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SectionTableMap::COL_UPDATED_BY, $updatedBy, $comparison);
    }

    /**
     * Filter the query by a related \Propel\Models\User object
     *
     * @param \Propel\Models\User|ObjectCollection $user The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSectionQuery The current query, for fluid interface
     */
    public function filterByUserRelatedByCreatedBy($user, $comparison = null)
    {
        if ($user instanceof \Propel\Models\User) {
            return $this
                ->addUsingAlias(SectionTableMap::COL_CREATED_BY, $user->getId(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SectionTableMap::COL_CREATED_BY, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildSectionQuery The current query, for fluid interface
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
     * @return ChildSectionQuery The current query, for fluid interface
     */
    public function filterByUserRelatedByUpdatedBy($user, $comparison = null)
    {
        if ($user instanceof \Propel\Models\User) {
            return $this
                ->addUsingAlias(SectionTableMap::COL_UPDATED_BY, $user->getId(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SectionTableMap::COL_UPDATED_BY, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildSectionQuery The current query, for fluid interface
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
     * Filter the query by a related \Propel\Models\SectionField object
     *
     * @param \Propel\Models\SectionField|ObjectCollection $sectionField the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSectionQuery The current query, for fluid interface
     */
    public function filterBySectionField($sectionField, $comparison = null)
    {
        if ($sectionField instanceof \Propel\Models\SectionField) {
            return $this
                ->addUsingAlias(SectionTableMap::COL_ID, $sectionField->getSectionId(), $comparison);
        } elseif ($sectionField instanceof ObjectCollection) {
            return $this
                ->useSectionFieldQuery()
                ->filterByPrimaryKeys($sectionField->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySectionField() only accepts arguments of type \Propel\Models\SectionField or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SectionField relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSectionQuery The current query, for fluid interface
     */
    public function joinSectionField($relationAlias = null, $joinType = 'INNER JOIN')
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SectionField');

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
            $this->addJoinObject($join, 'SectionField');
        }

        return $this;
    }

    /**
     * Use the SectionField relation SectionField object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Propel\Models\SectionFieldQuery A secondary query class using the current class as primary query
     */
    public function useSectionFieldQuery($relationAlias = null, $joinType = 'INNER JOIN')
    {
        return $this
            ->joinSectionField($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SectionField', '\Propel\Models\SectionFieldQuery');
    }

    /**
     * Filter the query by a related \Propel\Models\Publication object
     *
     * @param \Propel\Models\Publication|ObjectCollection $publication the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSectionQuery The current query, for fluid interface
     */
    public function filterByPublication($publication, $comparison = null)
    {
        if ($publication instanceof \Propel\Models\Publication) {
            return $this
                ->addUsingAlias(SectionTableMap::COL_ID, $publication->getSectionId(), $comparison);
        } elseif ($publication instanceof ObjectCollection) {
            return $this
                ->usePublicationQuery()
                ->filterByPrimaryKeys($publication->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPublication() only accepts arguments of type \Propel\Models\Publication or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Publication relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSectionQuery The current query, for fluid interface
     */
    public function joinPublication($relationAlias = null, $joinType = 'INNER JOIN')
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Publication');

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
            $this->addJoinObject($join, 'Publication');
        }

        return $this;
    }

    /**
     * Use the Publication relation Publication object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Propel\Models\PublicationQuery A secondary query class using the current class as primary query
     */
    public function usePublicationQuery($relationAlias = null, $joinType = 'INNER JOIN')
    {
        return $this
            ->joinPublication($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Publication', '\Propel\Models\PublicationQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildSection $section Object to remove from the list of results
     *
     * @return $this|ChildSectionQuery The current query, for fluid interface
     */
    public function prune($section = null)
    {
        if ($section) {
            $this->addUsingAlias(SectionTableMap::COL_ID, $section->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the fenric_section table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SectionTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SectionTableMap::clearInstancePool();
            SectionTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(SectionTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SectionTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            SectionTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SectionTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // SectionQuery
