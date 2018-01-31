<?php

namespace RevoSystems\SageOne;

use RevoSystems\SageOne\Validators\Validator;
use RevoSystems\SageApi\Api;

class SObject
{
    const RESOURCE_NAME = '';
    protected $api;
    protected $attributes;
    protected $fields;
    protected $queryParams  = '';

    public $id;

    /**
     * SageLiveSObject constructor.
     * @param Api $api
     * @param null $json
     */
    public function __construct(Api $api, $json = null)
    {
        $this->api        = $api;
        $this->id         = $json['id'] ?? $this->id;
        $this->attributes = collect($json);
        $this->fields     = collect($this->fields);
    }

    /**
     * @param Api $api
     * @return static
     */
    public static function make(Api $api)
    {
        return new static($api);
    }

    public function validate($attributes = false, $withRequired = true)
    {
        return [str_singular(static::RESOURCE_NAME) => (new Validator($this->fields, $attributes ? : $this->attributes))->validate($withRequired)->toArray()];
    }

    public function all($fields = ["id", "name"])
    {
        $this->queryParams = '';
        return $this->get($fields);
    }

    public function get($fields = ["id", "name"])
    {
        $items = collect($this->api->get(static::RESOURCE_NAME, $fields, $this->queryParams)["\$items"]);
        return $items->map(function ($data) {
            return new static($this->api, $data);
        });
    }

    public function where($query)
    {
        $this->queryParams .= $query;
        return $this;
    }

    public function count()
    {
        return $this->api->get(static::RESOURCE_NAME)["\$total"];
    }

    public function countWithFields()
    {
        $resource = $this->api->get(static::RESOURCE_NAME, $this->fields);
        try {
            return $resource["totalSize"];
        } catch (\Exception $e) {
            dd(static::RESOURCE_NAME, $resource);
        }
    }

    public function find($id)
    {
        if (! $id) {
            return new static($this->api);
        }
        return new static($this->api,
            $this->api->find(static::RESOURCE_NAME, $id)
        );
    }

    /**
     * @return SObject
     */
    public function create()
    {
        $this->id = $this->api->post(static::RESOURCE_NAME, $this->validate());
        return $this;
    }

    /**
     * @param $attributes
     * @return $this
     */
    public function update($attributes)
    {
        $this->attributes = $this->attributes->merge($attributes);
        $this->api->patch(static::RESOURCE_NAME, $this->id, $this->validate(collect($attributes), false));
        return $this;
    }

    public function destroy()
    {
        $this->api->delete(static::RESOURCE_NAME, $this->id);
    }

    public function __get($name)
    {
        if (array_has($this->attributes, $name)) {
            return $this->attributes[$name];
        }
        return null;
    }
}
