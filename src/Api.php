<?php

namespace RevoSystems\SageOne;

class Api extends \RevoSystems\SageApi\Api
{
    protected function urlForResource($resource)
    {
        return "https://api.columbus.sage.com/uki/sageone/accounts/v3/{$resource}"; // TODO: do it dynamic
    }
}
