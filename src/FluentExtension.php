<?php

namespace Firesphere\SolrSearch\Compat;

use Firesphere\SolrSearch\Factories\DocumentFactory;
use Firesphere\SolrSearch\Indexes\BaseIndex;
use Firesphere\SolrSearch\Queries\BaseQuery;
use Firesphere\SolrSearch\Services\SchemaService;
use Firesphere\SolrSearch\States\SiteState;
use SilverStripe\Core\Extension;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\DataList;
use SilverStripe\ORM\DataObject;
use Solarium\QueryType\Select\Query\Query;
use TractorCow\Fluent\Model\Locale;
use TractorCow\Fluent\State\FluentState;

/**
 * Support for Fluent translations.
 *
 * This class should be moved to a separate repo or to Fluent, but provides the basic Fluent support for now
 *
 * @package Firesphere\SolrSearch\Compat
 * @property DocumentFactory|BaseIndex|SchemaService|FluentExtension $owner
 */
class FluentExtension extends Extension
{
    /**
     * Add the fluent states
     */
    public function onBeforeInit()
    {
        if (!class_exists('TractorCow\\Fluent\\Model\\Locale')) {
            return;
        }
        $locales = Locale::get()->exclude(['IsGlobalDefault' => true]);
        SiteState::addStates($locales->column('Locale'));
    }

    /**
     * Add the needed language copy fields to Solr
     */
    public function onAfterInit(): void
    {
        if (!class_exists('TractorCow\\Fluent\\Model\\Locale')) {
            return;
        }
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
     *
     * @param ArrayList|DataList $data
     * @param DataObject $item
     */
    public function onAfterFieldDefinition($data, $item): void
    {
        if (!class_exists('TractorCow\\Fluent\\Model\\Locale')) {
            return;
        }
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
     *
     * @param array $field
     * @param string $value
     */
    public function onBeforeAddDoc(&$field, &$value): void
    {
        if (!class_exists('TractorCow\\Fluent\\Model\\Locale')) {
            return;
        }
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
     *
     * @param BaseQuery $query
     * @param Query $clientQuery
     */
    public function onBeforeSearch($query, $clientQuery): void
    {
        if (!class_exists('TractorCow\\Fluent\\Model\\Locale')) {
            return;
        }
        $locale = FluentState::singleton()->getLocale();
        $defaultLocale = Locale::get()->filter(['IsGlobalDefault' => true])->first();
        if ($locale && $defaultLocale !== null && $locale !== $defaultLocale->Locale) {
            $defaultField = $clientQuery->getQueryDefaultField() ?: '_text';
            $clientQuery->setQueryDefaultField($locale . $defaultField);
        }
    }
}
