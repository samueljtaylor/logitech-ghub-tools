<?php

namespace App\Http\Controllers\Api;

use App\Services\KeyMapper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Group;
use Spatie\RouteAttributes\Attributes\Post;

#[Group(prefix: 'api/key', as: 'api.key.')]
class SearchController extends ApiController
{
    public function __construct(
       protected KeyMapper $keyMapper
    ) {}

    #[Post('search', name: 'search')]
    public function search(Request $request): JsonResponse
    {
        return $this->respond($this->keyMapper->search($request->get('query')));
    }

    #[Post('find', name: 'find')]
    public function find(Request $request): JsonResponse
    {
        return $this->respond($this->keyMapper->find($request->get('query')));
    }
}
