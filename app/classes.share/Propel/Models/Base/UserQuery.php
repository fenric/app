<?php

namespace Propel\Models\Base;

use \Exception;
use \PDO;
use Propel\Models\User as ChildUser;
use Propel\Models\UserQuery as ChildUserQuery;
use Propel\Models\Map\UserTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'fenric_user' table.
 *
 *
 *
 * @method     ChildUserQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildUserQuery orderByRole($order = Criteria::ASC) Order by the role column
 * @method     ChildUserQuery orderByEmail($order = Criteria::ASC) Order by the email column
 * @method     ChildUserQuery orderByUsername($order = Criteria::ASC) Order by the username column
 * @method     ChildUserQuery orderByPassword($order = Criteria::ASC) Order by the password column
 * @method     ChildUserQuery orderByPhoto($order = Criteria::ASC) Order by the photo column
 * @method     ChildUserQuery orderByFirstname($order = Criteria::ASC) Order by the firstname column
 * @method     ChildUserQuery orderByLastname($order = Criteria::ASC) Order by the lastname column
 * @method     ChildUserQuery orderByGender($order = Criteria::ASC) Order by the gender column
 * @method     ChildUserQuery orderByBirthday($order = Criteria::ASC) Order by the birthday column
 * @method     ChildUserQuery orderByAbout($order = Criteria::ASC) Order by the about column
 * @method     ChildUserQuery orderByParams($order = Criteria::ASC) Order by the params column
 * @method     ChildUserQuery orderByRegistrationAt($order = Criteria::ASC) Order by the registration_at column
 * @method     ChildUserQuery orderByRegistrationIp($order = Criteria::ASC) Order by the registration_ip column
 * @method     ChildUserQuery orderByRegistrationConfirmed($order = Criteria::ASC) Order by the registration_confirmed column
 * @method     ChildUserQuery orderByRegistrationConfirmedAt($order = Criteria::ASC) Order by the registration_confirmed_at column
 * @method     ChildUserQuery orderByRegistrationConfirmedIp($order = Criteria::ASC) Order by the registration_confirmed_ip column
 * @method     ChildUserQuery orderByRegistrationConfirmationCode($order = Criteria::ASC) Order by the registration_confirmation_code column
 * @method     ChildUserQuery orderByAuthenticationAt($order = Criteria::ASC) Order by the authentication_at column
 * @method     ChildUserQuery orderByAuthenticationIp($order = Criteria::ASC) Order by the authentication_ip column
 * @method     ChildUserQuery orderByAuthenticationKey($order = Criteria::ASC) Order by the authentication_key column
 * @method     ChildUserQuery orderByAuthenticationToken($order = Criteria::ASC) Order by the authentication_token column
 * @method     ChildUserQuery orderByAuthenticationTokenAt($order = Criteria::ASC) Order by the authentication_token_at column
 * @method     ChildUserQuery orderByAuthenticationTokenIp($order = Criteria::ASC) Order by the authentication_token_ip column
 * @method     ChildUserQuery orderByAuthenticationAttemptCount($order = Criteria::ASC) Order by the authentication_attempt_count column
 * @method     ChildUserQuery orderByTrackAt($order = Criteria::ASC) Order by the track_at column
 * @method     ChildUserQuery orderByTrackIp($order = Criteria::ASC) Order by the track_ip column
 * @method     ChildUserQuery orderByTrackUrl($order = Criteria::ASC) Order by the track_url column
 * @method     ChildUserQuery orderByBanFrom($order = Criteria::ASC) Order by the ban_from column
 * @method     ChildUserQuery orderByBanUntil($order = Criteria::ASC) Order by the ban_until column
 * @method     ChildUserQuery orderByBanReason($order = Criteria::ASC) Order by the ban_reason column
 *
 * @method     ChildUserQuery groupById() Group by the id column
 * @method     ChildUserQuery groupByRole() Group by the role column
 * @method     ChildUserQuery groupByEmail() Group by the email column
 * @method     ChildUserQuery groupByUsername() Group by the username column
 * @method     ChildUserQuery groupByPassword() Group by the password column
 * @method     ChildUserQuery groupByPhoto() Group by the photo column
 * @method     ChildUserQuery groupByFirstname() Group by the firstname column
 * @method     ChildUserQuery groupByLastname() Group by the lastname column
 * @method     ChildUserQuery groupByGender() Group by the gender column
 * @method     ChildUserQuery groupByBirthday() Group by the birthday column
 * @method     ChildUserQuery groupByAbout() Group by the about column
 * @method     ChildUserQuery groupByParams() Group by the params column
 * @method     ChildUserQuery groupByRegistrationAt() Group by the registration_at column
 * @method     ChildUserQuery groupByRegistrationIp() Group by the registration_ip column
 * @method     ChildUserQuery groupByRegistrationConfirmed() Group by the registration_confirmed column
 * @method     ChildUserQuery groupByRegistrationConfirmedAt() Group by the registration_confirmed_at column
 * @method     ChildUserQuery groupByRegistrationConfirmedIp() Group by the registration_confirmed_ip column
 * @method     ChildUserQuery groupByRegistrationConfirmationCode() Group by the registration_confirmation_code column
 * @method     ChildUserQuery groupByAuthenticationAt() Group by the authentication_at column
 * @method     ChildUserQuery groupByAuthenticationIp() Group by the authentication_ip column
 * @method     ChildUserQuery groupByAuthenticationKey() Group by the authentication_key column
 * @method     ChildUserQuery groupByAuthenticationToken() Group by the authentication_token column
 * @method     ChildUserQuery groupByAuthenticationTokenAt() Group by the authentication_token_at column
 * @method     ChildUserQuery groupByAuthenticationTokenIp() Group by the authentication_token_ip column
 * @method     ChildUserQuery groupByAuthenticationAttemptCount() Group by the authentication_attempt_count column
 * @method     ChildUserQuery groupByTrackAt() Group by the track_at column
 * @method     ChildUserQuery groupByTrackIp() Group by the track_ip column
 * @method     ChildUserQuery groupByTrackUrl() Group by the track_url column
 * @method     ChildUserQuery groupByBanFrom() Group by the ban_from column
 * @method     ChildUserQuery groupByBanUntil() Group by the ban_until column
 * @method     ChildUserQuery groupByBanReason() Group by the ban_reason column
 *
 * @method     ChildUserQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildUserQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildUserQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildUserQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildUserQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildUserQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildUserQuery leftJoinFieldRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the FieldRelatedByCreatedBy relation
 * @method     ChildUserQuery rightJoinFieldRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FieldRelatedByCreatedBy relation
 * @method     ChildUserQuery innerJoinFieldRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the FieldRelatedByCreatedBy relation
 *
 * @method     ChildUserQuery joinWithFieldRelatedByCreatedBy($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the FieldRelatedByCreatedBy relation
 *
 * @method     ChildUserQuery leftJoinWithFieldRelatedByCreatedBy() Adds a LEFT JOIN clause and with to the query using the FieldRelatedByCreatedBy relation
 * @method     ChildUserQuery rightJoinWithFieldRelatedByCreatedBy() Adds a RIGHT JOIN clause and with to the query using the FieldRelatedByCreatedBy relation
 * @method     ChildUserQuery innerJoinWithFieldRelatedByCreatedBy() Adds a INNER JOIN clause and with to the query using the FieldRelatedByCreatedBy relation
 *
 * @method     ChildUserQuery leftJoinFieldRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the FieldRelatedByUpdatedBy relation
 * @method     ChildUserQuery rightJoinFieldRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FieldRelatedByUpdatedBy relation
 * @method     ChildUserQuery innerJoinFieldRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the FieldRelatedByUpdatedBy relation
 *
 * @method     ChildUserQuery joinWithFieldRelatedByUpdatedBy($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the FieldRelatedByUpdatedBy relation
 *
 * @method     ChildUserQuery leftJoinWithFieldRelatedByUpdatedBy() Adds a LEFT JOIN clause and with to the query using the FieldRelatedByUpdatedBy relation
 * @method     ChildUserQuery rightJoinWithFieldRelatedByUpdatedBy() Adds a RIGHT JOIN clause and with to the query using the FieldRelatedByUpdatedBy relation
 * @method     ChildUserQuery innerJoinWithFieldRelatedByUpdatedBy() Adds a INNER JOIN clause and with to the query using the FieldRelatedByUpdatedBy relation
 *
 * @method     ChildUserQuery leftJoinSectionRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the SectionRelatedByCreatedBy relation
 * @method     ChildUserQuery rightJoinSectionRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SectionRelatedByCreatedBy relation
 * @method     ChildUserQuery innerJoinSectionRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the SectionRelatedByCreatedBy relation
 *
 * @method     ChildUserQuery joinWithSectionRelatedByCreatedBy($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the SectionRelatedByCreatedBy relation
 *
 * @method     ChildUserQuery leftJoinWithSectionRelatedByCreatedBy() Adds a LEFT JOIN clause and with to the query using the SectionRelatedByCreatedBy relation
 * @method     ChildUserQuery rightJoinWithSectionRelatedByCreatedBy() Adds a RIGHT JOIN clause and with to the query using the SectionRelatedByCreatedBy relation
 * @method     ChildUserQuery innerJoinWithSectionRelatedByCreatedBy() Adds a INNER JOIN clause and with to the query using the SectionRelatedByCreatedBy relation
 *
 * @method     ChildUserQuery leftJoinSectionRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the SectionRelatedByUpdatedBy relation
 * @method     ChildUserQuery rightJoinSectionRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SectionRelatedByUpdatedBy relation
 * @method     ChildUserQuery innerJoinSectionRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the SectionRelatedByUpdatedBy relation
 *
 * @method     ChildUserQuery joinWithSectionRelatedByUpdatedBy($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the SectionRelatedByUpdatedBy relation
 *
 * @method     ChildUserQuery leftJoinWithSectionRelatedByUpdatedBy() Adds a LEFT JOIN clause and with to the query using the SectionRelatedByUpdatedBy relation
 * @method     ChildUserQuery rightJoinWithSectionRelatedByUpdatedBy() Adds a RIGHT JOIN clause and with to the query using the SectionRelatedByUpdatedBy relation
 * @method     ChildUserQuery innerJoinWithSectionRelatedByUpdatedBy() Adds a INNER JOIN clause and with to the query using the SectionRelatedByUpdatedBy relation
 *
 * @method     ChildUserQuery leftJoinPublicationRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the PublicationRelatedByCreatedBy relation
 * @method     ChildUserQuery rightJoinPublicationRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PublicationRelatedByCreatedBy relation
 * @method     ChildUserQuery innerJoinPublicationRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the PublicationRelatedByCreatedBy relation
 *
 * @method     ChildUserQuery joinWithPublicationRelatedByCreatedBy($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the PublicationRelatedByCreatedBy relation
 *
 * @method     ChildUserQuery leftJoinWithPublicationRelatedByCreatedBy() Adds a LEFT JOIN clause and with to the query using the PublicationRelatedByCreatedBy relation
 * @method     ChildUserQuery rightJoinWithPublicationRelatedByCreatedBy() Adds a RIGHT JOIN clause and with to the query using the PublicationRelatedByCreatedBy relation
 * @method     ChildUserQuery innerJoinWithPublicationRelatedByCreatedBy() Adds a INNER JOIN clause and with to the query using the PublicationRelatedByCreatedBy relation
 *
 * @method     ChildUserQuery leftJoinPublicationRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the PublicationRelatedByUpdatedBy relation
 * @method     ChildUserQuery rightJoinPublicationRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PublicationRelatedByUpdatedBy relation
 * @method     ChildUserQuery innerJoinPublicationRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the PublicationRelatedByUpdatedBy relation
 *
 * @method     ChildUserQuery joinWithPublicationRelatedByUpdatedBy($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the PublicationRelatedByUpdatedBy relation
 *
 * @method     ChildUserQuery leftJoinWithPublicationRelatedByUpdatedBy() Adds a LEFT JOIN clause and with to the query using the PublicationRelatedByUpdatedBy relation
 * @method     ChildUserQuery rightJoinWithPublicationRelatedByUpdatedBy() Adds a RIGHT JOIN clause and with to the query using the PublicationRelatedByUpdatedBy relation
 * @method     ChildUserQuery innerJoinWithPublicationRelatedByUpdatedBy() Adds a INNER JOIN clause and with to the query using the PublicationRelatedByUpdatedBy relation
 *
 * @method     ChildUserQuery leftJoinPublicationPhotoRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the PublicationPhotoRelatedByCreatedBy relation
 * @method     ChildUserQuery rightJoinPublicationPhotoRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PublicationPhotoRelatedByCreatedBy relation
 * @method     ChildUserQuery innerJoinPublicationPhotoRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the PublicationPhotoRelatedByCreatedBy relation
 *
 * @method     ChildUserQuery joinWithPublicationPhotoRelatedByCreatedBy($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the PublicationPhotoRelatedByCreatedBy relation
 *
 * @method     ChildUserQuery leftJoinWithPublicationPhotoRelatedByCreatedBy() Adds a LEFT JOIN clause and with to the query using the PublicationPhotoRelatedByCreatedBy relation
 * @method     ChildUserQuery rightJoinWithPublicationPhotoRelatedByCreatedBy() Adds a RIGHT JOIN clause and with to the query using the PublicationPhotoRelatedByCreatedBy relation
 * @method     ChildUserQuery innerJoinWithPublicationPhotoRelatedByCreatedBy() Adds a INNER JOIN clause and with to the query using the PublicationPhotoRelatedByCreatedBy relation
 *
 * @method     ChildUserQuery leftJoinPublicationPhotoRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the PublicationPhotoRelatedByUpdatedBy relation
 * @method     ChildUserQuery rightJoinPublicationPhotoRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PublicationPhotoRelatedByUpdatedBy relation
 * @method     ChildUserQuery innerJoinPublicationPhotoRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the PublicationPhotoRelatedByUpdatedBy relation
 *
 * @method     ChildUserQuery joinWithPublicationPhotoRelatedByUpdatedBy($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the PublicationPhotoRelatedByUpdatedBy relation
 *
 * @method     ChildUserQuery leftJoinWithPublicationPhotoRelatedByUpdatedBy() Adds a LEFT JOIN clause and with to the query using the PublicationPhotoRelatedByUpdatedBy relation
 * @method     ChildUserQuery rightJoinWithPublicationPhotoRelatedByUpdatedBy() Adds a RIGHT JOIN clause and with to the query using the PublicationPhotoRelatedByUpdatedBy relation
 * @method     ChildUserQuery innerJoinWithPublicationPhotoRelatedByUpdatedBy() Adds a INNER JOIN clause and with to the query using the PublicationPhotoRelatedByUpdatedBy relation
 *
 * @method     ChildUserQuery leftJoinSnippetRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the SnippetRelatedByCreatedBy relation
 * @method     ChildUserQuery rightJoinSnippetRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SnippetRelatedByCreatedBy relation
 * @method     ChildUserQuery innerJoinSnippetRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the SnippetRelatedByCreatedBy relation
 *
 * @method     ChildUserQuery joinWithSnippetRelatedByCreatedBy($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the SnippetRelatedByCreatedBy relation
 *
 * @method     ChildUserQuery leftJoinWithSnippetRelatedByCreatedBy() Adds a LEFT JOIN clause and with to the query using the SnippetRelatedByCreatedBy relation
 * @method     ChildUserQuery rightJoinWithSnippetRelatedByCreatedBy() Adds a RIGHT JOIN clause and with to the query using the SnippetRelatedByCreatedBy relation
 * @method     ChildUserQuery innerJoinWithSnippetRelatedByCreatedBy() Adds a INNER JOIN clause and with to the query using the SnippetRelatedByCreatedBy relation
 *
 * @method     ChildUserQuery leftJoinSnippetRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the SnippetRelatedByUpdatedBy relation
 * @method     ChildUserQuery rightJoinSnippetRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SnippetRelatedByUpdatedBy relation
 * @method     ChildUserQuery innerJoinSnippetRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the SnippetRelatedByUpdatedBy relation
 *
 * @method     ChildUserQuery joinWithSnippetRelatedByUpdatedBy($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the SnippetRelatedByUpdatedBy relation
 *
 * @method     ChildUserQuery leftJoinWithSnippetRelatedByUpdatedBy() Adds a LEFT JOIN clause and with to the query using the SnippetRelatedByUpdatedBy relation
 * @method     ChildUserQuery rightJoinWithSnippetRelatedByUpdatedBy() Adds a RIGHT JOIN clause and with to the query using the SnippetRelatedByUpdatedBy relation
 * @method     ChildUserQuery innerJoinWithSnippetRelatedByUpdatedBy() Adds a INNER JOIN clause and with to the query using the SnippetRelatedByUpdatedBy relation
 *
 * @method     ChildUserQuery leftJoinTagRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the TagRelatedByCreatedBy relation
 * @method     ChildUserQuery rightJoinTagRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TagRelatedByCreatedBy relation
 * @method     ChildUserQuery innerJoinTagRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the TagRelatedByCreatedBy relation
 *
 * @method     ChildUserQuery joinWithTagRelatedByCreatedBy($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the TagRelatedByCreatedBy relation
 *
 * @method     ChildUserQuery leftJoinWithTagRelatedByCreatedBy() Adds a LEFT JOIN clause and with to the query using the TagRelatedByCreatedBy relation
 * @method     ChildUserQuery rightJoinWithTagRelatedByCreatedBy() Adds a RIGHT JOIN clause and with to the query using the TagRelatedByCreatedBy relation
 * @method     ChildUserQuery innerJoinWithTagRelatedByCreatedBy() Adds a INNER JOIN clause and with to the query using the TagRelatedByCreatedBy relation
 *
 * @method     ChildUserQuery leftJoinTagRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the TagRelatedByUpdatedBy relation
 * @method     ChildUserQuery rightJoinTagRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TagRelatedByUpdatedBy relation
 * @method     ChildUserQuery innerJoinTagRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the TagRelatedByUpdatedBy relation
 *
 * @method     ChildUserQuery joinWithTagRelatedByUpdatedBy($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the TagRelatedByUpdatedBy relation
 *
 * @method     ChildUserQuery leftJoinWithTagRelatedByUpdatedBy() Adds a LEFT JOIN clause and with to the query using the TagRelatedByUpdatedBy relation
 * @method     ChildUserQuery rightJoinWithTagRelatedByUpdatedBy() Adds a RIGHT JOIN clause and with to the query using the TagRelatedByUpdatedBy relation
 * @method     ChildUserQuery innerJoinWithTagRelatedByUpdatedBy() Adds a INNER JOIN clause and with to the query using the TagRelatedByUpdatedBy relation
 *
 * @method     \Propel\Models\FieldQuery|\Propel\Models\SectionQuery|\Propel\Models\PublicationQuery|\Propel\Models\PublicationPhotoQuery|\Propel\Models\SnippetQuery|\Propel\Models\TagQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildUser findOne(ConnectionInterface $con = null) Return the first ChildUser matching the query
 * @method     ChildUser findOneOrCreate(ConnectionInterface $con = null) Return the first ChildUser matching the query, or a new ChildUser object populated from the query conditions when no match is found
 *
 * @method     ChildUser findOneById(int $id) Return the first ChildUser filtered by the id column
 * @method     ChildUser findOneByRole(string $role) Return the first ChildUser filtered by the role column
 * @method     ChildUser findOneByEmail(string $email) Return the first ChildUser filtered by the email column
 * @method     ChildUser findOneByUsername(string $username) Return the first ChildUser filtered by the username column
 * @method     ChildUser findOneByPassword(string $password) Return the first ChildUser filtered by the password column
 * @method     ChildUser findOneByPhoto(string $photo) Return the first ChildUser filtered by the photo column
 * @method     ChildUser findOneByFirstname(string $firstname) Return the first ChildUser filtered by the firstname column
 * @method     ChildUser findOneByLastname(string $lastname) Return the first ChildUser filtered by the lastname column
 * @method     ChildUser findOneByGender(string $gender) Return the first ChildUser filtered by the gender column
 * @method     ChildUser findOneByBirthday(string $birthday) Return the first ChildUser filtered by the birthday column
 * @method     ChildUser findOneByAbout(string $about) Return the first ChildUser filtered by the about column
 * @method     ChildUser findOneByParams(string $params) Return the first ChildUser filtered by the params column
 * @method     ChildUser findOneByRegistrationAt(string $registration_at) Return the first ChildUser filtered by the registration_at column
 * @method     ChildUser findOneByRegistrationIp(string $registration_ip) Return the first ChildUser filtered by the registration_ip column
 * @method     ChildUser findOneByRegistrationConfirmed(boolean $registration_confirmed) Return the first ChildUser filtered by the registration_confirmed column
 * @method     ChildUser findOneByRegistrationConfirmedAt(string $registration_confirmed_at) Return the first ChildUser filtered by the registration_confirmed_at column
 * @method     ChildUser findOneByRegistrationConfirmedIp(string $registration_confirmed_ip) Return the first ChildUser filtered by the registration_confirmed_ip column
 * @method     ChildUser findOneByRegistrationConfirmationCode(string $registration_confirmation_code) Return the first ChildUser filtered by the registration_confirmation_code column
 * @method     ChildUser findOneByAuthenticationAt(string $authentication_at) Return the first ChildUser filtered by the authentication_at column
 * @method     ChildUser findOneByAuthenticationIp(string $authentication_ip) Return the first ChildUser filtered by the authentication_ip column
 * @method     ChildUser findOneByAuthenticationKey(string $authentication_key) Return the first ChildUser filtered by the authentication_key column
 * @method     ChildUser findOneByAuthenticationToken(string $authentication_token) Return the first ChildUser filtered by the authentication_token column
 * @method     ChildUser findOneByAuthenticationTokenAt(string $authentication_token_at) Return the first ChildUser filtered by the authentication_token_at column
 * @method     ChildUser findOneByAuthenticationTokenIp(string $authentication_token_ip) Return the first ChildUser filtered by the authentication_token_ip column
 * @method     ChildUser findOneByAuthenticationAttemptCount(string $authentication_attempt_count) Return the first ChildUser filtered by the authentication_attempt_count column
 * @method     ChildUser findOneByTrackAt(string $track_at) Return the first ChildUser filtered by the track_at column
 * @method     ChildUser findOneByTrackIp(string $track_ip) Return the first ChildUser filtered by the track_ip column
 * @method     ChildUser findOneByTrackUrl(string $track_url) Return the first ChildUser filtered by the track_url column
 * @method     ChildUser findOneByBanFrom(string $ban_from) Return the first ChildUser filtered by the ban_from column
 * @method     ChildUser findOneByBanUntil(string $ban_until) Return the first ChildUser filtered by the ban_until column
 * @method     ChildUser findOneByBanReason(string $ban_reason) Return the first ChildUser filtered by the ban_reason column *

 * @method     ChildUser requirePk($key, ConnectionInterface $con = null) Return the ChildUser by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOne(ConnectionInterface $con = null) Return the first ChildUser matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildUser requireOneById(int $id) Return the first ChildUser filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByRole(string $role) Return the first ChildUser filtered by the role column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByEmail(string $email) Return the first ChildUser filtered by the email column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByUsername(string $username) Return the first ChildUser filtered by the username column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByPassword(string $password) Return the first ChildUser filtered by the password column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByPhoto(string $photo) Return the first ChildUser filtered by the photo column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByFirstname(string $firstname) Return the first ChildUser filtered by the firstname column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByLastname(string $lastname) Return the first ChildUser filtered by the lastname column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByGender(string $gender) Return the first ChildUser filtered by the gender column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByBirthday(string $birthday) Return the first ChildUser filtered by the birthday column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByAbout(string $about) Return the first ChildUser filtered by the about column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByParams(string $params) Return the first ChildUser filtered by the params column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByRegistrationAt(string $registration_at) Return the first ChildUser filtered by the registration_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByRegistrationIp(string $registration_ip) Return the first ChildUser filtered by the registration_ip column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByRegistrationConfirmed(boolean $registration_confirmed) Return the first ChildUser filtered by the registration_confirmed column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByRegistrationConfirmedAt(string $registration_confirmed_at) Return the first ChildUser filtered by the registration_confirmed_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByRegistrationConfirmedIp(string $registration_confirmed_ip) Return the first ChildUser filtered by the registration_confirmed_ip column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByRegistrationConfirmationCode(string $registration_confirmation_code) Return the first ChildUser filtered by the registration_confirmation_code column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByAuthenticationAt(string $authentication_at) Return the first ChildUser filtered by the authentication_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByAuthenticationIp(string $authentication_ip) Return the first ChildUser filtered by the authentication_ip column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByAuthenticationKey(string $authentication_key) Return the first ChildUser filtered by the authentication_key column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByAuthenticationToken(string $authentication_token) Return the first ChildUser filtered by the authentication_token column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByAuthenticationTokenAt(string $authentication_token_at) Return the first ChildUser filtered by the authentication_token_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByAuthenticationTokenIp(string $authentication_token_ip) Return the first ChildUser filtered by the authentication_token_ip column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByAuthenticationAttemptCount(string $authentication_attempt_count) Return the first ChildUser filtered by the authentication_attempt_count column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByTrackAt(string $track_at) Return the first ChildUser filtered by the track_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByTrackIp(string $track_ip) Return the first ChildUser filtered by the track_ip column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByTrackUrl(string $track_url) Return the first ChildUser filtered by the track_url column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByBanFrom(string $ban_from) Return the first ChildUser filtered by the ban_from column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByBanUntil(string $ban_until) Return the first ChildUser filtered by the ban_until column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByBanReason(string $ban_reason) Return the first ChildUser filtered by the ban_reason column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildUser[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildUser objects based on current ModelCriteria
 * @method     ChildUser[]|ObjectCollection findById(int $id) Return ChildUser objects filtered by the id column
 * @method     ChildUser[]|ObjectCollection findByRole(string $role) Return ChildUser objects filtered by the role column
 * @method     ChildUser[]|ObjectCollection findByEmail(string $email) Return ChildUser objects filtered by the email column
 * @method     ChildUser[]|ObjectCollection findByUsername(string $username) Return ChildUser objects filtered by the username column
 * @method     ChildUser[]|ObjectCollection findByPassword(string $password) Return ChildUser objects filtered by the password column
 * @method     ChildUser[]|ObjectCollection findByPhoto(string $photo) Return ChildUser objects filtered by the photo column
 * @method     ChildUser[]|ObjectCollection findByFirstname(string $firstname) Return ChildUser objects filtered by the firstname column
 * @method     ChildUser[]|ObjectCollection findByLastname(string $lastname) Return ChildUser objects filtered by the lastname column
 * @method     ChildUser[]|ObjectCollection findByGender(string $gender) Return ChildUser objects filtered by the gender column
 * @method     ChildUser[]|ObjectCollection findByBirthday(string $birthday) Return ChildUser objects filtered by the birthday column
 * @method     ChildUser[]|ObjectCollection findByAbout(string $about) Return ChildUser objects filtered by the about column
 * @method     ChildUser[]|ObjectCollection findByParams(string $params) Return ChildUser objects filtered by the params column
 * @method     ChildUser[]|ObjectCollection findByRegistrationAt(string $registration_at) Return ChildUser objects filtered by the registration_at column
 * @method     ChildUser[]|ObjectCollection findByRegistrationIp(string $registration_ip) Return ChildUser objects filtered by the registration_ip column
 * @method     ChildUser[]|ObjectCollection findByRegistrationConfirmed(boolean $registration_confirmed) Return ChildUser objects filtered by the registration_confirmed column
 * @method     ChildUser[]|ObjectCollection findByRegistrationConfirmedAt(string $registration_confirmed_at) Return ChildUser objects filtered by the registration_confirmed_at column
 * @method     ChildUser[]|ObjectCollection findByRegistrationConfirmedIp(string $registration_confirmed_ip) Return ChildUser objects filtered by the registration_confirmed_ip column
 * @method     ChildUser[]|ObjectCollection findByRegistrationConfirmationCode(string $registration_confirmation_code) Return ChildUser objects filtered by the registration_confirmation_code column
 * @method     ChildUser[]|ObjectCollection findByAuthenticationAt(string $authentication_at) Return ChildUser objects filtered by the authentication_at column
 * @method     ChildUser[]|ObjectCollection findByAuthenticationIp(string $authentication_ip) Return ChildUser objects filtered by the authentication_ip column
 * @method     ChildUser[]|ObjectCollection findByAuthenticationKey(string $authentication_key) Return ChildUser objects filtered by the authentication_key column
 * @method     ChildUser[]|ObjectCollection findByAuthenticationToken(string $authentication_token) Return ChildUser objects filtered by the authentication_token column
 * @method     ChildUser[]|ObjectCollection findByAuthenticationTokenAt(string $authentication_token_at) Return ChildUser objects filtered by the authentication_token_at column
 * @method     ChildUser[]|ObjectCollection findByAuthenticationTokenIp(string $authentication_token_ip) Return ChildUser objects filtered by the authentication_token_ip column
 * @method     ChildUser[]|ObjectCollection findByAuthenticationAttemptCount(string $authentication_attempt_count) Return ChildUser objects filtered by the authentication_attempt_count column
 * @method     ChildUser[]|ObjectCollection findByTrackAt(string $track_at) Return ChildUser objects filtered by the track_at column
 * @method     ChildUser[]|ObjectCollection findByTrackIp(string $track_ip) Return ChildUser objects filtered by the track_ip column
 * @method     ChildUser[]|ObjectCollection findByTrackUrl(string $track_url) Return ChildUser objects filtered by the track_url column
 * @method     ChildUser[]|ObjectCollection findByBanFrom(string $ban_from) Return ChildUser objects filtered by the ban_from column
 * @method     ChildUser[]|ObjectCollection findByBanUntil(string $ban_until) Return ChildUser objects filtered by the ban_until column
 * @method     ChildUser[]|ObjectCollection findByBanReason(string $ban_reason) Return ChildUser objects filtered by the ban_reason column
 * @method     ChildUser[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class UserQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Propel\Models\Base\UserQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Propel\\Models\\User', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildUserQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildUserQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildUserQuery) {
            return $criteria;
        }
        $query = new ChildUserQuery();
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
     * @return ChildUser|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(UserTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = UserTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildUser A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, role, email, username, photo, firstname, lastname, gender, birthday, registration_at, registration_ip, registration_confirmed, registration_confirmed_at, registration_confirmed_ip, authentication_at, authentication_ip, authentication_token_at, authentication_token_ip, authentication_attempt_count, track_at, track_ip, track_url, ban_from, ban_until, ban_reason FROM fenric_user WHERE id = :p0';
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
            /** @var ChildUser $obj */
            $obj = new ChildUser();
            $obj->hydrate($row);
            UserTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildUser|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(UserTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(UserTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(UserTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(UserTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the role column
     *
     * Example usage:
     * <code>
     * $query->filterByRole('fooValue');   // WHERE role = 'fooValue'
     * $query->filterByRole('%fooValue%', Criteria::LIKE); // WHERE role LIKE '%fooValue%'
     * </code>
     *
     * @param     string $role The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByRole($role = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($role)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_ROLE, $role, $comparison);
    }

    /**
     * Filter the query on the email column
     *
     * Example usage:
     * <code>
     * $query->filterByEmail('fooValue');   // WHERE email = 'fooValue'
     * $query->filterByEmail('%fooValue%', Criteria::LIKE); // WHERE email LIKE '%fooValue%'
     * </code>
     *
     * @param     string $email The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByEmail($email = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($email)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_EMAIL, $email, $comparison);
    }

    /**
     * Filter the query on the username column
     *
     * Example usage:
     * <code>
     * $query->filterByUsername('fooValue');   // WHERE username = 'fooValue'
     * $query->filterByUsername('%fooValue%', Criteria::LIKE); // WHERE username LIKE '%fooValue%'
     * </code>
     *
     * @param     string $username The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByUsername($username = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($username)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_USERNAME, $username, $comparison);
    }

    /**
     * Filter the query on the password column
     *
     * Example usage:
     * <code>
     * $query->filterByPassword('fooValue');   // WHERE password = 'fooValue'
     * $query->filterByPassword('%fooValue%', Criteria::LIKE); // WHERE password LIKE '%fooValue%'
     * </code>
     *
     * @param     string $password The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByPassword($password = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($password)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_PASSWORD, $password, $comparison);
    }

    /**
     * Filter the query on the photo column
     *
     * Example usage:
     * <code>
     * $query->filterByPhoto('fooValue');   // WHERE photo = 'fooValue'
     * $query->filterByPhoto('%fooValue%', Criteria::LIKE); // WHERE photo LIKE '%fooValue%'
     * </code>
     *
     * @param     string $photo The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByPhoto($photo = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($photo)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_PHOTO, $photo, $comparison);
    }

    /**
     * Filter the query on the firstname column
     *
     * Example usage:
     * <code>
     * $query->filterByFirstname('fooValue');   // WHERE firstname = 'fooValue'
     * $query->filterByFirstname('%fooValue%', Criteria::LIKE); // WHERE firstname LIKE '%fooValue%'
     * </code>
     *
     * @param     string $firstname The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByFirstname($firstname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($firstname)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_FIRSTNAME, $firstname, $comparison);
    }

    /**
     * Filter the query on the lastname column
     *
     * Example usage:
     * <code>
     * $query->filterByLastname('fooValue');   // WHERE lastname = 'fooValue'
     * $query->filterByLastname('%fooValue%', Criteria::LIKE); // WHERE lastname LIKE '%fooValue%'
     * </code>
     *
     * @param     string $lastname The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByLastname($lastname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($lastname)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_LASTNAME, $lastname, $comparison);
    }

    /**
     * Filter the query on the gender column
     *
     * Example usage:
     * <code>
     * $query->filterByGender('fooValue');   // WHERE gender = 'fooValue'
     * $query->filterByGender('%fooValue%', Criteria::LIKE); // WHERE gender LIKE '%fooValue%'
     * </code>
     *
     * @param     string $gender The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByGender($gender = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($gender)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_GENDER, $gender, $comparison);
    }

    /**
     * Filter the query on the birthday column
     *
     * Example usage:
     * <code>
     * $query->filterByBirthday('2011-03-14'); // WHERE birthday = '2011-03-14'
     * $query->filterByBirthday('now'); // WHERE birthday = '2011-03-14'
     * $query->filterByBirthday(array('max' => 'yesterday')); // WHERE birthday > '2011-03-13'
     * </code>
     *
     * @param     mixed $birthday The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByBirthday($birthday = null, $comparison = null)
    {
        if (is_array($birthday)) {
            $useMinMax = false;
            if (isset($birthday['min'])) {
                $this->addUsingAlias(UserTableMap::COL_BIRTHDAY, $birthday['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($birthday['max'])) {
                $this->addUsingAlias(UserTableMap::COL_BIRTHDAY, $birthday['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_BIRTHDAY, $birthday, $comparison);
    }

    /**
     * Filter the query on the about column
     *
     * Example usage:
     * <code>
     * $query->filterByAbout('fooValue');   // WHERE about = 'fooValue'
     * $query->filterByAbout('%fooValue%', Criteria::LIKE); // WHERE about LIKE '%fooValue%'
     * </code>
     *
     * @param     string $about The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByAbout($about = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($about)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_ABOUT, $about, $comparison);
    }

    /**
     * Filter the query on the params column
     *
     * Example usage:
     * <code>
     * $query->filterByParams('fooValue');   // WHERE params = 'fooValue'
     * $query->filterByParams('%fooValue%', Criteria::LIKE); // WHERE params LIKE '%fooValue%'
     * </code>
     *
     * @param     string $params The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByParams($params = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($params)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_PARAMS, $params, $comparison);
    }

    /**
     * Filter the query on the registration_at column
     *
     * Example usage:
     * <code>
     * $query->filterByRegistrationAt('2011-03-14'); // WHERE registration_at = '2011-03-14'
     * $query->filterByRegistrationAt('now'); // WHERE registration_at = '2011-03-14'
     * $query->filterByRegistrationAt(array('max' => 'yesterday')); // WHERE registration_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $registrationAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByRegistrationAt($registrationAt = null, $comparison = null)
    {
        if (is_array($registrationAt)) {
            $useMinMax = false;
            if (isset($registrationAt['min'])) {
                $this->addUsingAlias(UserTableMap::COL_REGISTRATION_AT, $registrationAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($registrationAt['max'])) {
                $this->addUsingAlias(UserTableMap::COL_REGISTRATION_AT, $registrationAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_REGISTRATION_AT, $registrationAt, $comparison);
    }

    /**
     * Filter the query on the registration_ip column
     *
     * Example usage:
     * <code>
     * $query->filterByRegistrationIp('fooValue');   // WHERE registration_ip = 'fooValue'
     * $query->filterByRegistrationIp('%fooValue%', Criteria::LIKE); // WHERE registration_ip LIKE '%fooValue%'
     * </code>
     *
     * @param     string $registrationIp The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByRegistrationIp($registrationIp = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($registrationIp)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_REGISTRATION_IP, $registrationIp, $comparison);
    }

    /**
     * Filter the query on the registration_confirmed column
     *
     * Example usage:
     * <code>
     * $query->filterByRegistrationConfirmed(true); // WHERE registration_confirmed = true
     * $query->filterByRegistrationConfirmed('yes'); // WHERE registration_confirmed = true
     * </code>
     *
     * @param     boolean|string $registrationConfirmed The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByRegistrationConfirmed($registrationConfirmed = null, $comparison = null)
    {
        if (is_string($registrationConfirmed)) {
            $registrationConfirmed = in_array(strtolower($registrationConfirmed), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(UserTableMap::COL_REGISTRATION_CONFIRMED, $registrationConfirmed, $comparison);
    }

    /**
     * Filter the query on the registration_confirmed_at column
     *
     * Example usage:
     * <code>
     * $query->filterByRegistrationConfirmedAt('2011-03-14'); // WHERE registration_confirmed_at = '2011-03-14'
     * $query->filterByRegistrationConfirmedAt('now'); // WHERE registration_confirmed_at = '2011-03-14'
     * $query->filterByRegistrationConfirmedAt(array('max' => 'yesterday')); // WHERE registration_confirmed_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $registrationConfirmedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByRegistrationConfirmedAt($registrationConfirmedAt = null, $comparison = null)
    {
        if (is_array($registrationConfirmedAt)) {
            $useMinMax = false;
            if (isset($registrationConfirmedAt['min'])) {
                $this->addUsingAlias(UserTableMap::COL_REGISTRATION_CONFIRMED_AT, $registrationConfirmedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($registrationConfirmedAt['max'])) {
                $this->addUsingAlias(UserTableMap::COL_REGISTRATION_CONFIRMED_AT, $registrationConfirmedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_REGISTRATION_CONFIRMED_AT, $registrationConfirmedAt, $comparison);
    }

    /**
     * Filter the query on the registration_confirmed_ip column
     *
     * Example usage:
     * <code>
     * $query->filterByRegistrationConfirmedIp('fooValue');   // WHERE registration_confirmed_ip = 'fooValue'
     * $query->filterByRegistrationConfirmedIp('%fooValue%', Criteria::LIKE); // WHERE registration_confirmed_ip LIKE '%fooValue%'
     * </code>
     *
     * @param     string $registrationConfirmedIp The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByRegistrationConfirmedIp($registrationConfirmedIp = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($registrationConfirmedIp)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_REGISTRATION_CONFIRMED_IP, $registrationConfirmedIp, $comparison);
    }

    /**
     * Filter the query on the registration_confirmation_code column
     *
     * Example usage:
     * <code>
     * $query->filterByRegistrationConfirmationCode('fooValue');   // WHERE registration_confirmation_code = 'fooValue'
     * $query->filterByRegistrationConfirmationCode('%fooValue%', Criteria::LIKE); // WHERE registration_confirmation_code LIKE '%fooValue%'
     * </code>
     *
     * @param     string $registrationConfirmationCode The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByRegistrationConfirmationCode($registrationConfirmationCode = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($registrationConfirmationCode)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_REGISTRATION_CONFIRMATION_CODE, $registrationConfirmationCode, $comparison);
    }

    /**
     * Filter the query on the authentication_at column
     *
     * Example usage:
     * <code>
     * $query->filterByAuthenticationAt('2011-03-14'); // WHERE authentication_at = '2011-03-14'
     * $query->filterByAuthenticationAt('now'); // WHERE authentication_at = '2011-03-14'
     * $query->filterByAuthenticationAt(array('max' => 'yesterday')); // WHERE authentication_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $authenticationAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByAuthenticationAt($authenticationAt = null, $comparison = null)
    {
        if (is_array($authenticationAt)) {
            $useMinMax = false;
            if (isset($authenticationAt['min'])) {
                $this->addUsingAlias(UserTableMap::COL_AUTHENTICATION_AT, $authenticationAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($authenticationAt['max'])) {
                $this->addUsingAlias(UserTableMap::COL_AUTHENTICATION_AT, $authenticationAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_AUTHENTICATION_AT, $authenticationAt, $comparison);
    }

    /**
     * Filter the query on the authentication_ip column
     *
     * Example usage:
     * <code>
     * $query->filterByAuthenticationIp('fooValue');   // WHERE authentication_ip = 'fooValue'
     * $query->filterByAuthenticationIp('%fooValue%', Criteria::LIKE); // WHERE authentication_ip LIKE '%fooValue%'
     * </code>
     *
     * @param     string $authenticationIp The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByAuthenticationIp($authenticationIp = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($authenticationIp)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_AUTHENTICATION_IP, $authenticationIp, $comparison);
    }

    /**
     * Filter the query on the authentication_key column
     *
     * Example usage:
     * <code>
     * $query->filterByAuthenticationKey('fooValue');   // WHERE authentication_key = 'fooValue'
     * $query->filterByAuthenticationKey('%fooValue%', Criteria::LIKE); // WHERE authentication_key LIKE '%fooValue%'
     * </code>
     *
     * @param     string $authenticationKey The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByAuthenticationKey($authenticationKey = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($authenticationKey)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_AUTHENTICATION_KEY, $authenticationKey, $comparison);
    }

    /**
     * Filter the query on the authentication_token column
     *
     * Example usage:
     * <code>
     * $query->filterByAuthenticationToken('fooValue');   // WHERE authentication_token = 'fooValue'
     * $query->filterByAuthenticationToken('%fooValue%', Criteria::LIKE); // WHERE authentication_token LIKE '%fooValue%'
     * </code>
     *
     * @param     string $authenticationToken The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByAuthenticationToken($authenticationToken = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($authenticationToken)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_AUTHENTICATION_TOKEN, $authenticationToken, $comparison);
    }

    /**
     * Filter the query on the authentication_token_at column
     *
     * Example usage:
     * <code>
     * $query->filterByAuthenticationTokenAt('2011-03-14'); // WHERE authentication_token_at = '2011-03-14'
     * $query->filterByAuthenticationTokenAt('now'); // WHERE authentication_token_at = '2011-03-14'
     * $query->filterByAuthenticationTokenAt(array('max' => 'yesterday')); // WHERE authentication_token_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $authenticationTokenAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByAuthenticationTokenAt($authenticationTokenAt = null, $comparison = null)
    {
        if (is_array($authenticationTokenAt)) {
            $useMinMax = false;
            if (isset($authenticationTokenAt['min'])) {
                $this->addUsingAlias(UserTableMap::COL_AUTHENTICATION_TOKEN_AT, $authenticationTokenAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($authenticationTokenAt['max'])) {
                $this->addUsingAlias(UserTableMap::COL_AUTHENTICATION_TOKEN_AT, $authenticationTokenAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_AUTHENTICATION_TOKEN_AT, $authenticationTokenAt, $comparison);
    }

    /**
     * Filter the query on the authentication_token_ip column
     *
     * Example usage:
     * <code>
     * $query->filterByAuthenticationTokenIp('fooValue');   // WHERE authentication_token_ip = 'fooValue'
     * $query->filterByAuthenticationTokenIp('%fooValue%', Criteria::LIKE); // WHERE authentication_token_ip LIKE '%fooValue%'
     * </code>
     *
     * @param     string $authenticationTokenIp The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByAuthenticationTokenIp($authenticationTokenIp = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($authenticationTokenIp)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_AUTHENTICATION_TOKEN_IP, $authenticationTokenIp, $comparison);
    }

    /**
     * Filter the query on the authentication_attempt_count column
     *
     * Example usage:
     * <code>
     * $query->filterByAuthenticationAttemptCount(1234); // WHERE authentication_attempt_count = 1234
     * $query->filterByAuthenticationAttemptCount(array(12, 34)); // WHERE authentication_attempt_count IN (12, 34)
     * $query->filterByAuthenticationAttemptCount(array('min' => 12)); // WHERE authentication_attempt_count > 12
     * </code>
     *
     * @param     mixed $authenticationAttemptCount The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByAuthenticationAttemptCount($authenticationAttemptCount = null, $comparison = null)
    {
        if (is_array($authenticationAttemptCount)) {
            $useMinMax = false;
            if (isset($authenticationAttemptCount['min'])) {
                $this->addUsingAlias(UserTableMap::COL_AUTHENTICATION_ATTEMPT_COUNT, $authenticationAttemptCount['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($authenticationAttemptCount['max'])) {
                $this->addUsingAlias(UserTableMap::COL_AUTHENTICATION_ATTEMPT_COUNT, $authenticationAttemptCount['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_AUTHENTICATION_ATTEMPT_COUNT, $authenticationAttemptCount, $comparison);
    }

    /**
     * Filter the query on the track_at column
     *
     * Example usage:
     * <code>
     * $query->filterByTrackAt('2011-03-14'); // WHERE track_at = '2011-03-14'
     * $query->filterByTrackAt('now'); // WHERE track_at = '2011-03-14'
     * $query->filterByTrackAt(array('max' => 'yesterday')); // WHERE track_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $trackAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByTrackAt($trackAt = null, $comparison = null)
    {
        if (is_array($trackAt)) {
            $useMinMax = false;
            if (isset($trackAt['min'])) {
                $this->addUsingAlias(UserTableMap::COL_TRACK_AT, $trackAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($trackAt['max'])) {
                $this->addUsingAlias(UserTableMap::COL_TRACK_AT, $trackAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_TRACK_AT, $trackAt, $comparison);
    }

    /**
     * Filter the query on the track_ip column
     *
     * Example usage:
     * <code>
     * $query->filterByTrackIp('fooValue');   // WHERE track_ip = 'fooValue'
     * $query->filterByTrackIp('%fooValue%', Criteria::LIKE); // WHERE track_ip LIKE '%fooValue%'
     * </code>
     *
     * @param     string $trackIp The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByTrackIp($trackIp = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($trackIp)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_TRACK_IP, $trackIp, $comparison);
    }

    /**
     * Filter the query on the track_url column
     *
     * Example usage:
     * <code>
     * $query->filterByTrackUrl('fooValue');   // WHERE track_url = 'fooValue'
     * $query->filterByTrackUrl('%fooValue%', Criteria::LIKE); // WHERE track_url LIKE '%fooValue%'
     * </code>
     *
     * @param     string $trackUrl The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByTrackUrl($trackUrl = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($trackUrl)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_TRACK_URL, $trackUrl, $comparison);
    }

    /**
     * Filter the query on the ban_from column
     *
     * Example usage:
     * <code>
     * $query->filterByBanFrom('2011-03-14'); // WHERE ban_from = '2011-03-14'
     * $query->filterByBanFrom('now'); // WHERE ban_from = '2011-03-14'
     * $query->filterByBanFrom(array('max' => 'yesterday')); // WHERE ban_from > '2011-03-13'
     * </code>
     *
     * @param     mixed $banFrom The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByBanFrom($banFrom = null, $comparison = null)
    {
        if (is_array($banFrom)) {
            $useMinMax = false;
            if (isset($banFrom['min'])) {
                $this->addUsingAlias(UserTableMap::COL_BAN_FROM, $banFrom['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($banFrom['max'])) {
                $this->addUsingAlias(UserTableMap::COL_BAN_FROM, $banFrom['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_BAN_FROM, $banFrom, $comparison);
    }

    /**
     * Filter the query on the ban_until column
     *
     * Example usage:
     * <code>
     * $query->filterByBanUntil('2011-03-14'); // WHERE ban_until = '2011-03-14'
     * $query->filterByBanUntil('now'); // WHERE ban_until = '2011-03-14'
     * $query->filterByBanUntil(array('max' => 'yesterday')); // WHERE ban_until > '2011-03-13'
     * </code>
     *
     * @param     mixed $banUntil The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByBanUntil($banUntil = null, $comparison = null)
    {
        if (is_array($banUntil)) {
            $useMinMax = false;
            if (isset($banUntil['min'])) {
                $this->addUsingAlias(UserTableMap::COL_BAN_UNTIL, $banUntil['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($banUntil['max'])) {
                $this->addUsingAlias(UserTableMap::COL_BAN_UNTIL, $banUntil['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_BAN_UNTIL, $banUntil, $comparison);
    }

    /**
     * Filter the query on the ban_reason column
     *
     * Example usage:
     * <code>
     * $query->filterByBanReason('fooValue');   // WHERE ban_reason = 'fooValue'
     * $query->filterByBanReason('%fooValue%', Criteria::LIKE); // WHERE ban_reason LIKE '%fooValue%'
     * </code>
     *
     * @param     string $banReason The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByBanReason($banReason = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($banReason)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_BAN_REASON, $banReason, $comparison);
    }

    /**
     * Filter the query by a related \Propel\Models\Field object
     *
     * @param \Propel\Models\Field|ObjectCollection $field the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserQuery The current query, for fluid interface
     */
    public function filterByFieldRelatedByCreatedBy($field, $comparison = null)
    {
        if ($field instanceof \Propel\Models\Field) {
            return $this
                ->addUsingAlias(UserTableMap::COL_ID, $field->getCreatedBy(), $comparison);
        } elseif ($field instanceof ObjectCollection) {
            return $this
                ->useFieldRelatedByCreatedByQuery()
                ->filterByPrimaryKeys($field->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByFieldRelatedByCreatedBy() only accepts arguments of type \Propel\Models\Field or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the FieldRelatedByCreatedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function joinFieldRelatedByCreatedBy($relationAlias = null, $joinType = 'INNER JOIN')
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('FieldRelatedByCreatedBy');

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
            $this->addJoinObject($join, 'FieldRelatedByCreatedBy');
        }

        return $this;
    }

    /**
     * Use the FieldRelatedByCreatedBy relation Field object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Propel\Models\FieldQuery A secondary query class using the current class as primary query
     */
    public function useFieldRelatedByCreatedByQuery($relationAlias = null, $joinType = 'INNER JOIN')
    {
        return $this
            ->joinFieldRelatedByCreatedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'FieldRelatedByCreatedBy', '\Propel\Models\FieldQuery');
    }

    /**
     * Filter the query by a related \Propel\Models\Field object
     *
     * @param \Propel\Models\Field|ObjectCollection $field the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserQuery The current query, for fluid interface
     */
    public function filterByFieldRelatedByUpdatedBy($field, $comparison = null)
    {
        if ($field instanceof \Propel\Models\Field) {
            return $this
                ->addUsingAlias(UserTableMap::COL_ID, $field->getUpdatedBy(), $comparison);
        } elseif ($field instanceof ObjectCollection) {
            return $this
                ->useFieldRelatedByUpdatedByQuery()
                ->filterByPrimaryKeys($field->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByFieldRelatedByUpdatedBy() only accepts arguments of type \Propel\Models\Field or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the FieldRelatedByUpdatedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function joinFieldRelatedByUpdatedBy($relationAlias = null, $joinType = 'INNER JOIN')
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('FieldRelatedByUpdatedBy');

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
            $this->addJoinObject($join, 'FieldRelatedByUpdatedBy');
        }

        return $this;
    }

    /**
     * Use the FieldRelatedByUpdatedBy relation Field object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Propel\Models\FieldQuery A secondary query class using the current class as primary query
     */
    public function useFieldRelatedByUpdatedByQuery($relationAlias = null, $joinType = 'INNER JOIN')
    {
        return $this
            ->joinFieldRelatedByUpdatedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'FieldRelatedByUpdatedBy', '\Propel\Models\FieldQuery');
    }

    /**
     * Filter the query by a related \Propel\Models\Section object
     *
     * @param \Propel\Models\Section|ObjectCollection $section the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserQuery The current query, for fluid interface
     */
    public function filterBySectionRelatedByCreatedBy($section, $comparison = null)
    {
        if ($section instanceof \Propel\Models\Section) {
            return $this
                ->addUsingAlias(UserTableMap::COL_ID, $section->getCreatedBy(), $comparison);
        } elseif ($section instanceof ObjectCollection) {
            return $this
                ->useSectionRelatedByCreatedByQuery()
                ->filterByPrimaryKeys($section->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySectionRelatedByCreatedBy() only accepts arguments of type \Propel\Models\Section or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SectionRelatedByCreatedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function joinSectionRelatedByCreatedBy($relationAlias = null, $joinType = 'INNER JOIN')
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SectionRelatedByCreatedBy');

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
            $this->addJoinObject($join, 'SectionRelatedByCreatedBy');
        }

        return $this;
    }

    /**
     * Use the SectionRelatedByCreatedBy relation Section object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Propel\Models\SectionQuery A secondary query class using the current class as primary query
     */
    public function useSectionRelatedByCreatedByQuery($relationAlias = null, $joinType = 'INNER JOIN')
    {
        return $this
            ->joinSectionRelatedByCreatedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SectionRelatedByCreatedBy', '\Propel\Models\SectionQuery');
    }

    /**
     * Filter the query by a related \Propel\Models\Section object
     *
     * @param \Propel\Models\Section|ObjectCollection $section the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserQuery The current query, for fluid interface
     */
    public function filterBySectionRelatedByUpdatedBy($section, $comparison = null)
    {
        if ($section instanceof \Propel\Models\Section) {
            return $this
                ->addUsingAlias(UserTableMap::COL_ID, $section->getUpdatedBy(), $comparison);
        } elseif ($section instanceof ObjectCollection) {
            return $this
                ->useSectionRelatedByUpdatedByQuery()
                ->filterByPrimaryKeys($section->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySectionRelatedByUpdatedBy() only accepts arguments of type \Propel\Models\Section or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SectionRelatedByUpdatedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function joinSectionRelatedByUpdatedBy($relationAlias = null, $joinType = 'INNER JOIN')
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SectionRelatedByUpdatedBy');

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
            $this->addJoinObject($join, 'SectionRelatedByUpdatedBy');
        }

        return $this;
    }

    /**
     * Use the SectionRelatedByUpdatedBy relation Section object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Propel\Models\SectionQuery A secondary query class using the current class as primary query
     */
    public function useSectionRelatedByUpdatedByQuery($relationAlias = null, $joinType = 'INNER JOIN')
    {
        return $this
            ->joinSectionRelatedByUpdatedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SectionRelatedByUpdatedBy', '\Propel\Models\SectionQuery');
    }

    /**
     * Filter the query by a related \Propel\Models\Publication object
     *
     * @param \Propel\Models\Publication|ObjectCollection $publication the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserQuery The current query, for fluid interface
     */
    public function filterByPublicationRelatedByCreatedBy($publication, $comparison = null)
    {
        if ($publication instanceof \Propel\Models\Publication) {
            return $this
                ->addUsingAlias(UserTableMap::COL_ID, $publication->getCreatedBy(), $comparison);
        } elseif ($publication instanceof ObjectCollection) {
            return $this
                ->usePublicationRelatedByCreatedByQuery()
                ->filterByPrimaryKeys($publication->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPublicationRelatedByCreatedBy() only accepts arguments of type \Propel\Models\Publication or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PublicationRelatedByCreatedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function joinPublicationRelatedByCreatedBy($relationAlias = null, $joinType = 'INNER JOIN')
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PublicationRelatedByCreatedBy');

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
            $this->addJoinObject($join, 'PublicationRelatedByCreatedBy');
        }

        return $this;
    }

    /**
     * Use the PublicationRelatedByCreatedBy relation Publication object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Propel\Models\PublicationQuery A secondary query class using the current class as primary query
     */
    public function usePublicationRelatedByCreatedByQuery($relationAlias = null, $joinType = 'INNER JOIN')
    {
        return $this
            ->joinPublicationRelatedByCreatedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PublicationRelatedByCreatedBy', '\Propel\Models\PublicationQuery');
    }

    /**
     * Filter the query by a related \Propel\Models\Publication object
     *
     * @param \Propel\Models\Publication|ObjectCollection $publication the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserQuery The current query, for fluid interface
     */
    public function filterByPublicationRelatedByUpdatedBy($publication, $comparison = null)
    {
        if ($publication instanceof \Propel\Models\Publication) {
            return $this
                ->addUsingAlias(UserTableMap::COL_ID, $publication->getUpdatedBy(), $comparison);
        } elseif ($publication instanceof ObjectCollection) {
            return $this
                ->usePublicationRelatedByUpdatedByQuery()
                ->filterByPrimaryKeys($publication->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPublicationRelatedByUpdatedBy() only accepts arguments of type \Propel\Models\Publication or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PublicationRelatedByUpdatedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function joinPublicationRelatedByUpdatedBy($relationAlias = null, $joinType = 'INNER JOIN')
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PublicationRelatedByUpdatedBy');

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
            $this->addJoinObject($join, 'PublicationRelatedByUpdatedBy');
        }

        return $this;
    }

    /**
     * Use the PublicationRelatedByUpdatedBy relation Publication object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Propel\Models\PublicationQuery A secondary query class using the current class as primary query
     */
    public function usePublicationRelatedByUpdatedByQuery($relationAlias = null, $joinType = 'INNER JOIN')
    {
        return $this
            ->joinPublicationRelatedByUpdatedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PublicationRelatedByUpdatedBy', '\Propel\Models\PublicationQuery');
    }

    /**
     * Filter the query by a related \Propel\Models\PublicationPhoto object
     *
     * @param \Propel\Models\PublicationPhoto|ObjectCollection $publicationPhoto the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserQuery The current query, for fluid interface
     */
    public function filterByPublicationPhotoRelatedByCreatedBy($publicationPhoto, $comparison = null)
    {
        if ($publicationPhoto instanceof \Propel\Models\PublicationPhoto) {
            return $this
                ->addUsingAlias(UserTableMap::COL_ID, $publicationPhoto->getCreatedBy(), $comparison);
        } elseif ($publicationPhoto instanceof ObjectCollection) {
            return $this
                ->usePublicationPhotoRelatedByCreatedByQuery()
                ->filterByPrimaryKeys($publicationPhoto->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPublicationPhotoRelatedByCreatedBy() only accepts arguments of type \Propel\Models\PublicationPhoto or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PublicationPhotoRelatedByCreatedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function joinPublicationPhotoRelatedByCreatedBy($relationAlias = null, $joinType = 'INNER JOIN')
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PublicationPhotoRelatedByCreatedBy');

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
            $this->addJoinObject($join, 'PublicationPhotoRelatedByCreatedBy');
        }

        return $this;
    }

    /**
     * Use the PublicationPhotoRelatedByCreatedBy relation PublicationPhoto object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Propel\Models\PublicationPhotoQuery A secondary query class using the current class as primary query
     */
    public function usePublicationPhotoRelatedByCreatedByQuery($relationAlias = null, $joinType = 'INNER JOIN')
    {
        return $this
            ->joinPublicationPhotoRelatedByCreatedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PublicationPhotoRelatedByCreatedBy', '\Propel\Models\PublicationPhotoQuery');
    }

    /**
     * Filter the query by a related \Propel\Models\PublicationPhoto object
     *
     * @param \Propel\Models\PublicationPhoto|ObjectCollection $publicationPhoto the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserQuery The current query, for fluid interface
     */
    public function filterByPublicationPhotoRelatedByUpdatedBy($publicationPhoto, $comparison = null)
    {
        if ($publicationPhoto instanceof \Propel\Models\PublicationPhoto) {
            return $this
                ->addUsingAlias(UserTableMap::COL_ID, $publicationPhoto->getUpdatedBy(), $comparison);
        } elseif ($publicationPhoto instanceof ObjectCollection) {
            return $this
                ->usePublicationPhotoRelatedByUpdatedByQuery()
                ->filterByPrimaryKeys($publicationPhoto->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPublicationPhotoRelatedByUpdatedBy() only accepts arguments of type \Propel\Models\PublicationPhoto or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PublicationPhotoRelatedByUpdatedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function joinPublicationPhotoRelatedByUpdatedBy($relationAlias = null, $joinType = 'INNER JOIN')
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PublicationPhotoRelatedByUpdatedBy');

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
            $this->addJoinObject($join, 'PublicationPhotoRelatedByUpdatedBy');
        }

        return $this;
    }

    /**
     * Use the PublicationPhotoRelatedByUpdatedBy relation PublicationPhoto object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Propel\Models\PublicationPhotoQuery A secondary query class using the current class as primary query
     */
    public function usePublicationPhotoRelatedByUpdatedByQuery($relationAlias = null, $joinType = 'INNER JOIN')
    {
        return $this
            ->joinPublicationPhotoRelatedByUpdatedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PublicationPhotoRelatedByUpdatedBy', '\Propel\Models\PublicationPhotoQuery');
    }

    /**
     * Filter the query by a related \Propel\Models\Snippet object
     *
     * @param \Propel\Models\Snippet|ObjectCollection $snippet the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserQuery The current query, for fluid interface
     */
    public function filterBySnippetRelatedByCreatedBy($snippet, $comparison = null)
    {
        if ($snippet instanceof \Propel\Models\Snippet) {
            return $this
                ->addUsingAlias(UserTableMap::COL_ID, $snippet->getCreatedBy(), $comparison);
        } elseif ($snippet instanceof ObjectCollection) {
            return $this
                ->useSnippetRelatedByCreatedByQuery()
                ->filterByPrimaryKeys($snippet->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySnippetRelatedByCreatedBy() only accepts arguments of type \Propel\Models\Snippet or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SnippetRelatedByCreatedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function joinSnippetRelatedByCreatedBy($relationAlias = null, $joinType = 'INNER JOIN')
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SnippetRelatedByCreatedBy');

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
            $this->addJoinObject($join, 'SnippetRelatedByCreatedBy');
        }

        return $this;
    }

    /**
     * Use the SnippetRelatedByCreatedBy relation Snippet object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Propel\Models\SnippetQuery A secondary query class using the current class as primary query
     */
    public function useSnippetRelatedByCreatedByQuery($relationAlias = null, $joinType = 'INNER JOIN')
    {
        return $this
            ->joinSnippetRelatedByCreatedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SnippetRelatedByCreatedBy', '\Propel\Models\SnippetQuery');
    }

    /**
     * Filter the query by a related \Propel\Models\Snippet object
     *
     * @param \Propel\Models\Snippet|ObjectCollection $snippet the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserQuery The current query, for fluid interface
     */
    public function filterBySnippetRelatedByUpdatedBy($snippet, $comparison = null)
    {
        if ($snippet instanceof \Propel\Models\Snippet) {
            return $this
                ->addUsingAlias(UserTableMap::COL_ID, $snippet->getUpdatedBy(), $comparison);
        } elseif ($snippet instanceof ObjectCollection) {
            return $this
                ->useSnippetRelatedByUpdatedByQuery()
                ->filterByPrimaryKeys($snippet->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySnippetRelatedByUpdatedBy() only accepts arguments of type \Propel\Models\Snippet or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SnippetRelatedByUpdatedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function joinSnippetRelatedByUpdatedBy($relationAlias = null, $joinType = 'INNER JOIN')
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SnippetRelatedByUpdatedBy');

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
            $this->addJoinObject($join, 'SnippetRelatedByUpdatedBy');
        }

        return $this;
    }

    /**
     * Use the SnippetRelatedByUpdatedBy relation Snippet object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Propel\Models\SnippetQuery A secondary query class using the current class as primary query
     */
    public function useSnippetRelatedByUpdatedByQuery($relationAlias = null, $joinType = 'INNER JOIN')
    {
        return $this
            ->joinSnippetRelatedByUpdatedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SnippetRelatedByUpdatedBy', '\Propel\Models\SnippetQuery');
    }

    /**
     * Filter the query by a related \Propel\Models\Tag object
     *
     * @param \Propel\Models\Tag|ObjectCollection $tag the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserQuery The current query, for fluid interface
     */
    public function filterByTagRelatedByCreatedBy($tag, $comparison = null)
    {
        if ($tag instanceof \Propel\Models\Tag) {
            return $this
                ->addUsingAlias(UserTableMap::COL_ID, $tag->getCreatedBy(), $comparison);
        } elseif ($tag instanceof ObjectCollection) {
            return $this
                ->useTagRelatedByCreatedByQuery()
                ->filterByPrimaryKeys($tag->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByTagRelatedByCreatedBy() only accepts arguments of type \Propel\Models\Tag or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the TagRelatedByCreatedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function joinTagRelatedByCreatedBy($relationAlias = null, $joinType = 'INNER JOIN')
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('TagRelatedByCreatedBy');

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
            $this->addJoinObject($join, 'TagRelatedByCreatedBy');
        }

        return $this;
    }

    /**
     * Use the TagRelatedByCreatedBy relation Tag object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Propel\Models\TagQuery A secondary query class using the current class as primary query
     */
    public function useTagRelatedByCreatedByQuery($relationAlias = null, $joinType = 'INNER JOIN')
    {
        return $this
            ->joinTagRelatedByCreatedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'TagRelatedByCreatedBy', '\Propel\Models\TagQuery');
    }

    /**
     * Filter the query by a related \Propel\Models\Tag object
     *
     * @param \Propel\Models\Tag|ObjectCollection $tag the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserQuery The current query, for fluid interface
     */
    public function filterByTagRelatedByUpdatedBy($tag, $comparison = null)
    {
        if ($tag instanceof \Propel\Models\Tag) {
            return $this
                ->addUsingAlias(UserTableMap::COL_ID, $tag->getUpdatedBy(), $comparison);
        } elseif ($tag instanceof ObjectCollection) {
            return $this
                ->useTagRelatedByUpdatedByQuery()
                ->filterByPrimaryKeys($tag->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByTagRelatedByUpdatedBy() only accepts arguments of type \Propel\Models\Tag or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the TagRelatedByUpdatedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function joinTagRelatedByUpdatedBy($relationAlias = null, $joinType = 'INNER JOIN')
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('TagRelatedByUpdatedBy');

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
            $this->addJoinObject($join, 'TagRelatedByUpdatedBy');
        }

        return $this;
    }

    /**
     * Use the TagRelatedByUpdatedBy relation Tag object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Propel\Models\TagQuery A secondary query class using the current class as primary query
     */
    public function useTagRelatedByUpdatedByQuery($relationAlias = null, $joinType = 'INNER JOIN')
    {
        return $this
            ->joinTagRelatedByUpdatedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'TagRelatedByUpdatedBy', '\Propel\Models\TagQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildUser $user Object to remove from the list of results
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function prune($user = null)
    {
        if ($user) {
            $this->addUsingAlias(UserTableMap::COL_ID, $user->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the fenric_user table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            UserTableMap::clearInstancePool();
            UserTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(UserTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(UserTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            UserTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            UserTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // UserQuery
