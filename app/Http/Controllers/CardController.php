<?php

namespace App\Http\Controllers;

use App\JsonModels\Card;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\RouteAttributes\Attributes\Resource;

#[Resource('card')]
class CardController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('Models/Card/CardIndex', [
            'grouped' => Card::query()->groupBy($request->get('groupBy') ?? 'category'),
        ]);
    }

    public function show(Card $card): Response
    {
        return Inertia::render('Models/Card/CardShow', [
            'card' => $card,
        ]);
    }
}
