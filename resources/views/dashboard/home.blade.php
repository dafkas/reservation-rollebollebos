@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">Reserveringen</div>
                    <div class="panel-body">
                        <span><b>Wachtend op bevestiging:</b></span>
                            @foreach($date as $dates)
                                @if($dates->available == 2)
                                <span><a href="/date/show/{{$dates->id}}/{{$dateg = date('d-m-Y', $dates->date) }}"><br/>{{$dateg}}</a></span>
                                @endif
                            @endforeach
                            <br/><span><b>Beschikbare datums:</b></span>
                            @foreach($date as $dates)
                                @if($dates->available == 1)
                                    <a href="/date/show/{{$dates->id}}/{{$dateg = date('d-m-Y', $dates->date) }}"><br/>{{$dateg}}</a>
                                @endif
                            @endforeach
                        <br/><span><b>Gereserveerd:</b></span>
                        @foreach($date as $dates)
                            @if($dates->available == NULL)
                                <a href="/date/show/{{$dates->id}}/{{$dateg = date('d-m-Y', $dates->date) }}"><br/>{{$dateg}}</a>
                            @endif
                        @endforeach


                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">Genereer datums</div>
                    <div class="panel-body">
                                {{ Form::open(['action' => 'DateController@createAllDays']) }}
                                <div class="years">
                            <p>Jaar:</p>
                                {{ Form::selectYear('year', $year, $year + 03) }}
                                </div><p></p>
                            <p>Maanden:</p>
                            <div class="months" style="display: inline-block;">
                                @foreach($months as $number => $months)

                                    @if($number == 6)
                            </div>
                            <div class="months1" style="display: inline-block;">
                                    @endif
                                    {{ Form::checkbox('month[]', $months) }}

                                    {{ Form::label($months) }}<br/>
                                @endforeach
                            </div>
                            <div class="days" style="display: inline;">
                                <p>Dagen:</p>
                                @foreach($days as $number => $day)
                                    {{ Form::checkbox('days[]', $day)}}
                                    {{ Form::label($day) }}
                                @endforeach<p> </p>
                            </div><p>
                                    {{ Form::submit('Genereer beschikbare datums', array('class' => 'btn btn-primary'))}}
                                    {{ Form::close() }}</p>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
