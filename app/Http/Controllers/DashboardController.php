<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Spatie\RouteAttributes\Attributes\Get;

class DashboardController extends Controller
{
    #[Get('dashboard', name: 'dashboard')]
    public function show(): Response
    {
        return Inertia::render('Dashboard');
    }
}
