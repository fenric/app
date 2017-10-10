<?php

namespace Propel\Models\Base;

use \Exception;
use \PDO;
use Propel\Models\SectionField as ChildSectionField;
use Propel\Models\SectionFieldQuery as ChildSectionFieldQuery;
use Propel\Models\Map\SectionFieldTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'fenric_section_field' table.
 *
 *
 *
 * @method     ChildSectionFieldQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildSectionFieldQuery orderBySectionId($order = Criteria::ASC) Order by the section_id column
 * @method     ChildSectionFieldQuery orderByFieldId($order = Criteria::ASC) Order by the field_id column
 * @method     ChildSectionFieldQuery orderBySequence($order = Criteria::ASC) Order by the sequence column
 * @method     ChildSectionFieldQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildSectionFieldQuery orderByCreatedBy($order = Criteria::ASC) Order by the created_by column
 *
 * @method     ChildSectionFieldQuery groupById() Group by the id column
 * @method     ChildSectionFieldQuery groupBySectionId() Group by the section_id column
 * @method     ChildSectionFieldQuery groupByFieldId() Group by the field_id column
 * @method     ChildSectionFieldQuery groupBySequence() Group by the sequence column
 * @method     ChildSectionFieldQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildSectionFieldQuery groupByCreatedBy() Group by the created_by column
 *
 * @method     ChildSectionFieldQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSectionFieldQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSectionFieldQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSectionFieldQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildSectionFieldQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildSectionFieldQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildSectionFieldQuery leftJoinSection($relationAlias = null) Adds a LEFT JOIN clause to the query using the Section relation
 * @method     ChildSectionFieldQuery rightJoinSection($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Section relation
 * @method     ChildSectionFieldQuery innerJoinSection($relationAlias = null) Adds a INNER JOIN clause to the query using the Section relation
 *
 * @method     ChildSectionFieldQuery joinWithSection($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Section relation
 *
 * @method     ChildSectionFieldQuery leftJoinWithSection() Adds a LEFT JOIN clause and with to the query using the Section relation
 * @method     ChildSectionFieldQuery rightJoinWithSection() Adds a RIGHT JOIN clause and with to the query using the Section relation
 * @method     ChildSectionFieldQuery innerJoinWithSection() Adds a INNER JOIN clause and with to the query using the Section relation
 *
 * @method     ChildSectionFieldQuery leftJoinField($relationAlias = null) Adds a LEFT JOIN clause to the query using the Field relation
 * @method     ChildSectionFieldQuery rightJoinField($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Field relation
 * @method     ChildSectionFieldQuery innerJoinField($relationAlias = null) Adds a INNER JOIN clause to the query using the Field relation
 *
 * @method     ChildSectionFieldQuery joinWithField($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Field relation
 *
 * @method     ChildSectionFieldQuery leftJoinWithField() Adds a LEFT JOIN clause and with to the query using the Field relation
 * @method     ChildSectionFieldQuery rightJoinWithField() Adds a RIGHT JOIN clause and with to the query using the Field relation
 * @method     ChildSectionFieldQuery innerJoinWithField() Adds a INNER JOIN clause and with to the query using the Field relation
 *
 * @method     ChildSectionFieldQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method     ChildSectionFieldQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method     ChildSectionFieldQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method     ChildSectionFieldQuery joinWithUser($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the User relation
 *
 * @method     ChildSectionFieldQuery leftJoinWithUser() Adds a LEFT JOIN clause and with to the query using the User relation
 * @method     ChildSectionFieldQuery rightJoinWithUser() Adds a RIGHT JOIN clause and with to the query using the User relation
 * @method     ChildSectionFieldQuery innerJoinWithUser() Adds a INNER JOIN clause and with to the query using the User relation
 *
 * @method     ChildSectionFieldQuery leftJoinPublicationField($relationAlias = null) Adds a LEFT JOIN clause to the query using the PublicationField relation
 * @method     ChildSectionFieldQuery rightJoinPublicationField($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PublicationField relation
 * @method     ChildSectionFieldQuery innerJoinPublicationField($relationAlias = null) Adds a INNER JOIN clause to the query using the PublicationField relation
 *
 * @method     ChildSectionFieldQuery joinWithPublicationField($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the PublicationField relation
 *
 * @method     ChildSectionFieldQuery leftJoinWithPublicationField() Adds a LEFT JOIN clause and with to the query using the PublicationField relation
 * @method     ChildSectionFieldQuery rightJoinWithPublicationField() Adds a RIGHT JOIN clause and with to the query using the PublicationField relation
 * @method     ChildSectionFieldQuery innerJoinWithPublicationField() Adds a INNER JOIN clause and with to the query using the PublicationField relation
 *
 * @method     \Propel\Models\SectionQuery|\Propel\Models\FieldQuery|\Propel\Models\UserQuery|\Propel\Models\PublicationFieldQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildSectionField findOne(ConnectionInterface $con = null) Return the first ChildSectionField matching the query
 * @method     ChildSectionField findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSectionField matching the query, or a new ChildSectionField object populated from the query conditions when no match is found
 *
 * @method     ChildSectionField findOneById(int $id) Return the first ChildSectionField filtered by the id column
 * @method     ChildSectionField findOneBySectionId(int $section_id) Return the first ChildSectionField filtered by the section_id column
 * @method     ChildSectionField findOneByFieldId(int $field_id) Return the first ChildSectionField filtered by the field_id column
 * @method     ChildSectionField findOneBySequence(string $sequence) Return the first ChildSectionField filtered by the sequence column
 * @method     ChildSectionField findOneByCreatedAt(string $created_at) Return the first ChildSectionField filtered by the created_at column
 * @method     ChildSectionField findOneByCreatedBy(int $created_by) Return the first ChildSectionField filtered by the created_by column *

 * @method     ChildSectionField requirePk($key, ConnectionInterface $con = null) Return the ChildSectionField by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSectionField requireOne(ConnectionInterface $con = null) Return the first ChildSectionField matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSectionField requireOneById(int $id) Return the first ChildSectionField filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSectionField requireOneBySectionId(int $section_id) Return the first ChildSectionField filtered by the section_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSectionField requireOneByFieldId(int $field_id) Return the first ChildSectionField filtered by the field_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSectionField requireOneBySequence(string $sequence) Return the first ChildSectionField filtered by the sequence column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSectionField requireOneByCreatedAt(string $created_at) Return the first ChildSectionField filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSectionField requireOneByCreatedBy(int $created_by) Return the first ChildSectionField filtered by the created_by column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSectionField[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSectionField objects based on current ModelCriteria
 * @method     ChildSectionField[]|ObjectCollection findById(int $id) Return ChildSectionField objects filtered by the id column
 * @method     ChildSectionField[]|ObjectCollection findBySectionId(int $section_id) Return ChildSectionField objects filtered by the section_id column
 * @method     ChildSectionField[]|ObjectCollection findByFieldId(int $field_id) Return ChildSectionField objects filtered by the field_id column
 * @method     ChildSectionField[]|ObjectCollection findBySequence(string $sequence) Return ChildSectionField objects filtered by the sequence column
 * @method     ChildSectionField[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildSectionField objects filtered by the created_at column
 * @method     ChildSectionField[]|ObjectCollection findByCreatedBy(int $created_by) Return ChildSectionField objects filtered by the created_by column
 * @method     ChildSectionField[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SectionFieldQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Propel\Models\Base\SectionFieldQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Propel\\Models\\SectionField', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSectionFieldQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSectionFieldQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSectionFieldQuery) {
            return $criteria;
        }
        $query = new ChildSectionFieldQuery();
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
     * @return ChildSectionField|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SectionFieldTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = SectionFieldTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildSectionField A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, section_id, field_id, sequence, created_at, created_by FROM fenric_section_field WHERE id = :p0';
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
            /** @var ChildSectionField $obj */
            $obj = new ChildSectionField();
            $obj->hydrate($row);
            SectionFieldTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildSectionField|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildSectionFieldQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SectionFieldTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSectionFieldQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SectionFieldTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildSectionFieldQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(SectionFieldTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(SectionFieldTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SectionFieldTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the section_id column
     *
     * Example usage:
     * <code>
     * $query->filterBySectionId(1234); // WHERE section_id = 1234
     * $query->filterBySectionId(array(12, 34)); // WHERE section_id IN (12, 34)
     * $query->filterBySectionId(array('min' => 12)); // WHERE section_id > 12
     * </code>
     *
     * @see       filterBySection()
     *
     * @param     mixed $sectionId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSectionFieldQuery The current query, for fluid interface
     */
    public function filterBySectionId($sectionId = null, $comparison = null)
    {
        if (is_array($sectionId)) {
            $useMinMax = false;
            if (isset($sectionId['min'])) {
                $this->addUsingAlias(SectionFieldTableMap::COL_SECTION_ID, $sectionId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sectionId['max'])) {
                $this->addUsingAlias(SectionFieldTableMap::COL_SECTION_ID, $sectionId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SectionFieldTableMap::COL_SECTION_ID, $sectionId, $comparison);
    }

    /**
     * Filter the query on the field_id column
     *
     * Example usage:
     * <code>
     * $query->filterByFieldId(1234); // WHERE field_id = 1234
     * $query->filterByFieldId(array(12, 34)); // WHERE field_id IN (12, 34)
     * $query->filterByFieldId(array('min' => 12)); // WHERE field_id > 12
     * </code>
     *
     * @see       filterByField()
     *
     * @param     mixed $fieldId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSectionFieldQuery The current query, for fluid interface
     */
    public function filterByFieldId($fieldId = null, $comparison = null)
    {
        if (is_array($fieldId)) {
            $useMinMax = false;
            if (isset($fieldId['min'])) {
                $this->addUsingAlias(SectionFieldTableMap::COL_FIELD_ID, $fieldId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fieldId['max'])) {
                $this->addUsingAlias(SectionFieldTableMap::COL_FIELD_ID, $fieldId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SectionFieldTableMap::COL_FIELD_ID, $fieldId, $comparison);
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
     * @return $this|ChildSectionFieldQuery The current query, for fluid interface
     */
    public function filterBySequence($sequence = null, $comparison = null)
    {
        if (is_array($sequence)) {
            $useMinMax = false;
            if (isset($sequence['min'])) {
                $this->addUsingAlias(SectionFieldTableMap::COL_SEQUENCE, $sequence['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sequence['max'])) {
                $this->addUsingAlias(SectionFieldTableMap::COL_SEQUENCE, $sequence['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SectionFieldTableMap::COL_SEQUENCE, $sequence, $comparison);
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
     * @return $this|ChildSectionFieldQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(SectionFieldTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(SectionFieldTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SectionFieldTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @see       filterByUser()
     *
     * @param     mixed $createdBy The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSectionFieldQuery The current query, for fluid interface
     */
    public function filterByCreatedBy($createdBy = null, $comparison = null)
    {
        if (is_array($createdBy)) {
            $useMinMax = false;
            if (isset($createdBy['min'])) {
                $this->addUsingAlias(SectionFieldTableMap::COL_CREATED_BY, $createdBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdBy['max'])) {
                $this->addUsingAlias(SectionFieldTableMap::COL_CREATED_BY, $createdBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SectionFieldTableMap::COL_CREATED_BY, $createdBy, $comparison);
    }

    /**
     * Filter the query by a related \Propel\Models\Section object
     *
     * @param \Propel\Models\Section|ObjectCollection $section The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSectionFieldQuery The current query, for fluid interface
     */
    public function filterBySection($section, $comparison = null)
    {
        if ($section instanceof \Propel\Models\Section) {
            return $this
                ->addUsingAlias(SectionFieldTableMap::COL_SECTION_ID, $section->getId(), $comparison);
        } elseif ($section instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SectionFieldTableMap::COL_SECTION_ID, $section->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterBySection() only accepts arguments of type \Propel\Models\Section or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Section relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSectionFieldQuery The current query, for fluid interface
     */
    public function joinSection($relationAlias = null, $joinType = 'INNER JOIN')
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Section');

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
            $this->addJoinObject($join, 'Section');
        }

        return $this;
    }

    /**
     * Use the Section relation Section object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Propel\Models\SectionQuery A secondary query class using the current class as primary query
     */
    public function useSectionQuery($relationAlias = null, $joinType = 'INNER JOIN')
    {
        return $this
            ->joinSection($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Section', '\Propel\Models\SectionQuery');
    }

    /**
     * Filter the query by a related \Propel\Models\Field object
     *
     * @param \Propel\Models\Field|ObjectCollection $field The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSectionFieldQuery The current query, for fluid interface
     */
    public function filterByField($field, $comparison = null)
    {
        if ($field instanceof \Propel\Models\Field) {
            return $this
                ->addUsingAlias(SectionFieldTableMap::COL_FIELD_ID, $field->getId(), $comparison);
        } elseif ($field instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SectionFieldTableMap::COL_FIELD_ID, $field->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByField() only accepts arguments of type \Propel\Models\Field or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Field relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSectionFieldQuery The current query, for fluid interface
     */
    public function joinField($relationAlias = null, $joinType = 'INNER JOIN')
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Field');

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
            $this->addJoinObject($join, 'Field');
        }

        return $this;
    }

    /**
     * Use the Field relation Field object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Propel\Models\FieldQuery A secondary query class using the current class as primary query
     */
    public function useFieldQuery($relationAlias = null, $joinType = 'INNER JOIN')
    {
        return $this
            ->joinField($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Field', '\Propel\Models\FieldQuery');
    }

    /**
     * Filter the query by a related \Propel\Models\User object
     *
     * @param \Propel\Models\User|ObjectCollection $user The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSectionFieldQuery The current query, for fluid interface
     */
    public function filterByUser($user, $comparison = null)
    {
        if ($user instanceof \Propel\Models\User) {
            return $this
                ->addUsingAlias(SectionFieldTableMap::COL_CREATED_BY, $user->getId(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SectionFieldTableMap::COL_CREATED_BY, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByUser() only accepts arguments of type \Propel\Models\User or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the User relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSectionFieldQuery The current query, for fluid interface
     */
    public function joinUser($relationAlias = null, $joinType = 'INNER JOIN')
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('User');

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
            $this->addJoinObject($join, 'User');
        }

        return $this;
    }

    /**
     * Use the User relation User object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Propel\Models\UserQuery A secondary query class using the current class as primary query
     */
    public function useUserQuery($relationAlias = null, $joinType = 'INNER JOIN')
    {
        return $this
            ->joinUser($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'User', '\Propel\Models\UserQuery');
    }

    /**
     * Filter the query by a related \Propel\Models\PublicationField object
     *
     * @param \Propel\Models\PublicationField|ObjectCollection $publicationField the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSectionFieldQuery The current query, for fluid interface
     */
    public function filterByPublicationField($publicationField, $comparison = null)
    {
        if ($publicationField instanceof \Propel\Models\PublicationField) {
            return $this
                ->addUsingAlias(SectionFieldTableMap::COL_ID, $publicationField->getSectionFieldId(), $comparison);
        } elseif ($publicationField instanceof ObjectCollection) {
            return $this
                ->usePublicationFieldQuery()
                ->filterByPrimaryKeys($publicationField->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPublicationField() only accepts arguments of type \Propel\Models\PublicationField or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PublicationField relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSectionFieldQuery The current query, for fluid interface
     */
    public function joinPublicationField($relationAlias = null, $joinType = 'INNER JOIN')
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PublicationField');

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
            $this->addJoinObject($join, 'PublicationField');
        }

        return $this;
    }

    /**
     * Use the PublicationField relation PublicationField object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Propel\Models\PublicationFieldQuery A secondary query class using the current class as primary query
     */
    public function usePublicationFieldQuery($relationAlias = null, $joinType = 'INNER JOIN')
    {
        return $this
            ->joinPublicationField($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PublicationField', '\Propel\Models\PublicationFieldQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildSectionField $sectionField Object to remove from the list of results
     *
     * @return $this|ChildSectionFieldQuery The current query, for fluid interface
     */
    public function prune($sectionField = null)
    {
        if ($sectionField) {
            $this->addUsingAlias(SectionFieldTableMap::COL_ID, $sectionField->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the fenric_section_field table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SectionFieldTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SectionFieldTableMap::clearInstancePool();
            SectionFieldTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(SectionFieldTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SectionFieldTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            SectionFieldTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SectionFieldTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // SectionFieldQuery
