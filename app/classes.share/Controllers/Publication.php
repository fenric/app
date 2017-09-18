<?php

namespace Fenric\Controllers;

/**
 * Import classes
 */
use Propel\Models\PublicationQuery;
use Fenric\Controllers\Abstractable\Abstractable;

/**
 * Publication
 */
class Publication extends Abstractable
{

	/**
	 * Предварительная инициализация контроллера
	 */
	public function preInit() : bool
	{
		$section = $this->request->parameters->get('section');
		$publication = $this->request->parameters->get('publication');

		if (! PublicationQuery::checkNestingByCode($publication, $section)) {
			$this->response->setStatus(404);
			return false;
		}

		if ($this->request->environment->exists('HTTP_IF_MODIFIED_SINCE')) {
			if ($timestamp = strtotime($this->request->environment->get('HTTP_IF_MODIFIED_SINCE'))) {
				if (! PublicationQuery::checkModifiedByCode($publication, $timestamp)) {
					$this->response->setStatus(304);
					return false;
				}
			}
		}

		return true;
	}

	/**
	 * Рендеринг контроллера
	 */
	public function render() : void
	{
		$publication = PublicationQuery::create()->findOneByCode(
			$this->request->parameters->get('publication')
		);

		$view = fenric('view::publication');

		if (fenric(sprintf('view::sections/%s/publication', $publication->getSection()->getCode()))->exists()) {
			$view = fenric(sprintf('view::sections/%s/publication', $publication->getSection()->getCode()));
		}

		$this->response->setHeader(sprintf('Last-Modified: %s', $publication->getUpdatedAt()->format('D, d M Y H:i:s T')));

		$this->response->setContent($view->render([
			'publication' => $publication,
		]));

		$publication->registerHit();
	}
}
