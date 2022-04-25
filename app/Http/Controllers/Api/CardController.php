<?php

namespace App\Http\Controllers\Api;

use App\Attributes\JsonModel;
use App\JsonModels\Card;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Group;
use Spatie\RouteAttributes\Attributes\Put;
use Spatie\RouteAttributes\Attributes\Resource;

#[Group(prefix: 'api', as: 'api.')]
#[JsonModel(Card::class)]
class CardController extends ApiController
{
    #[Put('card/{card}', name: 'card.update')]
    public function update(Card $card, Request $request): JsonResponse
    {
        $card->update($request->all());
        return $this->respond('Success');
    }
}
