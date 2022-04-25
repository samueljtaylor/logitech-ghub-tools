<?php

namespace App\Http\Controllers;

use App\JsonModels\Application;
use Inertia\Response;
use Spatie\RouteAttributes\Attributes\Resource;

#[Resource('application')]
class ApplicationController extends InertiaController
{
    public function index(): Response
    {
        return $this->render([
            'applications' => Application::all(),
        ]);
    }
}
