<?php

namespace Propel\Models\Base;

use \Exception;
use \PDO;
use Propel\Models\Comment as ChildComment;
use Propel\Models\CommentQuery as ChildCommentQuery;
use Propel\Models\Map\CommentTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'fenric_comment' table.
 *
 *
 *
 * @method     ChildCommentQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildCommentQuery orderByParentId($order = Criteria::ASC) Order by the parent_id column
 * @method     ChildCommentQuery orderByPublicationId($order = Criteria::ASC) Order by the publication_id column
 * @method     ChildCommentQuery orderByPicture($order = Criteria::ASC) Order by the picture column
 * @method     ChildCommentQuery orderByContent($order = Criteria::ASC) Order by the content column
 * @method     ChildCommentQuery orderByIsDeleted($order = Criteria::ASC) Order by the is_deleted column
 * @method     ChildCommentQuery orderByIsVerified($order = Criteria::ASC) Order by the is_verified column
 * @method     ChildCommentQuery orderByUpdatingReason($order = Criteria::ASC) Order by the updating_reason column
 * @method     ChildCommentQuery orderByDeletingReason($order = Criteria::ASC) Order by the deleting_reason column
 * @method     ChildCommentQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildCommentQuery orderByCreatedBy($order = Criteria::ASC) Order by the created_by column
 * @method     ChildCommentQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 * @method     ChildCommentQuery orderByUpdatedBy($order = Criteria::ASC) Order by the updated_by column
 * @method     ChildCommentQuery orderByDeletedAt($order = Criteria::ASC) Order by the deleted_at column
 * @method     ChildCommentQuery orderByDeletedBy($order = Criteria::ASC) Order by the deleted_by column
 * @method     ChildCommentQuery orderByVerifiedAt($order = Criteria::ASC) Order by the verified_at column
 * @method     ChildCommentQuery orderByVerifiedBy($order = Criteria::ASC) Order by the verified_by column
 *
 * @method     ChildCommentQuery groupById() Group by the id column
 * @method     ChildCommentQuery groupByParentId() Group by the parent_id column
 * @method     ChildCommentQuery groupByPublicationId() Group by the publication_id column
 * @method     ChildCommentQuery groupByPicture() Group by the picture column
 * @method     ChildCommentQuery groupByContent() Group by the content column
 * @method     ChildCommentQuery groupByIsDeleted() Group by the is_deleted column
 * @method     ChildCommentQuery groupByIsVerified() Group by the is_verified column
 * @method     ChildCommentQuery groupByUpdatingReason() Group by the updating_reason column
 * @method     ChildCommentQuery groupByDeletingReason() Group by the deleting_reason column
 * @method     ChildCommentQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildCommentQuery groupByCreatedBy() Group by the created_by column
 * @method     ChildCommentQuery groupByUpdatedAt() Group by the updated_at column
 * @method     ChildCommentQuery groupByUpdatedBy() Group by the updated_by column
 * @method     ChildCommentQuery groupByDeletedAt() Group by the deleted_at column
 * @method     ChildCommentQuery groupByDeletedBy() Group by the deleted_by column
 * @method     ChildCommentQuery groupByVerifiedAt() Group by the verified_at column
 * @method     ChildCommentQuery groupByVerifiedBy() Group by the verified_by column
 *
 * @method     ChildCommentQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCommentQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCommentQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCommentQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildCommentQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildCommentQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildCommentQuery leftJoinParent($relationAlias = null) Adds a LEFT JOIN clause to the query using the Parent relation
 * @method     ChildCommentQuery rightJoinParent($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Parent relation
 * @method     ChildCommentQuery innerJoinParent($relationAlias = null) Adds a INNER JOIN clause to the query using the Parent relation
 *
 * @method     ChildCommentQuery joinWithParent($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Parent relation
 *
 * @method     ChildCommentQuery leftJoinWithParent() Adds a LEFT JOIN clause and with to the query using the Parent relation
 * @method     ChildCommentQuery rightJoinWithParent() Adds a RIGHT JOIN clause and with to the query using the Parent relation
 * @method     ChildCommentQuery innerJoinWithParent() Adds a INNER JOIN clause and with to the query using the Parent relation
 *
 * @method     ChildCommentQuery leftJoinPublication($relationAlias = null) Adds a LEFT JOIN clause to the query using the Publication relation
 * @method     ChildCommentQuery rightJoinPublication($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Publication relation
 * @method     ChildCommentQuery innerJoinPublication($relationAlias = null) Adds a INNER JOIN clause to the query using the Publication relation
 *
 * @method     ChildCommentQuery joinWithPublication($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Publication relation
 *
 * @method     ChildCommentQuery leftJoinWithPublication() Adds a LEFT JOIN clause and with to the query using the Publication relation
 * @method     ChildCommentQuery rightJoinWithPublication() Adds a RIGHT JOIN clause and with to the query using the Publication relation
 * @method     ChildCommentQuery innerJoinWithPublication() Adds a INNER JOIN clause and with to the query using the Publication relation
 *
 * @method     ChildCommentQuery leftJoinUserRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserRelatedByCreatedBy relation
 * @method     ChildCommentQuery rightJoinUserRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserRelatedByCreatedBy relation
 * @method     ChildCommentQuery innerJoinUserRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the UserRelatedByCreatedBy relation
 *
 * @method     ChildCommentQuery joinWithUserRelatedByCreatedBy($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the UserRelatedByCreatedBy relation
 *
 * @method     ChildCommentQuery leftJoinWithUserRelatedByCreatedBy() Adds a LEFT JOIN clause and with to the query using the UserRelatedByCreatedBy relation
 * @method     ChildCommentQuery rightJoinWithUserRelatedByCreatedBy() Adds a RIGHT JOIN clause and with to the query using the UserRelatedByCreatedBy relation
 * @method     ChildCommentQuery innerJoinWithUserRelatedByCreatedBy() Adds a INNER JOIN clause and with to the query using the UserRelatedByCreatedBy relation
 *
 * @method     ChildCommentQuery leftJoinUserRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserRelatedByUpdatedBy relation
 * @method     ChildCommentQuery rightJoinUserRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserRelatedByUpdatedBy relation
 * @method     ChildCommentQuery innerJoinUserRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the UserRelatedByUpdatedBy relation
 *
 * @method     ChildCommentQuery joinWithUserRelatedByUpdatedBy($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the UserRelatedByUpdatedBy relation
 *
 * @method     ChildCommentQuery leftJoinWithUserRelatedByUpdatedBy() Adds a LEFT JOIN clause and with to the query using the UserRelatedByUpdatedBy relation
 * @method     ChildCommentQuery rightJoinWithUserRelatedByUpdatedBy() Adds a RIGHT JOIN clause and with to the query using the UserRelatedByUpdatedBy relation
 * @method     ChildCommentQuery innerJoinWithUserRelatedByUpdatedBy() Adds a INNER JOIN clause and with to the query using the UserRelatedByUpdatedBy relation
 *
 * @method     ChildCommentQuery leftJoinUserRelatedByDeletedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserRelatedByDeletedBy relation
 * @method     ChildCommentQuery rightJoinUserRelatedByDeletedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserRelatedByDeletedBy relation
 * @method     ChildCommentQuery innerJoinUserRelatedByDeletedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the UserRelatedByDeletedBy relation
 *
 * @method     ChildCommentQuery joinWithUserRelatedByDeletedBy($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the UserRelatedByDeletedBy relation
 *
 * @method     ChildCommentQuery leftJoinWithUserRelatedByDeletedBy() Adds a LEFT JOIN clause and with to the query using the UserRelatedByDeletedBy relation
 * @method     ChildCommentQuery rightJoinWithUserRelatedByDeletedBy() Adds a RIGHT JOIN clause and with to the query using the UserRelatedByDeletedBy relation
 * @method     ChildCommentQuery innerJoinWithUserRelatedByDeletedBy() Adds a INNER JOIN clause and with to the query using the UserRelatedByDeletedBy relation
 *
 * @method     ChildCommentQuery leftJoinUserRelatedByVerifiedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserRelatedByVerifiedBy relation
 * @method     ChildCommentQuery rightJoinUserRelatedByVerifiedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserRelatedByVerifiedBy relation
 * @method     ChildCommentQuery innerJoinUserRelatedByVerifiedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the UserRelatedByVerifiedBy relation
 *
 * @method     ChildCommentQuery joinWithUserRelatedByVerifiedBy($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the UserRelatedByVerifiedBy relation
 *
 * @method     ChildCommentQuery leftJoinWithUserRelatedByVerifiedBy() Adds a LEFT JOIN clause and with to the query using the UserRelatedByVerifiedBy relation
 * @method     ChildCommentQuery rightJoinWithUserRelatedByVerifiedBy() Adds a RIGHT JOIN clause and with to the query using the UserRelatedByVerifiedBy relation
 * @method     ChildCommentQuery innerJoinWithUserRelatedByVerifiedBy() Adds a INNER JOIN clause and with to the query using the UserRelatedByVerifiedBy relation
 *
 * @method     ChildCommentQuery leftJoinCommentRelatedById($relationAlias = null) Adds a LEFT JOIN clause to the query using the CommentRelatedById relation
 * @method     ChildCommentQuery rightJoinCommentRelatedById($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CommentRelatedById relation
 * @method     ChildCommentQuery innerJoinCommentRelatedById($relationAlias = null) Adds a INNER JOIN clause to the query using the CommentRelatedById relation
 *
 * @method     ChildCommentQuery joinWithCommentRelatedById($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the CommentRelatedById relation
 *
 * @method     ChildCommentQuery leftJoinWithCommentRelatedById() Adds a LEFT JOIN clause and with to the query using the CommentRelatedById relation
 * @method     ChildCommentQuery rightJoinWithCommentRelatedById() Adds a RIGHT JOIN clause and with to the query using the CommentRelatedById relation
 * @method     ChildCommentQuery innerJoinWithCommentRelatedById() Adds a INNER JOIN clause and with to the query using the CommentRelatedById relation
 *
 * @method     \Propel\Models\CommentQuery|\Propel\Models\PublicationQuery|\Propel\Models\UserQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildComment findOne(ConnectionInterface $con = null) Return the first ChildComment matching the query
 * @method     ChildComment findOneOrCreate(ConnectionInterface $con = null) Return the first ChildComment matching the query, or a new ChildComment object populated from the query conditions when no match is found
 *
 * @method     ChildComment findOneById(int $id) Return the first ChildComment filtered by the id column
 * @method     ChildComment findOneByParentId(int $parent_id) Return the first ChildComment filtered by the parent_id column
 * @method     ChildComment findOneByPublicationId(int $publication_id) Return the first ChildComment filtered by the publication_id column
 * @method     ChildComment findOneByPicture(string $picture) Return the first ChildComment filtered by the picture column
 * @method     ChildComment findOneByContent(string $content) Return the first ChildComment filtered by the content column
 * @method     ChildComment findOneByIsDeleted(boolean $is_deleted) Return the first ChildComment filtered by the is_deleted column
 * @method     ChildComment findOneByIsVerified(boolean $is_verified) Return the first ChildComment filtered by the is_verified column
 * @method     ChildComment findOneByUpdatingReason(string $updating_reason) Return the first ChildComment filtered by the updating_reason column
 * @method     ChildComment findOneByDeletingReason(string $deleting_reason) Return the first ChildComment filtered by the deleting_reason column
 * @method     ChildComment findOneByCreatedAt(string $created_at) Return the first ChildComment filtered by the created_at column
 * @method     ChildComment findOneByCreatedBy(int $created_by) Return the first ChildComment filtered by the created_by column
 * @method     ChildComment findOneByUpdatedAt(string $updated_at) Return the first ChildComment filtered by the updated_at column
 * @method     ChildComment findOneByUpdatedBy(int $updated_by) Return the first ChildComment filtered by the updated_by column
 * @method     ChildComment findOneByDeletedAt(string $deleted_at) Return the first ChildComment filtered by the deleted_at column
 * @method     ChildComment findOneByDeletedBy(int $deleted_by) Return the first ChildComment filtered by the deleted_by column
 * @method     ChildComment findOneByVerifiedAt(string $verified_at) Return the first ChildComment filtered by the verified_at column
 * @method     ChildComment findOneByVerifiedBy(int $verified_by) Return the first ChildComment filtered by the verified_by column *

 * @method     ChildComment requirePk($key, ConnectionInterface $con = null) Return the ChildComment by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildComment requireOne(ConnectionInterface $con = null) Return the first ChildComment matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildComment requireOneById(int $id) Return the first ChildComment filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildComment requireOneByParentId(int $parent_id) Return the first ChildComment filtered by the parent_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildComment requireOneByPublicationId(int $publication_id) Return the first ChildComment filtered by the publication_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildComment requireOneByPicture(string $picture) Return the first ChildComment filtered by the picture column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildComment requireOneByContent(string $content) Return the first ChildComment filtered by the content column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildComment requireOneByIsDeleted(boolean $is_deleted) Return the first ChildComment filtered by the is_deleted column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildComment requireOneByIsVerified(boolean $is_verified) Return the first ChildComment filtered by the is_verified column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildComment requireOneByUpdatingReason(string $updating_reason) Return the first ChildComment filtered by the updating_reason column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildComment requireOneByDeletingReason(string $deleting_reason) Return the first ChildComment filtered by the deleting_reason column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildComment requireOneByCreatedAt(string $created_at) Return the first ChildComment filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildComment requireOneByCreatedBy(int $created_by) Return the first ChildComment filtered by the created_by column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildComment requireOneByUpdatedAt(string $updated_at) Return the first ChildComment filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildComment requireOneByUpdatedBy(int $updated_by) Return the first ChildComment filtered by the updated_by column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildComment requireOneByDeletedAt(string $deleted_at) Return the first ChildComment filtered by the deleted_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildComment requireOneByDeletedBy(int $deleted_by) Return the first ChildComment filtered by the deleted_by column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildComment requireOneByVerifiedAt(string $verified_at) Return the first ChildComment filtered by the verified_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildComment requireOneByVerifiedBy(int $verified_by) Return the first ChildComment filtered by the verified_by column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildComment[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildComment objects based on current ModelCriteria
 * @method     ChildComment[]|ObjectCollection findById(int $id) Return ChildComment objects filtered by the id column
 * @method     ChildComment[]|ObjectCollection findByParentId(int $parent_id) Return ChildComment objects filtered by the parent_id column
 * @method     ChildComment[]|ObjectCollection findByPublicationId(int $publication_id) Return ChildComment objects filtered by the publication_id column
 * @method     ChildComment[]|ObjectCollection findByPicture(string $picture) Return ChildComment objects filtered by the picture column
 * @method     ChildComment[]|ObjectCollection findByContent(string $content) Return ChildComment objects filtered by the content column
 * @method     ChildComment[]|ObjectCollection findByIsDeleted(boolean $is_deleted) Return ChildComment objects filtered by the is_deleted column
 * @method     ChildComment[]|ObjectCollection findByIsVerified(boolean $is_verified) Return ChildComment objects filtered by the is_verified column
 * @method     ChildComment[]|ObjectCollection findByUpdatingReason(string $updating_reason) Return ChildComment objects filtered by the updating_reason column
 * @method     ChildComment[]|ObjectCollection findByDeletingReason(string $deleting_reason) Return ChildComment objects filtered by the deleting_reason column
 * @method     ChildComment[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildComment objects filtered by the created_at column
 * @method     ChildComment[]|ObjectCollection findByCreatedBy(int $created_by) Return ChildComment objects filtered by the created_by column
 * @method     ChildComment[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildComment objects filtered by the updated_at column
 * @method     ChildComment[]|ObjectCollection findByUpdatedBy(int $updated_by) Return ChildComment objects filtered by the updated_by column
 * @method     ChildComment[]|ObjectCollection findByDeletedAt(string $deleted_at) Return ChildComment objects filtered by the deleted_at column
 * @method     ChildComment[]|ObjectCollection findByDeletedBy(int $deleted_by) Return ChildComment objects filtered by the deleted_by column
 * @method     ChildComment[]|ObjectCollection findByVerifiedAt(string $verified_at) Return ChildComment objects filtered by the verified_at column
 * @method     ChildComment[]|ObjectCollection findByVerifiedBy(int $verified_by) Return ChildComment objects filtered by the verified_by column
 * @method     ChildComment[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class CommentQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Propel\Models\Base\CommentQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Propel\\Models\\Comment', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCommentQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCommentQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildCommentQuery) {
            return $criteria;
        }
        $query = new ChildCommentQuery();
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
     * @return ChildComment|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CommentTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = CommentTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildComment A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, parent_id, publication_id, picture, content, is_deleted, is_verified, updating_reason, deleting_reason, created_at, created_by, updated_at, updated_by, deleted_at, deleted_by, verified_at, verified_by FROM fenric_comment WHERE id = :p0';
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
            /** @var ChildComment $obj */
            $obj = new ChildComment();
            $obj->hydrate($row);
            CommentTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildComment|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildCommentQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CommentTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildCommentQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CommentTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildCommentQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(CommentTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(CommentTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CommentTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the parent_id column
     *
     * Example usage:
     * <code>
     * $query->filterByParentId(1234); // WHERE parent_id = 1234
     * $query->filterByParentId(array(12, 34)); // WHERE parent_id IN (12, 34)
     * $query->filterByParentId(array('min' => 12)); // WHERE parent_id > 12
     * </code>
     *
     * @see       filterByParent()
     *
     * @param     mixed $parentId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCommentQuery The current query, for fluid interface
     */
    public function filterByParentId($parentId = null, $comparison = null)
    {
        if (is_array($parentId)) {
            $useMinMax = false;
            if (isset($parentId['min'])) {
                $this->addUsingAlias(CommentTableMap::COL_PARENT_ID, $parentId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($parentId['max'])) {
                $this->addUsingAlias(CommentTableMap::COL_PARENT_ID, $parentId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CommentTableMap::COL_PARENT_ID, $parentId, $comparison);
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
     * @return $this|ChildCommentQuery The current query, for fluid interface
     */
    public function filterByPublicationId($publicationId = null, $comparison = null)
    {
        if (is_array($publicationId)) {
            $useMinMax = false;
            if (isset($publicationId['min'])) {
                $this->addUsingAlias(CommentTableMap::COL_PUBLICATION_ID, $publicationId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($publicationId['max'])) {
                $this->addUsingAlias(CommentTableMap::COL_PUBLICATION_ID, $publicationId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CommentTableMap::COL_PUBLICATION_ID, $publicationId, $comparison);
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
     * @return $this|ChildCommentQuery The current query, for fluid interface
     */
    public function filterByPicture($picture = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($picture)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CommentTableMap::COL_PICTURE, $picture, $comparison);
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
     * @return $this|ChildCommentQuery The current query, for fluid interface
     */
    public function filterByContent($content = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($content)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CommentTableMap::COL_CONTENT, $content, $comparison);
    }

    /**
     * Filter the query on the is_deleted column
     *
     * Example usage:
     * <code>
     * $query->filterByIsDeleted(true); // WHERE is_deleted = true
     * $query->filterByIsDeleted('yes'); // WHERE is_deleted = true
     * </code>
     *
     * @param     boolean|string $isDeleted The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCommentQuery The current query, for fluid interface
     */
    public function filterByIsDeleted($isDeleted = null, $comparison = null)
    {
        if (is_string($isDeleted)) {
            $isDeleted = in_array(strtolower($isDeleted), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(CommentTableMap::COL_IS_DELETED, $isDeleted, $comparison);
    }

    /**
     * Filter the query on the is_verified column
     *
     * Example usage:
     * <code>
     * $query->filterByIsVerified(true); // WHERE is_verified = true
     * $query->filterByIsVerified('yes'); // WHERE is_verified = true
     * </code>
     *
     * @param     boolean|string $isVerified The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCommentQuery The current query, for fluid interface
     */
    public function filterByIsVerified($isVerified = null, $comparison = null)
    {
        if (is_string($isVerified)) {
            $isVerified = in_array(strtolower($isVerified), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(CommentTableMap::COL_IS_VERIFIED, $isVerified, $comparison);
    }

    /**
     * Filter the query on the updating_reason column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdatingReason('fooValue');   // WHERE updating_reason = 'fooValue'
     * $query->filterByUpdatingReason('%fooValue%', Criteria::LIKE); // WHERE updating_reason LIKE '%fooValue%'
     * </code>
     *
     * @param     string $updatingReason The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCommentQuery The current query, for fluid interface
     */
    public function filterByUpdatingReason($updatingReason = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($updatingReason)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CommentTableMap::COL_UPDATING_REASON, $updatingReason, $comparison);
    }

    /**
     * Filter the query on the deleting_reason column
     *
     * Example usage:
     * <code>
     * $query->filterByDeletingReason('fooValue');   // WHERE deleting_reason = 'fooValue'
     * $query->filterByDeletingReason('%fooValue%', Criteria::LIKE); // WHERE deleting_reason LIKE '%fooValue%'
     * </code>
     *
     * @param     string $deletingReason The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCommentQuery The current query, for fluid interface
     */
    public function filterByDeletingReason($deletingReason = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($deletingReason)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CommentTableMap::COL_DELETING_REASON, $deletingReason, $comparison);
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
     * @return $this|ChildCommentQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(CommentTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(CommentTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CommentTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildCommentQuery The current query, for fluid interface
     */
    public function filterByCreatedBy($createdBy = null, $comparison = null)
    {
        if (is_array($createdBy)) {
            $useMinMax = false;
            if (isset($createdBy['min'])) {
                $this->addUsingAlias(CommentTableMap::COL_CREATED_BY, $createdBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdBy['max'])) {
                $this->addUsingAlias(CommentTableMap::COL_CREATED_BY, $createdBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CommentTableMap::COL_CREATED_BY, $createdBy, $comparison);
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
     * @return $this|ChildCommentQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(CommentTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(CommentTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CommentTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
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
     * @return $this|ChildCommentQuery The current query, for fluid interface
     */
    public function filterByUpdatedBy($updatedBy = null, $comparison = null)
    {
        if (is_array($updatedBy)) {
            $useMinMax = false;
            if (isset($updatedBy['min'])) {
                $this->addUsingAlias(CommentTableMap::COL_UPDATED_BY, $updatedBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedBy['max'])) {
                $this->addUsingAlias(CommentTableMap::COL_UPDATED_BY, $updatedBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CommentTableMap::COL_UPDATED_BY, $updatedBy, $comparison);
    }

    /**
     * Filter the query on the deleted_at column
     *
     * Example usage:
     * <code>
     * $query->filterByDeletedAt('2011-03-14'); // WHERE deleted_at = '2011-03-14'
     * $query->filterByDeletedAt('now'); // WHERE deleted_at = '2011-03-14'
     * $query->filterByDeletedAt(array('max' => 'yesterday')); // WHERE deleted_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $deletedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCommentQuery The current query, for fluid interface
     */
    public function filterByDeletedAt($deletedAt = null, $comparison = null)
    {
        if (is_array($deletedAt)) {
            $useMinMax = false;
            if (isset($deletedAt['min'])) {
                $this->addUsingAlias(CommentTableMap::COL_DELETED_AT, $deletedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($deletedAt['max'])) {
                $this->addUsingAlias(CommentTableMap::COL_DELETED_AT, $deletedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CommentTableMap::COL_DELETED_AT, $deletedAt, $comparison);
    }

    /**
     * Filter the query on the deleted_by column
     *
     * Example usage:
     * <code>
     * $query->filterByDeletedBy(1234); // WHERE deleted_by = 1234
     * $query->filterByDeletedBy(array(12, 34)); // WHERE deleted_by IN (12, 34)
     * $query->filterByDeletedBy(array('min' => 12)); // WHERE deleted_by > 12
     * </code>
     *
     * @see       filterByUserRelatedByDeletedBy()
     *
     * @param     mixed $deletedBy The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCommentQuery The current query, for fluid interface
     */
    public function filterByDeletedBy($deletedBy = null, $comparison = null)
    {
        if (is_array($deletedBy)) {
            $useMinMax = false;
            if (isset($deletedBy['min'])) {
                $this->addUsingAlias(CommentTableMap::COL_DELETED_BY, $deletedBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($deletedBy['max'])) {
                $this->addUsingAlias(CommentTableMap::COL_DELETED_BY, $deletedBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CommentTableMap::COL_DELETED_BY, $deletedBy, $comparison);
    }

    /**
     * Filter the query on the verified_at column
     *
     * Example usage:
     * <code>
     * $query->filterByVerifiedAt('2011-03-14'); // WHERE verified_at = '2011-03-14'
     * $query->filterByVerifiedAt('now'); // WHERE verified_at = '2011-03-14'
     * $query->filterByVerifiedAt(array('max' => 'yesterday')); // WHERE verified_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $verifiedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCommentQuery The current query, for fluid interface
     */
    public function filterByVerifiedAt($verifiedAt = null, $comparison = null)
    {
        if (is_array($verifiedAt)) {
            $useMinMax = false;
            if (isset($verifiedAt['min'])) {
                $this->addUsingAlias(CommentTableMap::COL_VERIFIED_AT, $verifiedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($verifiedAt['max'])) {
                $this->addUsingAlias(CommentTableMap::COL_VERIFIED_AT, $verifiedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CommentTableMap::COL_VERIFIED_AT, $verifiedAt, $comparison);
    }

    /**
     * Filter the query on the verified_by column
     *
     * Example usage:
     * <code>
     * $query->filterByVerifiedBy(1234); // WHERE verified_by = 1234
     * $query->filterByVerifiedBy(array(12, 34)); // WHERE verified_by IN (12, 34)
     * $query->filterByVerifiedBy(array('min' => 12)); // WHERE verified_by > 12
     * </code>
     *
     * @see       filterByUserRelatedByVerifiedBy()
     *
     * @param     mixed $verifiedBy The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCommentQuery The current query, for fluid interface
     */
    public function filterByVerifiedBy($verifiedBy = null, $comparison = null)
    {
        if (is_array($verifiedBy)) {
            $useMinMax = false;
            if (isset($verifiedBy['min'])) {
                $this->addUsingAlias(CommentTableMap::COL_VERIFIED_BY, $verifiedBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($verifiedBy['max'])) {
                $this->addUsingAlias(CommentTableMap::COL_VERIFIED_BY, $verifiedBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CommentTableMap::COL_VERIFIED_BY, $verifiedBy, $comparison);
    }

    /**
     * Filter the query by a related \Propel\Models\Comment object
     *
     * @param \Propel\Models\Comment|ObjectCollection $comment The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCommentQuery The current query, for fluid interface
     */
    public function filterByParent($comment, $comparison = null)
    {
        if ($comment instanceof \Propel\Models\Comment) {
            return $this
                ->addUsingAlias(CommentTableMap::COL_PARENT_ID, $comment->getId(), $comparison);
        } elseif ($comment instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CommentTableMap::COL_PARENT_ID, $comment->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByParent() only accepts arguments of type \Propel\Models\Comment or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Parent relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCommentQuery The current query, for fluid interface
     */
    public function joinParent($relationAlias = null, $joinType = 'INNER JOIN')
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Parent');

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
            $this->addJoinObject($join, 'Parent');
        }

        return $this;
    }

    /**
     * Use the Parent relation Comment object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Propel\Models\CommentQuery A secondary query class using the current class as primary query
     */
    public function useParentQuery($relationAlias = null, $joinType = 'INNER JOIN')
    {
        return $this
            ->joinParent($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Parent', '\Propel\Models\CommentQuery');
    }

    /**
     * Filter the query by a related \Propel\Models\Publication object
     *
     * @param \Propel\Models\Publication|ObjectCollection $publication The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCommentQuery The current query, for fluid interface
     */
    public function filterByPublication($publication, $comparison = null)
    {
        if ($publication instanceof \Propel\Models\Publication) {
            return $this
                ->addUsingAlias(CommentTableMap::COL_PUBLICATION_ID, $publication->getId(), $comparison);
        } elseif ($publication instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CommentTableMap::COL_PUBLICATION_ID, $publication->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildCommentQuery The current query, for fluid interface
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
     * @return ChildCommentQuery The current query, for fluid interface
     */
    public function filterByUserRelatedByCreatedBy($user, $comparison = null)
    {
        if ($user instanceof \Propel\Models\User) {
            return $this
                ->addUsingAlias(CommentTableMap::COL_CREATED_BY, $user->getId(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CommentTableMap::COL_CREATED_BY, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildCommentQuery The current query, for fluid interface
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
     * @return ChildCommentQuery The current query, for fluid interface
     */
    public function filterByUserRelatedByUpdatedBy($user, $comparison = null)
    {
        if ($user instanceof \Propel\Models\User) {
            return $this
                ->addUsingAlias(CommentTableMap::COL_UPDATED_BY, $user->getId(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CommentTableMap::COL_UPDATED_BY, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildCommentQuery The current query, for fluid interface
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
     * Filter the query by a related \Propel\Models\User object
     *
     * @param \Propel\Models\User|ObjectCollection $user The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCommentQuery The current query, for fluid interface
     */
    public function filterByUserRelatedByDeletedBy($user, $comparison = null)
    {
        if ($user instanceof \Propel\Models\User) {
            return $this
                ->addUsingAlias(CommentTableMap::COL_DELETED_BY, $user->getId(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CommentTableMap::COL_DELETED_BY, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByUserRelatedByDeletedBy() only accepts arguments of type \Propel\Models\User or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UserRelatedByDeletedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCommentQuery The current query, for fluid interface
     */
    public function joinUserRelatedByDeletedBy($relationAlias = null, $joinType = 'INNER JOIN')
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UserRelatedByDeletedBy');

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
            $this->addJoinObject($join, 'UserRelatedByDeletedBy');
        }

        return $this;
    }

    /**
     * Use the UserRelatedByDeletedBy relation User object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Propel\Models\UserQuery A secondary query class using the current class as primary query
     */
    public function useUserRelatedByDeletedByQuery($relationAlias = null, $joinType = 'INNER JOIN')
    {
        return $this
            ->joinUserRelatedByDeletedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UserRelatedByDeletedBy', '\Propel\Models\UserQuery');
    }

    /**
     * Filter the query by a related \Propel\Models\User object
     *
     * @param \Propel\Models\User|ObjectCollection $user The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCommentQuery The current query, for fluid interface
     */
    public function filterByUserRelatedByVerifiedBy($user, $comparison = null)
    {
        if ($user instanceof \Propel\Models\User) {
            return $this
                ->addUsingAlias(CommentTableMap::COL_VERIFIED_BY, $user->getId(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CommentTableMap::COL_VERIFIED_BY, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByUserRelatedByVerifiedBy() only accepts arguments of type \Propel\Models\User or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UserRelatedByVerifiedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCommentQuery The current query, for fluid interface
     */
    public function joinUserRelatedByVerifiedBy($relationAlias = null, $joinType = 'INNER JOIN')
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UserRelatedByVerifiedBy');

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
            $this->addJoinObject($join, 'UserRelatedByVerifiedBy');
        }

        return $this;
    }

    /**
     * Use the UserRelatedByVerifiedBy relation User object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Propel\Models\UserQuery A secondary query class using the current class as primary query
     */
    public function useUserRelatedByVerifiedByQuery($relationAlias = null, $joinType = 'INNER JOIN')
    {
        return $this
            ->joinUserRelatedByVerifiedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UserRelatedByVerifiedBy', '\Propel\Models\UserQuery');
    }

    /**
     * Filter the query by a related \Propel\Models\Comment object
     *
     * @param \Propel\Models\Comment|ObjectCollection $comment the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCommentQuery The current query, for fluid interface
     */
    public function filterByCommentRelatedById($comment, $comparison = null)
    {
        if ($comment instanceof \Propel\Models\Comment) {
            return $this
                ->addUsingAlias(CommentTableMap::COL_ID, $comment->getParentId(), $comparison);
        } elseif ($comment instanceof ObjectCollection) {
            return $this
                ->useCommentRelatedByIdQuery()
                ->filterByPrimaryKeys($comment->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCommentRelatedById() only accepts arguments of type \Propel\Models\Comment or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CommentRelatedById relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCommentQuery The current query, for fluid interface
     */
    public function joinCommentRelatedById($relationAlias = null, $joinType = 'INNER JOIN')
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CommentRelatedById');

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
            $this->addJoinObject($join, 'CommentRelatedById');
        }

        return $this;
    }

    /**
     * Use the CommentRelatedById relation Comment object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Propel\Models\CommentQuery A secondary query class using the current class as primary query
     */
    public function useCommentRelatedByIdQuery($relationAlias = null, $joinType = 'INNER JOIN')
    {
        return $this
            ->joinCommentRelatedById($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CommentRelatedById', '\Propel\Models\CommentQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildComment $comment Object to remove from the list of results
     *
     * @return $this|ChildCommentQuery The current query, for fluid interface
     */
    public function prune($comment = null)
    {
        if ($comment) {
            $this->addUsingAlias(CommentTableMap::COL_ID, $comment->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the fenric_comment table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CommentTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CommentTableMap::clearInstancePool();
            CommentTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(CommentTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CommentTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            CommentTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            CommentTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // CommentQuery
