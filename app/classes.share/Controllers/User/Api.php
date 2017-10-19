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

			$this->response->setJsonContent([
				'file' => basename($file['location']),
			]);
		}

		catch (\RuntimeException $e)
		{
			switch ($e->getCode())
			{
				case 1 :
					$this->response->setStatus(400);
					break;

				default :
					$this->response->setStatus(503);
					break;
			}

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
		if (! fenric('user')->haveAccessToUploadPDF())
		{
			$this->response->setStatus(403)->setJsonContent([
				'success' => false,
				'message' => 'Недостаточно прав.',
			]);
		}

		$upload = new Upload($this->request->getBody());

		try
		{
			$file = $upload->asPDF();

			$this->response->setJsonContent([
				'file' => basename($file['location']),
				'cover' => basename($file['cover']),
			]);
		}

		catch (\RuntimeException $e)
		{
			switch ($e->getCode())
			{
				case 1 :
					$this->response->setStatus(400);
					break;

				default :
					$this->response->setStatus(503);
					break;
			}

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
