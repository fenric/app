<?php

namespace Propel\Models\Base;

use \Exception;
use \PDO;
use Propel\Models\PollVote as ChildPollVote;
use Propel\Models\PollVoteQuery as ChildPollVoteQuery;
use Propel\Models\Map\PollVoteTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'fenric_poll_vote' table.
 *
 *
 *
 * @method     ChildPollVoteQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildPollVoteQuery orderByPollVariantId($order = Criteria::ASC) Order by the poll_variant_id column
 * @method     ChildPollVoteQuery orderByRespondentUserAgent($order = Criteria::ASC) Order by the respondent_user_agent column
 * @method     ChildPollVoteQuery orderByRespondentRemoteAddress($order = Criteria::ASC) Order by the respondent_remote_address column
 * @method     ChildPollVoteQuery orderByRespondentSessionId($order = Criteria::ASC) Order by the respondent_session_id column
 * @method     ChildPollVoteQuery orderByRespondentVoteId($order = Criteria::ASC) Order by the respondent_vote_id column
 * @method     ChildPollVoteQuery orderByRespondentId($order = Criteria::ASC) Order by the respondent_id column
 * @method     ChildPollVoteQuery orderByVoteAt($order = Criteria::ASC) Order by the vote_at column
 *
 * @method     ChildPollVoteQuery groupById() Group by the id column
 * @method     ChildPollVoteQuery groupByPollVariantId() Group by the poll_variant_id column
 * @method     ChildPollVoteQuery groupByRespondentUserAgent() Group by the respondent_user_agent column
 * @method     ChildPollVoteQuery groupByRespondentRemoteAddress() Group by the respondent_remote_address column
 * @method     ChildPollVoteQuery groupByRespondentSessionId() Group by the respondent_session_id column
 * @method     ChildPollVoteQuery groupByRespondentVoteId() Group by the respondent_vote_id column
 * @method     ChildPollVoteQuery groupByRespondentId() Group by the respondent_id column
 * @method     ChildPollVoteQuery groupByVoteAt() Group by the vote_at column
 *
 * @method     ChildPollVoteQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPollVoteQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPollVoteQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPollVoteQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildPollVoteQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildPollVoteQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildPollVoteQuery leftJoinPollVariant($relationAlias = null) Adds a LEFT JOIN clause to the query using the PollVariant relation
 * @method     ChildPollVoteQuery rightJoinPollVariant($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PollVariant relation
 * @method     ChildPollVoteQuery innerJoinPollVariant($relationAlias = null) Adds a INNER JOIN clause to the query using the PollVariant relation
 *
 * @method     ChildPollVoteQuery joinWithPollVariant($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the PollVariant relation
 *
 * @method     ChildPollVoteQuery leftJoinWithPollVariant() Adds a LEFT JOIN clause and with to the query using the PollVariant relation
 * @method     ChildPollVoteQuery rightJoinWithPollVariant() Adds a RIGHT JOIN clause and with to the query using the PollVariant relation
 * @method     ChildPollVoteQuery innerJoinWithPollVariant() Adds a INNER JOIN clause and with to the query using the PollVariant relation
 *
 * @method     \Propel\Models\PollVariantQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPollVote findOne(ConnectionInterface $con = null) Return the first ChildPollVote matching the query
 * @method     ChildPollVote findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPollVote matching the query, or a new ChildPollVote object populated from the query conditions when no match is found
 *
 * @method     ChildPollVote findOneById(int $id) Return the first ChildPollVote filtered by the id column
 * @method     ChildPollVote findOneByPollVariantId(int $poll_variant_id) Return the first ChildPollVote filtered by the poll_variant_id column
 * @method     ChildPollVote findOneByRespondentUserAgent(string $respondent_user_agent) Return the first ChildPollVote filtered by the respondent_user_agent column
 * @method     ChildPollVote findOneByRespondentRemoteAddress(string $respondent_remote_address) Return the first ChildPollVote filtered by the respondent_remote_address column
 * @method     ChildPollVote findOneByRespondentSessionId(string $respondent_session_id) Return the first ChildPollVote filtered by the respondent_session_id column
 * @method     ChildPollVote findOneByRespondentVoteId(string $respondent_vote_id) Return the first ChildPollVote filtered by the respondent_vote_id column
 * @method     ChildPollVote findOneByRespondentId(string $respondent_id) Return the first ChildPollVote filtered by the respondent_id column
 * @method     ChildPollVote findOneByVoteAt(string $vote_at) Return the first ChildPollVote filtered by the vote_at column *

 * @method     ChildPollVote requirePk($key, ConnectionInterface $con = null) Return the ChildPollVote by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPollVote requireOne(ConnectionInterface $con = null) Return the first ChildPollVote matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPollVote requireOneById(int $id) Return the first ChildPollVote filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPollVote requireOneByPollVariantId(int $poll_variant_id) Return the first ChildPollVote filtered by the poll_variant_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPollVote requireOneByRespondentUserAgent(string $respondent_user_agent) Return the first ChildPollVote filtered by the respondent_user_agent column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPollVote requireOneByRespondentRemoteAddress(string $respondent_remote_address) Return the first ChildPollVote filtered by the respondent_remote_address column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPollVote requireOneByRespondentSessionId(string $respondent_session_id) Return the first ChildPollVote filtered by the respondent_session_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPollVote requireOneByRespondentVoteId(string $respondent_vote_id) Return the first ChildPollVote filtered by the respondent_vote_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPollVote requireOneByRespondentId(string $respondent_id) Return the first ChildPollVote filtered by the respondent_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPollVote requireOneByVoteAt(string $vote_at) Return the first ChildPollVote filtered by the vote_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPollVote[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPollVote objects based on current ModelCriteria
 * @method     ChildPollVote[]|ObjectCollection findById(int $id) Return ChildPollVote objects filtered by the id column
 * @method     ChildPollVote[]|ObjectCollection findByPollVariantId(int $poll_variant_id) Return ChildPollVote objects filtered by the poll_variant_id column
 * @method     ChildPollVote[]|ObjectCollection findByRespondentUserAgent(string $respondent_user_agent) Return ChildPollVote objects filtered by the respondent_user_agent column
 * @method     ChildPollVote[]|ObjectCollection findByRespondentRemoteAddress(string $respondent_remote_address) Return ChildPollVote objects filtered by the respondent_remote_address column
 * @method     ChildPollVote[]|ObjectCollection findByRespondentSessionId(string $respondent_session_id) Return ChildPollVote objects filtered by the respondent_session_id column
 * @method     ChildPollVote[]|ObjectCollection findByRespondentVoteId(string $respondent_vote_id) Return ChildPollVote objects filtered by the respondent_vote_id column
 * @method     ChildPollVote[]|ObjectCollection findByRespondentId(string $respondent_id) Return ChildPollVote objects filtered by the respondent_id column
 * @method     ChildPollVote[]|ObjectCollection findByVoteAt(string $vote_at) Return ChildPollVote objects filtered by the vote_at column
 * @method     ChildPollVote[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PollVoteQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Propel\Models\Base\PollVoteQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Propel\\Models\\PollVote', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPollVoteQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPollVoteQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPollVoteQuery) {
            return $criteria;
        }
        $query = new ChildPollVoteQuery();
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
     * @return ChildPollVote|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PollVoteTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = PollVoteTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildPollVote A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, poll_variant_id, respondent_user_agent, respondent_remote_address, respondent_session_id, respondent_vote_id, respondent_id, vote_at FROM fenric_poll_vote WHERE id = :p0';
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
            /** @var ChildPollVote $obj */
            $obj = new ChildPollVote();
            $obj->hydrate($row);
            PollVoteTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildPollVote|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPollVoteQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PollVoteTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPollVoteQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PollVoteTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildPollVoteQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(PollVoteTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PollVoteTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PollVoteTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the poll_variant_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPollVariantId(1234); // WHERE poll_variant_id = 1234
     * $query->filterByPollVariantId(array(12, 34)); // WHERE poll_variant_id IN (12, 34)
     * $query->filterByPollVariantId(array('min' => 12)); // WHERE poll_variant_id > 12
     * </code>
     *
     * @see       filterByPollVariant()
     *
     * @param     mixed $pollVariantId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPollVoteQuery The current query, for fluid interface
     */
    public function filterByPollVariantId($pollVariantId = null, $comparison = null)
    {
        if (is_array($pollVariantId)) {
            $useMinMax = false;
            if (isset($pollVariantId['min'])) {
                $this->addUsingAlias(PollVoteTableMap::COL_POLL_VARIANT_ID, $pollVariantId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($pollVariantId['max'])) {
                $this->addUsingAlias(PollVoteTableMap::COL_POLL_VARIANT_ID, $pollVariantId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PollVoteTableMap::COL_POLL_VARIANT_ID, $pollVariantId, $comparison);
    }

    /**
     * Filter the query on the respondent_user_agent column
     *
     * Example usage:
     * <code>
     * $query->filterByRespondentUserAgent('fooValue');   // WHERE respondent_user_agent = 'fooValue'
     * $query->filterByRespondentUserAgent('%fooValue%', Criteria::LIKE); // WHERE respondent_user_agent LIKE '%fooValue%'
     * </code>
     *
     * @param     string $respondentUserAgent The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPollVoteQuery The current query, for fluid interface
     */
    public function filterByRespondentUserAgent($respondentUserAgent = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($respondentUserAgent)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PollVoteTableMap::COL_RESPONDENT_USER_AGENT, $respondentUserAgent, $comparison);
    }

    /**
     * Filter the query on the respondent_remote_address column
     *
     * Example usage:
     * <code>
     * $query->filterByRespondentRemoteAddress('fooValue');   // WHERE respondent_remote_address = 'fooValue'
     * $query->filterByRespondentRemoteAddress('%fooValue%', Criteria::LIKE); // WHERE respondent_remote_address LIKE '%fooValue%'
     * </code>
     *
     * @param     string $respondentRemoteAddress The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPollVoteQuery The current query, for fluid interface
     */
    public function filterByRespondentRemoteAddress($respondentRemoteAddress = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($respondentRemoteAddress)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PollVoteTableMap::COL_RESPONDENT_REMOTE_ADDRESS, $respondentRemoteAddress, $comparison);
    }

    /**
     * Filter the query on the respondent_session_id column
     *
     * Example usage:
     * <code>
     * $query->filterByRespondentSessionId('fooValue');   // WHERE respondent_session_id = 'fooValue'
     * $query->filterByRespondentSessionId('%fooValue%', Criteria::LIKE); // WHERE respondent_session_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $respondentSessionId The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPollVoteQuery The current query, for fluid interface
     */
    public function filterByRespondentSessionId($respondentSessionId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($respondentSessionId)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PollVoteTableMap::COL_RESPONDENT_SESSION_ID, $respondentSessionId, $comparison);
    }

    /**
     * Filter the query on the respondent_vote_id column
     *
     * Example usage:
     * <code>
     * $query->filterByRespondentVoteId('fooValue');   // WHERE respondent_vote_id = 'fooValue'
     * $query->filterByRespondentVoteId('%fooValue%', Criteria::LIKE); // WHERE respondent_vote_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $respondentVoteId The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPollVoteQuery The current query, for fluid interface
     */
    public function filterByRespondentVoteId($respondentVoteId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($respondentVoteId)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PollVoteTableMap::COL_RESPONDENT_VOTE_ID, $respondentVoteId, $comparison);
    }

    /**
     * Filter the query on the respondent_id column
     *
     * Example usage:
     * <code>
     * $query->filterByRespondentId('fooValue');   // WHERE respondent_id = 'fooValue'
     * $query->filterByRespondentId('%fooValue%', Criteria::LIKE); // WHERE respondent_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $respondentId The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPollVoteQuery The current query, for fluid interface
     */
    public function filterByRespondentId($respondentId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($respondentId)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PollVoteTableMap::COL_RESPONDENT_ID, $respondentId, $comparison);
    }

    /**
     * Filter the query on the vote_at column
     *
     * Example usage:
     * <code>
     * $query->filterByVoteAt('2011-03-14'); // WHERE vote_at = '2011-03-14'
     * $query->filterByVoteAt('now'); // WHERE vote_at = '2011-03-14'
     * $query->filterByVoteAt(array('max' => 'yesterday')); // WHERE vote_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $voteAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPollVoteQuery The current query, for fluid interface
     */
    public function filterByVoteAt($voteAt = null, $comparison = null)
    {
        if (is_array($voteAt)) {
            $useMinMax = false;
            if (isset($voteAt['min'])) {
                $this->addUsingAlias(PollVoteTableMap::COL_VOTE_AT, $voteAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($voteAt['max'])) {
                $this->addUsingAlias(PollVoteTableMap::COL_VOTE_AT, $voteAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PollVoteTableMap::COL_VOTE_AT, $voteAt, $comparison);
    }

    /**
     * Filter the query by a related \Propel\Models\PollVariant object
     *
     * @param \Propel\Models\PollVariant|ObjectCollection $pollVariant The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPollVoteQuery The current query, for fluid interface
     */
    public function filterByPollVariant($pollVariant, $comparison = null)
    {
        if ($pollVariant instanceof \Propel\Models\PollVariant) {
            return $this
                ->addUsingAlias(PollVoteTableMap::COL_POLL_VARIANT_ID, $pollVariant->getId(), $comparison);
        } elseif ($pollVariant instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PollVoteTableMap::COL_POLL_VARIANT_ID, $pollVariant->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByPollVariant() only accepts arguments of type \Propel\Models\PollVariant or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PollVariant relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPollVoteQuery The current query, for fluid interface
     */
    public function joinPollVariant($relationAlias = null, $joinType = 'INNER JOIN')
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PollVariant');

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
            $this->addJoinObject($join, 'PollVariant');
        }

        return $this;
    }

    /**
     * Use the PollVariant relation PollVariant object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Propel\Models\PollVariantQuery A secondary query class using the current class as primary query
     */
    public function usePollVariantQuery($relationAlias = null, $joinType = 'INNER JOIN')
    {
        return $this
            ->joinPollVariant($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PollVariant', '\Propel\Models\PollVariantQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPollVote $pollVote Object to remove from the list of results
     *
     * @return $this|ChildPollVoteQuery The current query, for fluid interface
     */
    public function prune($pollVote = null)
    {
        if ($pollVote) {
            $this->addUsingAlias(PollVoteTableMap::COL_ID, $pollVote->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the fenric_poll_vote table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PollVoteTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PollVoteTableMap::clearInstancePool();
            PollVoteTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PollVoteTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PollVoteTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PollVoteTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PollVoteTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PollVoteQuery
