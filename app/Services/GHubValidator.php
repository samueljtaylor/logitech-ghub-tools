<?php

namespace App\Services;

class GHubValidator
{
    /**
     * Convert these keys from empty arrays to empty objects.
     *
     * @var array
     */
    protected array $forceObjects = [
        'arx_control_authentication',
    ];

    protected string $validatedJson;

    public function __construct(
       protected string $json
    ) {
        $this->validate();
    }

    protected function validate(): void
    {
        $this->validatedJson = $this->json;
        $this->replaceForcedObjects();
    }

    protected function replaceForcedObjects(): void
    {
        foreach($this->forceObjects as $key) {
            $this->validatedJson = str_replace('"'.$key.'": [],', '"'.$key.'": {},', $this->validatedJson);
            $this->validatedJson = str_replace('"'.$key.'":[],', '"'.$key.'":{},', $this->validatedJson);
        }
    }

    public function isValid(): bool
    {
        return $this->json === $this->validatedJson;
    }

    public function getOriginal(): string
    {
        return $this->json;
    }

    public function getJson(): string
    {
        return $this->validatedJson;
    }

    public function __toString(): string
    {
        return $this->getJson();
    }
}
