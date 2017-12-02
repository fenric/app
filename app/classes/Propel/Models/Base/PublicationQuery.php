<?php

namespace Propel\Models\Base;

use \Exception;
use \PDO;
use Propel\Models\Publication as ChildPublication;
use Propel\Models\PublicationQuery as ChildPublicationQuery;
use Propel\Models\Map\PublicationTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'fenric_publication' table.
 *
 *
 *
 * @method     ChildPublicationQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildPublicationQuery orderBySectionId($order = Criteria::ASC) Order by the section_id column
 * @method     ChildPublicationQuery orderByCode($order = Criteria::ASC) Order by the code column
 * @method     ChildPublicationQuery orderByHeader($order = Criteria::ASC) Order by the header column
 * @method     ChildPublicationQuery orderByPicture($order = Criteria::ASC) Order by the picture column
 * @method     ChildPublicationQuery orderByPictureSource($order = Criteria::ASC) Order by the picture_source column
 * @method     ChildPublicationQuery orderByPictureSignature($order = Criteria::ASC) Order by the picture_signature column
 * @method     ChildPublicationQuery orderByAnons($order = Criteria::ASC) Order by the anons column
 * @method     ChildPublicationQuery orderByContent($order = Criteria::ASC) Order by the content column
 * @method     ChildPublicationQuery orderByMetaTitle($order = Criteria::ASC) Order by the meta_title column
 * @method     ChildPublicationQuery orderByMetaAuthor($order = Criteria::ASC) Order by the meta_author column
 * @method     ChildPublicationQuery orderByMetaKeywords($order = Criteria::ASC) Order by the meta_keywords column
 * @method     ChildPublicationQuery orderByMetaDescription($order = Criteria::ASC) Order by the meta_description column
 * @method     ChildPublicationQuery orderByMetaCanonical($order = Criteria::ASC) Order by the meta_canonical column
 * @method     ChildPublicationQuery orderByMetaRobots($order = Criteria::ASC) Order by the meta_robots column
 * @method     ChildPublicationQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildPublicationQuery orderByCreatedBy($order = Criteria::ASC) Order by the created_by column
 * @method     ChildPublicationQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 * @method     ChildPublicationQuery orderByUpdatedBy($order = Criteria::ASC) Order by the updated_by column
 * @method     ChildPublicationQuery orderByShowAt($order = Criteria::ASC) Order by the show_at column
 * @method     ChildPublicationQuery orderByHideAt($order = Criteria::ASC) Order by the hide_at column
 * @method     ChildPublicationQuery orderByHits($order = Criteria::ASC) Order by the hits column
 *
 * @method     ChildPublicationQuery groupById() Group by the id column
 * @method     ChildPublicationQuery groupBySectionId() Group by the section_id column
 * @method     ChildPublicationQuery groupByCode() Group by the code column
 * @method     ChildPublicationQuery groupByHeader() Group by the header column
 * @method     ChildPublicationQuery groupByPicture() Group by the picture column
 * @method     ChildPublicationQuery groupByPictureSource() Group by the picture_source column
 * @method     ChildPublicationQuery groupByPictureSignature() Group by the picture_signature column
 * @method     ChildPublicationQuery groupByAnons() Group by the anons column
 * @method     ChildPublicationQuery groupByContent() Group by the content column
 * @method     ChildPublicationQuery groupByMetaTitle() Group by the meta_title column
 * @method     ChildPublicationQuery groupByMetaAuthor() Group by the meta_author column
 * @method     ChildPublicationQuery groupByMetaKeywords() Group by the meta_keywords column
 * @method     ChildPublicationQuery groupByMetaDescription() Group by the meta_description column
 * @method     ChildPublicationQuery groupByMetaCanonical() Group by the meta_canonical column
 * @method     ChildPublicationQuery groupByMetaRobots() Group by the meta_robots column
 * @method     ChildPublicationQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildPublicationQuery groupByCreatedBy() Group by the created_by column
 * @method     ChildPublicationQuery groupByUpdatedAt() Group by the updated_at column
 * @method     ChildPublicationQuery groupByUpdatedBy() Group by the updated_by column
 * @method     ChildPublicationQuery groupByShowAt() Group by the show_at column
 * @method     ChildPublicationQuery groupByHideAt() Group by the hide_at column
 * @method     ChildPublicationQuery groupByHits() Group by the hits column
 *
 * @method     ChildPublicationQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPublicationQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPublicationQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPublicationQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildPublicationQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildPublicationQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildPublicationQuery leftJoinSection($relationAlias = null) Adds a LEFT JOIN clause to the query using the Section relation
 * @method     ChildPublicationQuery rightJoinSection($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Section relation
 * @method     ChildPublicationQuery innerJoinSection($relationAlias = null) Adds a INNER JOIN clause to the query using the Section relation
 *
 * @method     ChildPublicationQuery joinWithSection($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Section relation
 *
 * @method     ChildPublicationQuery leftJoinWithSection() Adds a LEFT JOIN clause and with to the query using the Section relation
 * @method     ChildPublicationQuery rightJoinWithSection() Adds a RIGHT JOIN clause and with to the query using the Section relation
 * @method     ChildPublicationQuery innerJoinWithSection() Adds a INNER JOIN clause and with to the query using the Section relation
 *
 * @method     ChildPublicationQuery leftJoinUserRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserRelatedByCreatedBy relation
 * @method     ChildPublicationQuery rightJoinUserRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserRelatedByCreatedBy relation
 * @method     ChildPublicationQuery innerJoinUserRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the UserRelatedByCreatedBy relation
 *
 * @method     ChildPublicationQuery joinWithUserRelatedByCreatedBy($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the UserRelatedByCreatedBy relation
 *
 * @method     ChildPublicationQuery leftJoinWithUserRelatedByCreatedBy() Adds a LEFT JOIN clause and with to the query using the UserRelatedByCreatedBy relation
 * @method     ChildPublicationQuery rightJoinWithUserRelatedByCreatedBy() Adds a RIGHT JOIN clause and with to the query using the UserRelatedByCreatedBy relation
 * @method     ChildPublicationQuery innerJoinWithUserRelatedByCreatedBy() Adds a INNER JOIN clause and with to the query using the UserRelatedByCreatedBy relation
 *
 * @method     ChildPublicationQuery leftJoinUserRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserRelatedByUpdatedBy relation
 * @method     ChildPublicationQuery rightJoinUserRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserRelatedByUpdatedBy relation
 * @method     ChildPublicationQuery innerJoinUserRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the UserRelatedByUpdatedBy relation
 *
 * @method     ChildPublicationQuery joinWithUserRelatedByUpdatedBy($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the UserRelatedByUpdatedBy relation
 *
 * @method     ChildPublicationQuery leftJoinWithUserRelatedByUpdatedBy() Adds a LEFT JOIN clause and with to the query using the UserRelatedByUpdatedBy relation
 * @method     ChildPublicationQuery rightJoinWithUserRelatedByUpdatedBy() Adds a RIGHT JOIN clause and with to the query using the UserRelatedByUpdatedBy relation
 * @method     ChildPublicationQuery innerJoinWithUserRelatedByUpdatedBy() Adds a INNER JOIN clause and with to the query using the UserRelatedByUpdatedBy relation
 *
 * @method     ChildPublicationQuery leftJoinComment($relationAlias = null) Adds a LEFT JOIN clause to the query using the Comment relation
 * @method     ChildPublicationQuery rightJoinComment($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Comment relation
 * @method     ChildPublicationQuery innerJoinComment($relationAlias = null) Adds a INNER JOIN clause to the query using the Comment relation
 *
 * @method     ChildPublicationQuery joinWithComment($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Comment relation
 *
 * @method     ChildPublicationQuery leftJoinWithComment() Adds a LEFT JOIN clause and with to the query using the Comment relation
 * @method     ChildPublicationQuery rightJoinWithComment() Adds a RIGHT JOIN clause and with to the query using the Comment relation
 * @method     ChildPublicationQuery innerJoinWithComment() Adds a INNER JOIN clause and with to the query using the Comment relation
 *
 * @method     ChildPublicationQuery leftJoinPublicationField($relationAlias = null) Adds a LEFT JOIN clause to the query using the PublicationField relation
 * @method     ChildPublicationQuery rightJoinPublicationField($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PublicationField relation
 * @method     ChildPublicationQuery innerJoinPublicationField($relationAlias = null) Adds a INNER JOIN clause to the query using the PublicationField relation
 *
 * @method     ChildPublicationQuery joinWithPublicationField($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the PublicationField relation
 *
 * @method     ChildPublicationQuery leftJoinWithPublicationField() Adds a LEFT JOIN clause and with to the query using the PublicationField relation
 * @method     ChildPublicationQuery rightJoinWithPublicationField() Adds a RIGHT JOIN clause and with to the query using the PublicationField relation
 * @method     ChildPublicationQuery innerJoinWithPublicationField() Adds a INNER JOIN clause and with to the query using the PublicationField relation
 *
 * @method     ChildPublicationQuery leftJoinPublicationPhoto($relationAlias = null) Adds a LEFT JOIN clause to the query using the PublicationPhoto relation
 * @method     ChildPublicationQuery rightJoinPublicationPhoto($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PublicationPhoto relation
 * @method     ChildPublicationQuery innerJoinPublicationPhoto($relationAlias = null) Adds a INNER JOIN clause to the query using the PublicationPhoto relation
 *
 * @method     ChildPublicationQuery joinWithPublicationPhoto($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the PublicationPhoto relation
 *
 * @method     ChildPublicationQuery leftJoinWithPublicationPhoto() Adds a LEFT JOIN clause and with to the query using the PublicationPhoto relation
 * @method     ChildPublicationQuery rightJoinWithPublicationPhoto() Adds a RIGHT JOIN clause and with to the query using the PublicationPhoto relation
 * @method     ChildPublicationQuery innerJoinWithPublicationPhoto() Adds a INNER JOIN clause and with to the query using the PublicationPhoto relation
 *
 * @method     ChildPublicationQuery leftJoinPublicationRelation($relationAlias = null) Adds a LEFT JOIN clause to the query using the PublicationRelation relation
 * @method     ChildPublicationQuery rightJoinPublicationRelation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PublicationRelation relation
 * @method     ChildPublicationQuery innerJoinPublicationRelation($relationAlias = null) Adds a INNER JOIN clause to the query using the PublicationRelation relation
 *
 * @method     ChildPublicationQuery joinWithPublicationRelation($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the PublicationRelation relation
 *
 * @method     ChildPublicationQuery leftJoinWithPublicationRelation() Adds a LEFT JOIN clause and with to the query using the PublicationRelation relation
 * @method     ChildPublicationQuery rightJoinWithPublicationRelation() Adds a RIGHT JOIN clause and with to the query using the PublicationRelation relation
 * @method     ChildPublicationQuery innerJoinWithPublicationRelation() Adds a INNER JOIN clause and with to the query using the PublicationRelation relation
 *
 * @method     ChildPublicationQuery leftJoinPublicationTag($relationAlias = null) Adds a LEFT JOIN clause to the query using the PublicationTag relation
 * @method     ChildPublicationQuery rightJoinPublicationTag($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PublicationTag relation
 * @method     ChildPublicationQuery innerJoinPublicationTag($relationAlias = null) Adds a INNER JOIN clause to the query using the PublicationTag relation
 *
 * @method     ChildPublicationQuery joinWithPublicationTag($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the PublicationTag relation
 *
 * @method     ChildPublicationQuery leftJoinWithPublicationTag() Adds a LEFT JOIN clause and with to the query using the PublicationTag relation
 * @method     ChildPublicationQuery rightJoinWithPublicationTag() Adds a RIGHT JOIN clause and with to the query using the PublicationTag relation
 * @method     ChildPublicationQuery innerJoinWithPublicationTag() Adds a INNER JOIN clause and with to the query using the PublicationTag relation
 *
 * @method     ChildPublicationQuery leftJoinUserFavorite($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserFavorite relation
 * @method     ChildPublicationQuery rightJoinUserFavorite($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserFavorite relation
 * @method     ChildPublicationQuery innerJoinUserFavorite($relationAlias = null) Adds a INNER JOIN clause to the query using the UserFavorite relation
 *
 * @method     ChildPublicationQuery joinWithUserFavorite($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the UserFavorite relation
 *
 * @method     ChildPublicationQuery leftJoinWithUserFavorite() Adds a LEFT JOIN clause and with to the query using the UserFavorite relation
 * @method     ChildPublicationQuery rightJoinWithUserFavorite() Adds a RIGHT JOIN clause and with to the query using the UserFavorite relation
 * @method     ChildPublicationQuery innerJoinWithUserFavorite() Adds a INNER JOIN clause and with to the query using the UserFavorite relation
 *
 * @method     \Propel\Models\SectionQuery|\Propel\Models\UserQuery|\Propel\Models\CommentQuery|\Propel\Models\PublicationFieldQuery|\Propel\Models\PublicationPhotoQuery|\Propel\Models\PublicationRelationQuery|\Propel\Models\PublicationTagQuery|\Propel\Models\UserFavoriteQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPublication findOne(ConnectionInterface $con = null) Return the first ChildPublication matching the query
 * @method     ChildPublication findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPublication matching the query, or a new ChildPublication object populated from the query conditions when no match is found
 *
 * @method     ChildPublication findOneById(int $id) Return the first ChildPublication filtered by the id column
 * @method     ChildPublication findOneBySectionId(int $section_id) Return the first ChildPublication filtered by the section_id column
 * @method     ChildPublication findOneByCode(string $code) Return the first ChildPublication filtered by the code column
 * @method     ChildPublication findOneByHeader(string $header) Return the first ChildPublication filtered by the header column
 * @method     ChildPublication findOneByPicture(string $picture) Return the first ChildPublication filtered by the picture column
 * @method     ChildPublication findOneByPictureSource(string $picture_source) Return the first ChildPublication filtered by the picture_source column
 * @method     ChildPublication findOneByPictureSignature(string $picture_signature) Return the first ChildPublication filtered by the picture_signature column
 * @method     ChildPublication findOneByAnons(string $anons) Return the first ChildPublication filtered by the anons column
 * @method     ChildPublication findOneByContent(string $content) Return the first ChildPublication filtered by the content column
 * @method     ChildPublication findOneByMetaTitle(string $meta_title) Return the first ChildPublication filtered by the meta_title column
 * @method     ChildPublication findOneByMetaAuthor(string $meta_author) Return the first ChildPublication filtered by the meta_author column
 * @method     ChildPublication findOneByMetaKeywords(string $meta_keywords) Return the first ChildPublication filtered by the meta_keywords column
 * @method     ChildPublication findOneByMetaDescription(string $meta_description) Return the first ChildPublication filtered by the meta_description column
 * @method     ChildPublication findOneByMetaCanonical(string $meta_canonical) Return the first ChildPublication filtered by the meta_canonical column
 * @method     ChildPublication findOneByMetaRobots(string $meta_robots) Return the first ChildPublication filtered by the meta_robots column
 * @method     ChildPublication findOneByCreatedAt(string $created_at) Return the first ChildPublication filtered by the created_at column
 * @method     ChildPublication findOneByCreatedBy(int $created_by) Return the first ChildPublication filtered by the created_by column
 * @method     ChildPublication findOneByUpdatedAt(string $updated_at) Return the first ChildPublication filtered by the updated_at column
 * @method     ChildPublication findOneByUpdatedBy(int $updated_by) Return the first ChildPublication filtered by the updated_by column
 * @method     ChildPublication findOneByShowAt(string $show_at) Return the first ChildPublication filtered by the show_at column
 * @method     ChildPublication findOneByHideAt(string $hide_at) Return the first ChildPublication filtered by the hide_at column
 * @method     ChildPublication findOneByHits(string $hits) Return the first ChildPublication filtered by the hits column *

 * @method     ChildPublication requirePk($key, ConnectionInterface $con = null) Return the ChildPublication by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPublication requireOne(ConnectionInterface $con = null) Return the first ChildPublication matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPublication requireOneById(int $id) Return the first ChildPublication filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPublication requireOneBySectionId(int $section_id) Return the first ChildPublication filtered by the section_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPublication requireOneByCode(string $code) Return the first ChildPublication filtered by the code column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPublication requireOneByHeader(string $header) Return the first ChildPublication filtered by the header column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPublication requireOneByPicture(string $picture) Return the first ChildPublication filtered by the picture column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPublication requireOneByPictureSource(string $picture_source) Return the first ChildPublication filtered by the picture_source column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPublication requireOneByPictureSignature(string $picture_signature) Return the first ChildPublication filtered by the picture_signature column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPublication requireOneByAnons(string $anons) Return the first ChildPublication filtered by the anons column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPublication requireOneByContent(string $content) Return the first ChildPublication filtered by the content column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPublication requireOneByMetaTitle(string $meta_title) Return the first ChildPublication filtered by the meta_title column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPublication requireOneByMetaAuthor(string $meta_author) Return the first ChildPublication filtered by the meta_author column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPublication requireOneByMetaKeywords(string $meta_keywords) Return the first ChildPublication filtered by the meta_keywords column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPublication requireOneByMetaDescription(string $meta_description) Return the first ChildPublication filtered by the meta_description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPublication requireOneByMetaCanonical(string $meta_canonical) Return the first ChildPublication filtered by the meta_canonical column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPublication requireOneByMetaRobots(string $meta_robots) Return the first ChildPublication filtered by the meta_robots column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPublication requireOneByCreatedAt(string $created_at) Return the first ChildPublication filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPublication requireOneByCreatedBy(int $created_by) Return the first ChildPublication filtered by the created_by column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPublication requireOneByUpdatedAt(string $updated_at) Return the first ChildPublication filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPublication requireOneByUpdatedBy(int $updated_by) Return the first ChildPublication filtered by the updated_by column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPublication requireOneByShowAt(string $show_at) Return the first ChildPublication filtered by the show_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPublication requireOneByHideAt(string $hide_at) Return the first ChildPublication filtered by the hide_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPublication requireOneByHits(string $hits) Return the first ChildPublication filtered by the hits column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPublication[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPublication objects based on current ModelCriteria
 * @method     ChildPublication[]|ObjectCollection findById(int $id) Return ChildPublication objects filtered by the id column
 * @method     ChildPublication[]|ObjectCollection findBySectionId(int $section_id) Return ChildPublication objects filtered by the section_id column
 * @method     ChildPublication[]|ObjectCollection findByCode(string $code) Return ChildPublication objects filtered by the code column
 * @method     ChildPublication[]|ObjectCollection findByHeader(string $header) Return ChildPublication objects filtered by the header column
 * @method     ChildPublication[]|ObjectCollection findByPicture(string $picture) Return ChildPublication objects filtered by the picture column
 * @method     ChildPublication[]|ObjectCollection findByPictureSource(string $picture_source) Return ChildPublication objects filtered by the picture_source column
 * @method     ChildPublication[]|ObjectCollection findByPictureSignature(string $picture_signature) Return ChildPublication objects filtered by the picture_signature column
 * @method     ChildPublication[]|ObjectCollection findByAnons(string $anons) Return ChildPublication objects filtered by the anons column
 * @method     ChildPublication[]|ObjectCollection findByContent(string $content) Return ChildPublication objects filtered by the content column
 * @method     ChildPublication[]|ObjectCollection findByMetaTitle(string $meta_title) Return ChildPublication objects filtered by the meta_title column
 * @method     ChildPublication[]|ObjectCollection findByMetaAuthor(string $meta_author) Return ChildPublication objects filtered by the meta_author column
 * @method     ChildPublication[]|ObjectCollection findByMetaKeywords(string $meta_keywords) Return ChildPublication objects filtered by the meta_keywords column
 * @method     ChildPublication[]|ObjectCollection findByMetaDescription(string $meta_description) Return ChildPublication objects filtered by the meta_description column
 * @method     ChildPublication[]|ObjectCollection findByMetaCanonical(string $meta_canonical) Return ChildPublication objects filtered by the meta_canonical column
 * @method     ChildPublication[]|ObjectCollection findByMetaRobots(string $meta_robots) Return ChildPublication objects filtered by the meta_robots column
 * @method     ChildPublication[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildPublication objects filtered by the created_at column
 * @method     ChildPublication[]|ObjectCollection findByCreatedBy(int $created_by) Return ChildPublication objects filtered by the created_by column
 * @method     ChildPublication[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildPublication objects filtered by the updated_at column
 * @method     ChildPublication[]|ObjectCollection findByUpdatedBy(int $updated_by) Return ChildPublication objects filtered by the updated_by column
 * @method     ChildPublication[]|ObjectCollection findByShowAt(string $show_at) Return ChildPublication objects filtered by the show_at column
 * @method     ChildPublication[]|ObjectCollection findByHideAt(string $hide_at) Return ChildPublication objects filtered by the hide_at column
 * @method     ChildPublication[]|ObjectCollection findByHits(string $hits) Return ChildPublication objects filtered by the hits column
 * @method     ChildPublication[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PublicationQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Propel\Models\Base\PublicationQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Propel\\Models\\Publication', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPublicationQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPublicationQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPublicationQuery) {
            return $criteria;
        }
        $query = new ChildPublicationQuery();
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
     * @return ChildPublication|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PublicationTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = PublicationTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildPublication A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, section_id, code, header, picture, picture_source, picture_signature, anons, meta_title, meta_author, meta_keywords, meta_description, meta_canonical, meta_robots, created_at, created_by, updated_at, updated_by, show_at, hide_at, hits FROM fenric_publication WHERE id = :p0';
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
            /** @var ChildPublication $obj */
            $obj = new ChildPublication();
            $obj->hydrate($row);
            PublicationTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildPublication|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPublicationQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PublicationTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPublicationQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PublicationTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildPublicationQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(PublicationTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PublicationTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PublicationTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildPublicationQuery The current query, for fluid interface
     */
    public function filterBySectionId($sectionId = null, $comparison = null)
    {
        if (is_array($sectionId)) {
            $useMinMax = false;
            if (isset($sectionId['min'])) {
                $this->addUsingAlias(PublicationTableMap::COL_SECTION_ID, $sectionId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sectionId['max'])) {
                $this->addUsingAlias(PublicationTableMap::COL_SECTION_ID, $sectionId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PublicationTableMap::COL_SECTION_ID, $sectionId, $comparison);
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
     * @return $this|ChildPublicationQuery The current query, for fluid interface
     */
    public function filterByCode($code = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($code)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PublicationTableMap::COL_CODE, $code, $comparison);
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
     * @return $this|ChildPublicationQuery The current query, for fluid interface
     */
    public function filterByHeader($header = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($header)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PublicationTableMap::COL_HEADER, $header, $comparison);
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
     * @return $this|ChildPublicationQuery The current query, for fluid interface
     */
    public function filterByPicture($picture = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($picture)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PublicationTableMap::COL_PICTURE, $picture, $comparison);
    }

    /**
     * Filter the query on the picture_source column
     *
     * Example usage:
     * <code>
     * $query->filterByPictureSource('fooValue');   // WHERE picture_source = 'fooValue'
     * $query->filterByPictureSource('%fooValue%', Criteria::LIKE); // WHERE picture_source LIKE '%fooValue%'
     * </code>
     *
     * @param     string $pictureSource The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPublicationQuery The current query, for fluid interface
     */
    public function filterByPictureSource($pictureSource = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($pictureSource)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PublicationTableMap::COL_PICTURE_SOURCE, $pictureSource, $comparison);
    }

    /**
     * Filter the query on the picture_signature column
     *
     * Example usage:
     * <code>
     * $query->filterByPictureSignature('fooValue');   // WHERE picture_signature = 'fooValue'
     * $query->filterByPictureSignature('%fooValue%', Criteria::LIKE); // WHERE picture_signature LIKE '%fooValue%'
     * </code>
     *
     * @param     string $pictureSignature The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPublicationQuery The current query, for fluid interface
     */
    public function filterByPictureSignature($pictureSignature = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($pictureSignature)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PublicationTableMap::COL_PICTURE_SIGNATURE, $pictureSignature, $comparison);
    }

    /**
     * Filter the query on the anons column
     *
     * Example usage:
     * <code>
     * $query->filterByAnons('fooValue');   // WHERE anons = 'fooValue'
     * $query->filterByAnons('%fooValue%', Criteria::LIKE); // WHERE anons LIKE '%fooValue%'
     * </code>
     *
     * @param     string $anons The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPublicationQuery The current query, for fluid interface
     */
    public function filterByAnons($anons = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($anons)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PublicationTableMap::COL_ANONS, $anons, $comparison);
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
     * @return $this|ChildPublicationQuery The current query, for fluid interface
     */
    public function filterByContent($content = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($content)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PublicationTableMap::COL_CONTENT, $content, $comparison);
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
     * @return $this|ChildPublicationQuery The current query, for fluid interface
     */
    public function filterByMetaTitle($metaTitle = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($metaTitle)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PublicationTableMap::COL_META_TITLE, $metaTitle, $comparison);
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
     * @return $this|ChildPublicationQuery The current query, for fluid interface
     */
    public function filterByMetaAuthor($metaAuthor = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($metaAuthor)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PublicationTableMap::COL_META_AUTHOR, $metaAuthor, $comparison);
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
     * @return $this|ChildPublicationQuery The current query, for fluid interface
     */
    public function filterByMetaKeywords($metaKeywords = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($metaKeywords)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PublicationTableMap::COL_META_KEYWORDS, $metaKeywords, $comparison);
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
     * @return $this|ChildPublicationQuery The current query, for fluid interface
     */
    public function filterByMetaDescription($metaDescription = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($metaDescription)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PublicationTableMap::COL_META_DESCRIPTION, $metaDescription, $comparison);
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
     * @return $this|ChildPublicationQuery The current query, for fluid interface
     */
    public function filterByMetaCanonical($metaCanonical = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($metaCanonical)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PublicationTableMap::COL_META_CANONICAL, $metaCanonical, $comparison);
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
     * @return $this|ChildPublicationQuery The current query, for fluid interface
     */
    public function filterByMetaRobots($metaRobots = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($metaRobots)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PublicationTableMap::COL_META_ROBOTS, $metaRobots, $comparison);
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
     * @return $this|ChildPublicationQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(PublicationTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(PublicationTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PublicationTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildPublicationQuery The current query, for fluid interface
     */
    public function filterByCreatedBy($createdBy = null, $comparison = null)
    {
        if (is_array($createdBy)) {
            $useMinMax = false;
            if (isset($createdBy['min'])) {
                $this->addUsingAlias(PublicationTableMap::COL_CREATED_BY, $createdBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdBy['max'])) {
                $this->addUsingAlias(PublicationTableMap::COL_CREATED_BY, $createdBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PublicationTableMap::COL_CREATED_BY, $createdBy, $comparison);
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
     * @return $this|ChildPublicationQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(PublicationTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(PublicationTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PublicationTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
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
     * @return $this|ChildPublicationQuery The current query, for fluid interface
     */
    public function filterByUpdatedBy($updatedBy = null, $comparison = null)
    {
        if (is_array($updatedBy)) {
            $useMinMax = false;
            if (isset($updatedBy['min'])) {
                $this->addUsingAlias(PublicationTableMap::COL_UPDATED_BY, $updatedBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedBy['max'])) {
                $this->addUsingAlias(PublicationTableMap::COL_UPDATED_BY, $updatedBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PublicationTableMap::COL_UPDATED_BY, $updatedBy, $comparison);
    }

    /**
     * Filter the query on the show_at column
     *
     * Example usage:
     * <code>
     * $query->filterByShowAt('2011-03-14'); // WHERE show_at = '2011-03-14'
     * $query->filterByShowAt('now'); // WHERE show_at = '2011-03-14'
     * $query->filterByShowAt(array('max' => 'yesterday')); // WHERE show_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $showAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPublicationQuery The current query, for fluid interface
     */
    public function filterByShowAt($showAt = null, $comparison = null)
    {
        if (is_array($showAt)) {
            $useMinMax = false;
            if (isset($showAt['min'])) {
                $this->addUsingAlias(PublicationTableMap::COL_SHOW_AT, $showAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($showAt['max'])) {
                $this->addUsingAlias(PublicationTableMap::COL_SHOW_AT, $showAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PublicationTableMap::COL_SHOW_AT, $showAt, $comparison);
    }

    /**
     * Filter the query on the hide_at column
     *
     * Example usage:
     * <code>
     * $query->filterByHideAt('2011-03-14'); // WHERE hide_at = '2011-03-14'
     * $query->filterByHideAt('now'); // WHERE hide_at = '2011-03-14'
     * $query->filterByHideAt(array('max' => 'yesterday')); // WHERE hide_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $hideAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPublicationQuery The current query, for fluid interface
     */
    public function filterByHideAt($hideAt = null, $comparison = null)
    {
        if (is_array($hideAt)) {
            $useMinMax = false;
            if (isset($hideAt['min'])) {
                $this->addUsingAlias(PublicationTableMap::COL_HIDE_AT, $hideAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($hideAt['max'])) {
                $this->addUsingAlias(PublicationTableMap::COL_HIDE_AT, $hideAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PublicationTableMap::COL_HIDE_AT, $hideAt, $comparison);
    }

    /**
     * Filter the query on the hits column
     *
     * Example usage:
     * <code>
     * $query->filterByHits(1234); // WHERE hits = 1234
     * $query->filterByHits(array(12, 34)); // WHERE hits IN (12, 34)
     * $query->filterByHits(array('min' => 12)); // WHERE hits > 12
     * </code>
     *
     * @param     mixed $hits The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPublicationQuery The current query, for fluid interface
     */
    public function filterByHits($hits = null, $comparison = null)
    {
        if (is_array($hits)) {
            $useMinMax = false;
            if (isset($hits['min'])) {
                $this->addUsingAlias(PublicationTableMap::COL_HITS, $hits['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($hits['max'])) {
                $this->addUsingAlias(PublicationTableMap::COL_HITS, $hits['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PublicationTableMap::COL_HITS, $hits, $comparison);
    }

    /**
     * Filter the query by a related \Propel\Models\Section object
     *
     * @param \Propel\Models\Section|ObjectCollection $section The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPublicationQuery The current query, for fluid interface
     */
    public function filterBySection($section, $comparison = null)
    {
        if ($section instanceof \Propel\Models\Section) {
            return $this
                ->addUsingAlias(PublicationTableMap::COL_SECTION_ID, $section->getId(), $comparison);
        } elseif ($section instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PublicationTableMap::COL_SECTION_ID, $section->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildPublicationQuery The current query, for fluid interface
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
     * Filter the query by a related \Propel\Models\User object
     *
     * @param \Propel\Models\User|ObjectCollection $user The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPublicationQuery The current query, for fluid interface
     */
    public function filterByUserRelatedByCreatedBy($user, $comparison = null)
    {
        if ($user instanceof \Propel\Models\User) {
            return $this
                ->addUsingAlias(PublicationTableMap::COL_CREATED_BY, $user->getId(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PublicationTableMap::COL_CREATED_BY, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildPublicationQuery The current query, for fluid interface
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
     * @return ChildPublicationQuery The current query, for fluid interface
     */
    public function filterByUserRelatedByUpdatedBy($user, $comparison = null)
    {
        if ($user instanceof \Propel\Models\User) {
            return $this
                ->addUsingAlias(PublicationTableMap::COL_UPDATED_BY, $user->getId(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PublicationTableMap::COL_UPDATED_BY, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildPublicationQuery The current query, for fluid interface
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
     * Filter the query by a related \Propel\Models\Comment object
     *
     * @param \Propel\Models\Comment|ObjectCollection $comment the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPublicationQuery The current query, for fluid interface
     */
    public function filterByComment($comment, $comparison = null)
    {
        if ($comment instanceof \Propel\Models\Comment) {
            return $this
                ->addUsingAlias(PublicationTableMap::COL_ID, $comment->getPublicationId(), $comparison);
        } elseif ($comment instanceof ObjectCollection) {
            return $this
                ->useCommentQuery()
                ->filterByPrimaryKeys($comment->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByComment() only accepts arguments of type \Propel\Models\Comment or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Comment relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPublicationQuery The current query, for fluid interface
     */
    public function joinComment($relationAlias = null, $joinType = 'INNER JOIN')
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Comment');

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
            $this->addJoinObject($join, 'Comment');
        }

        return $this;
    }

    /**
     * Use the Comment relation Comment object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Propel\Models\CommentQuery A secondary query class using the current class as primary query
     */
    public function useCommentQuery($relationAlias = null, $joinType = 'INNER JOIN')
    {
        return $this
            ->joinComment($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Comment', '\Propel\Models\CommentQuery');
    }

    /**
     * Filter the query by a related \Propel\Models\PublicationField object
     *
     * @param \Propel\Models\PublicationField|ObjectCollection $publicationField the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPublicationQuery The current query, for fluid interface
     */
    public function filterByPublicationField($publicationField, $comparison = null)
    {
        if ($publicationField instanceof \Propel\Models\PublicationField) {
            return $this
                ->addUsingAlias(PublicationTableMap::COL_ID, $publicationField->getPublicationId(), $comparison);
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
     * @return $this|ChildPublicationQuery The current query, for fluid interface
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
     * Filter the query by a related \Propel\Models\PublicationPhoto object
     *
     * @param \Propel\Models\PublicationPhoto|ObjectCollection $publicationPhoto the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPublicationQuery The current query, for fluid interface
     */
    public function filterByPublicationPhoto($publicationPhoto, $comparison = null)
    {
        if ($publicationPhoto instanceof \Propel\Models\PublicationPhoto) {
            return $this
                ->addUsingAlias(PublicationTableMap::COL_ID, $publicationPhoto->getPublicationId(), $comparison);
        } elseif ($publicationPhoto instanceof ObjectCollection) {
            return $this
                ->usePublicationPhotoQuery()
                ->filterByPrimaryKeys($publicationPhoto->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPublicationPhoto() only accepts arguments of type \Propel\Models\PublicationPhoto or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PublicationPhoto relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPublicationQuery The current query, for fluid interface
     */
    public function joinPublicationPhoto($relationAlias = null, $joinType = 'INNER JOIN')
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PublicationPhoto');

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
            $this->addJoinObject($join, 'PublicationPhoto');
        }

        return $this;
    }

    /**
     * Use the PublicationPhoto relation PublicationPhoto object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Propel\Models\PublicationPhotoQuery A secondary query class using the current class as primary query
     */
    public function usePublicationPhotoQuery($relationAlias = null, $joinType = 'INNER JOIN')
    {
        return $this
            ->joinPublicationPhoto($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PublicationPhoto', '\Propel\Models\PublicationPhotoQuery');
    }

    /**
     * Filter the query by a related \Propel\Models\PublicationRelation object
     *
     * @param \Propel\Models\PublicationRelation|ObjectCollection $publicationRelation the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPublicationQuery The current query, for fluid interface
     */
    public function filterByPublicationRelation($publicationRelation, $comparison = null)
    {
        if ($publicationRelation instanceof \Propel\Models\PublicationRelation) {
            return $this
                ->addUsingAlias(PublicationTableMap::COL_ID, $publicationRelation->getPublicationId(), $comparison);
        } elseif ($publicationRelation instanceof ObjectCollection) {
            return $this
                ->usePublicationRelationQuery()
                ->filterByPrimaryKeys($publicationRelation->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPublicationRelation() only accepts arguments of type \Propel\Models\PublicationRelation or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PublicationRelation relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPublicationQuery The current query, for fluid interface
     */
    public function joinPublicationRelation($relationAlias = null, $joinType = 'INNER JOIN')
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PublicationRelation');

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
            $this->addJoinObject($join, 'PublicationRelation');
        }

        return $this;
    }

    /**
     * Use the PublicationRelation relation PublicationRelation object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Propel\Models\PublicationRelationQuery A secondary query class using the current class as primary query
     */
    public function usePublicationRelationQuery($relationAlias = null, $joinType = 'INNER JOIN')
    {
        return $this
            ->joinPublicationRelation($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PublicationRelation', '\Propel\Models\PublicationRelationQuery');
    }

    /**
     * Filter the query by a related \Propel\Models\PublicationTag object
     *
     * @param \Propel\Models\PublicationTag|ObjectCollection $publicationTag the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPublicationQuery The current query, for fluid interface
     */
    public function filterByPublicationTag($publicationTag, $comparison = null)
    {
        if ($publicationTag instanceof \Propel\Models\PublicationTag) {
            return $this
                ->addUsingAlias(PublicationTableMap::COL_ID, $publicationTag->getPublicationId(), $comparison);
        } elseif ($publicationTag instanceof ObjectCollection) {
            return $this
                ->usePublicationTagQuery()
                ->filterByPrimaryKeys($publicationTag->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPublicationTag() only accepts arguments of type \Propel\Models\PublicationTag or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PublicationTag relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPublicationQuery The current query, for fluid interface
     */
    public function joinPublicationTag($relationAlias = null, $joinType = 'INNER JOIN')
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PublicationTag');

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
            $this->addJoinObject($join, 'PublicationTag');
        }

        return $this;
    }

    /**
     * Use the PublicationTag relation PublicationTag object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Propel\Models\PublicationTagQuery A secondary query class using the current class as primary query
     */
    public function usePublicationTagQuery($relationAlias = null, $joinType = 'INNER JOIN')
    {
        return $this
            ->joinPublicationTag($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PublicationTag', '\Propel\Models\PublicationTagQuery');
    }

    /**
     * Filter the query by a related \Propel\Models\UserFavorite object
     *
     * @param \Propel\Models\UserFavorite|ObjectCollection $userFavorite the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPublicationQuery The current query, for fluid interface
     */
    public function filterByUserFavorite($userFavorite, $comparison = null)
    {
        if ($userFavorite instanceof \Propel\Models\UserFavorite) {
            return $this
                ->addUsingAlias(PublicationTableMap::COL_ID, $userFavorite->getPublicationId(), $comparison);
        } elseif ($userFavorite instanceof ObjectCollection) {
            return $this
                ->useUserFavoriteQuery()
                ->filterByPrimaryKeys($userFavorite->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByUserFavorite() only accepts arguments of type \Propel\Models\UserFavorite or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UserFavorite relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPublicationQuery The current query, for fluid interface
     */
    public function joinUserFavorite($relationAlias = null, $joinType = 'INNER JOIN')
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UserFavorite');

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
            $this->addJoinObject($join, 'UserFavorite');
        }

        return $this;
    }

    /**
     * Use the UserFavorite relation UserFavorite object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Propel\Models\UserFavoriteQuery A secondary query class using the current class as primary query
     */
    public function useUserFavoriteQuery($relationAlias = null, $joinType = 'INNER JOIN')
    {
        return $this
            ->joinUserFavorite($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UserFavorite', '\Propel\Models\UserFavoriteQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPublication $publication Object to remove from the list of results
     *
     * @return $this|ChildPublicationQuery The current query, for fluid interface
     */
    public function prune($publication = null)
    {
        if ($publication) {
            $this->addUsingAlias(PublicationTableMap::COL_ID, $publication->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the fenric_publication table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PublicationTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PublicationTableMap::clearInstancePool();
            PublicationTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PublicationTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PublicationTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PublicationTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PublicationTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PublicationQuery
