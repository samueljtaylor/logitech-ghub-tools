<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\KeyMapper;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('api')]
class SearchController extends Controller
{
    public function __construct(
       protected KeyMapper $keyMapper
    ) {}


}
