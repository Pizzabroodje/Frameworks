@extends('layouts.app')
@php
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TournamentController;
@endphp

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 text-center mt-4 mb-2">
                <h1 style="color: #ffffff">Alle tournamenten</h1>
            </div>
            <div class="list-group col-lg-8">
                @php
                    $currentTime = new DateTime()
                @endphp
                @forelse($tournaments as $tournament)
                    <li class="list-group-item flex-column align-items-start" style="background-color: #E1E1E1">
                        <div class="row col-12">
                            <h3 class="mb-1 col-12">{{$tournament->name}}</h3>
                            @php
                                $startTime = new DateTime($tournament->start_time);
                                $endTime = new DateTime($tournament->end_time);
                            @endphp
                            <div class="col-12">
                                Start: {{TournamentController::dutchTimeString(strftime('%A %e %B %Y om %H:%M',strtotime($tournament->start_time)))}}
                            </div>
                            <div class="col-12">
                                Einde: {{TournamentController::dutchTimeString(strftime('%A %e %B %Y om %H:%M',strtotime($tournament->end_time)))}}
                            </div>
                            <div class="ml-auto">
                                <div class="row justify-content-end">
                                    <span class="ml-auto mr-1 mt-1"><a class="btn btn-primary" href="{{route('tournaments.show', $tournament->id)}}">Tafelindeling</a></span>
                                    <form action="{{route('tournaments.sync', $tournament->id)}}" method="post">
                                        @csrf
                                        <span>
                                            @if($currentTime < $startTime)
                                                @if($tournament->users()->where('users.id', '=', Auth::id())->exists())
                                                    <button class="btn btn-danger mt-1" type="submit">Uitschrijven</button>
                                                @else
                                                    <button class="btn btn-success mt-1" type="submit">Inschrijven</button>
                                                @endif
                                            @elseif($currentTime > $startTime && $currentTime < $endTime)
                                                <span><button class="btn btn-secondary mt-1" style="cursor: default;" disabled readonly>Gestart</button></span>
                                            @else
                                                <span><button class="btn btn-secondary mt-1" style="cursor: default;" disabled readonly>Afgelopen</button></span>
                                            @endif
                                        </span>
                                    </form>
                                </div>
                            </div>
{{--                            <p></p>--}}
                        </div>

                    </li>
                @empty
                    <div class="alert alert-danger">
                        Er zijn nog geen tournamenten!
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
