<?php
/**
 * class SolrCoreServiceExtension|Firesphere\SolrCompatibility\Extensions\SolrCoreServiceExtension add the old
 * active state check
 *
 * @package Firesphere\Solr\Compatibility
 * @author Simon `Firesphere` Erkelens; Marco `Sheepy` Hermo
 * @copyright Copyright (c) 2018 - now() Firesphere & Sheepy
 */

namespace Firesphere\SolrCompatibility\Extensions;

use Firesphere\SolrSearch\Services\SolrCoreService;
use SilverStripe\Core\Extension;
use Solarium\QueryType\Server\CoreAdmin\Result\StatusResult;

/**
 * Class \Firesphere\SolrCompatibility\Extensions\SolrCoreServiceExtension
 *
 * Add the old coreIsActive method to the Service for backward compatibility
 *
 * @property SolrCoreService|SolrCoreServiceExtension $owner
 */
class SolrCoreServiceExtension extends Extension
{
    /**
     * Check the status of a core
     *
     * @param string $core
     * @return StatusResult|null
     * @deprecated backward compatibility stub
     */
    public function coreIsActive($core)
    {
        return $this->owner->coreStatus($core);
    }
}
