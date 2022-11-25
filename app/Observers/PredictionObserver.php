<?php

namespace App\Observers;

use App\Models\Prediction;

class PredictionObserver
{
    /**
     * Handle the Prediction "created" event.
     *
     * @param \App\Models\Prediction $prediction
     * @return void
     */
    public function created(Prediction $prediction)
    {
        // Eventually will prevent players to create and update predictions after the game
        // The logic below is responsible for updating prediction and user points when a prediction is created.
        $game = $prediction->game()->first();
        if ($game->result !== null) {
            if ($game->result === $prediction->result) {
                $prediction->result_points = 1;
                if ($game->home_score === $prediction->home_score && $game->away_score === $prediction->away_score) {
                    $prediction->score_points = 2;
                }
            }
            $prediction->points = $prediction->score_points + $prediction->result_points;

            $user = $prediction->user()->first();
            $user->points += $prediction->points;

            $user->saveQuietly();
            $prediction->saveQuietly();
        }

    }

    /**
     * Handle the Prediction "updated" event.
     *
     * @param \App\Models\Prediction $prediction
     * @return void
     */
    public function updated(Prediction $prediction)
    {
        //
    }

    /**
     * Handle the Prediction "deleted" event.
     *
     * @param \App\Models\Prediction $prediction
     * @return void
     */
    public function deleted(Prediction $prediction)
    {
        //
    }

    /**
     * Handle the Prediction "restored" event.
     *
     * @param \App\Models\Prediction $prediction
     * @return void
     */
    public function restored(Prediction $prediction)
    {
        //
    }

    /**
     * Handle the Prediction "force deleted" event.
     *
     * @param \App\Models\Prediction $prediction
     * @return void
     */
    public function forceDeleted(Prediction $prediction)
    {
        //
    }
}
