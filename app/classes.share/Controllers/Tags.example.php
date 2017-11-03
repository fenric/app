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
		$tags = TagQuery::create();
		$tags->orderByHeader(Criteria::ASC);

		$this->response->setContent(fenric('view::tags', [
			'tags' => $tags->find(),
		])->render());
	}
}
