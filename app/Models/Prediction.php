<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'score_points',
        'result_points',
    ];

    protected $appends = ['predicted_score_line'];

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function game()
    {
        return $this->hasOne('App\Models\Game', 'id', 'game_id');
    }

    public function getPredictedScoreLineAttribute()
    {
        return $this->game()->first()->getHomeTeamName() . ' ' . $this->home_score . ' - ' . $this->away_score . ' ' . $this->game()->first()->getAwayTeamName();
    }

    public static function commonPointsUpdateLogic($updating, User $user, Prediction $prediction, Game $game)
    {
        if ($updating) {
            $user->points -= $prediction->points;
        }

        if ($game->result === $prediction->result) {
            $prediction->result_points = 1;
            if ($game->home_score === $prediction->home_score && $game->away_score === $prediction->away_score) {
                $prediction->score_points = 2;
            }
        }

        $prediction->points = $prediction->score_points + $prediction->result_points;
        $user->points += $prediction->points;

        $user->saveQuietly();
        $prediction->saveQuietly();
    }
}
