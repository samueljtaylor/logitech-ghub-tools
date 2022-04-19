<?php

namespace App\Http\Controllers\Api;

use App\Contracts\JsonFileRepositoryContract;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class RepositoryController extends Controller
{
    protected JsonFileRepositoryContract $repository;

    public function __construct(JsonFileRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    public function lastUpdated(Request $request): JsonResponse
    {
        $carbon = $this->repository->lastUpdated();

        if($request->has('format')) {
            if($request->get('format') === 'diffForHumans') {
                return new JsonResponse($carbon->diffForHumans());
            }

            try {
                return new JsonResponse($carbon->format($request->get('format')));
            } catch (\Exception) {

            }
        }

        return new JsonResponse($carbon);
    }

    public function hasChanged(): JsonResponse
    {
        return new JsonResponse($this->repository->hasChanged());
    }

    public function settings(): JsonResponse
    {
        return new JsonResponse($this->repository->settings()->collection());
    }

    public function reload(): JsonResponse
    {
        $this->repository->reload();
        return new JsonResponse('Reloaded');
    }
}
