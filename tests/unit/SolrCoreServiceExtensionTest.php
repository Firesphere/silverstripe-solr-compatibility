<?php


namespace Firesphere\SolrCompatibility\Tests;


use Firesphere\SolrSearch\Services\SolrCoreService;
use SilverStripe\Dev\SapphireTest;

class SolrCoreServiceExtensionTest extends SapphireTest
{

    public function testCoreIsActive()
    {
        $class = new SolrCoreService();

        $this->assertGreaterThan($class->coreStatus('CircleCITestIndex')->getUptime(), $class->coreIsActive('CircleCITestIndex')->getUptime());
    }
}
