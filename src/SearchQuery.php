<?php
/**
 * Class SearchQuery|SilverStripe\FullTextSearch\Search\Queries\SearchQuery provide backward compatibility help for
 * migrating from the old module
 *
 * @package SilverStripe\FullTextSearch\Search\Queries
 * @author Simon `Firesphere` Erkelens; Marco `Sheepy` Hermo
 * @copyright Copyright (c) 2018 - now() Firesphere & Sheepy
 */

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
     * @param string $text
     * @param null|array $fields
     * @param int $boost
     * @return $this
     * @deprecated please use {@link self::addTerm()}
     */
    public function addSearchTerm($text, $fields = [], int $boost = 0)
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
     * @deprecated please use {@link self::setRows()}
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
     * @deprecated please use {@link self::getRows()}
     */
    public function getLimit(): int
    {
        return $this->rows;
    }
}
