<?php

namespace Fenric\Controllers;

/**
 * Import classes
 */
use Propel\Models\TagQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use Fenric\Controllers\Abstractable\Abstractable;

/**
 * Tags
 */
class Tags extends Abstractable
{

	/**
	 * Рендеринг контроллера
	 */
	public function render() : void
	{
		$query = TagQuery::create();
		$query->orderById(Criteria::DESC);

		$this->response->setContent(fenric('view::tags')->render([
			'tags' => $query->find(),
		]));
	}
}
