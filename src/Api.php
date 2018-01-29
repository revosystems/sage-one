<?php

namespace RevoSystems\SageOne;

use Zttp\ZttpResponse;

class Api extends \RevoSystems\SageApi\Api
{
    const PATCH_METHOD = 'put';

    protected function urlForResource($resource)
    {
        return "https://api.columbus.sage.com/uki/sageone/accounts/v3/{$resource}"; // TODO: do it dynamic uki, es, fr, ...
    }

    protected function urlForQueries()
    {
        return "https://api.columbus.sage.com/uki/sageone/accounts/v3/";
    }

    public function get($resource, $fields = ["id", "name"], $query = '')
    {
        $response = $this->call('get', $this->urlForQueries() . "{$resource}{$query}");
        return $response instanceof ZttpResponse ? $response->json() : null;
    }
}
