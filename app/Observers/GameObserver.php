<?php

namespace App\Observers;

use App\Models\Game;
use App\Models\Prediction;

class GameObserver
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
     * Handle the Game "created" event.
     *
     * @param \App\Models\Game $game
     * @return void
     */
    public function created(Game $game)
    {
        $this->updatePoints($game);
    }

    /**
     * Handle the Game "updating" event.
     *
     * @param \App\Models\Game $game
     * @return void
     */
    public function updating(Game $game)
    {
        Prediction::commonValidateWinLogic($game);
        $this->updatePoints($game, true);
    }

    /**
     * Handle the Game "updated" event.
     *
     * @param \App\Models\Game $game
     * @return void
     */
    public function updated(Game $game)
    {
        //
    }

    /**
     * Handle the Game "deleted" event.
     *
     * @param \App\Models\Game $game
     * @return void
     */
    public function deleted(Game $game)
    {
        //
    }

    /**
     * Handle the Game "restored" event.
     *
     * @param \App\Models\Game $game
     * @return void
     */
    public function restored(Game $game)
    {
        //
    }

    /**
     * Handle the Game "force deleted" event.
     *
     * @param \App\Models\Game $game
     * @return void
     */
    public function forceDeleted(Game $game)
    {
        //
    }

    private function updatePoints(Game $game, $updating = false)
    {
        if ($game->result !== null) {
            $game->predictions()
                ->get()
                ->each(function (Prediction $prediction) use ($game, $updating) {
                    $user = $prediction->user()->first();
                    Prediction::commonPointsUpdateLogic($updating, $user, $prediction, $game);
                });
        }
    }
}
