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
abstract class SolrIndex extends BaseIndex
{
    /**
     * Add the SiteTree class by default
     */
    public function init()
    {
        $this->addClass(SiteTree::class);
        parent::init();
    }

    /**
     * Return the classname by default (Not advised)
     *
     * @return string
     */
    public function getIndexName()
    {
        return str_replace('\\', '_', static::class);
    }
}
