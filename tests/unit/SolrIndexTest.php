<?php


namespace Firesphere\SolrCompatibility\Tests\Tests;


use CircleCITestIndex;
use SilverStripe\Dev\SapphireTest;

class SolrIndexTest extends SapphireTest
{

    public function testGetName()
    {
        $index = new CircleCITestIndex();

        $this->assertEquals('CircleCITestIndex', $index->getIndexName());
    }
}
