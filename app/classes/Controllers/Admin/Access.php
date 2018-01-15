<?php

namespace Fenric\Controllers\Admin;

/**
 * Access
 */
trait Access
{

	/**
	 * Предварительная инициализация контроллера
	 */
	public function preInit() : bool
	{
		if (fenric('user')->isLogged())
		{
			if (fenric('user')->haveAccessToDesktop())
			{
				return parent::preInit();
			}
			else $this->response->status(\Fenric\Response::STATUS_403);
		}
		else $this->response->status(\Fenric\Response::STATUS_401);

		return false;
	}
}
