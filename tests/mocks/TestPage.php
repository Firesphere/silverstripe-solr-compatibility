<?php


namespace Firesphere\SolrCompatibility\Tests;

use Page;
use SilverStripe\Dev\TestOnly;

/**
 * Class TestPage
 * @package Firesphere\SolrCompatibility\Tests
 */
class TestPage extends Page implements TestOnly
{
    /**
     * @var array
     */
    private static $has_one = [
        'TestObject' => TestObject::class,
    ];

    /**
     * @var array
     */
    private static $has_many = [
    ];

    /**
     * @return string
     */
    public function getSalutation()
    {
        return sprintf('Dear %s', $this->Title);
    }
}
