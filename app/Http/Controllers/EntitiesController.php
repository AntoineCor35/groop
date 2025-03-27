<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EntitiesController extends Controller
{
    public function index()
    {
        // Les composants Livewire s'occuperont de la récupération des données
        return view('dashboard');
    }
}
