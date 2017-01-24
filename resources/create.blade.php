@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Datum {{$month}} </div>
                <div class="panel-body">

                <btn class="btn btn-info">Wijzig klant gegevens</btn><br/>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
