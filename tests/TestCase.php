<?php

namespace MKob\Pirates\Tests;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return ['MKob\Pirates\PiratesServiceProvider'];
    }
}
