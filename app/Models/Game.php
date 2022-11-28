<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * App\Models\Game
 *
 * @property int $id
 * @property string $date
 * @property string $time
 * @property int $home_id
 * @property int|null $home_score
 * @property int $away_id
 * @property int|null $away_score
 * @property string|null $result
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Game newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Game newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Game query()
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereAwayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereAwayScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereHomeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereHomeScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'time',
        'home_id',
        'home_score',
        'away_id',
        'away_score',
        'result',
    ];

    public static function updatables()
    {
        return [
            'date',
            'time',
            'home_score',
            'away_score',
            'result',
        ];
    }

    protected $appends = ['score_line', 'versus', 'date_formatted'];

    public function homeTeam()
    {
        return $this->belongsTo('App\Models\Team', 'home_id');
    }

    public function awayTeam()
    {
        return $this->belongsTo('App\Models\Team', 'away_id');
    }

    public function predictions()
    {
        return $this->hasMany('App\Models\Prediction', 'game_id', 'id');
    }

    public function getHomeTeamName()
    {
        return $this->homeTeam()->first()->name;
    }

    public function getAwayTeamName()
    {
        return $this->awayTeam()->first()->name;
    }

    public function getScoreLineAttribute()
    {
        if ($this->home_score === null || $this->away_score === null) {
            return $this->versus;
        }

        return $this->getHomeTeamName() . ' ' . $this->home_score . ' - ' . $this->away_score . ' ' . $this->getAwayTeamName();
    }

    public function getVersusAttribute()
    {
        return $this->getHomeTeamName() . ' vs ' . $this->getAwayTeamName();
    }

    public function getDateFormattedAttribute()
    {
        return Carbon::parse($this->date)->format('d-M-Y');
    }

    // Should be cached
    public static function selectForAntd()
    {
        return self::orderByDesc('date')
            ->get()
            ->map(function (Game $game) {
                return [
                    'value' => $game->id,
                    'label' => $game->versus . ', ' . Carbon::parse($game->date)->format('d-M-Y'),
                ];
            });
    }

    public static function uniqueCompositeKey(Game $game)
    {
        $exists = Game::where('home_id', '=', $game->home_id)
            ->where('away_id', '=', $game->away_id)
            ->whereDate('date', '=', $game->date)
            ->exists();

        if ($exists || $game->home_id === $game->away_id) {
            throw new UnprocessableEntityHttpException('Game already exists or invalid game.');
        }
    }

    public function getCarbonInstance()
    {
        return Carbon::parse($this->date . ' ' . $this->time, 'Asia/Karachi');
    }
}
