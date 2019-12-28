<?php


namespace Firesphere\SolrCompatibility\Tests;

use Firesphere\SolrCompatibility\Extensions\SolrCoreServiceExtension;
use Firesphere\SolrSearch\Services\SolrCoreService;
use SilverStripe\Dev\SapphireTest;

class SolrCoreServiceExtensionTest extends SapphireTest
{
    public function testCoreIsActive()
    {
        $service = new SolrCoreService();

        $extension = new SolrCoreServiceExtension();

        $extension->setOwner($service);

        $this->assertGreaterThan(
            $extension->coreStatus('CircleCITestIndex')->getUptime(),
            $service->coreIsActive('CircleCITestIndex')->getUptime()
        );
    }
}
