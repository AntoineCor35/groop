<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entities;
use Illuminate\Support\Facades\Auth;
use App\Services\OrganizationService;

class EntitiesController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $entities = OrganizationService::getUserEntities($user);

        return view('dashboard', compact('entities'));
    }
}
