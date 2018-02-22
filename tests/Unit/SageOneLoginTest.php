<?php

namespace Tests\Unit;

use RevoSystems\SageOne\SObjects\Contact;

class SageOneLoginTest extends SageOneBaseTest
{
    /** @test */
    public function can_update_env_tokens()
    {
        (new Contact($this->api))->all();
        $this->object = null;
    }
}
