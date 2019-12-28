<?php


namespace Firesphere\SolrCompatibility\Tests;

use Firesphere\SolrSearch\Indexes\BaseIndex;
use SilverStripe\Dev\TestOnly;

class TestIndexThree extends BaseIndex implements TestOnly
{
    public function init()
    {
        return;
    }

    public function getIndexName()
    {
        return 'TestIndexThree';
    }
}
