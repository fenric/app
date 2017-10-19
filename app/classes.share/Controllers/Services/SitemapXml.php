<?php

namespace Fenric\Controllers\Services;

/**
 * Import classes
 */
use DateTime;
use SimpleXMLElement;
use Propel\Models\Map\SectionTableMap;
use Propel\Models\Map\PublicationTableMap;
use Fenric\Controllers\Abstractable\Abstractable;

/**
 * SitemapXml
 */
class SitemapXml extends Abstractable
{

	/**
	 * Рендеринг контроллера
	 */
	public function render() : void
	{
		$blank = '<?xml version="1.0" encoding="UTF-8"?>';
		$blank .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" />';

		$sitemap = new SimpleXMLElement($blank);

		$query = fenric('query')
		->cache(3600) // 1 hour.

		->select(SectionTableMap::COL_CODE)->alias('scode')
		->select(PublicationTableMap::COL_CODE)->alias('pcode')
		->select(PublicationTableMap::COL_UPDATED_AT)

		->from(PublicationTableMap::TABLE_NAME)
		->inner()->join(SectionTableMap::TABLE_NAME)
		->on(PublicationTableMap::COL_SECTION_ID, '=', SectionTableMap::COL_ID)

		->where(1, '=', 1)

			->and_open()
					->where(PublicationTableMap::COL_SHOW_AT, 'is', null)
						->or_()->where(PublicationTableMap::COL_SHOW_AT, '<=', new DateTime('now'))

				->close_and_open()
					->where(PublicationTableMap::COL_HIDE_AT, 'is', null)
						->or_()->where(PublicationTableMap::COL_HIDE_AT, '>=', new DateTime('now'))

		->order(PublicationTableMap::COL_ID)
		->asc();

		$req = $this->request;

		if ($rows = $query->toArray())
		{
			foreach ($rows as $row)
			{
				$loc = sprintf('%s://%s/%s/%s.html',
					$req->getScheme(),
					$req->getHost(),
					$row['scode'],
					$row['pcode']
				);

				$lastmod = new DateTime($row['updated_at']);

				$url = $sitemap->addChild('url');
				$url->addChild('loc', $loc);
				$url->addChild('lastmod', $lastmod->format(DateTime::W3C));
				$url->addChild('changefreq', 'monthly');
				$url->addChild('priority', '1.0');
			}
		}

		$this->response->setHeader('Content-type: text/xml');
		$this->response->setContent($sitemap->asXML());
	}
}
