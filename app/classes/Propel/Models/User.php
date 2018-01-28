<?php

namespace Propel\Models;

use DateTime;
use DateInterval;
use Propel\Models\Base\User as BaseUser;
use Propel\Models\Map\UserTableMap;
use Propel\Runtime\Connection\ConnectionInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Skeleton subclass for representing a row from the 'user' table.
 *
 * You should add additional methods to this class to meet the application requirements.
 * This class will only be generated as long as it does not already exist in the output directory.
 */
class User extends BaseUser
{

	/**
	 * Получение адреса учетной записи
	 */
	public function getUri() : string
	{
		return sprintf('/users/%d/', $this->getId());
	}

	/**
	 * Является ли учетная запись текущей
	 */
	public function isMe() : bool
	{
		if (fenric('user')->isLogged())
		{
			if (strcmp(fenric('user')->getId(), $this->getId()) === 0)
			{
				return true;
			}
		}

		return false;
	}

	/**
	 * Получение имени роли
	 */
	public function getRoleName() : string
	{
		$options = fenric('config::user')->all();

		return $options['roles'][$this->getRole()]['name'] ?? $this->getRole();
	}

	/**
	 * Проверка разрешения роли
	 */
	public function checkAccess(string $code) : bool
	{
		$options = fenric('config::user')->all();

		return !! ($options['roles'][$this->getRole()]['accesses'][$code] ?? false);
	}

	/**
	 * Имеет ли учетная запись права администратора
	 */
	public function isAdministrator() : bool
	{
		return 0 === strcmp($this->getRole(), 'administrator');
	}

	/**
	 * Имеет ли учетная запись права редактора
	 */
	public function isRedactor() : bool
	{
		return 0 === strcmp($this->getRole(), 'redactor');
	}

	/**
	 * Имеет ли учетная запись права модератора
	 */
	public function isModerator() : bool
	{
		return 0 === strcmp($this->getRole(), 'moderator');
	}

	/**
	 * Имеет ли учетная запись права пользователя
	 */
	public function isUser() : bool
	{
		return 0 === strcmp($this->getRole(), 'user');
	}

	/**
	 * Имеет ли учетная запись разрешение на доступ к рабочему столу
	 */
	public function haveAccessToDesktop() : bool
	{
		return $this->checkAccess('desktop');
	}

	/**
	 * Имеет ли учетная запись разрешение на загрузку изображений
	 */
	public function haveAccessToUploadImages() : bool
	{
		return $this->checkAccess('upload.images');
	}

	/**
	 * Имеет ли учетная запись разрешение на загрузку аудиофайлов
	 */
	public function haveAccessToUploadAudios() : bool
	{
		return $this->checkAccess('upload.audios');
	}

	/**
	 * Имеет ли учетная запись разрешение на загрузку видеофайлов
	 */
	public function haveAccessToUploadVideos() : bool
	{
		return $this->checkAccess('upload.videos');
	}

	/**
	 * Имеет ли учетная запись разрешение на загрузку PDF документов
	 */
	public function haveAccessToUploadPdf() : bool
	{
		return $this->checkAccess('upload.pdf');
	}

	/**
	 * Принадлежит ли учетная запись мужчине
	 */
	public function isMale() : bool
	{
		return strcmp($this->getGender(), 'male') === 0;
	}

	/**
	 * Принадлежит ли учетная запись женщине
	 */
	public function isFemale() : bool
	{
		return strcmp($this->getGender(), 'female') === 0;
	}

	/**
	 * Принадлежит ли учетная запись совершеннолетнему пользователю
	 */
	public function isAdult() : bool
	{
		$adulthood = fenric('config::user')->get('adulthood', 18);

		if ($this->getAge() instanceof DateInterval)
		{
			if ($this->getAge()->y >= $adulthood)
			{
				return true;
			}
		}

		return false;
	}

	/**
	 * Является ли учетная запись заблокированной
	 */
	public function isBlocked() : bool
	{
		if ($this->getBanFrom() instanceof DateTime)
		{
			if ($this->getBanUntil() instanceof DateTime)
			{
				if ($this->getBanFrom()->getTimestamp() < time())
				{
					if ($this->getBanUntil()->getTimestamp() > time())
					{
						return true;
					}
				}
			}
		}

		return false;
	}

	/**
	 * Является ли учетная запись разблокированной
	 */
	public function isUnblocked() : bool
	{
		return ! $this->isBlocked();
	}

