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
			else $this->response->setStatus(403);
		}
		else $this->response->setStatus(401);

		return false;
	}
}
