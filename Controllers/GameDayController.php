<?php
namespace App\Http\Controllers\Sport;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Player;
use App\Models\Team;
use DB;

class GameDayController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth'); //need to login for this controller
    }

    /**
     * Actions:
     * - showAllTeams
     * -- gets all teams and displays to user.  they will then be able to choose 2 teams for their game
     *
     * - showGameTeams
     * -- this page will display the 2 teams selected above and display them in 2 columns.
     * -- Each column has searchbox for player or player #
     *
     * - showPlayer
     * -- player searched by user to query and return results.
     * -- called via ajax to get that player info and return to the showGameTeams page
     */

    /*
     * Get list of all teams
     */
    public function showAllTeams(){
        $allTeams = Team::all()->sortBy('team_name');
        return view('sport.gameDay.allTeams',compact('allTeams'));
    }

    /*
     * Get info for both teams in game
     */
    public function showGameTeams($awayTeamId, $homeTeamId){
        $awayTeam = Team::with('setting')->find($awayTeamId);
        $homeTeam = Team::with('setting')->find($homeTeamId);

        return view('sport.gameDay.gameTeams', compact(['awayTeam', 'homeTeam'])); //may need to change view?
    }

    /**
     * Search player by their number or name on specific team
     */
    public function showPlayer($teamId, $playerStr){
        if (is_numeric($playerStr)){
            $results = (new Player)->detailsByNumber($teamId, $playerStr);
        }else{
            $results = (new Player)->detailsByName($teamId, $playerStr);
        }

        return response()->json($results);
    }
    
}
