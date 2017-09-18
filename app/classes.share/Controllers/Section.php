<?php

namespace Fenric\Controllers;

/**
 * Import classes
 */
use DateTime;
use Propel\Models\SectionQuery;
use Propel\Models\PublicationQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use Fenric\Controllers\Abstractable\Abstractable;

/**
 * Section
 */
class Section extends Abstractable
{

	/**
	 * Предварительная инициализация контроллера
	 */
	public function preInit() : bool
	{
		if (! SectionQuery::existsByCode($this->request->parameters->get('code'))) {
			$this->response->setStatus(404);
			return false;
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

		$section = SectionQuery::create()->findOneByCode(
			$this->request->parameters->get('code')
		);

		$publications = PublicationQuery::create();
		$publications->innerJoinSection();

		$publications->filterBySectionId($section->getId());
		$publications->filterByShowAt(null)->_or()->filterByShowAt(new DateTime('now'), Criteria::LESS_EQUAL);
		$publications->filterByHideAt(null)->_or()->filterByHideAt(new DateTime('now'), Criteria::GREATER_EQUAL);
		$publications->orderByCreatedAt(Criteria::DESC);

		$publications = $publications->paginate(
			$page ?? 1,
			$limit ?? 18
		);

		$view = fenric('view::section');

		if (fenric(sprintf('view::sections/%s/section', $this->request->parameters->get('code')))->exists()) {
			$view = fenric(sprintf('view::sections/%s/section', $this->request->parameters->get('code')));
		}

		$this->response->setContent($view->render([
			'section' => $section,
			'publications' => $publications,
		]));
	}
}
