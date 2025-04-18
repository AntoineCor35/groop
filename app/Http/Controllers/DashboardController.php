<?php

namespace App\Http\Controllers;

use App\Services\OrganizationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $entities = OrganizationService::getUserEntities($user);
        $isAdmin = $user && ($user->is_admin || $user->admin || $user->role === 'admin');

        return view('dashboard', [
            'entities' => $entities,
            'isAdmin' => $isAdmin,
        ]);
    }
}
