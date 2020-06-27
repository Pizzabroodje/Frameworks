<?php

namespace App\Http\Controllers;

use App\Tournament;
use App\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TournamentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
    }

    //show all tournaments
    public function index()
    {
        //get the current time
        $currentTime = new DateTime();

        //get all tournaments, sort them by start_time, and put the tournaments that are over at the end of the list
        $tournaments = Tournament::all()->sortBy('start_time')->sort(function($tournament) use($currentTime){
            $endTime = new DateTime($tournament->end_time);
            if($endTime > $currentTime) {
                return 1;
            }
            return 2;
        });

        //return the view and pass the tournaments
        return view('tournaments', compact('tournaments'));
    }

    //show all tables of a tournament
    public function show(Request $request)
    {
        //get the tournament
        $tournament = Tournament::find($request->id);
        //get the tournament name
        $tournamentName = $tournament->name;
        //get all players of the tournament
        $players = $tournament->users()->get();
        //get the amount of players in the tournament
        $amountOfPlayers = $players->count();
        //calculate the amount of tables needed
        $amountOfTables = (int)ceil($players->count()/4);
        //count how many players can't be divided into a table of 4
        $restplayers = $players->count()%4;

        //If there are more then 8 players
        if($amountOfPlayers > 8) {
            //Calculate how many tables need to be reduced to 3 players
            if ($restplayers == 1) {
                $amountOfReducedTables = 3;
            } elseif ($restplayers == 2) {
                $amountOfReducedTables = 2;
            } elseif ($restplayers == 3) {
                $amountOfReducedTables = 1;
            } else {
                $amountOfReducedTables = 0;
            }

            //initialize the array for the tables
            $tables = [];
            //for each table initialize an empty array within the tables array
            for ($i = 1; $i <= $amountOfTables; $i++) {
                $tables[$i] = [];
            }

            //calculate at which table to stop putting 4 people in that table
            $stopAtTableNr = $amountOfTables - $amountOfReducedTables;

            $i = 1;
            $playersOnTable = 1;
            $tableNr = 1;

            //loop through the players
            foreach ($players as $player) {
                //put the player in a table
                array_push($tables[$tableNr], $player);

                //if there's 9 players
                if ($amountOfPlayers == 9) {
                    //and the current player count is dividable by 3
                    if ($i % 3 == 0) {
                        //go to the next table
                        $tableNr++;
                    }
                //if there's more than 9 players
                } else {
                    //if the current table should contain 4 players
                    if ($tableNr <= $stopAtTableNr) {
                        //if there's more then 4 players in total and there's 4 players in the current table
                        if (($i >= 4) && $playersOnTable == 4) {
                            //add a table and reset the count for te amount of players on the table
                            $tableNr++;
                            $playersOnTable = 0;
                        }
                    //if the current table should contain 3 players
                    } else {
                        //if there's more then 3 players in total and there's 3 players in the current table
                        if ($i >= 3 && $playersOnTable == 3) {
                            //add a table and reset the count for te amount of players on the table
                            $tableNr++;
                            $playersOnTable = 0;
                        }
                    }
                }
                //add 1 to the count of the amount of players on the current table
                $playersOnTable++;
                $i++;
            }
        //if there's 8 players or less in the tournament
        } else {
            //initialize 1 table
            $tables[1] = [];

            //put all players in that table
            foreach ($players as $player) {
                array_push($tables[1], $player);
            }
        }

        //return the view of the tables and pass the array with the table layout
        return view('tables', compact('tables', 'tournamentName'));
    }

    //register or unregister a player for a tournament
    public function sync(Request $request, $tournamentId)
    {
        //get the tournament
        $tournament = Tournament::findOrFail($tournamentId);

        //check if the user has already registered for the tournament
        $hasJoined = $tournament->users()->where('users.id', '=', Auth::id())->exists();

        //get the current time
        $currentTime = new DateTime();

        //get the start time of the tournament
        $startTime = new DateTime($tournament->start_time);

        //if the tournament hasn't started yet
        if($currentTime < $startTime) {
            //if he is registered to the tournament
            if ($hasJoined) {
                //remove the user from the tournament
                $tournament->users()->detach(Auth::id());
            //if he isn't registered to the tournament
            } else {
                //add the user to the tournament
                $tournament->users()->attach(Auth::id());
            }
        //if the tournament has started throw an error
        } else {
            abort('404');
        }

        //return back
        return redirect()->back();
    }

    //convert an English time-string to a Dutch time-string
    public static function dutchTimeString($time) {

        //all the days and there translations
        $days = array(
            "monday"   => "Maandag",
            "tuesday"   => "Dinsdag",
            "wednesday"  => "Woensdag",
            "thursday" => "Donderdag",
            "friday"   => "Vrijdag",
            "saturday"  => "Zaterdag",
            "sunday"    => "Zondag"
        );

        //all the months and there translations
        $months = array(
            "january"   => "Januari",
            "february"  => "Februari",
            "march"     => "Maart",
            "april"     => "April",
            "may"       => "Mei",
            "june"      => "Juni",
            "july"      => "Juli",
            "august"  => "Augustus",
            "september" => "September",
            "october"   => "Oktober",
            "november"  => "November",
            "december"  => "December"
        );

        //divide the time-string by spaces
        $array = explode(" ", $time);
        //replace the day
        $array[0] = $days[strtolower($array[0])];
        //replace the month
        $array[2] = $months[strtolower($array[2])];

        //reattach all the parts of the time-string and return that
        return (implode(" ", $array));
    }
}
