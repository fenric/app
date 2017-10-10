<?php

namespace Propel\Models\Base;

use \Exception;
use \PDO;
use Propel\Models\PublicationPhoto as ChildPublicationPhoto;
use Propel\Models\PublicationPhotoQuery as ChildPublicationPhotoQuery;
use Propel\Models\Map\PublicationPhotoTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'fenric_publication_photo' table.
 *
 *
 *
 * @method     ChildPublicationPhotoQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildPublicationPhotoQuery orderByPublicationId($order = Criteria::ASC) Order by the publication_id column
 * @method     ChildPublicationPhotoQuery orderByFile($order = Criteria::ASC) Order by the file column
 * @method     ChildPublicationPhotoQuery orderByDisplay($order = Criteria::ASC) Order by the display column
 * @method     ChildPublicationPhotoQuery orderBySequence($order = Criteria::ASC) Order by the sequence column
 * @method     ChildPublicationPhotoQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildPublicationPhotoQuery orderByCreatedBy($order = Criteria::ASC) Order by the created_by column
 * @method     ChildPublicationPhotoQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 * @method     ChildPublicationPhotoQuery orderByUpdatedBy($order = Criteria::ASC) Order by the updated_by column
 *
 * @method     ChildPublicationPhotoQuery groupById() Group by the id column
 * @method     ChildPublicationPhotoQuery groupByPublicationId() Group by the publication_id column
 * @method     ChildPublicationPhotoQuery groupByFile() Group by the file column
 * @method     ChildPublicationPhotoQuery groupByDisplay() Group by the display column
 * @method     ChildPublicationPhotoQuery groupBySequence() Group by the sequence column
 * @method     ChildPublicationPhotoQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildPublicationPhotoQuery groupByCreatedBy() Group by the created_by column
 * @method     ChildPublicationPhotoQuery groupByUpdatedAt() Group by the updated_at column
 * @method     ChildPublicationPhotoQuery groupByUpdatedBy() Group by the updated_by column
 *
 * @method     ChildPublicationPhotoQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPublicationPhotoQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPublicationPhotoQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPublicationPhotoQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildPublicationPhotoQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildPublicationPhotoQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildPublicationPhotoQuery leftJoinPublication($relationAlias = null) Adds a LEFT JOIN clause to the query using the Publication relation
 * @method     ChildPublicationPhotoQuery rightJoinPublication($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Publication relation
 * @method     ChildPublicationPhotoQuery innerJoinPublication($relationAlias = null) Adds a INNER JOIN clause to the query using the Publication relation
 *
 * @method     ChildPublicationPhotoQuery joinWithPublication($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Publication relation
 *
 * @method     ChildPublicationPhotoQuery leftJoinWithPublication() Adds a LEFT JOIN clause and with to the query using the Publication relation
 * @method     ChildPublicationPhotoQuery rightJoinWithPublication() Adds a RIGHT JOIN clause and with to the query using the Publication relation
 * @method     ChildPublicationPhotoQuery innerJoinWithPublication() Adds a INNER JOIN clause and with to the query using the Publication relation
 *
 * @method     ChildPublicationPhotoQuery leftJoinUserRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserRelatedByCreatedBy relation
 * @method     ChildPublicationPhotoQuery rightJoinUserRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserRelatedByCreatedBy relation
 * @method     ChildPublicationPhotoQuery innerJoinUserRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the UserRelatedByCreatedBy relation
 *
 * @method     ChildPublicationPhotoQuery joinWithUserRelatedByCreatedBy($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the UserRelatedByCreatedBy relation
 *
 * @method     ChildPublicationPhotoQuery leftJoinWithUserRelatedByCreatedBy() Adds a LEFT JOIN clause and with to the query using the UserRelatedByCreatedBy relation
 * @method     ChildPublicationPhotoQuery rightJoinWithUserRelatedByCreatedBy() Adds a RIGHT JOIN clause and with to the query using the UserRelatedByCreatedBy relation
 * @method     ChildPublicationPhotoQuery innerJoinWithUserRelatedByCreatedBy() Adds a INNER JOIN clause and with to the query using the UserRelatedByCreatedBy relation
 *
 * @method     ChildPublicationPhotoQuery leftJoinUserRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserRelatedByUpdatedBy relation
 * @method     ChildPublicationPhotoQuery rightJoinUserRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserRelatedByUpdatedBy relation
 * @method     ChildPublicationPhotoQuery innerJoinUserRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the UserRelatedByUpdatedBy relation
 *
 * @method     ChildPublicationPhotoQuery joinWithUserRelatedByUpdatedBy($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the UserRelatedByUpdatedBy relation
 *
 * @method     ChildPublicationPhotoQuery leftJoinWithUserRelatedByUpdatedBy() Adds a LEFT JOIN clause and with to the query using the UserRelatedByUpdatedBy relation
 * @method     ChildPublicationPhotoQuery rightJoinWithUserRelatedByUpdatedBy() Adds a RIGHT JOIN clause and with to the query using the UserRelatedByUpdatedBy relation
 * @method     ChildPublicationPhotoQuery innerJoinWithUserRelatedByUpdatedBy() Adds a INNER JOIN clause and with to the query using the UserRelatedByUpdatedBy relation
 *
 * @method     \Propel\Models\PublicationQuery|\Propel\Models\UserQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPublicationPhoto findOne(ConnectionInterface $con = null) Return the first ChildPublicationPhoto matching the query
 * @method     ChildPublicationPhoto findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPublicationPhoto matching the query, or a new ChildPublicationPhoto object populated from the query conditions when no match is found
 *
 * @method     ChildPublicationPhoto findOneById(int $id) Return the first ChildPublicationPhoto filtered by the id column
 * @method     ChildPublicationPhoto findOneByPublicationId(int $publication_id) Return the first ChildPublicationPhoto filtered by the publication_id column
 * @method     ChildPublicationPhoto findOneByFile(string $file) Return the first ChildPublicationPhoto filtered by the file column
 * @method     ChildPublicationPhoto findOneByDisplay(boolean $display) Return the first ChildPublicationPhoto filtered by the display column
 * @method     ChildPublicationPhoto findOneBySequence(string $sequence) Return the first ChildPublicationPhoto filtered by the sequence column
 * @method     ChildPublicationPhoto findOneByCreatedAt(string $created_at) Return the first ChildPublicationPhoto filtered by the created_at column
 * @method     ChildPublicationPhoto findOneByCreatedBy(int $created_by) Return the first ChildPublicationPhoto filtered by the created_by column
 * @method     ChildPublicationPhoto findOneByUpdatedAt(string $updated_at) Return the first ChildPublicationPhoto filtered by the updated_at column
 * @method     ChildPublicationPhoto findOneByUpdatedBy(int $updated_by) Return the first ChildPublicationPhoto filtered by the updated_by column *

 * @method     ChildPublicationPhoto requirePk($key, ConnectionInterface $con = null) Return the ChildPublicationPhoto by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPublicationPhoto requireOne(ConnectionInterface $con = null) Return the first ChildPublicationPhoto matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPublicationPhoto requireOneById(int $id) Return the first ChildPublicationPhoto filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPublicationPhoto requireOneByPublicationId(int $publication_id) Return the first ChildPublicationPhoto filtered by the publication_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPublicationPhoto requireOneByFile(string $file) Return the first ChildPublicationPhoto filtered by the file column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPublicationPhoto requireOneByDisplay(boolean $display) Return the first ChildPublicationPhoto filtered by the display column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPublicationPhoto requireOneBySequence(string $sequence) Return the first ChildPublicationPhoto filtered by the sequence column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPublicationPhoto requireOneByCreatedAt(string $created_at) Return the first ChildPublicationPhoto filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPublicationPhoto requireOneByCreatedBy(int $created_by) Return the first ChildPublicationPhoto filtered by the created_by column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPublicationPhoto requireOneByUpdatedAt(string $updated_at) Return the first ChildPublicationPhoto filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPublicationPhoto requireOneByUpdatedBy(int $updated_by) Return the first ChildPublicationPhoto filtered by the updated_by column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPublicationPhoto[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPublicationPhoto objects based on current ModelCriteria
 * @method     ChildPublicationPhoto[]|ObjectCollection findById(int $id) Return ChildPublicationPhoto objects filtered by the id column
 * @method     ChildPublicationPhoto[]|ObjectCollection findByPublicationId(int $publication_id) Return ChildPublicationPhoto objects filtered by the publication_id column
 * @method     ChildPublicationPhoto[]|ObjectCollection findByFile(string $file) Return ChildPublicationPhoto objects filtered by the file column
 * @method     ChildPublicationPhoto[]|ObjectCollection findByDisplay(boolean $display) Return ChildPublicationPhoto objects filtered by the display column
 * @method     ChildPublicationPhoto[]|ObjectCollection findBySequence(string $sequence) Return ChildPublicationPhoto objects filtered by the sequence column
 * @method     ChildPublicationPhoto[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildPublicationPhoto objects filtered by the created_at column
 * @method     ChildPublicationPhoto[]|ObjectCollection findByCreatedBy(int $created_by) Return ChildPublicationPhoto objects filtered by the created_by column
 * @method     ChildPublicationPhoto[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildPublicationPhoto objects filtered by the updated_at column
 * @method     ChildPublicationPhoto[]|ObjectCollection findByUpdatedBy(int $updated_by) Return ChildPublicationPhoto objects filtered by the updated_by column
 * @method     ChildPublicationPhoto[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PublicationPhotoQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Propel\Models\Base\PublicationPhotoQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Propel\\Models\\PublicationPhoto', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPublicationPhotoQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPublicationPhotoQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPublicationPhotoQuery) {
            return $criteria;
        }
        $query = new ChildPublicationPhotoQuery();
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
     * @return ChildPublicationPhoto|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PublicationPhotoTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = PublicationPhotoTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildPublicationPhoto A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, publication_id, file, display, sequence, created_at, created_by, updated_at, updated_by FROM fenric_publication_photo WHERE id = :p0';
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
            /** @var ChildPublicationPhoto $obj */
            $obj = new ChildPublicationPhoto();
            $obj->hydrate($row);
            PublicationPhotoTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildPublicationPhoto|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPublicationPhotoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PublicationPhotoTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPublicationPhotoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PublicationPhotoTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildPublicationPhotoQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(PublicationPhotoTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PublicationPhotoTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PublicationPhotoTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the publication_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPublicationId(1234); // WHERE publication_id = 1234
     * $query->filterByPublicationId(array(12, 34)); // WHERE publication_id IN (12, 34)
     * $query->filterByPublicationId(array('min' => 12)); // WHERE publication_id > 12
     * </code>
     *
     * @see       filterByPublication()
     *
     * @param     mixed $publicationId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPublicationPhotoQuery The current query, for fluid interface
     */
    public function filterByPublicationId($publicationId = null, $comparison = null)
    {
        if (is_array($publicationId)) {
            $useMinMax = false;
            if (isset($publicationId['min'])) {
                $this->addUsingAlias(PublicationPhotoTableMap::COL_PUBLICATION_ID, $publicationId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($publicationId['max'])) {
                $this->addUsingAlias(PublicationPhotoTableMap::COL_PUBLICATION_ID, $publicationId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PublicationPhotoTableMap::COL_PUBLICATION_ID, $publicationId, $comparison);
    }

    /**
     * Filter the query on the file column
     *
     * Example usage:
     * <code>
     * $query->filterByFile('fooValue');   // WHERE file = 'fooValue'
     * $query->filterByFile('%fooValue%', Criteria::LIKE); // WHERE file LIKE '%fooValue%'
     * </code>
     *
     * @param     string $file The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPublicationPhotoQuery The current query, for fluid interface
     */
    public function filterByFile($file = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($file)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PublicationPhotoTableMap::COL_FILE, $file, $comparison);
    }

    /**
     * Filter the query on the display column
     *
     * Example usage:
     * <code>
     * $query->filterByDisplay(true); // WHERE display = true
     * $query->filterByDisplay('yes'); // WHERE display = true
     * </code>
     *
     * @param     boolean|string $display The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPublicationPhotoQuery The current query, for fluid interface
     */
    public function filterByDisplay($display = null, $comparison = null)
    {
        if (is_string($display)) {
            $display = in_array(strtolower($display), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(PublicationPhotoTableMap::COL_DISPLAY, $display, $comparison);
    }

    /**
     * Filter the query on the sequence column
     *
     * Example usage:
     * <code>
     * $query->filterBySequence(1234); // WHERE sequence = 1234
     * $query->filterBySequence(array(12, 34)); // WHERE sequence IN (12, 34)
     * $query->filterBySequence(array('min' => 12)); // WHERE sequence > 12
     * </code>
     *
     * @param     mixed $sequence The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPublicationPhotoQuery The current query, for fluid interface
     */
    public function filterBySequence($sequence = null, $comparison = null)
    {
        if (is_array($sequence)) {
            $useMinMax = false;
            if (isset($sequence['min'])) {
                $this->addUsingAlias(PublicationPhotoTableMap::COL_SEQUENCE, $sequence['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sequence['max'])) {
                $this->addUsingAlias(PublicationPhotoTableMap::COL_SEQUENCE, $sequence['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PublicationPhotoTableMap::COL_SEQUENCE, $sequence, $comparison);
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
     * @return $this|ChildPublicationPhotoQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(PublicationPhotoTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(PublicationPhotoTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PublicationPhotoTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildPublicationPhotoQuery The current query, for fluid interface
     */
    public function filterByCreatedBy($createdBy = null, $comparison = null)
    {
        if (is_array($createdBy)) {
            $useMinMax = false;
            if (isset($createdBy['min'])) {
                $this->addUsingAlias(PublicationPhotoTableMap::COL_CREATED_BY, $createdBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdBy['max'])) {
                $this->addUsingAlias(PublicationPhotoTableMap::COL_CREATED_BY, $createdBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PublicationPhotoTableMap::COL_CREATED_BY, $createdBy, $comparison);
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
     * @return $this|ChildPublicationPhotoQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(PublicationPhotoTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(PublicationPhotoTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PublicationPhotoTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
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
     * @return $this|ChildPublicationPhotoQuery The current query, for fluid interface
     */
    public function filterByUpdatedBy($updatedBy = null, $comparison = null)
    {
        if (is_array($updatedBy)) {
            $useMinMax = false;
            if (isset($updatedBy['min'])) {
                $this->addUsingAlias(PublicationPhotoTableMap::COL_UPDATED_BY, $updatedBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedBy['max'])) {
                $this->addUsingAlias(PublicationPhotoTableMap::COL_UPDATED_BY, $updatedBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PublicationPhotoTableMap::COL_UPDATED_BY, $updatedBy, $comparison);
    }

    /**
     * Filter the query by a related \Propel\Models\Publication object
     *
     * @param \Propel\Models\Publication|ObjectCollection $publication The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPublicationPhotoQuery The current query, for fluid interface
     */
    public function filterByPublication($publication, $comparison = null)
    {
        if ($publication instanceof \Propel\Models\Publication) {
            return $this
                ->addUsingAlias(PublicationPhotoTableMap::COL_PUBLICATION_ID, $publication->getId(), $comparison);
        } elseif ($publication instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PublicationPhotoTableMap::COL_PUBLICATION_ID, $publication->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildPublicationPhotoQuery The current query, for fluid interface
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
     * Filter the query by a related \Propel\Models\User object
     *
     * @param \Propel\Models\User|ObjectCollection $user The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPublicationPhotoQuery The current query, for fluid interface
     */
    public function filterByUserRelatedByCreatedBy($user, $comparison = null)
    {
        if ($user instanceof \Propel\Models\User) {
            return $this
                ->addUsingAlias(PublicationPhotoTableMap::COL_CREATED_BY, $user->getId(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PublicationPhotoTableMap::COL_CREATED_BY, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildPublicationPhotoQuery The current query, for fluid interface
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
     * @return ChildPublicationPhotoQuery The current query, for fluid interface
     */
    public function filterByUserRelatedByUpdatedBy($user, $comparison = null)
    {
        if ($user instanceof \Propel\Models\User) {
            return $this
                ->addUsingAlias(PublicationPhotoTableMap::COL_UPDATED_BY, $user->getId(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PublicationPhotoTableMap::COL_UPDATED_BY, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildPublicationPhotoQuery The current query, for fluid interface
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
     * @param   ChildPublicationPhoto $publicationPhoto Object to remove from the list of results
     *
     * @return $this|ChildPublicationPhotoQuery The current query, for fluid interface
     */
    public function prune($publicationPhoto = null)
    {
        if ($publicationPhoto) {
            $this->addUsingAlias(PublicationPhotoTableMap::COL_ID, $publicationPhoto->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the fenric_publication_photo table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PublicationPhotoTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PublicationPhotoTableMap::clearInstancePool();
            PublicationPhotoTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PublicationPhotoTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PublicationPhotoTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PublicationPhotoTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PublicationPhotoTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PublicationPhotoQuery
