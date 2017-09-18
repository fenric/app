<?php

namespace Fenric\Controllers\User;

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
			return parent::preInit();
		}

		$this->response->setStatus(401);

		return false;
	}
}