	/**
	 * Находится ли учетная запись в режиме «онлайн»
	 */
	public function isOnline() : bool
	{
		if ($this->getTrackAt() instanceof DateTime)
		{
			if ($this->getTrackAt()->getTimestamp() > time() - 300)
			{
				return true;
			}
		}

		return false;
	}

	/**
	 * Находится ли учетная запись в режиме «оффлайн»
	 */
	public function isOffline() : bool
	{
		return ! $this->isOnline();
	}

	/**
	 * Регистрация неудачной попытки входа
	 */
	public function registerUnsuccessfulLoginAttempt() : void
	{
		$this->setAuthenticationAttemptCount(
			$this->getAuthenticationAttemptCount() + 1
		);

		$this->save();
	}

	/**
	 * Сброс зарегистрированных неудачных попыток входа
	 */
	public function resetUnsuccessfulLoginAttempts() : void
	{
		$this->setAuthenticationAttemptCount(0);

		$this->save();
	}

	/**
	 * Получение имени пользователя
	 */
	public function getName() : string
	{
		$parts = [];

		if ($this->getFirstname()) {
			$parts[] = $this->getFirstname();
		}
		if ($this->getLastname()) {
			$parts[] = $this->getLastname();
		}

		if (count($parts)) {
			return implode(' ', $parts);
		}

		return $this->getUsername();
	}

	/**
	 * Установка даты рождения пользователя с предварительной валидацией
	 *
	 * ORM создает сразу экземпляр DateTime, который может бросить исключение в случаи некорректной даты,
	 * что может вызвать дополнительные проблемы как для пользователя, так и для приложения в целом...
	 */
	public function setBirthday($value)
	{
		if (strlen($value) > 0)
		{
			if (preg_match('/^(?<year>\d{4})-(?<month>\d{2})-(?<day>\d{2})$/', $value, $matches))
			{
				if (checkdate($matches['month'], $matches['day'], $matches['year']))
				{
					parent::setBirthday($value);
				}
			}
		}

		return $this;
	}

	/**
	 * Получение возраста пользователя
	 */
	public function getAge() :? DateInterval
	{
		$now = new DateTime('now');

		if ($this->getBirthday() instanceof DateTime)
		{
			return $now->diff($this->getBirthday());
		}

		return null;
	}

	/**
	 * Верификация пароля
	 */
	public function verifyPassword(string $password, ConnectionInterface $connection = null) : bool
	{
		return password_verify($password, $this->getPassword($connection));
	}

	/**
	 * Установка параметров
	 */
	public function setParams($params)
	{
		return parent::setParams(json_encode($params));
	}

	/**
	 * Получение параметров
	 */
	public function getParams(ConnectionInterface $connection = null)
	{
		return json_decode(parent::getParams($connection), true);
	}

	/**
	 * Генерация случайного кода
	 */
	public function generateCode() : string
	{
		$bytes = random_bytes(16);

		$uniqueString = bin2hex($bytes);
		$uniqueString .= microtime(true);

		return hash('sha1', $uniqueString);
	}

	/**
	 * Code to be run before persisting the object
	 *
	 * @param   ConnectionInterface   $connection
	 *
	 * @access  public
	 * @return  bool
	 */
	public function preSave(ConnectionInterface $connection = null)
	{
		if ($this->isColumnModified(UserTableMap::COL_PASSWORD))
		{
			$this->setVirtualColumn('password', $this->getPassword($connection));

			$this->setPassword(password_hash($this->getPassword($connection), PASSWORD_BCRYPT, ['cost' => 12]));
		}

		return true;
	}

	/**
	 * Code to be run before inserting to database
	 *
	 * @param   ConnectionInterface   $connection
	 *
	 * @access  public
	 * @return  bool
	 */
	public function preInsert(ConnectionInterface $connection = null)
	{
		$this->setParams([
			'desktop' => new \stdClass,
		]);

		$this->setRegistrationAt(
			new DateTime('now')
		);

		$this->setRegistrationIp(
			fenric('request')->ip()
		);

		$this->setRegistrationConfirmationCode(
			$this->generateCode()
		);

		return true;
	}

	/**
	 * Code to be run before deleting the object in database
	 *
	 * @param   ConnectionInterface   $connection
	 *
	 * @access  public
	 * @return  bool
	 */
	public function preDelete(ConnectionInterface $connection = null)
	{
		if ($this->getPhoto())
		{
			if (is_file(\Fenric\Upload::path($this->getPhoto())))
			{
				if (is_readable(\Fenric\Upload::path($this->getPhoto())))
				{
					unlink(\Fenric\Upload::path($this->getPhoto()));
				}
			}
		}

		return true;
	}

