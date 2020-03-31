<?php


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

    public function triggerReindex()
    {
        $this->owner->doReindex();
    }
}
