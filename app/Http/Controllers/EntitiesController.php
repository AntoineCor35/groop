<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entities;

class EntitiesController extends Controller
{
    public function index()
    {
        // Chargement des entités avec leurs promotions et les groupes de chaque promotion
        $entities = Entities::with(['promotions' => function ($query) {
            $query->with('groups');
        }])->get();

        return view('dashboard', compact('entities'));
    }
}
