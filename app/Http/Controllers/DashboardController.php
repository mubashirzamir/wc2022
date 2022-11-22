<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::select(['name', 'points'])->orderByDesc('points')->get();
        $games = Game::with(['homeTeam', 'awayTeam'])
            ->orderBy('date')
            ->orderBy('time')
            ->get();

        return Inertia::render('Dashboard',
            [
                'users' => $users,
                'games' => $games,
            ]
        );
    }
}
