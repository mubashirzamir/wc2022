<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Team;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GameController extends Controller
{
    public function index()
    {
        $games = Game::with('homeTeam', 'awayTeam')
            ->orderBy('date')
            ->orderBy('time')
            ->get();

        return Inertia::render('Games/index', [
            'games' => $games,
        ]);
    }

    public function create()
    {
        return Inertia::render('Games/FormComponent', [
            'teams' => Team::selectForAntd(),
        ]);
    }

    public function store(Request $request)
    {
        Game::create($request->all());

        return \Redirect::route('games.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Game $game
     * @return \Illuminate\Http\Response
     */
    public function show(Game $game)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Game $game
     */
    public function edit(Game $game)
    {
        return Inertia::render('Games/FormComponent', [
            'teams' => Team::selectForAntd(),
            'game' => $game,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Game $game
     */
    public function update(Request $request, Game $game)
    {
        $game->update($request->only(Game::updatables()));

        return \Redirect::route('games.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Game $game
     * @return \Illuminate\Http\Response
     */
    public function destroy(Game $game)
    {
        //
    }
}
