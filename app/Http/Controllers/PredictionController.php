<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Prediction;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PredictionController extends Controller
{
    public function index()
    {
        $predictions = Prediction::with(['player', 'game'])
            ->get();

        return Inertia::render('Predictions/index',
            [
                'predictions' => $predictions,
            ]
        );
    }

    public function create()
    {
        $games = Game::orderByDesc('date')
            ->orderByDesc('time')
            ->get()
            ->map(function (Game $game) {
                return [
                    'value' => $game->id,
                    'label' => $game->versus
                ];
            });

        $users = User::get()
            ->map(function (User $user) {
                return [
                    'value' => $user->id,
                    'label' => $user->name
                ];
            });

        return Inertia::render('Predictions/FormComponent', [
            'games' => $games,
            'users' => $users,
        ]);
    }

    public function store(Request $request)
    {
        Prediction::create($request->all());

        return \Redirect::route('predictions.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Prediction $prediction
     * @return \Illuminate\Http\Response
     */
    public function show(Prediction $prediction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Prediction $prediction
     * @return \Illuminate\Http\Response
     */
    public function edit(Prediction $prediction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Prediction $prediction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Prediction $prediction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Prediction $prediction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Prediction $prediction)
    {
        //
    }
}
