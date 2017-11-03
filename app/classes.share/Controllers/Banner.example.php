<?php

namespace Fenric\Controllers;

/**
 * Import classes
 */
use Propel\Models\Map\BannerTableMap as Table;
use Fenric\Controllers\Abstractable\Abstractable;

/**
 * Banner
 */
class Banner extends Abstractable
{

	/**
	 * Предварительная инициализация контроллера
	 */
	public function preInit() : bool
	{
		$query = fenric('query');
		$query->select(Table::COL_ID);
		$query->select(Table::COL_HYPERLINK_URL)->alias('url');
		$query->select(Table::COL_CLICKS);
		$query->from(Table::TABLE_NAME);
		$query->where(Table::COL_ID, '=', $this->request->parameters->get('id'));

		if ($row = $query->readRow())
		{
			$clicks = fenric('session')
				->get('clicks');

			if (empty($clicks[$row->id]))
			{
				$clicks[$row->id] = time();

				fenric('session')
					->set('clicks', $clicks);

				fenric('query')
					->update(Table::TABLE_NAME, [
						Table::COL_CLICKS => $row->clicks + 1,
					])
					->where(Table::COL_ID, '=', $row->id)
					->limit(1)
				->shutdown();
			}

			$this->redirect($row->url, 302);

			return true;
		}

		$this->response->setStatus(404);

		return false;
	}

	/**
	 * Рендеринг контроллера
	 */
	public function render() : void
	{}
}
