<?php


namespace SilverStripe\FullTextSearch\Solr;

use Firesphere\SolrSearch\Indexes\BaseIndex;
use Firesphere\SolrSearch\Services\SolrCoreService;

class Solr
{

    /**
     * Compatibility with Fulltext Search module for configurations
     * @param $config
     */
    public static function configure_server($config): void
    {
        $configArray = [
            'endpoint' => [
                'localhost' => [
                    'host' => $config['host'],
                    'port' => $config['port'],
                ]
            ]
        ];
        SolrCoreService::config()->set('config', $configArray);
        $modeArray = [
            'mode' => $config['indexstore']['mode'],
            'path' => $config['path']
        ];
        SolrCoreService::config()->set('mode', $modeArray);
    }
}
