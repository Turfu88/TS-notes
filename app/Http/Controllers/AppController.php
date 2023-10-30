<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Inertia\Response;
use Illuminate\Http\Request;

class AppController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:api', ['except' => ['index','login','register']]);
    }

    public function index(): Response
    {
        return inertia('Index', [
            'title' => 'TS notes',
        ]);
    }

    public function login(): Response
    {
        return inertia('Login', [
            'title' => 'Login page'
        ]);
    }

    public function register(): Response
    {
        return inertia('Register', [
            'title' => 'Register page'
        ]);
    }

    public function dashboard(): Response
    {
        return inertia('Dashboard', [
            'title' => 'Dashboard page'
        ]);
    }

    public function parameters(): Response
    {
        return inertia('Parameters', [
            'title' => 'Paramètres'
        ]);
    }

    public function logout()
    {
        Session::flush();
        return redirect('/connexion');
    }
}
