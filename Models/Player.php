<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

/**
 * Class Player
 */
class Player extends Model
{
    protected $table = 'player';
    protected $primaryKey = 'player_id';
    public $timestamps = false;
    protected $guarded = [];
    protected $fillable = [
        'team_id',
        'player_num',
        'position',
        'name',
        'age',
        'height',
        'weight',
        'date_of_birth',
        'college'
    ];

    /**
     * Player belongs to a team.
     * Joining tables player and team
     */
    public function team(){
        return $this->belongsTo('App\Team')->get();
    }

    /**
     * Get player rec(s) where name is matched for this team
     * @param $teamId
     * @param $playerName
     * @return collection of team players or null
     */
    public function detailsByName($teamId, $playerName){
        try {
            return DB::table('player')->where([
                ['name', 'LIKE',  '%'.$playerName.'%'],
                ['team_id', $teamId]
            ])->orderBy('name')->get();

        } catch (Exception $e) {
            Logger::logError("<exception> Error: " . $e->getMessage());
        }
        return null;
    }

    /**
     * Get rec for specific player number on this team
     * @param $teamId
     * @param $playerNumber
     * @return Player object or null
     */
    public function detailsByNumber($teamId, $playerNumber){
        try {
            return DB::table('player')->where([
                ['player_num',$playerNumber],
                ['team_id', $teamId]
            ])->get();

        } catch (Exception $e) {
            Logger::logError("<exception> Error: " . $e->getMessage());
        }
        return null;
    }
}
