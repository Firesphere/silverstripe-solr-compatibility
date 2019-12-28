<?php


namespace Firesphere\SolrCompatibility\Tests;


use Firesphere\SolrSearch\Services\SolrCoreService;
use SilverStripe\Dev\SapphireTest;

class SolrCoreServiceExtensionTest extends SapphireTest
{

    public function testCoreIsActive()
    {
        $index = new \CircleCITestIndex();

        $class = new SolrCoreService();

        $this->assertEquals($class->coreStatus('CircleCITestIndex'), $class->coreIsActive('CircleCITestIndex'));
    }
}
