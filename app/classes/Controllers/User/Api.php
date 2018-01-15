<?php

namespace Fenric\Controllers\User;

/**
 * Import classes
 */
use Fenric\Upload;
use Fenric\Controllers\Abstractable\Abstractable as Controller;

/**
 * Api
 */
class Api extends Controller
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
			$this->response->status(\Fenric\Response::STATUS_403)->json([
				'success' => false,
				'message' => 'Недостаточно прав.',
			]);
		}

		$upload = new Upload($this->request->body());

		try
		{
			$file = $upload->asImage();

			$json['file'] = basename($file['location']);

			if (isset($file['source']))
			{
				$json['source'] = basename($file['source']);
			}

			$this->response->json($json);
		}

		catch (\RuntimeException $e)
		{
			$this->response->status(constant(
				sprintf('\\Fenric\\Response::STATUS_%d', $e->getCode())
			));

			$this->response->json([
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
			$this->response->status(\Fenric\Response::STATUS_403)->json([
				'success' => false,
				'message' => 'Недостаточно прав.',
			]);
		}

		$upload = new Upload($this->request->body());

		try
		{
			$file = $upload->asAudio();

			$this->response->json([
				'file' => basename($file['location']),
				'cover' => basename($file['cover']),
			]);
		}

		catch (\RuntimeException $e)
		{
			$this->response->status(constant(
				sprintf('\\Fenric\\Response::STATUS_%d', $e->getCode())
			));

			$this->response->json([
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
			$this->response->status(\Fenric\Response::STATUS_403)->json([
				'success' => false,
				'message' => 'Недостаточно прав.',
			]);
		}

		$upload = new Upload($this->request->body());

		try
		{
			$file = $upload->asVideo();

			$this->response->json([
				'file' => basename($file['location']),
				'cover' => basename($file['cover']),
			]);
		}

		catch (\RuntimeException $e)
		{
			$this->response->status(constant(
				sprintf('\\Fenric\\Response::STATUS_%d', $e->getCode())
			));

			$this->response->json([
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
			$this->response->status(\Fenric\Response::STATUS_403)->json([
				'success' => false,
				'message' => 'Недостаточно прав.',
			]);
		}

		$upload = new Upload($this->request->body());

		try
		{
			$file = $upload->asPdf();

			$this->response->json([
				'file' => basename($file['location']),
				'cover' => basename($file['cover']),
			]);
		}

		catch (\RuntimeException $e)
		{
			$this->response->status(constant(
				sprintf('\\Fenric\\Response::STATUS_%d', $e->getCode())
			));

			$this->response->json([
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

		if ($this->response->isOk())
		{
			$json = json_decode($this->response->getContent(), true);

			fenric('user')->setPhoto($json['file']);
			fenric('user')->save();
		}
	}
}
