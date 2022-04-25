<?php

namespace App\Http\Controllers;

use App\JsonModels\Application;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\RouteAttributes\Attributes\Resource;

#[Resource('application')]
class ApplicationController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Models/Application/ApplicationIndex', [
            'applications' => Application::all(),
        ]);
    }
}
