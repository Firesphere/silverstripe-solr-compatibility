<?php


namespace SilverStripe\FullTextSearch\Solr;

use Firesphere\SolrSearch\Indexes\BaseIndex;
use SilverStripe\CMS\Model\SiteTree;

/**
 * Class SolrIndex
 * This class serves as a stub to make migration from Fulltext Search easier
 *
 * @package SilverStripe\FullTextSearch\Solr
 */
class SolrIndex extends BaseIndex
{
    /**
     * Add the SiteTree class by default
     */
    public function init()
    {
        $this->addClass(SiteTree::class);
        return parent::init();
    }

    /**
     * Return the classname by default
     * @return string
     */
    public function getIndexName()
    {
        return static::class;
    }
}
