<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

/**
 * Class Team
 */
class Team extends Model
{
    protected $table = 'team';
    protected $primaryKey = 'team_id';
    public $timestamps = false;
    protected $guarded = [];
    protected $fillable = [
        'team_city',
        'team_name',
        'head_coach'
    ];

   /**
   * Get all players on a team
   * Joining tables team and setting 
   */
    public function setting() {
        return $this->hasMany(TeamSetting::class);
    }

   /**
   * Get all players on a team
   * Joining tables team and player 
   */
    public function allPlayers(){
        return $this->hasMany(Player::class);
    }

   /**
   * Get specific player on a team
   * Joining tables team and player 
   */
    public function player($playerId){
        return $this->hasOne(Player::class)->find($playerId);
    }



//    Save for future use
//    public function myTeam(){
//        return DB::table('team')
//            ->join('team_setting', function($join){
//                $join->on('team_setting.team_id', '=', 'team.team_id')
//                    ->where('team.team_name', '=', $this->favoriteTeam);
//            })
//            ->get();
//    }        
}
