<?php

namespace App\Http\Controllers\Api;

use App\Services\KeyMapper;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('api')]
class SearchController extends ApiController
{
    public function __construct(
       protected KeyMapper $keyMapper
    ) {}

    public function search(string $term): JsonResponse
    {

    }
}
