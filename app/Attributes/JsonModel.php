<?php

namespace App\Attributes;

use App\Contracts\JsonModels\JsonModel as JsonModelContract;
use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class JsonModel
{

    const MODEL_NAMESPACE = 'Models/';

    /**
     * @param string $model
     * @param ?string $componentNamespace
     */
    public function __construct(
        protected string $model,
        protected ?string $componentNamespace = null,
    ) {}

    /**
     * Get an instance of the model.
     *
     * @return JsonModelContract
     */
    public function model(): JsonModelContract
    {
        $model = $this->model;
        return new $model;
    }

    /**
     * Resolve the InertiaJS component namespace.
     *
     * @return string
     */
    protected function resolveComponentNamespace(): string
    {
        return static::MODEL_NAMESPACE.$this->getModelName().'/';
    }

    /**
     * Get the model's name.
     *
     * @return string
     */
    public function getModelName(): string
    {
        return class_basename($this->model);
    }

    /**
     * Get the model class name.
     *
     * @return string
     */
    public function getModel(): string
    {
        return $this->model;
    }

    /**
     * Get the InertiaJS component namespace.
     *
     * @return string
     */
    public function getComponentNamespace(): string
    {
        $this->componentNamespace ??= $this->resolveComponentNamespace();
        return $this->componentNamespace;
    }
}
