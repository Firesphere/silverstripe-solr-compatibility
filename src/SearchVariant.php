<?php

namespace SilverStripe\FullTextSearch\Search\Variants;


use Firesphere\SolrSearch\States\SiteState;

/**
 * Class SearchVariant is a stub to reduce the impact of migration to a newer Solr implementation.
 *
 * This class actually does nothing but supply the same endpoint as the existing one
 *
 * @package SilverStripe\FullTextSearch\Search\Variants
 */
abstract class SearchVariant extends SiteState
{
    /**
     * Stub to supply a check for a class if it has an extension applied
     * @param string $class
     * @param string $extension
     * @return bool
     * @throws \ReflectionException
     */
    public static function has_extension($class, $extension)
    {
        return parent::hasExtension($class, $extension);
    }

    /**
     * Invoke the WithState method through a stub
     * @param $state
     * @throws \ReflectionException
     */
    public static function activate_state($state)
    {
        parent::withState($state);
    }
}
