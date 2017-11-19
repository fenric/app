<?php

/**
 * Package
 */
namespace Fenric;

/**
 * Release
 */
class Release
{

	/**
	 * Сырая информация о текущем релизе
	 */
	protected $rawRelease;

	/**
	 * Дата текущего релиза
	 */
	protected $releaseDate;

	/**
	 * Версия текущего релиза
	 */
	protected $releaseVersion;

	/**
	 * Описание текущего релиза
	 */
	protected $releaseDescription;

	/**
	 * История прошлых релизов
	 */
	protected $releaseHistory;

	/**
	 * Конструктор класса
	 */
	public function __construct()
	{
		if (is_file($this->getFile()))
		{
			if (is_readable($this->getFile()))
			{
				$content = file_get_contents($this->getFile());

				if ($release = json_decode($content, true))
				{
					if (isset($release['date']))
					{
						$this->releaseDate = new \DateTime($release['date']);
					}

					if (isset($release['version']))
					{
						$this->releaseVersion = $release['version'];
					}

					if (isset($release['description']))
					{
						$this->releaseDescription = $release['description'];
					}

					if (isset($release['history']))
					{
						$this->releaseHistory = $release['history'];
					}

					$this->rawRelease = $release;
				}
			}
		}
	}

	/**
	 * Получение файла содержащего информацию о текущем релизе
	 */
	public function getFile() : string
	{
		return fenric()->path('.', 'release.json');
	}

	/**
	 * Получение даты текущего релиза
	 */
	public function getReleaseDate() :? \DateTime
	{
		return $this->releaseDate;
	}

	/**
	 * Получение версии текущего релиза
	 */
	public function getReleaseVersion() :? string
	{
		return $this->releaseVersion;
	}

	/**
	 * Получение описания текущего релиза
	 */
	public function getReleaseDescription() :? string
	{
		return $this->releaseDescription;
	}

	/**
	 * Получение истории прошлых релизов
	 */
	public function getReleaseHistory() :? array
	{
		return $this->releaseHistory;
	}

	/**
	 * Получение сырой информации о текущем релизе
	 */
	public function getRawRelease() :? array
	{
		return $this->rawRelease;
	}
}
