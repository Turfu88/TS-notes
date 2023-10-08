<?php

namespace App\Http\Controllers;

use Inertia\Response;

class AppController {
    public function index(): Response
    {
        return inertia('Index', [
            'title' => 'Accueil',
        ]);
    }

    public function login(): Response
    {
        return inertia('Login', [
            'title' => 'Login',
        ]);
    }

    public function subscribe(): Response
    {
        return inertia('Subscribe', [
            'title' => 'Inscription',
        ]);
    }
}
