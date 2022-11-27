<?php

namespace App\Observers;

use App\Models\Prediction;

class PredictionObserver
{
    /**
     * Handle the Prediction "creating" event.
     *
     * @param \App\Models\Prediction $prediction
     * @return void
     */
    public function creating(Prediction $prediction)
    {
        Prediction::commonValidateWinLogic($prediction);
    }
    /**
     * Handle the Prediction "created" event.
     *
     * @param \App\Models\Prediction $prediction
     * @return void
     */
    public function created(Prediction $prediction)
    {
        $this->updatePoints($prediction);
    }

    /**
     * Handle the Prediction "updated" event.
     *
     * @param \App\Models\Prediction $prediction
     * @return void
     */
    public function updating(Prediction $prediction)
    {
        Prediction::commonValidateWinLogic($prediction);
        $this->updatePoints($prediction, true);
    }

    /**
     * Handle the Prediction "updated" event.
     *
     * @param \App\Models\Prediction $prediction
     * @return void
     */
    public function updated(Prediction $prediction)
    {

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

    private function updatePoints(Prediction $prediction, $updating = false)
    {
        // Eventually will prevent players to create and update predictions after the game
        // The logic below is responsible for updating prediction and user points when a prediction is created/updated
        $game = $prediction->game()->first();
        $user = $prediction->user()->first();

        if ($game->result !== null) {
            Prediction::commonPointsUpdateLogic($updating, $user, $prediction, $game);
        }
    }
}