	/**
	 * Configure validators constraints.
	 *
	 * The Validator object uses this method to perform object validation
	 *
	 * @param   ClassMetadata   $metadata
	 *
	 * @access  public
	 * @return  void
	 */
	public static function loadValidatorMetadata(ClassMetadata $metadata)
	{
		$metadata->addPropertyConstraint('role', new Callback(function($value, ExecutionContextInterface $context, $payload)
		{
			$roles = ['administrator', 'redactor', 'moderator', 'user'];

			if ($context->getRoot()->isMe()) {
				if ($context->getRoot()->isColumnModified(UserTableMap::COL_ROLE)) {
					$context->addViolation(__('user', 'validation.error.role.permission'));
					return false;
				}
			}

			if ($context->getRoot()->getRole()) {
				if (! in_array($context->getRoot()->getRole(), $roles, true)) {
					$context->addViolation(__('user', 'validation.error.role.unknown'));
					return false;
				}
			}
		}));

		$metadata->addPropertyConstraint('password', new Callback(function($value, ExecutionContextInterface $context, $payload)
		{
			if ($context->getRoot()->isColumnModified(UserTableMap::COL_PASSWORD)) {
				if (stripos($context->getRoot()->getPassword(), strstr($context->getRoot()->getEmail(), '@', true)) !== false) {
					$context->addViolation(__('user', 'validation.error.password.have.in.email'));
					return false;
				}
				if (stripos($context->getRoot()->getPassword(), $context->getRoot()->getUsername()) !== false) {
					$context->addViolation(__('user', 'validation.error.password.have.in.username'));
					return false;
				}
				if ($context->getRoot()->hasVirtualColumn('password_confirmation')) {
					if (strcmp($context->getRoot()->getPassword(), $context->getRoot()->getVirtualColumn('password_confirmation')) !== 0) {
						$context->addViolation(__('user', 'validation.error.password.comparison'));
						return false;
					}
				}
			}
		}));

		$metadata->addPropertyConstraint('gender', new Callback(function($value, ExecutionContextInterface $context, $payload)
		{
			if ($context->getRoot()->getGender()) {
				if (! preg_match('/^(?:male|female)$/', $context->getRoot()->getGender())) {
					$context->addViolation(__('user', 'validation.error.gender.invalid'));
					return false;
				}
			}
		}));

		$metadata->addPropertyConstraint('firstname', new Callback(function($value, ExecutionContextInterface $context, $payload)
		{
			if ($context->getRoot()->getFirstname()) {
				if (mb_strlen($context->getRoot()->getFirstname(), 'utf-8') > 64) {
					$context->addViolation(__('user', 'validation.error.firstname.length'));
					return false;
				}
				if (! preg_match('/^[\p{L}]+$/u', $context->getRoot()->getFirstname())) {
					$context->addViolation(__('user', 'validation.error.firstname.characters'));
					return false;
				}
			}
		}));

		$metadata->addPropertyConstraint('lastname', new Callback(function($value, ExecutionContextInterface $context, $payload)
		{
			if ($context->getRoot()->getLastname()) {
				if (mb_strlen($context->getRoot()->getLastname(), 'utf-8') > 64) {
					$context->addViolation(__('user', 'validation.error.lastname.length'));
					return false;
				}
				if (! preg_match('/^[\p{L}]+$/u', $context->getRoot()->getLastname())) {
					$context->addViolation(__('user', 'validation.error.lastname.characters'));
					return false;
				}
			}
		}));

		$metadata->addPropertyConstraint('ban_from', new Callback(function($value, ExecutionContextInterface $context, $payload)
		{
			if (! empty($value) && $context->getRoot()->isMe() && $context->getRoot()->isColumnModified(UserTableMap::COL_BAN_FROM)) {
				$context->addViolation(__('user', 'validation.error.ban.permission'));
				return false;
			}
		}));

		$metadata->addPropertyConstraint('ban_until', new Callback(function($value, ExecutionContextInterface $context, $payload)
		{
			if (! empty($value) && $context->getRoot()->isMe() && $context->getRoot()->isColumnModified(UserTableMap::COL_BAN_UNTIL)) {
				$context->addViolation(__('user', 'validation.error.ban.permission'));
				return false;
			}
		}));

		$metadata->addPropertyConstraint('ban_reason', new Callback(function($value, ExecutionContextInterface $context, $payload)
		{
			if (! empty($value) && $context->getRoot()->isMe() && $context->getRoot()->isColumnModified(UserTableMap::COL_BAN_REASON)) {
				$context->addViolation(__('user', 'validation.error.ban.permission'));
				return false;
			}
		}));
	}
}
