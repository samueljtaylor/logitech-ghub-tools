<?php

namespace App\Http\Controllers\Api;

use App\Repositories\FileRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Group;
use Spatie\RouteAttributes\Attributes\Post;

#[Group(prefix: 'api/repository', as: 'api.repository.')]
class RepositoryController extends ApiController
{
    public function __construct(
        protected FileRepository $repository
    ) {}

    #[Get('status', name: 'status')]
    public function status(): JsonResponse
    {
        return $this->respond($this->repository->status());
    }

    #[Get('settings', name: 'settings')]
    public function settings(): JsonResponse
    {
        return $this->respond($this->repository->settings()->collection());
    }

    #[Post('reload', name: 'reload')]
    public function reload(): JsonResponse
    {
        $this->repository->reload();
        return $this->respond('Reloaded');
    }

    #[Post('save', name: 'save')]
    public function save(): JsonResponse
    {
        return $this->repository->write() ? $this->respond('Success') : $this->respond('Failed', 500);
    }
}
