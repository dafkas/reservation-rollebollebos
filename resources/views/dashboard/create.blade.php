@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Datum {{$month}} </div>
                <div class="panel-body">
                  {{ Form::open(['action' => 'DateController@store']) }}
                  {{ Form::hidden ('date', $epoch)}}
                  {{ Form::submit('Maak datum beschikbaar', array('class' => 'btn btn-success'))}}
                  {{ Form::close() }}


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
