<?php

namespace Chadhutchins\OAuth2\Client\Test\Provider;

use Chadhutchins\OAuth2\Client\Provider\Zoho as ZohoProvider;

use Mockery as m;

class ZohoTest extends \PHPUnit_Framework_TestCase
{
    protected $provider;

    protected function setUp()
    {
        $this->provider = new ZohoProvider([
            'clientId' => 'mock_client_id',
            'clientSecret' => 'mock_secret',
            'redirectUri' => 'none',
        ]);
    }

    public function tearDown()
    {
        m::close();
        parent::tearDown();
    }
}
