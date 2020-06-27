@extends('layouts.app')

@section('head')
    <link href="{{asset('css/print.css')}}" rel="stylesheet" />
@endsection

@section('content')
    <div class="container bg-light mt-sm-4" id="printableArea">

        <div class="row col-12 justify-content-around">
            <div class="row col-12 my-3">
                <div class="col-6 col-md-3 col-lg-2">
                    <a class="btn btn-primary col-12 col-md-auto text-white float-left hidden-on-print" href="{{route('tournaments.index')}}"><i class="fa fa-caret-square-left"></i> Terug</a>
                </div>
                <div class="col-6 col-md-3 col-lg-2 order-md-last">
                    @if(!empty($tables[1]))
                        <button class="btn btn-primary col-12 col-md-auto float-right hidden-on-print" id="printButton" onclick="printDiv()"><i class="fa fa-print"></i> Print</button>
                    @endif
                </div>
                <div class="col-12 col-md-6 col-lg-8 text-center mt-2 m-md-auto">
                    <h1>Tafelindeling {{$tournamentName}}</h1>
                </div>
            </div>
            @if(!empty($tables[1]))
                <div class="row col-12 justify-content-center mt-xl-2 tables-row">
                    @for($i = 1; $i <= count($tables); $i++)
                        @if($i%2!==0)
                            <div class="col-lg-4 col-md-6 avoid-break print-left">
                        @else
                            <div class="col-lg-4 col-md-6 avoid-break print-right">
                        @endif
                            <div class="row justify-content-center">
                                <div class="col-auto">
                                    <h2 style="text-align: center">Tafel {{$i}}</h2>
                                    <table class="table table-responsive table-bordered">
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
                        @if($i%2==0)
                            <div style="clear: both;"></div>
                        @endif
                    @endfor
                </div>
            @else
                <div class="alert alert-danger">
                    Er staan geen spelers ingeschreven voor dit tournament!
                </div>
            @endif
        </div>
    </div>

    <script>
        function printDiv() {
            // var hiddenOnPrint = Array.from(document.getElementsByClassName('hidden-on-print'));
            // var originalContents = document.body.innerHTML;
            //
            // hiddenOnPrint.forEach(function (item, index) {
            //     item.style.display = "none";
            // });
            //
            // document.body.innerHTML = document.getElementById('printableArea').innerHTML;
            //
            window.print();
            //
            // document.body.innerHTML = originalContents;
        }
    </script>
@endsection
