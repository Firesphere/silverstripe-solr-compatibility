<?php


namespace Firesphere\SolrCompatibility\Tests\Tests;

use Firesphere\SolrSearch\Services\SolrCoreService;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\FullTextSearch\Solr\Solr;

class SolrTest extends SapphireTest
{
    public function testConfigureServer()
    {
        $config = [
            'host'       => 'localhost',
            'port'       => 1234,
            'indexstore' => [
                'mode' => 'post'
            ]
        ];
        Solr::configure_server($config);

        $expected = [
            'endpoint' =>
                [
                    'localhost' =>
                        [
                            'host' => 'localhost',
                            'port' => 1234,
                        ],
                ],
        ];
        $this->assertEquals($expected, SolrCoreService::config()->get('config'));
        $mode = [
            'mode' => 'post',
            'path' => '.solr'
        ];
        $this->assertEquals($mode, SolrCoreService::config()->get('mode'));
        $this->assertEquals(1, SolrCoreService::config()->get('cpucores'));
    }
}
