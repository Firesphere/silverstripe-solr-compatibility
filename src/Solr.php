<?php
/**
 * Class Solr|SilverStripe\FullTextSearch\Search\Queries\Solr provide backward compatibility help for
 * migrating from the old module
 *
 * @package SilverStripe\FullTextSearch\Search\Queries
 * @author Simon `Firesphere` Erkelens; Marco `Sheepy` Hermo
 * @copyright Copyright (c) 2018 - now() Firesphere & Sheepy
 */

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
                    'host' => $config['host'] ?? '127.0.0.1',
                    'port' => $config['port'] ?? 8983,
                ],
            ],
        ];
        SolrCoreService::config()->set('config', $configArray);
        $modeArray = [
            'mode' => $config['indexstore']['mode'] ?? 'file',
            'path' => $config['indexstore']['path'] ?? '.solr',
        ];
        SolrCoreService::config()->set('mode', $modeArray);
        SolrCoreService::config()->set('cpucores', $config['cores'] ?? 1);
    }
}
