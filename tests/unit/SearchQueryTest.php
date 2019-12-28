<?php


namespace Firesphere\SolrCompatibility\Tests;

use SilverStripe\Dev\SapphireTest;
use SilverStripe\FullTextSearch\Search\Queries\SearchQuery;

class SearchQueryTest extends SapphireTest
{
    public function testAddSearchTerm()
    {
        $query = new SearchQuery();
        $query = $query->addSearchTerm('Test term', [], 2);

        $expected = [
            [
                'text'   => 'Test term',
                'fields' =>
                    [
                    ],
                'boost'  => 2,
                'fuzzy'  => null,
            ]
        ];

        $this->assertEquals($expected, $query->getTerms());
    }

    public function testLimits()
    {
        $query = new SearchQuery();

        $query->setLimit(5);

        $this->assertEquals(5, $query->getRows());
        $this->assertEquals(5, $query->getLimit());
    }
}
