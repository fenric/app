<?php

namespace Fenric\Controllers\Abstractable;

/**
 * Actionable
 */
abstract class Actionable extends Abstractable
{

	/**
	 * Рендеринг контроллера
	 */
	final public function render() : void
	{
		if ($this->request->parameters->exists('action'))
		{
			$requestAction = $this->request->parameters->get('action');
			$requestMethod = $this->request->getMethod();

			$controllerMethod = str_replace('-', ' ', $requestAction);
			$controllerMethod = ucwords($controllerMethod);
			$controllerMethod = str_replace(' ', '', $controllerMethod);

			$controllerMethod = sprintf('action%sVia%s', $controllerMethod, $requestMethod);

			if (is_callable([$this, $controllerMethod]))
			{
				call_user_func([$this, $controllerMethod]);
			}
			else $this->response->setStatus(404);
		}
		else $this->response->setStatus(400);
	}
}
