<?php

namespace App\Http\Controllers;

use App\JsonModels\Card;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CardController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Models/Card/CardIndex', [
            'cards' => Card::all(),
        ]);
    }

    public function show(Card $card): Response
    {
        return Inertia::render('Models/Card/CardShow', [
            'card' => $card,
        ]);
    }
}
