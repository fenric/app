<?php

namespace Fenric\Controllers;

/**
 * Import classes
 */
use Propel\Models\SectionQuery;
use Propel\Models\Map\SectionTableMap;

use Propel\Models\PublicationQuery;
use Propel\Models\Map\PublicationTableMap;

use Propel\Models\PublicationRelationQuery;
use Propel\Models\Map\PublicationRelationTableMap;

use Fenric\Controllers\Abstractable\Abstractable;

/**
 * PublicationMentions
 */
class PublicationMentions extends Abstractable
{

	/**
	 * Предварительная инициализация контроллера
	 */
	public function preInit() : bool
	{
		$section = $this->request->parameters->get('section');
		$publication = $this->request->parameters->get('publication');
		$relation = $this->request->parameters->get('relation');

		if (! PublicationQuery::checkNestingByCode($publication, $section))
		{
			$this->response->setStatus(404);

			return false;
		}

		if (! SectionQuery::existsByCode($relation))
		{
			$this->response->setStatus(404);

			return false;
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

		$relation = SectionQuery::create()->findOneByCode(
			$this->request->parameters->get('relation')
		);

		$mentions = $publication->getMentions(function($self, $query, $subquery) use($relation)
		{
			$subquery->inner()->join(PublicationTableMap::TABLE_NAME);
			$subquery->on(PublicationTableMap::COL_ID, '=', PublicationRelationTableMap::COL_PUBLICATION_ID);

			$subquery->inner()->join(SectionTableMap::TABLE_NAME);
			$subquery->on(SectionTableMap::COL_ID, '=', PublicationTableMap::COL_SECTION_ID);

			$subquery->where(SectionTableMap::COL_ID, '=', $relation->getId());
		});

		$view = fenric('view::publication');

		if (fenric(sprintf('view::sections/%s/publication', $publication->getSection()->getCode()))->exists())
		{
			$view = fenric(sprintf('view::sections/%s/publication', $publication->getSection()->getCode()));
		}

		$this->response->setHeader(sprintf('Last-Modified: %s', $publication->getUpdatedAt()->format('D, d M Y H:i:s T')));

		$this->response->setContent($view->render([
			'publication' => $publication,
		]));

		$this->hit($publication);
	}
}
