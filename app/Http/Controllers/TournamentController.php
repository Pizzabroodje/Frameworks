<?php

namespace App\Http\Controllers;

use App\Tournament;
use App\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TournamentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currentTime = new DateTime();
        $tournaments = Tournament::all()->sortBy('start_time')->sort(function($tournament) use($currentTime){
            $endTime = new DateTime($tournament->end_time);
            if($endTime > $currentTime) {
                return 1;
            }
            return 2;
        });

        return view('tournaments', compact('tournaments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Request $id
     * @return void
     */
    public function show(Request $request)
    {
        $tournament = Tournament::find($request->id);
        $tournamentName = $tournament->name;
        $players = $tournament->users()->get();
        $amountOfPlayers = $players->count();
        $amountOfTables = (int)ceil($players->count()/4);
        $restplayers = $players->count()%4;


        if($amountOfPlayers > 8) {
            if ($restplayers == 1) {
                $amountOfReducedTables = 3;
            } elseif ($restplayers == 2) {
                $amountOfReducedTables = 2;
            } elseif ($restplayers == 3) {
                $amountOfReducedTables = 1;
            } else {
                $amountOfReducedTables = 0;
            }

            $tables = [];
            $tableNr = 1;

            for ($i = 1; $i <= $amountOfTables; $i++) {
                $tables[$i] = [];
            }
            $stopAtTableNr = $amountOfTables - $amountOfReducedTables;
            $i = 1;

            $playersOnTable = 1;

            foreach ($players as $player) {
                array_push($tables[$tableNr], $player);
                if ($amountOfPlayers == 9) {
                    if ($i == 3 || $i == 6) {
                        $tableNr++;
                    }
                } else {
                    if ($tableNr <= $stopAtTableNr) {
                        if (($i >= 4) && $playersOnTable == 4) {
                            $tableNr++;
                            $playersOnTable = 0;
                        }
                    } else {
                        if ($i >= 3 && $playersOnTable == 3) {
                            $tableNr++;
                            $playersOnTable = 0;
                        }
                    }
                }
                $playersOnTable++;
                $i++;
            }
        } else {
            $tables[1] = [];
            foreach ($players as $player) {
                array_push($tables[1], $player);
            }
        }

        return view('tables', compact('tables', 'tournamentName'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tournament  $tournament
     * @return \Illuminate\Http\Response
     */
    public function edit(Tournament $tournament)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tournament  $tournament
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tournament $tournament)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tournament  $tournament
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tournament $tournament)
    {
        //
    }

    public function sync(Request $request, $tournamentId)
    {
        $tournament = Tournament::findOrFail($tournamentId);
        $hasJoined = $tournament->users()->where('users.id', '=', Auth::id())->exists();

        if($hasJoined) {
            $tournament->users()->detach(Auth::id());
        } else {
            $tournament->users()->attach(Auth::id());
        }

        return redirect()->back();
    }
}
