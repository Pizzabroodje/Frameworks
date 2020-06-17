@extends('layouts.app')
@php
use App\User;
use Illuminate\Support\Facades\Auth;
@endphp

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 text-center my-3">
                <h1>Alle tournamenten</h1>
            </div>
            <div class="list-group col-md-8">
                @php
                    $currentTime = new DateTime()
                @endphp
                @foreach($tournaments as $tournament)
                    <li class="list-group-item flex-column align-items-start">
                        <div class="d-flex w-100 justify-content-between">
                            <h4 class="mb-1">{{$tournament->name}}</h4>
                            @php
                                $startTime = new DateTime($tournament->start_time);
                                $endTime = new DateTime($tournament->end_time);
                            @endphp
                            <span class="ml-auto mr-1"><a class="btn btn-primary" href="{{route('tournaments.show', $tournament->id)}}">Tafelindeling</a></span>
                            <form action="{{route('tournaments.sync', $tournament->id)}}" method="post">
                                @csrf
                                <span>
                                    @if($currentTime < $startTime)
                                        @if($tournament->users()->where('users.id', '=', Auth::id())->exists())
                                            <button class="btn btn-danger" type="submit">Uitschrijven</button>
                                        @else
                                            <button class="btn btn-success" type="submit">Inschrijven</button>
                                        @endif
                                    @elseif($currentTime > $startTime && $currentTime < $endTime)
                                        <span><button class="btn btn-secondary" style="cursor: default;" disabled readonly>Gestart</button></span>
                                    @else
                                        <span><button class="btn btn-secondary" style="cursor: default;" disabled readonly>Afgelopen</button></span>
                                    @endif
                                </span>
                            </form>
{{--                            <p></p>--}}
                        </div>
                        <div class="col-12">
                            Start: {{\App\Tournament::dutchTimeString(strftime('%A %e %B %Y om %H:%M',strtotime($tournament->start_time)))}}
                        </div>
                        <div class="col-12">
                            Einde: {{\App\Tournament::dutchTimeString(strftime('%A %e %B %Y om %H:%M',strtotime($tournament->end_time)))}}
                        </div>
                    </li>
                @endforeach
            </div>
        </div>
    </div>
@endsection
