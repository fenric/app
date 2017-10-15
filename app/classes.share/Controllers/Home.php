<?php

namespace Fenric\Controllers;

/**
 * Import classes
 */
use Fenric\Controllers\Abstractable\Abstractable;

use Propel\Models\Section;
use Propel\Models\SectionQuery;
use Propel\Models\Map\SectionTableMap;

/**
 * Home
 */
class Home extends Abstractable
{

	/**
	 * Рендеринг контроллера
	 */
	public function render() : void
	{
		$query = SectionQuery::create();
		$section = $query->findOneByCode('home');

		if ($section instanceof Section)
		{
			$this->response->setContent(
				fenric('view::section.home')->render([
					'section' => $section,
				])
			);

			return;
		}

		$this->response->setContent(
			fenric('view::home')->render()
		);
	}
}
