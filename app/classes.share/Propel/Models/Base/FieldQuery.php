<?php

namespace Propel\Models\Base;

use \Exception;
use \PDO;
use Propel\Models\Field as ChildField;
use Propel\Models\FieldQuery as ChildFieldQuery;
use Propel\Models\Map\FieldTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'fenric_field' table.
 *
 *
 *
 * @method     ChildFieldQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildFieldQuery orderByType($order = Criteria::ASC) Order by the type column
 * @method     ChildFieldQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildFieldQuery orderByLabel($order = Criteria::ASC) Order by the label column
 * @method     ChildFieldQuery orderByTooltip($order = Criteria::ASC) Order by the tooltip column
 * @method     ChildFieldQuery orderByDefaultValue($order = Criteria::ASC) Order by the default_value column
 * @method     ChildFieldQuery orderByValidationRegex($order = Criteria::ASC) Order by the validation_regex column
 * @method     ChildFieldQuery orderByValidationError($order = Criteria::ASC) Order by the validation_error column
 * @method     ChildFieldQuery orderByIsUnique($order = Criteria::ASC) Order by the is_unique column
 * @method     ChildFieldQuery orderByIsRequired($order = Criteria::ASC) Order by the is_required column
 * @method     ChildFieldQuery orderByIsSearchable($order = Criteria::ASC) Order by the is_searchable column
 * @method     ChildFieldQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildFieldQuery orderByCreatedBy($order = Criteria::ASC) Order by the created_by column
 * @method     ChildFieldQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 * @method     ChildFieldQuery orderByUpdatedBy($order = Criteria::ASC) Order by the updated_by column
 *
 * @method     ChildFieldQuery groupById() Group by the id column
 * @method     ChildFieldQuery groupByType() Group by the type column
 * @method     ChildFieldQuery groupByName() Group by the name column
 * @method     ChildFieldQuery groupByLabel() Group by the label column
 * @method     ChildFieldQuery groupByTooltip() Group by the tooltip column
 * @method     ChildFieldQuery groupByDefaultValue() Group by the default_value column
 * @method     ChildFieldQuery groupByValidationRegex() Group by the validation_regex column
 * @method     ChildFieldQuery groupByValidationError() Group by the validation_error column
 * @method     ChildFieldQuery groupByIsUnique() Group by the is_unique column
 * @method     ChildFieldQuery groupByIsRequired() Group by the is_required column
 * @method     ChildFieldQuery groupByIsSearchable() Group by the is_searchable column
 * @method     ChildFieldQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildFieldQuery groupByCreatedBy() Group by the created_by column
 * @method     ChildFieldQuery groupByUpdatedAt() Group by the updated_at column
 * @method     ChildFieldQuery groupByUpdatedBy() Group by the updated_by column
 *
 * @method     ChildFieldQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildFieldQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildFieldQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildFieldQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildFieldQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildFieldQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildFieldQuery leftJoinUserRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserRelatedByCreatedBy relation
 * @method     ChildFieldQuery rightJoinUserRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserRelatedByCreatedBy relation
 * @method     ChildFieldQuery innerJoinUserRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the UserRelatedByCreatedBy relation
 *
 * @method     ChildFieldQuery joinWithUserRelatedByCreatedBy($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the UserRelatedByCreatedBy relation
 *
 * @method     ChildFieldQuery leftJoinWithUserRelatedByCreatedBy() Adds a LEFT JOIN clause and with to the query using the UserRelatedByCreatedBy relation
 * @method     ChildFieldQuery rightJoinWithUserRelatedByCreatedBy() Adds a RIGHT JOIN clause and with to the query using the UserRelatedByCreatedBy relation
 * @method     ChildFieldQuery innerJoinWithUserRelatedByCreatedBy() Adds a INNER JOIN clause and with to the query using the UserRelatedByCreatedBy relation
 *
 * @method     ChildFieldQuery leftJoinUserRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserRelatedByUpdatedBy relation
 * @method     ChildFieldQuery rightJoinUserRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserRelatedByUpdatedBy relation
 * @method     ChildFieldQuery innerJoinUserRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the UserRelatedByUpdatedBy relation
 *
 * @method     ChildFieldQuery joinWithUserRelatedByUpdatedBy($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the UserRelatedByUpdatedBy relation
 *
 * @method     ChildFieldQuery leftJoinWithUserRelatedByUpdatedBy() Adds a LEFT JOIN clause and with to the query using the UserRelatedByUpdatedBy relation
 * @method     ChildFieldQuery rightJoinWithUserRelatedByUpdatedBy() Adds a RIGHT JOIN clause and with to the query using the UserRelatedByUpdatedBy relation
 * @method     ChildFieldQuery innerJoinWithUserRelatedByUpdatedBy() Adds a INNER JOIN clause and with to the query using the UserRelatedByUpdatedBy relation
 *
 * @method     ChildFieldQuery leftJoinSectionField($relationAlias = null) Adds a LEFT JOIN clause to the query using the SectionField relation
 * @method     ChildFieldQuery rightJoinSectionField($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SectionField relation
 * @method     ChildFieldQuery innerJoinSectionField($relationAlias = null) Adds a INNER JOIN clause to the query using the SectionField relation
 *
 * @method     ChildFieldQuery joinWithSectionField($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the SectionField relation
 *
 * @method     ChildFieldQuery leftJoinWithSectionField() Adds a LEFT JOIN clause and with to the query using the SectionField relation
 * @method     ChildFieldQuery rightJoinWithSectionField() Adds a RIGHT JOIN clause and with to the query using the SectionField relation
 * @method     ChildFieldQuery innerJoinWithSectionField() Adds a INNER JOIN clause and with to the query using the SectionField relation
 *
 * @method     \Propel\Models\UserQuery|\Propel\Models\SectionFieldQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildField findOne(ConnectionInterface $con = null) Return the first ChildField matching the query
 * @method     ChildField findOneOrCreate(ConnectionInterface $con = null) Return the first ChildField matching the query, or a new ChildField object populated from the query conditions when no match is found
 *
 * @method     ChildField findOneById(int $id) Return the first ChildField filtered by the id column
 * @method     ChildField findOneByType(string $type) Return the first ChildField filtered by the type column
 * @method     ChildField findOneByName(string $name) Return the first ChildField filtered by the name column
 * @method     ChildField findOneByLabel(string $label) Return the first ChildField filtered by the label column
 * @method     ChildField findOneByTooltip(string $tooltip) Return the first ChildField filtered by the tooltip column
 * @method     ChildField findOneByDefaultValue(string $default_value) Return the first ChildField filtered by the default_value column
 * @method     ChildField findOneByValidationRegex(string $validation_regex) Return the first ChildField filtered by the validation_regex column
 * @method     ChildField findOneByValidationError(string $validation_error) Return the first ChildField filtered by the validation_error column
 * @method     ChildField findOneByIsUnique(boolean $is_unique) Return the first ChildField filtered by the is_unique column
 * @method     ChildField findOneByIsRequired(boolean $is_required) Return the first ChildField filtered by the is_required column
 * @method     ChildField findOneByIsSearchable(boolean $is_searchable) Return the first ChildField filtered by the is_searchable column
 * @method     ChildField findOneByCreatedAt(string $created_at) Return the first ChildField filtered by the created_at column
 * @method     ChildField findOneByCreatedBy(int $created_by) Return the first ChildField filtered by the created_by column
 * @method     ChildField findOneByUpdatedAt(string $updated_at) Return the first ChildField filtered by the updated_at column
 * @method     ChildField findOneByUpdatedBy(int $updated_by) Return the first ChildField filtered by the updated_by column *

 * @method     ChildField requirePk($key, ConnectionInterface $con = null) Return the ChildField by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildField requireOne(ConnectionInterface $con = null) Return the first ChildField matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildField requireOneById(int $id) Return the first ChildField filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildField requireOneByType(string $type) Return the first ChildField filtered by the type column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildField requireOneByName(string $name) Return the first ChildField filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildField requireOneByLabel(string $label) Return the first ChildField filtered by the label column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildField requireOneByTooltip(string $tooltip) Return the first ChildField filtered by the tooltip column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildField requireOneByDefaultValue(string $default_value) Return the first ChildField filtered by the default_value column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildField requireOneByValidationRegex(string $validation_regex) Return the first ChildField filtered by the validation_regex column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildField requireOneByValidationError(string $validation_error) Return the first ChildField filtered by the validation_error column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildField requireOneByIsUnique(boolean $is_unique) Return the first ChildField filtered by the is_unique column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildField requireOneByIsRequired(boolean $is_required) Return the first ChildField filtered by the is_required column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildField requireOneByIsSearchable(boolean $is_searchable) Return the first ChildField filtered by the is_searchable column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildField requireOneByCreatedAt(string $created_at) Return the first ChildField filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildField requireOneByCreatedBy(int $created_by) Return the first ChildField filtered by the created_by column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildField requireOneByUpdatedAt(string $updated_at) Return the first ChildField filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildField requireOneByUpdatedBy(int $updated_by) Return the first ChildField filtered by the updated_by column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildField[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildField objects based on current ModelCriteria
 * @method     ChildField[]|ObjectCollection findById(int $id) Return ChildField objects filtered by the id column
 * @method     ChildField[]|ObjectCollection findByType(string $type) Return ChildField objects filtered by the type column
 * @method     ChildField[]|ObjectCollection findByName(string $name) Return ChildField objects filtered by the name column
 * @method     ChildField[]|ObjectCollection findByLabel(string $label) Return ChildField objects filtered by the label column
 * @method     ChildField[]|ObjectCollection findByTooltip(string $tooltip) Return ChildField objects filtered by the tooltip column
 * @method     ChildField[]|ObjectCollection findByDefaultValue(string $default_value) Return ChildField objects filtered by the default_value column
 * @method     ChildField[]|ObjectCollection findByValidationRegex(string $validation_regex) Return ChildField objects filtered by the validation_regex column
 * @method     ChildField[]|ObjectCollection findByValidationError(string $validation_error) Return ChildField objects filtered by the validation_error column
 * @method     ChildField[]|ObjectCollection findByIsUnique(boolean $is_unique) Return ChildField objects filtered by the is_unique column
 * @method     ChildField[]|ObjectCollection findByIsRequired(boolean $is_required) Return ChildField objects filtered by the is_required column
 * @method     ChildField[]|ObjectCollection findByIsSearchable(boolean $is_searchable) Return ChildField objects filtered by the is_searchable column
 * @method     ChildField[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildField objects filtered by the created_at column
 * @method     ChildField[]|ObjectCollection findByCreatedBy(int $created_by) Return ChildField objects filtered by the created_by column
 * @method     ChildField[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildField objects filtered by the updated_at column
 * @method     ChildField[]|ObjectCollection findByUpdatedBy(int $updated_by) Return ChildField objects filtered by the updated_by column
 * @method     ChildField[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class FieldQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Propel\Models\Base\FieldQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Propel\\Models\\Field', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildFieldQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildFieldQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildFieldQuery) {
            return $criteria;
        }
        $query = new ChildFieldQuery();
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
     * @return ChildField|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(FieldTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = FieldTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildField A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, type, name, label, tooltip, default_value, validation_regex, validation_error, is_unique, is_required, is_searchable, created_at, created_by, updated_at, updated_by FROM fenric_field WHERE id = :p0';
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
            /** @var ChildField $obj */
            $obj = new ChildField();
            $obj->hydrate($row);
            FieldTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildField|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildFieldQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(FieldTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildFieldQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(FieldTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildFieldQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(FieldTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(FieldTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FieldTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the type column
     *
     * Example usage:
     * <code>
     * $query->filterByType('fooValue');   // WHERE type = 'fooValue'
     * $query->filterByType('%fooValue%', Criteria::LIKE); // WHERE type LIKE '%fooValue%'
     * </code>
     *
     * @param     string $type The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFieldQuery The current query, for fluid interface
     */
    public function filterByType($type = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($type)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FieldTableMap::COL_TYPE, $type, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%', Criteria::LIKE); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFieldQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FieldTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the label column
     *
     * Example usage:
     * <code>
     * $query->filterByLabel('fooValue');   // WHERE label = 'fooValue'
     * $query->filterByLabel('%fooValue%', Criteria::LIKE); // WHERE label LIKE '%fooValue%'
     * </code>
     *
     * @param     string $label The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFieldQuery The current query, for fluid interface
     */
    public function filterByLabel($label = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($label)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FieldTableMap::COL_LABEL, $label, $comparison);
    }

    /**
     * Filter the query on the tooltip column
     *
     * Example usage:
     * <code>
     * $query->filterByTooltip('fooValue');   // WHERE tooltip = 'fooValue'
     * $query->filterByTooltip('%fooValue%', Criteria::LIKE); // WHERE tooltip LIKE '%fooValue%'
     * </code>
     *
     * @param     string $tooltip The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFieldQuery The current query, for fluid interface
     */
    public function filterByTooltip($tooltip = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($tooltip)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FieldTableMap::COL_TOOLTIP, $tooltip, $comparison);
    }

    /**
     * Filter the query on the default_value column
     *
     * Example usage:
     * <code>
     * $query->filterByDefaultValue('fooValue');   // WHERE default_value = 'fooValue'
     * $query->filterByDefaultValue('%fooValue%', Criteria::LIKE); // WHERE default_value LIKE '%fooValue%'
     * </code>
     *
     * @param     string $defaultValue The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFieldQuery The current query, for fluid interface
     */
    public function filterByDefaultValue($defaultValue = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($defaultValue)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FieldTableMap::COL_DEFAULT_VALUE, $defaultValue, $comparison);
    }

    /**
     * Filter the query on the validation_regex column
     *
     * Example usage:
     * <code>
     * $query->filterByValidationRegex('fooValue');   // WHERE validation_regex = 'fooValue'
     * $query->filterByValidationRegex('%fooValue%', Criteria::LIKE); // WHERE validation_regex LIKE '%fooValue%'
     * </code>
     *
     * @param     string $validationRegex The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFieldQuery The current query, for fluid interface
     */
    public function filterByValidationRegex($validationRegex = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($validationRegex)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FieldTableMap::COL_VALIDATION_REGEX, $validationRegex, $comparison);
    }

    /**
     * Filter the query on the validation_error column
     *
     * Example usage:
     * <code>
     * $query->filterByValidationError('fooValue');   // WHERE validation_error = 'fooValue'
     * $query->filterByValidationError('%fooValue%', Criteria::LIKE); // WHERE validation_error LIKE '%fooValue%'
     * </code>
     *
     * @param     string $validationError The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFieldQuery The current query, for fluid interface
     */
    public function filterByValidationError($validationError = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($validationError)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FieldTableMap::COL_VALIDATION_ERROR, $validationError, $comparison);
    }

    /**
     * Filter the query on the is_unique column
     *
     * Example usage:
     * <code>
     * $query->filterByIsUnique(true); // WHERE is_unique = true
     * $query->filterByIsUnique('yes'); // WHERE is_unique = true
     * </code>
     *
     * @param     boolean|string $isUnique The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFieldQuery The current query, for fluid interface
     */
    public function filterByIsUnique($isUnique = null, $comparison = null)
    {
        if (is_string($isUnique)) {
            $isUnique = in_array(strtolower($isUnique), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(FieldTableMap::COL_IS_UNIQUE, $isUnique, $comparison);
    }

    /**
     * Filter the query on the is_required column
     *
     * Example usage:
     * <code>
     * $query->filterByIsRequired(true); // WHERE is_required = true
     * $query->filterByIsRequired('yes'); // WHERE is_required = true
     * </code>
     *
     * @param     boolean|string $isRequired The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFieldQuery The current query, for fluid interface
     */
    public function filterByIsRequired($isRequired = null, $comparison = null)
    {
        if (is_string($isRequired)) {
            $isRequired = in_array(strtolower($isRequired), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(FieldTableMap::COL_IS_REQUIRED, $isRequired, $comparison);
    }

    /**
     * Filter the query on the is_searchable column
     *
     * Example usage:
     * <code>
     * $query->filterByIsSearchable(true); // WHERE is_searchable = true
     * $query->filterByIsSearchable('yes'); // WHERE is_searchable = true
     * </code>
     *
     * @param     boolean|string $isSearchable The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFieldQuery The current query, for fluid interface
     */
    public function filterByIsSearchable($isSearchable = null, $comparison = null)
    {
        if (is_string($isSearchable)) {
            $isSearchable = in_array(strtolower($isSearchable), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(FieldTableMap::COL_IS_SEARCHABLE, $isSearchable, $comparison);
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
     * @return $this|ChildFieldQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(FieldTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(FieldTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FieldTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildFieldQuery The current query, for fluid interface
     */
    public function filterByCreatedBy($createdBy = null, $comparison = null)
    {
        if (is_array($createdBy)) {
            $useMinMax = false;
            if (isset($createdBy['min'])) {
                $this->addUsingAlias(FieldTableMap::COL_CREATED_BY, $createdBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdBy['max'])) {
                $this->addUsingAlias(FieldTableMap::COL_CREATED_BY, $createdBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FieldTableMap::COL_CREATED_BY, $createdBy, $comparison);
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
     * @return $this|ChildFieldQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(FieldTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(FieldTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FieldTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
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
     * @return $this|ChildFieldQuery The current query, for fluid interface
     */
    public function filterByUpdatedBy($updatedBy = null, $comparison = null)
    {
        if (is_array($updatedBy)) {
            $useMinMax = false;
            if (isset($updatedBy['min'])) {
                $this->addUsingAlias(FieldTableMap::COL_UPDATED_BY, $updatedBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedBy['max'])) {
                $this->addUsingAlias(FieldTableMap::COL_UPDATED_BY, $updatedBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FieldTableMap::COL_UPDATED_BY, $updatedBy, $comparison);
    }

    /**
     * Filter the query by a related \Propel\Models\User object
     *
     * @param \Propel\Models\User|ObjectCollection $user The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildFieldQuery The current query, for fluid interface
     */
    public function filterByUserRelatedByCreatedBy($user, $comparison = null)
    {
        if ($user instanceof \Propel\Models\User) {
            return $this
                ->addUsingAlias(FieldTableMap::COL_CREATED_BY, $user->getId(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(FieldTableMap::COL_CREATED_BY, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildFieldQuery The current query, for fluid interface
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
     * @return ChildFieldQuery The current query, for fluid interface
     */
    public function filterByUserRelatedByUpdatedBy($user, $comparison = null)
    {
        if ($user instanceof \Propel\Models\User) {
            return $this
                ->addUsingAlias(FieldTableMap::COL_UPDATED_BY, $user->getId(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(FieldTableMap::COL_UPDATED_BY, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildFieldQuery The current query, for fluid interface
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
     * @return ChildFieldQuery The current query, for fluid interface
     */
    public function filterBySectionField($sectionField, $comparison = null)
    {
        if ($sectionField instanceof \Propel\Models\SectionField) {
            return $this
                ->addUsingAlias(FieldTableMap::COL_ID, $sectionField->getFieldId(), $comparison);
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
     * @return $this|ChildFieldQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildField $field Object to remove from the list of results
     *
     * @return $this|ChildFieldQuery The current query, for fluid interface
     */
    public function prune($field = null)
    {
        if ($field) {
            $this->addUsingAlias(FieldTableMap::COL_ID, $field->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the fenric_field table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(FieldTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            FieldTableMap::clearInstancePool();
            FieldTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(FieldTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(FieldTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            FieldTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            FieldTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // FieldQuery
