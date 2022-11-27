<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        // Selecting only name and points was messing up the appended score_count and result_count attributes
        $users = User::get();

        $games = Game::with(['homeTeam', 'awayTeam'])
            ->whereDate('date', '=', Carbon::today())
            ->orderBy('date')
            ->orderBy('time')
            ->get();

        return Inertia::render('Dashboard', [
            'users' => $users,
            'games' => $games,
        ]);
    }
}
