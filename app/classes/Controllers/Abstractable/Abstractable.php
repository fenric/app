<?php

namespace Fenric\Controllers\Abstractable;

/**
 * Import classes
 */
use Fenric\Controller;

/**
 * Abstractable
 */
abstract class Abstractable extends Controller
{

	/**
	 * Переадресация к указанному адресу
	 */
	final protected function redirect(string $location, int $statusCode = 302, \Closure $beforeRedirect = null) : void
	{
		$status = constant(sprintf('\\Fenric\\Response::STATUS_%d', $statusCode));

		$this->response->status($status)->header('Location', $location)->content(null);

		($beforeRedirect instanceof \Closure) and $beforeRedirect();

		$this->response->send();

		exit(0);
	}

	/**
	 * Переадресация к домашнему адресу
	 */
	final protected function homeward(int $statusCode = 302, \Closure $beforeRedirect = null) : void
	{
		$location = $this->request->root() ?: '/';

		$this->redirect($location, $statusCode, $beforeRedirect);
	}

	/**
	 * Переадресация к отсылающему адресу
	 */
	final protected function backward(int $statusCode = 302, \Closure $beforeRedirect = null) : void
	{
		$location = $this->request->environment->get('HTTP_REFERER') ?: $this->request->root() ?: '/';

		$this->redirect($location, $statusCode, $beforeRedirect);
	}

	/**
	 * Контроль завершающего слеша в запрошеном пути
	 */
	final public function trailingSlashes(\Closure $beforeRedirect = null) : void
	{
		if (preg_match('#^(?:.*[^/])$#', $this->request->path()))
		{
			$redirectLocation = $this->request->path() . '/';

			if (strlen($this->request->query()) > 0)
			{
				$redirectLocation .= '?' . $this->request->query();
			}

			$this->redirect($redirectLocation, 301, $beforeRedirect);
		}
	}
}
