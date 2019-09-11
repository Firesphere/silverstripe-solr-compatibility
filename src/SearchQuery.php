<?php

namespace SilverStripe\FullTextSearch\Search\Queries;

use Firesphere\SolrSearch\Queries\BaseQuery;

/**
 * Class SearchQuery
 * Cover any changes between the SilverStripe FulltextSearch module and the upgraded module
 *
 * @package SilverStripe\FullTextSearch\Search\Queries
 */
class SearchQuery extends BaseQuery
{
    /**
     * @var int Default page size
     */
    public static $default_page_size = 10;

    /**
     * A simple stub to cover changes between Solr Search modules
     *
     * @deprecated please use {@link self::addTerm()}
     * @param string $text
     * @param null|array $fields
     * @param array $boost
     * @return $this
     */
    public function addSearchTerm($text, $fields = [], $boost = [])
    {
        $fields = $fields ? (array)$fields : [];
        $this->addTerm($text, $fields, $boost);

        return $this;
    }

    /**
     * Set the rows that are to be returned
     * Compatibility stub
     *
     * @param int $limit
     * @return $this
     */
    public function setLimit($limit): self
    {
        $this->rows = $limit;

        return $this;
    }

    /**
     * Get the rows that are to be returned
     * Compatibility stub
     *
     * @return int
     */
    public function getLimit(): int
    {
        return $this->rows;
    }
}
