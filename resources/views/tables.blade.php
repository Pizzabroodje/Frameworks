@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-around">
            <div class="col-12 text-center my-3">
                <h1>Tafelindeling {{$tournamentName}}</h1>
            </div>
            @if(!empty($tables[1]))
                @for($i = 1; $i <= count($tables); $i++)
                    <div class="col-4">
                        <div class="row justify-content-center">
                            <div class="col-auto">
                                <h2 style="text-align: center">Tafel {{$i}}</h2>
                                <table class="table table-responsive">
                                    <thead>
                                        <tr>
                                            <th>Spelersnr.</th>
                                            <th>Naam</th>
                                        </tr>
                                    </thead>
                                    @foreach($tables[$i] as $player)
                                        <tbody>
                                            <tr>
                                                <th scope="row">{{$player->id}}</th>
                                                <td>{{$player->name}}</td>
                                            </tr>
                                        </tbody>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                @endfor
            @else
                <div class="alert alert-danger">
                    Er staan geen spelers ingeschreven voor dit tournament!
                </div>
            @endif
        </div>
    </div>
@endsection
