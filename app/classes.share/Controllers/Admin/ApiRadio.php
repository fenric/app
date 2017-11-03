<?php

namespace Fenric\Controllers\Admin;

/**
 * Import classes
 */
use Propel\Models\Radio;
use Propel\Models\RadioQuery;
use Propel\Models\Map\RadioTableMap;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Fenric\Controllers\Abstractable\CRUD;

/**
 * ApiRadio
 */
class ApiRadio extends CRUD
{

	/**
	 * Доступ к контроллеру
	 */
	use Access;

	/**
	 * Создание объекта
	 */
	protected function actionCreateViaPOST() : void
	{
		parent::create(new Radio(), [
			RadioTableMap::COL_TITLE => $this->request->post->get('title'),
			RadioTableMap::COL_STREAM => $this->request->post->get('stream'),
		]);
	}

	/**
	 * Обновление объекта
	 */
	protected function actionUpdateViaPATCH() : void
	{
		parent::update(RadioQuery::create(), [
			RadioTableMap::COL_TITLE => $this->request->post->get('title'),
			RadioTableMap::COL_STREAM => $this->request->post->get('stream'),
		]);
	}

	/**
	 * Удаление объекта
	 */
	protected function actionDeleteViaDELETE() : void
	{
		parent::delete(RadioQuery::create());
	}

	/**
	 * Чтение объекта
	 */
	protected function actionReadViaGET() : void
	{
		parent::read(RadioQuery::create(), [
			RadioTableMap::COL_ID,
			RadioTableMap::COL_TITLE,
			RadioTableMap::COL_STREAM,
		]);
	}

	/**
	 * Выгрузка объектов
	 */
	protected function actionAllViaGET() : void
	{
		fenric()->callSharedService('event', [self::EVENT_PREPARE_ITEM])->subscribe(function(Radio $radio, array & $json)
		{
			if ($radio->getUserRelatedByCreatedBy() instanceof ActiveRecordInterface)
			{
				$json['creator'] = [];
				$json['creator']['id'] = $radio->getUserRelatedByCreatedBy()->getId();
				$json['creator']['username'] = $radio->getUserRelatedByCreatedBy()->getUsername();
			}

			if ($radio->getUserRelatedByUpdatedBy() instanceof ActiveRecordInterface)
			{
				$json['updater'] = [];
				$json['updater']['id'] = $radio->getUserRelatedByUpdatedBy()->getId();
				$json['updater']['username'] = $radio->getUserRelatedByUpdatedBy()->getUsername();
			}
		});

		$query = RadioQuery::create();
		$query->orderById(Criteria::DESC);

		if ($this->request->query->exists('q'))
		{
			$q = searchable($this->request->query->get('q'), 32, '%');

			$query->_or()->filterById(sprintf('%%%s%%', $q), Criteria::LIKE);
			$query->_or()->filterByTitle(sprintf('%%%s%%', $q), Criteria::LIKE);
		}

		parent::all($query, [
			RadioTableMap::COL_ID,
			RadioTableMap::COL_TITLE,
			RadioTableMap::COL_STREAM,
			RadioTableMap::COL_CREATED_AT,
			RadioTableMap::COL_UPDATED_AT,
		]);
	}

	/**
	 * Простая выгрузка объектов
	 */
	protected function actionUnloadViaGET() : void
	{
		$this->response->setJsonContent(
			fenric('query')
				->select(RadioTableMap::COL_ID)
				->select(RadioTableMap::COL_TITLE)
				->from(RadioTableMap::TABLE_NAME)
			->toArray()
		);
	}

	/**
	 * Опрос радиостанции
	 */
	protected function actionNowPlayingViaGET() : void
	{
		$id = $this->request->parameters->get('id');

		$query = RadioQuery::create();

		$result = [];

		if ($station = $query->findPk($id))
		{
			$options['http']['timeout'] = 3.5;
			$options['http']['method'] = 'GET';
			$options['http']['header'] = 'Icy-MetaData: 1';
			$options['http']['user_agent'] = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36';
			$options['http']['ignore_errors'] = true;

			if ($context = stream_context_create($options))
			{
				if ($stream = fopen($station->getStream(), 'r', false, $context))
				{
					if ($metadata = stream_get_meta_data($stream))
					{
						if (isset($metadata['wrapper_data']))
						{
							foreach ($metadata['wrapper_data'] as $header)
							{
								if (strpos($header, ':') !== false)
								{
									$header = explode(':', $header, 2);

									$header['name'] = trim($header[0]);
									$header['value'] = trim($header[1]);

									if (strcasecmp($header['name'], 'icy-metaint') === 0)
									{
										if ($content = stream_get_contents($stream, 255, $header['value']))
										{
											if (($start = stripos($content, 'StreamTitle')) !== false)
											{
												if (($end = strpos($content, ';', $start)) !== false)
												{
													$subject = substr($content, $start, $end);

													$expression = '/^StreamTitle\s*=\s*\047\s*(?<title>[^\047]+)\s*\047\s*;$/isu';

													if (preg_match($expression, $subject, $matches))
													{
														$result['title'] = trim($matches['title']);
													}
												}
											}
										}
									}
								}
							}
						}
					}

					fclose($stream);
				}
			}

			if (isset($result['title']))
			{
				$itunesApi = 'http://itunes.apple.com/search?term=%s&entity=musicTrack&limit=1';

				if ($itunesRaw = file_get_contents(sprintf($itunesApi, urlencode($result['title']))))
				{
					if ($itunesJson = json_decode($itunesRaw, true))
					{
						if (isset($itunesJson['results'][0]))
						{
							if (isset($itunesJson['results'][0]['primaryGenreName'])) {
								$result['genre'] = $itunesJson['results'][0]['primaryGenreName'];
							}
							if (isset($itunesJson['results'][0]['artistName'])) {
								$result['artist'] = $itunesJson['results'][0]['artistName'];
							}
							if (isset($itunesJson['results'][0]['artistViewUrl'])) {
								$result['artist_url'] = $itunesJson['results'][0]['artistViewUrl'];
							}
							if (isset($itunesJson['results'][0]['collectionName'])) {
								$result['album'] = $itunesJson['results'][0]['collectionName'];
							}
							if (isset($itunesJson['results'][0]['collectionViewUrl'])) {
								$result['album_url'] = $itunesJson['results'][0]['collectionViewUrl'];
							}
							if (isset($itunesJson['results'][0]['artworkUrl100'])) {
								$result['album_cover'] = $itunesJson['results'][0]['artworkUrl100'];
							}
							if (isset($itunesJson['results'][0]['trackName'])) {
								$result['track'] = $itunesJson['results'][0]['trackName'];
							}
							if (isset($itunesJson['results'][0]['trackViewUrl'])) {
								$result['track_url'] = $itunesJson['results'][0]['trackViewUrl'];
							}
							if (isset($itunesJson['results'][0]['previewUrl'])) {
								$result['track_preview'] = $itunesJson['results'][0]['previewUrl'];
							}
							if (isset($itunesJson['results'][0]['releaseDate'])) {
								$result['release'] = $itunesJson['results'][0]['releaseDate'];
							}
						}
					}
				}
			}
		}

		$this->response->setJsonContent($result);
	}
}
