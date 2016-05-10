<?php
namespace App\Http\Controllers\Sport;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Team;
use DB;

class TeamController extends Controller
{

    private $favoriteTeam = 'chiefs';

    public function __construct()
    {
        $this->middleware('auth'); //need to login for this controller
    }


    /**
     * Actions:
     * - showTeamById
     * -- gets all players on specific team.
     *
     * - teamSetting
     * -- joins to the setting table to return all team settings.`
     *
     * - allTeams
     * - default page to list all teams from db
     *
     * - showFavoriteTeam
     * - simple call to get team id by team name.
     *
     */


    /**
     * Gets all players on a specific team
     * @param null $teamId
     * @return mixed
     */
    public function showTeamById($teamId=null){
        if (!$teamId){
            return redirect('/allTeams');
        }

        $team = Team::with('allPlayers')->find($teamId);
        return view('sport.team.showTeamById', compact('team'));
    }

    /**
     * Get the settings for a specific team
     * @param $teamId
     */
    public function teamSetting($teamId){
        $team = Team::with('setting')->find($teamId);
        
        foreach($team->setting as $v){
            echo '<pre>';
            print_r($v->key);
            print_r($v->value);
            echo '</pre>';
        }
    }

    /**
     * Get collection of all teams
     * @return mixed
     */
    public function allTeams(){
        $allTeams = Team::all()->sortBy('team_name');
        return view('sport.team.allTeams',compact('allTeams'));
    }

    public function showFavoriteTeam($favoriteTeamName = null){
        if ($favoriteTeamName){
            $this->favoriteTeam = $favoriteTeamName;
        }
        $favorite = Team::where('team_name', '=', $this->favoriteTeam)
            ->orderBy('team_name', 'asc')
            ->take(1)
            ->get();

        //Redirect to the showTeamById
        return redirect('/team/'.$favorite[0]->team_id);
    }
}
