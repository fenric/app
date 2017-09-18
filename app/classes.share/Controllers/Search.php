<?php

namespace Fenric\Controllers;

/**
 * Import classes
 */
use Propel\Models\PublicationQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\Collection\ObjectCollection;
use Fenric\Controllers\Abstractable\Abstractable;

/**
 * Search
 */
class Search extends Abstractable
{

	/**
	 * Предварительная инициализация контроллера
	 */
	public function preInit() : bool
	{
		if ($this->request->query->exists('q')) {
			if (! is_string($this->request->query->get('q'))) {
				$this->response->setStatus(400);
				return false;
			}
		}

		if ($this->request->query->exists('page')) {
			if (! ctype_digit($this->request->query->get('page'))) {
				$this->response->setStatus(400);
				return false;
			}
		}

		if ($this->request->query->exists('limit')) {
			if (! ctype_digit($this->request->query->get('limit'))) {
				$this->response->setStatus(400);
				return false;
			}
		}

		return true;
	}

	/**
	 * Рендеринг контроллера
	 */
	public function render() : void
	{
		$data['publications'] = new ObjectCollection();

		if ($this->request->query->exists('q'))
		{
			if ($this->request->query->exists('page')) {
				if ($this->request->query->get('page') >= 1) {
					if ($this->request->query->get('page') <= PHP_INT_MAX) {
						$page = $this->request->query->get('page');
					}
				}
			}

			if ($this->request->query->exists('limit')) {
				if ($this->request->query->get('limit') >= 1) {
					if ($this->request->query->get('limit') <= 100) {
						$limit = $this->request->query->get('limit');
					}
				}
			}

			if ($q = trim($this->request->query->get('q')))
			{
				if ($query = PublicationQuery::search($q))
				{
					$query->orderById(Criteria::DESC);

					$data['publications'] = $query->paginate(
						$page ?? 1,
						$limit ?? 25
					);
				}
			}
		}

		$this->response->setContent(
			fenric('view::search')->render($data)
		);
	}
}
