<?php

namespace RevoSystems\SageOne;

use Zttp\Zttp;

class Api extends \RevoSystems\SageApi\Api
{
    const PATCH_METHOD = 'put';

    protected function urlForResource($resource)
    {
        return "https://api.columbus.sage.com/uki/sageone/accounts/v3/{$resource}"; // TODO: do it dynamic
    }

    protected function urlForQueries()
    {
        return "https://api.columbus.sage.com/uki/sageone/accounts/v3/";
    }

    public function get($resource, $fields = ["id", "name"], $query = '')
    {
        return Zttp::withHeaders($this->auth->getAuthHeaders())
            ->get($this->urlForQueries() . "{$resource}?{$query}")
            ->json();
    }
}
