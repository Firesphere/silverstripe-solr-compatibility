<?php

namespace Firesphere\SolrSearch\Compat;

use Firesphere\SolrSearch\Factories\DocumentFactory;
use Firesphere\SolrSearch\Indexes\BaseIndex;
use Firesphere\SolrSearch\Queries\BaseQuery;
use Firesphere\SolrSearch\Services\SchemaService;
use SilverStripe\Core\Extension;
use SilverStripe\ORM\DataObject;
use Solarium\QueryType\Select\Query\Query;
use TractorCow\Fluent\Model\Locale;
use TractorCow\Fluent\State\FluentState;

if (!class_exists('TractorCow\\Fluent\\Model\\Locale')) {
    return;
}

/**
 * Class FluentExtension
 * Support for Fluent translations. Should be moved to a separate repo or to Fluent
 * @package Firesphere\SolrSearch\Compat
 * @property DocumentFactory|BaseIndex|SchemaService|FluentExtension $owner
 */
class FluentExtension extends Extension
{
    /**
     * Add the needed language copy fields to Solr
     */
    public function onAfterInit(): void
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

    /**
     * Add the locale fields
     * @param array $data
     * @param DataObject $item
     */
    public function onAfterFieldDefinition($data, $item): void
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

    /**
     * Update the Solr field for the value to use the locale name
     * @param array $field
     * @param string $value
     */
    public function onBeforeAddDoc(&$field, &$value): void
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
     * Set to the correct language to search if needed
     * @param BaseQuery $query
     * @param Query $clientQuery
     */
    public function onBeforeSearch($query, $clientQuery): void
    {
        $locale = FluentState::singleton()->getLocale();
        $defaultLocale = Locale::get()->filter(['IsGlobalDefault' => true])->first();
        if ($locale && $defaultLocale !== null && $locale !== $defaultLocale->Locale) {
            $defaultField = $clientQuery->getQueryDefaultField() ?: '_text';
            $clientQuery->setQueryDefaultField($locale . $defaultField);
        }
    }
}
