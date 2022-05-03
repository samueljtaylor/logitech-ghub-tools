<?php

namespace App\Http\Controllers;

use App\Attributes\JsonModel;
use App\Collections\SettingsCollection;
use App\JsonModels\Card;
use Illuminate\Http\RedirectResponse;
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

    public function create(Request $request): Response
    {
        if($request->has('category')) {
            $attributes = ['category' => $request->get('category')];
        }

        $card = Card::newWithDefaults($attributes ?? []);
        return $this->render(compact('card'));
    }

    public function store(Request $request): RedirectResponse
    {
        $card = Card::createFromJson($request->get('card'));
        return redirect()->route('card.show', $card)->with('message', 'Card created successfully!');
    }

    public function destroy(Card $card): RedirectResponse
    {
        $card->delete();
        return redirect()->route('card.index')->with('message', 'Card deleted successfully!');
    }
}
