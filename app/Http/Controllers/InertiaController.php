<?php

namespace App\Http\Controllers;

use App\Attributes\JsonModel;
use App\Exceptions\ComponentResolutionException;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;
use ReflectionClass;

abstract class InertiaController extends Controller
{
    /**
     * Component naming convention.
     *
     * @var array
     */
    private array $componentNaming = [
        '{$model}{$action}',
        '{$action}',
    ];

    /**
     * Component file types.
     *
     * @var array
     */
    private array $componentTypes = [
        '.vue',
    ];

    private string $componentNamespace;

    /**
     * Get the component path.
     *
     * @return string
     */
    private function getComponentBasePath(): string
    {
        return base_path('resources/js/Pages').'/';
    }

    /**
     * Resolve the component name.
     *
     * @param string $model
     * @param string $action
     * @return string
     * @throws ComponentResolutionException
     */
    private function resolveComponentName(string $model, string $action): string
    {
        foreach($this->componentNaming as $convention) {
            $name = strtr($convention, ['{$model}' => Str::studly($model), '{$action}' => Str::studly($action)]);
            if($this->componentExists($name)) {
                return $name;
            }
        }

        throw new ComponentResolutionException('Could not resolve a component.');
    }

    /**
     * Does the given component exist?
     *
     * @param string $componentName
     * @return bool
     */
    private function componentExists(string $componentName): bool
    {
        foreach($this->componentTypes as $type) {
            if(file_exists($this->getComponentBasePath().$this->componentNamespace.$componentName.$type)) {
                return true;
            }
        }
        return false;
    }


    /**
     * Render the component.
     *
     * @param iterable $data
     * @param ?string $component
     * @param ?string $action
     * @return Response
     */
    protected function render(iterable $data = [], ?string $component = null, ?string $action = null): Response
    {
        try {
            return Inertia::render($this->resolveComponent($component, $action), $data);
        } catch(ComponentResolutionException) {
            return abort(500);
        }
    }

    /**
     * Resolve a component.
     *
     * @param ?string $component
     * @param ?string $action
     * @return string
     * @throws ComponentResolutionException
     */
    private function resolveComponent(?string $component = null, ?string $action = null): string
    {
        if($component) {
            return $component;
        }

        // Get the method name that the call came from which is 4 calls back
        $action ??= get_calling_method_name(3);
        $reflection = new ReflectionClass($this);
        $attributes = $reflection->getAttributes(JsonModel::class);

        if($attributes) {
            /** @var JsonModel $attribute */
            $attribute = $attributes[0]->newInstance();
            $this->componentNamespace = $attribute->getComponentNamespace();

            if($component) {
                return $this->componentNamespace.$component;
            }

            return $this->componentNamespace.$this->resolveComponentName($attribute->getModelName(), $action);
        }

        throw new ComponentResolutionException('Cannot auto-resolve components without the JsonModel attribute.');
    }
}
