<?php

namespace Firesphere\SolrSearch\Compat;

use Firesphere\SolrSearch\Factories\DocumentFactory;
use Firesphere\SolrSearch\Indexes\BaseIndex;
use Firesphere\SolrSearch\Queries\BaseQuery;
use Firesphere\SolrSearch\Services\SchemaService;
use SilverStripe\Core\Extension;
use Solarium\QueryType\Select\Query\Query;
use TractorCow\Fluent\Model\Locale;
use TractorCow\Fluent\State\FluentState;

if (!class_exists('TractorCow\\Fluent\\Model\\Locale')) {
    return;
}

/**
 * Class FluentExtension
 *
 * @package Firesphere\SolrSearch\Compat
 * @property DocumentFactory|BaseIndex|SchemaService|FluentExtension $owner
 */
class FluentExtension extends Extension
{
    protected $fieldLocale;

    /**
     * Add the needed language copy fields to Solr
     */
    public function onAfterInit()
    {
        $locales = Locale::get()->exclude(['IsGlobalDefault' => true]);
        /** @var BaseIndex $owner */
        $owner = $this->owner;
        $copyFields = $owner->getCopyFields();
        /** @var Locale $locale */
        foreach ($locales as $locale) {
            foreach ($copyFields as $copyField => $values) {
                $owner->addCopyField($locale->Locale . $copyField, $values);
            }
        }
    }

    public function onAfterFieldDefinition($data, $item)
    {
        $locales = Locale::get()->exclude(['IsGlobalDefault' => true]);

        foreach ($locales as $locale) {
            $isDest = strpos($item['Destination'], $locale->Locale);
            if ($isDest === 0 || $item['Destination'] === null) {
                $copy = $item;
                $copy['Field'] = $item['Field'] . '_' . $locale->Locale;
                $data->push($copy);
            }
        }
    }

    public function onBeforeAddDoc(&$field, &$value)
    {
        $fluentState = FluentState::singleton();
        $locale = $fluentState->getLocale();
        /** @var Locale $defaultLocale */
        $defaultLocale = Locale::get()->filter(['IsGlobalDefault' => true])->first();
        if ($locale !== null && $locale !== $defaultLocale->Locale) {
            $field['name'] .= '_' . $locale;
        }
    }

    /**
     * @param BaseQuery $query
     * @param Query $clientQuery
     */
    public function onBeforeSearch($query, $clientQuery)
    {
        $locale = FluentState::singleton()->getLocale();
        $defaultLocale = Locale::get()->filter(['IsGlobalDefault' => true])->first();
        if ($locale && $defaultLocale !== null && $locale !== $defaultLocale->Locale) {
            $defaultField = $clientQuery->getQueryDefaultField() ?: '_text';
            $clientQuery->setQueryDefaultField($locale . $defaultField);
        }
    }
}
