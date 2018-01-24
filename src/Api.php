<?php

namespace RevoSystems\SageOne;

class Api extends \RevoSystems\SageApi\Api
{
    protected function urlForResource($resource)
    {
        return "https://api.columbus.sage.com/fr/sageone/accounts/v3/{$resource}";
    }
}
