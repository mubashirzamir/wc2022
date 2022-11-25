<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    protected $appends = ['score_line', 'versus'];

    public function homeTeam()
    {
        return $this->belongsTo('App\Models\Team', 'home_id');
    }

    public function awayTeam()
    {
        return $this->belongsTo('App\Models\Team', 'away_id');
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
            return $this->getHomeTeamName() . 'TBP' . $this->getAwayTeamName();
        }

        return $this->getHomeTeamName() . ' ' . $this->home_score . ' - ' . $this->away_score . ' ' . $this->getAwayTeamName();
    }

    public function getVersusAttribute()
    {
        return $this->getHomeTeamName() . ' vs ' . $this->getAwayTeamName();
    }
}
