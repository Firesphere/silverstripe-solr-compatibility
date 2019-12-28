<?php
/**
 * Class FulltextSearchExtension|Firesphere\SolrCompatibility\Extensions\FulltextSearchExtension provide help for
 * migrating from the old module
 *
 * @package Firesphere\SolrCompatibility\Extensions
 * @author Simon `Firesphere` Erkelens; Marco `Sheepy` Hermo
 * @copyright Copyright (c) 2018 - now() Firesphere & Sheepy
 */

namespace Firesphere\SolrCompatibility\Extensions;

use Firesphere\SolrSearch\Indexes\BaseIndex;
use Firesphere\SolrSearch\Queries\BaseQuery;
use Firesphere\SolrSearch\Results\SearchResult;
use GuzzleHttp\Exception\GuzzleException;
use LogicException;
use ReflectionException;
use SilverStripe\Control\Controller;
use SilverStripe\Core\Extension;
use SilverStripe\Dev\Debug;
use SilverStripe\ORM\ValidationException;
use SilverStripe\View\ArrayData;

/**
 * Class \Firesphere\SolrCompatibility\Extensions\FulltextSearchExtension
 * Backward compatibility stubs for the Full text search module
 *
 * @package Firesphere\SolrCompatibility\Extensions
 * @property BaseIndex|FulltextSearchExtension $owner
 */
class FulltextSearchExtension extends Extension
{
    /**
     * Generate a yml version of the init method indexes
     */
    public function initToYml(): void
    {
        // @codeCoverageIgnoreStart
        if (function_exists('yaml_emit')) {
            /** @var BaseIndex $owner */
            $owner = $this->owner;
            $result = [
                BaseIndex::class => [
                    $owner->getIndexName() =>
                        [
                            'Classes'        => $owner->getClasses(),
                            'FulltextFields' => array_values($owner->getFulltextFields()),
                            'SortFields'     => $owner->getSortFields(),
                            'FilterFields'   => $owner->getFilterFields(),
                            'BoostedFields'  => $owner->getBoostedFields(),
                            'CopyFields'     => $owner->getCopyFields(),
                            'DefaultField'   => $owner->getDefaultField(),
                            'FacetFields'    => $owner->getFacetFields(),
                            'StoredFields'   => $owner->getStoredFields(),
                        ],
                ],
            ];

            Debug::dump(yaml_emit($result));

            return;
        }
        // @codeCoverageIgnoreEnd

        throw new LogicException('yaml-emit PHP module missing');
    }

    /**
     * Convert the SearchResult class to a Full text search compatible ArrayData
     *
     * @param SearchResult|ArrayData $results
     */
    public function updateSearchResults(&$results): void
    {
        $request = Controller::curr()->getRequest();
        $data = [
            'Matches'               => $results->getPaginatedMatches($request),
            'Facets'                => $results->getFacets(),
            'Highlights'            => $results->getHighlight(),
            'Spellcheck'            => $results->getSpellcheck(),
            'Suggestion'            => $results->getCollatedSpellcheck(),
            'SuggestionNice'        => $this->getCollatedNice($results->getCollatedSpellcheck()),
            'SuggestionQueryString' => $results->getCollatedSpellcheck(),
        ];
        // Override the results with an FTS compatible feature list
        $results = ArrayData::create($data);
    }

    /**
     * Create a spellcheck string that's not the literal collation with Solr query parts
     *
     * @param string $spellcheck
     * @return string mixed
     */
    protected function getCollatedNice($spellcheck): string
    {
        return str_replace(' +', ' ', $spellcheck);
    }

    /**
     * Convert the old search method to the new BaseIndex doSearch methods
     *
     * @param BaseQuery $query
     * @param int $start deprecated in favour of $query, exists for backward compatibility with FTS
     * @param int $limit deprecated in favour of $query, exists for backward compatibility with FTS
     * @param array $params deprecated in favour of $query, exists for backward compatibility with FTS
     * @param bool $spellcheck deprecated in favour of #query, exists for backward compatibility with FTS
     * @return SearchResult|ArrayData|mixed
     * @throws ValidationException
     * @throws GuzzleException
     * @throws ReflectionException
     * @deprecated This is used as an Fulltext Search compatibility method. Call doSearch instead with the correct Query
     */
    public function search($query, $start = 0, $limit = 10, $params = [], $spellcheck = null)
    {
        $query->getStart() === $start ?: $query->setStart($start);
        $query->getRows() === $limit ?: $query->setRows($limit);
        $query->hasSpellcheck() !== $spellcheck ?: $query->setSpellcheck($spellcheck);
        if (isset($params['fq']) && !count($query->getFields())) {
            $query->addField($params['fq']);
        }

        /** @var BaseIndex $owner */
        $owner = $this->owner;

        return $owner->doSearch($query);
    }

    /**
     * Add a Fulltext Field
     *
     * @param bool $includeSubclasses Compatibility mode, not actually used
     * @throws ReflectionException
     * @deprecated Please use addAllFulltextFields(). IncludeSubClasses is not used anymore
     */
    public function addFulltextFields($includeSubclasses = true)
    {
        /** @var BaseIndex $owner */
        $owner = $this->owner;

        $owner->addAllFulltextFields();
    }
}
