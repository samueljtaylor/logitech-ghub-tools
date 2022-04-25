<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\JsonModels\Card;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Prefix;
use Spatie\RouteAttributes\Attributes\Resource;

#[Prefix('api')]
#[Resource('card')]
class CardController extends Controller
{
    public function update(Card $card, Request $request): JsonResponse
    {
        $card->update($request->all());
        return new JsonResponse('Success');
    }
}
