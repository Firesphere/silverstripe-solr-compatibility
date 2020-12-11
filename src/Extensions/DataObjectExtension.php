<?php
/**
 * Class FulltextSearchExtension|Firesphere\SolrCompatibility\Extensions\DataObjectExtension provide help for
 * migrating from the old module
 *
 * @package Firesphere\Solr\Compatibility
 * @author Simon `Firesphere` Erkelens; Marco `Sheepy` Hermo
 * @copyright Copyright (c) 2018 - now() Firesphere & Sheepy
 */


namespace Firesphere\SolrCompatibility\Extensions;

use SilverStripe\Core\Extension;
use SilverStripe\ORM\DataObject;

/**
 * Class \Firesphere\SolrCompatibility\Extensions\DataObjectExtension
 *
 * @property DataObject|DataObjectExtension $owner
 */
class DataObjectExtension extends Extension
{
    /**
     * Stub for triggering a reindex of the owner
     */
    public function triggerReindex()
    {
        $this->owner->doReindex();
    }
}
