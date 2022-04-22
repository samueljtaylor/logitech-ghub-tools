<?php

namespace App\Providers;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\ClassString;
use phpDocumentor\Reflection\Types\Object_;

class CollectionMacroServiceProvider extends ServiceProvider
{
    /**
     * Which macros to include.
     *
     * @var array
     */
    protected array $include = ['*'];

    /**
     * Which macros to exclude.
     *
     * @var array
     */
    protected array $exclude = [];

    /**
     * Macros.
     *
     * @var Collection<ClassString, Object_>
     */
    protected Collection $macros;

    /**
     * @inheritDoc
     */
    public function register()
    {
        $this->macros()->each(fn ($macro, $name) => Collection::macro($name, $macro()));
    }

    /**
     * Get a list of all classes in macros namespace.
     *
     * @return Collection
     */
    protected function getClassListing(): Collection
    {
        $listing = new Collection();
        $namespace = 'App\\Collections\\Macros\\';

        foreach(glob(app_path(implode(DIRECTORY_SEPARATOR, ['Collections', 'Macros', '*.php']))) as $file) {
            $listing->push($namespace.Str::replace('.php', '', class_basename($file)));
        }

        return $listing;
    }

    /**
     * Should be included.
     *
     * @param string $class
     * @return bool
     */
    protected function shouldInclude(string $class): bool
    {
        return in_array($class, $this->include) || in_array('*', $this->include);
    }

    /**
     * Should be excluded.
     *
     * @param string $class
     * @return bool
     */
    protected function shouldExclude(string $class): bool
    {
        return in_array($class, $this->exclude);
    }

    /**
     * Should macro be added.
     *
     * @param string $class
     * @return bool
     */
    protected function shouldAdd(string $class): bool
    {
        return $this->shouldInclude($class) && !$this->shouldExclude($class);
    }

    /**
     * Build the macro list.
     *
     * @return Collection
     * @throws BindingResolutionException
     */
    protected function buildMacroList(): Collection
    {
        $macros = new Collection();

        foreach($this->getClassListing() as $class) {
            if($this->shouldAdd($class)) {
                $macros->put(Str::camel(class_basename($class)), $this->app->make($class));
            }
        }

        return $macros;
    }

    /**
     * Get the macro list.
     *
     * @return Collection
     */
    public function macros(): Collection
    {
        $this->macros ??= $this->buildMacroList();
        return $this->macros;
    }
}
