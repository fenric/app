<?php

namespace Fenric\Controllers\User;

/**
 * Import classes
 */
use Fenric\Upload;
use Fenric\Controllers\Abstractable\Actionable;

/**
 * Api
 */
class Api extends Actionable
{

	/**
	 * Доступ к контроллеру
	 */
	use Access;

	/**
	 * Открепление фотографии пользователя
	 */
	protected function actionDetachPhotoViaPATCH() : void
	{
		fenric('user')->setPhoto(null);
		fenric('user')->save();
	}

	/**
	 * Загрузка изображения
	 */
	protected function actionUploadImageViaPUT() : void
	{
		if (! fenric('user')->haveAccessToUploadImages())
		{
			$this->response->setStatus(403)->setJsonContent([
				'success' => false,
				'message' => 'Недостаточно прав.',
			]);
		}

		$upload = new Upload($this->request->getBody());

		try
		{
			$file = $upload->asImage();

			$json['file'] = basename($file['location']);

			if (isset($file['source']))
			{
				$json['source'] = basename($file['source']);
			}

			$this->response->setJsonContent($json);
		}

		catch (\RuntimeException $e)
		{
			$this->response->setStatus($e->getCode());

			$this->response->setJsonContent([
				'success' => false,
				'message' => $e->getMessage(),
			]);
		}
	}

	/**
	 * Загрузка аудиофайла
	 */
	protected function actionUploadAudioViaPUT() : void
	{
		if (! fenric('user')->haveAccessToUploadAudios())
		{
			$this->response->setStatus(403)->setJsonContent([
				'success' => false,
				'message' => 'Недостаточно прав.',
			]);
		}

		$upload = new Upload($this->request->getBody());

		try
		{
			$file = $upload->asAudio();

			$this->response->setJsonContent([
				'file' => basename($file['location']),
				'cover' => basename($file['cover']),
			]);
		}

		catch (\RuntimeException $e)
		{
			$this->response->setStatus($e->getCode());

			$this->response->setJsonContent([
				'success' => false,
				'message' => $e->getMessage(),
			]);
		}
	}

	/**
	 * Загрузка видеофайла
	 */
	protected function actionUploadVideoViaPUT() : void
	{
		if (! fenric('user')->haveAccessToUploadVideos())
		{
			$this->response->setStatus(403)->setJsonContent([
				'success' => false,
				'message' => 'Недостаточно прав.',
			]);
		}

		$upload = new Upload($this->request->getBody());

		try
		{
			$file = $upload->asVideo();

			$this->response->setJsonContent([
				'file' => basename($file['location']),
				'cover' => basename($file['cover']),
			]);
		}

		catch (\RuntimeException $e)
		{
			$this->response->setStatus($e->getCode());

			$this->response->setJsonContent([
				'success' => false,
				'message' => $e->getMessage(),
			]);
		}
	}

	/**
	 * Загрузка PDF документа
	 */
	protected function actionUploadPdfViaPUT() : void
	{
		if (! fenric('user')->haveAccessToUploadPdf())
		{
			$this->response->setStatus(403)->setJsonContent([
				'success' => false,
				'message' => 'Недостаточно прав.',
			]);
		}

		$upload = new Upload($this->request->getBody());

		try
		{
			$file = $upload->asPdf();

			$this->response->setJsonContent([
				'file' => basename($file['location']),
				'cover' => basename($file['cover']),
			]);
		}

		catch (\RuntimeException $e)
		{
			$this->response->setStatus($e->getCode());

			$this->response->setJsonContent([
				'success' => false,
				'message' => $e->getMessage(),
			]);
		}
	}

	/**
	 * Загрузка фотографии пользователя
	 */
	protected function actionUploadUserPhotoViaPUT() : void
	{
		$this->actionUploadImageViaPUT();

		if ($this->response->getStatus() === 200)
		{
			$json = json_decode($this->response->getContent(), true);

			fenric('user')->setPhoto($json['file']);
			fenric('user')->save();
		}
	}
}
