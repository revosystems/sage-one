<?php

namespace Tests\Unit;

use Dotenv\Dotenv;
use RevoSystems\SageOne\Api;
use RevoSystems\SageOne\Auth;
use PHPUnit\Framework\TestCase;

abstract class SageOneBaseTest extends TestCase
{
    protected $object;
    protected $api;

    public function setUp()
    {
        parent::setUp();
        $this->loadEnv();
        $this->api = $this->getSageApi();
    }

    public function getSageApi()
    {
        if (! $this->api) {
            $auth = new Auth(getenv('CLIENT_ID'), getenv('CLIENT_SECRET'));
            $auth->setAuthKeys([
                "access_token"      => getenv('TEST_ACCESS_TOKEN'),
                "refresh_token"     => getenv('TEST_REFRESH_TOKEN'),
            ], [
                "country"           => getenv('TEST_COUNTRY'),
                "resource_owner_id" => getenv('TEST_RESOURCE_OWNER_ID'),
                "subscription_id"   => getenv('SAGE_SUBSCRIPTION_ID'),
            ]);
            $this->api = new Api($auth);
        }
        return $this->api;
    }

    public function tearDown()
    {
        if ($this->object) {
            $this->object->destroy();
        }
        parent::tearDown();
    }

    /**
     * @return array
     */
    private function loadEnv()
    {
        return (new Dotenv(__DIR__, "../../.env"))->load();
    }
}
