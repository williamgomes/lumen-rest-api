<?php

namespace Tests;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Laravel\Lumen\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected Client $httpClient;

    /**
     * @throws \Exception
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->httpClient = new Client([
            'base_uri' => 'http://nginx',
            'timeout'  => 2.0,
        ]);
    }
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }

    protected function tearDown(): void
    {
        unset($this->httpClient);
        parent::tearDown();
    }
}
