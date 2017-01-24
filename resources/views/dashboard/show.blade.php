@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Datum {{$month}} </div>
                    <div class="panel-body">
                        <p><b>Persoonlijke gegevens:</b><p>
                        <p>{{$customerData->customer_name}}</p>
                        <p>{{$customerData->customer_email}}</p>
                        <p>{{$customerData->customer_phone}}</p>
                        <p><b>Arrangement gegevens:</b></p>
                        @if($customerData->option >= 1)
                            <p>Bittergarnituur {{$customerData->option}}</p>
                        @endif
                        <p>kinderen {{$customerData->amount}}</p>
                        <p><b>Overige informatie:</b></p>
                        <p>{{$customerData->description}}</p>
                        @if($customerData->available == NULL)
                            <p><b>Status:</b></p>
                            <p style="background-color:indianred; color: whitesmoke; display: inline-block;">Datum is gereserveerd</p>
                            <p></p>{{ Form::submit('Accepteer reservering', array('class' => 'btn btn-success disabled'))}}
                                {{ Form::model($customerData, array('style' => 'display:inline;', 'route' => array('date/destroy', $customerData->id))) }}
                                {{ Form::submit('Verwijder reservering', array('class' => 'btn btn-danger'))}}
                                {{ Form::close() }}
                                {{ Form::model($customerData, array('style' => 'display:inline;', 'route' => array('date/edit', $customerData->id))) }}
                                {{ Form::submit('Wijzig klantgegevens', array('class' => 'btn btn-primary'))}}
                                {{ Form::close() }}<p>
                        @elseif($customerData->available == 1)
                            <p style="background-color:mediumseagreen; color: whitesmoke; display: inline-block;">Datum is beschikbaar</p>
                        {{ Form::model($customerData, array('route' => array('date/destroy', $customerData->id))) }}
                        {{ Form::submit('Verwijder beschikbare datum', array('class' => 'btn btn-danger'))}}
                        {{ Form::close() }}
                        @else
                            <p style="background-color:yellow; display: inline-block;">Wachten op bevestiging</p>
                                {{ Form::model($customerData, array('route' => array('date/validateReservation', $customerData->id))) }}
                                {{ Form::submit('Bevestig reservering', array('class' => 'btn btn-success'))}}
                                {{ Form::close() }}
                        @endif
                        </p>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
