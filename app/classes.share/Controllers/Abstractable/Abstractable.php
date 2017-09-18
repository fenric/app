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
		$rawHeader = sprintf('Location: %s', $location);

		$this->response->setStatus($statusCode)->setHeader($rawHeader)->setContent('');

		($beforeRedirect instanceof \Closure) and $beforeRedirect();

		$this->response->send();

		exit(0);
	}

	/**
	 * Переадресация к домашнему адресу
	 */
	final protected function homeward(int $statusCode = 302, \Closure $beforeRedirect = null) : void
	{
		$location = $this->request->getRoot() ?: '/';

		$this->redirect($location, $statusCode, $beforeRedirect);
	}

	/**
	 * Переадресация к отсылающему адресу
	 */
	final protected function backward(int $statusCode = 302, \Closure $beforeRedirect = null) : void
	{
		$location = $this->request->environment->get('HTTP_REFERER') ?: $this->request->getRoot() ?: '/';

		$this->redirect($location, $statusCode, $beforeRedirect);
	}

	/**
	 * Контроль завершающего слеша в запрошеном пути
	 */
	final public function trailingSlashes(\Closure $beforeRedirect = null) : void
	{
		if (preg_match('#^(?:.*[^/])$#', $this->request->getPath()))
		{
			$redirectLocation = $this->request->getPath() . '/';

			if (strlen($this->request->getQuery()) > 0)
			{
				$redirectLocation .= '?' . $this->request->getQuery();
			}

			$this->redirect($redirectLocation, 301, $beforeRedirect);
		}
	}
}
