<?php


namespace SilverStripe\FullTextSearch\Solr;

use Firesphere\SolrSearch\Services\SolrCoreService;

/**
 * Class Solr Stub to convert old Solr configuration to config
 *
 * @package SilverStripe\FullTextSearch\Solr
 */
class Solr
{

    /**
     * Compatibility with Fulltext Search module for configurations
     *
     * @param $config
     */
    public static function configure_server($config): void
    {
        $configArray = [
            'endpoint' => [
                'localhost' => [
                    'host' => $config['host'],
                    'port' => $config['port'],
                ],
            ],
        ];
        SolrCoreService::config()->set('config', $configArray);
        $modeArray = [
            'mode' => $config['indexstore']['mode'],
            'path' => $config['indexstore']['path'],
        ];
        SolrCoreService::config()->set('mode', $modeArray);
    }
}
