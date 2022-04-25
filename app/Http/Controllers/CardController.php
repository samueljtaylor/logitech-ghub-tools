<?php

namespace App\Http\Controllers;

use App\Attributes\JsonModel;
use App\JsonModels\Card;
use Illuminate\Http\Request;
use Inertia\Response;
use Spatie\RouteAttributes\Attributes\Resource;

#[Resource('card')]
#[JsonModel(Card::class)]
class CardController extends InertiaController
{
    public function index(Request $request): Response
    {
        return $this->render([
            'grouped' => Card::query()->groupBy($request->get('groupBy') ?? 'category'),
        ]);
    }

    public function show(Card $card): Response
    {
        return $this->render(compact('card'));
    }

}
