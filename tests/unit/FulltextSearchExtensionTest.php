<?php


namespace Firesphere\SolrCompatibility\Tests\Tests;

use Firesphere\SolrSearch\Indexes\BaseIndex;
use Firesphere\SolrSearch\Queries\BaseQuery;
use Firesphere\SolrSearch\Tasks\SolrConfigureTask;
use Firesphere\SolrSearch\Tests\TestIndex;
use Psr\Log\NullLogger;
use SilverStripe\Control\NullHTTPRequest;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\View\ArrayData;

class FulltextSearchExtensionTest extends SapphireTest
{

    /**
     * @var BaseIndex
     */
    protected $index;

    public function testSearch()
    {
        $query = new BaseQuery();
        $query->addTerm('Test');

        $result = $this->index->search($query, 0, 10, [], true);

        $this->assertInstanceOf(ArrayData::class, $result);
    }

    public function testSearchWithFields()
    {
        $query = new BaseQuery();
        $query->addTerm('Test');

        $result = $this->index->search($query, 0, 10, ['fq' => 'Title'], true);

        $this->assertInstanceOf(ArrayData::class, $result);

        $this->assertEquals(['Title'], $query->getFields());
    }

    /**
     * @expectedException \LogicException
     */
    public function testInitToYml()
    {
        $this->index->initToYml();
    }


    protected function setUp()
    {
        $task = new SolrConfigureTask();
        $task->setLogger(new NullLogger());
        $task->run(new NullHTTPRequest());

        $this->index = Injector::inst()->get(TestIndex::class, false);

        parent::setUp();
    }
}
