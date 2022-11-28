<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Prediction;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PredictionController extends Controller
{
    public function index(Request $request)
    {
        $predictions = Prediction::with(['user', 'game'])
            ->when($request->has('user_id'), function ($builder) use ($request) {
                $builder->where('user_id', '=', $request->get('user_id'));
            })
            ->when($request->has('game_id'), function ($builder) use ($request) {
                $builder->where('game_id', '=', $request->get('game_id'));
            })
            ->orderByDesc('created_at')
            ->get();

        return Inertia::render('Predictions/index',
            [
                'predictions' => $predictions,
                'users' => User::filterForAntd()
            ]
        );
    }

    public function create()
    {
        return Inertia::render('Predictions/FormComponent', [
            'games' => Game::selectForAntd(),
            'users' => User::selectForAntd(),
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
     */
    public function edit(Prediction $prediction)
    {
        return Inertia::render('Predictions/FormComponent', [
            'games' => Game::selectForAntd(),
            'users' => User::selectForAntd(),
            'prediction' => $prediction
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Prediction $prediction
     */
    public function update(Request $request, Prediction $prediction)
    {
        $prediction->update($request->only(Prediction::updatables()));

        return \Redirect::route('predictions.index');
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
