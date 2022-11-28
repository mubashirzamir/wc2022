<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpKernel\Exception\PreconditionFailedHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * App\Models\Prediction
 *
 * @property int $id
 * @property int $user_id
 * @property int $game_id
 * @property int $home_score
 * @property int $away_score
 * @property string $result
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Prediction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Prediction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Prediction query()
 * @method static \Illuminate\Database\Eloquent\Builder|Prediction whereAwayScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prediction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prediction whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prediction whereHomeScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prediction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prediction whereResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prediction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prediction whereUserId($value)
 * @mixin \Eloquent
 */
class Prediction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'game_id',
        'home_score',
        'away_score',
        'result',
    ];

    public static function updatables()
    {
        return [
            'home_score',
            'away_score',
            'result',
        ];
    }

    protected $appends = ['points', 'predicted_score_line'];

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function game()
    {
        return $this->hasOne('App\Models\Game', 'id', 'game_id');
    }

    public function getPointsAttribute()
    {
        return $this->result_points + $this->score_points;
    }

    public function getPredictedScoreLineAttribute()
    {
        return $this->game()->first()->getHomeTeamName() . ' ' . $this->home_score . ' - ' . $this->away_score . ' ' . $this->game()->first()->getAwayTeamName();
    }

    // Common functions should eventually be stored appropriately
    public static function commonPointsUpdateLogic($updating, User $user, Prediction $prediction, Game $game)
    {
        if ($updating) {
            $prediction->result_points = 0;
            $prediction->score_points = 0;
        }

        if ($game->result === $prediction->result) {
            $prediction->result_points = 1;
        }

        if ($game->home_score === $prediction->home_score && $game->away_score === $prediction->away_score) {
            $prediction->score_points = 2;
        }

        $user->saveQuietly();
        $prediction->saveQuietly();
    }

    public static function preventTardiness(Game $game)
    {
//        if (Carbon::now()->gt($game->getCarbonInstance()) && \Auth::user()->is_admin === false) {
//            throw new PreconditionFailedHttpException('Cannot change predictions for matches which have started/finished.');
//        }
    }

    // Common functions should eventually be stored appropriately
    // This logic should also be applied on the frontend
    public static function commonValidateWinLogic($obj)
    {
        if (($obj->home_score > $obj->away_score && $obj->result !== 'h') ||
            ($obj->home_score < $obj->away_score && $obj->result !== 'a')) {
            throw new PreconditionFailedHttpException('Result does not match score.');
        }
    }

    public static function uniqueCompositeKey(Prediction $prediction)
    {
        $exists = Prediction::where('user_id', '=', $prediction->user_id)
            ->where('game_id', '=', $prediction->game_id)
            ->exists();

        if ($exists) {
            throw new UnprocessableEntityHttpException('Prediction for this game already exists.');
        }
    }
}
