<?php

namespace App\Http\Controllers;

use Inertia\Response;
use Spatie\RouteAttributes\Attributes\Get;

class DashboardController extends InertiaController
{
    #[Get('dashboard', name: 'dashboard')]
    public function show(): Response
    {
        return $this->render(component: 'Dashboard');
    }
}
