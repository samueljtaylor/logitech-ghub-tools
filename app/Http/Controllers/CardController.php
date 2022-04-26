<?php

namespace App\Http\Controllers;

use App\Attributes\JsonModel;
use App\JsonModels\Card;
use Illuminate\Http\Request;
use Inertia\Response;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Resource;

#[Resource('card')]
#[JsonModel(Card::class)]
class CardController extends InertiaController
{
//    #[Get('card', name: 'card.index')]
    public function index(Request $request): Response
    {
        return $this->render([
            'grouped' => Card::query()->groupBy($request->get('groupBy') ?? 'category'),
        ]);
    }

    // We need to explicitly declare the GET route because the Resource attribute
    // doesn't seem to work with resolving route model binds.
    #[Get('card/{card}', name: 'card.show')]
    public function show(Card $card): Response
    {
        return $this->render(compact('card'));
    }

}
