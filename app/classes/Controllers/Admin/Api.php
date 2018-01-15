<?php

namespace Fenric\Controllers\Admin;

/**
 * Import classes
 */
use Fenric\Controllers\Abstractable\Actionable as Controller;

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
	 * Выгрузка модулей рабочего стола
	 */
	protected function actionDesktopModulesViaGET() : void
	{
		$this->response->json(
			fenric('config::desktop')->get('modules', [])
		);
	}

	/**
	 * Выгрузка компонентов рабочего стола
	 */
	protected function actionDesktopComponentsViaGET() : void
	{
		$this->response->json(
			fenric('config::desktop')->get('components', [])
		);
	}

	/**
	 * Выгрузка учетной записи
	 */
	protected function actionAccountViaGET() : void
	{
		$params = fenric('user')->getParams();

		$this->response->json(
		[
			'id' => fenric('user')->getId(),
			'role' => fenric('user')->getRole(),
			'email' => fenric('user')->getEmail(),
			'username' => fenric('user')->getUsername(),

			'photo' => fenric('user')->getPhoto(),
			'gender' => fenric('user')->getGender(),

			'desktop' => $params['desktop'] ?? [],
		]);
	}

	/**
	 * Сохранение позиции иконки рабочего стола
	 */
	protected function actionSaveDesktopIconViaPATCH() : void
	{
		parse_str($this->request->body(), $data);

		$params = fenric('user')->getParams();

		$params['desktop']['icons'][$data['id']]['top'] = $data['top'];
		$params['desktop']['icons'][$data['id']]['left'] = $data['left'];

		fenric('user')->setParams($params);
		fenric('user')->save();
	}

	/**
	 * Сохранение цветовой палитры рабочего стола
	 */
	protected function actionSaveDesktopPaletteViaPATCH() : void
	{
		parse_str($this->request->body(), $data);

		$params = fenric('user')->getParams();

		$params['desktop']['palette'] = $data['palette'];

		fenric('user')->setParams($params);
		fenric('user')->save();
	}

	/**
	 * Сохранение фонового изображения рабочего стола
	 */
	protected function actionSaveDesktopWallpaperViaPATCH() : void
	{
		parse_str($this->request->body(), $data);

		$params = fenric('user')->getParams();

		$params['desktop']['wallpaper'] = $data['wallpaper'];

		fenric('user')->setParams($params);
		fenric('user')->save();
	}

	/**
	 * Сохранение размера шрифта для содержимого модальных окон рабочего стола
	 */
	protected function actionSaveDesktopModalContentFontSizeViaPATCH() : void
	{
		parse_str($this->request->body(), $data);

		$params = fenric('user')->getParams();

		$params['desktop']['modalContentFontSize'] = $data['value'];

		fenric('user')->setParams($params);
		fenric('user')->save();
	}
}
