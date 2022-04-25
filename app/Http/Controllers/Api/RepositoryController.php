<?php

namespace App\Http\Controllers\Api;

use App\Repositories\FileRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Group;

#[Group(prefix: 'api/repository', as: 'api.repository.')]
class RepositoryController extends ApiController
{
    public function __construct(
        protected FileRepository $repository
    ) {}

    #[Get('lastUpdated', name: 'lastUpdated')]
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

    #[Get('hasChanged', name: 'hasChanged')]
    public function hasChanged(): JsonResponse
    {
        return new JsonResponse($this->repository->hasChanged());
    }

    #[Get('settings', name: 'settings')]
    public function settings(): JsonResponse
    {
        return new JsonResponse($this->repository->settings()->collection());
    }

    #[Get('reload', name: 'reload')]
    public function reload(): JsonResponse
    {
        $this->repository->reload();
        return new JsonResponse('Reloaded');
    }
}
