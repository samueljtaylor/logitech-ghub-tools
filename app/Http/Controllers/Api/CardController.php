<?php

namespace App\Http\Controllers\Api;

use App\JsonModels\Card;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CardController
{
    public function update(Card $card, Request $request): JsonResponse
    {
        $card->update($request->all());
        return new JsonResponse('Success');
    }
}
