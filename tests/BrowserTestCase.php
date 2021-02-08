<?php

namespace Tests;

use Laravel\BrowserKitTesting\TestCase as BaseTestCase;

abstract class BrowserTestCase extends BaseTestCase
{
    use CreatesApplication;

    public $baseUrl = 'http://localhost';

}
