@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Datum {{$available}}</div>
                <div class="panel-body">
                  {{ Form::model($available, array('route' => array('reservation/store', $reservation->id, $available), 'class' => 'form-horizontal') ) }}

                    <div class="form-group">
                        {{ Form::label('Voornaam & achternaam', null, ['class' => 'col-md-4 control-label'])}}
                        <div class="col-md-6">
                            {{ Form::text('customer_name', null, ['class' => 'form-control col-md-6'] )}}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('E-mail', null, ['class' => 'col-md-4 control-label'] )}}
                        <div class="col-md-6">
                            {{ Form::text('customer_email', null, ['class' => 'form-control col-md-6'] )}}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('Telefoonnummer', null, ['class' => 'col-md-4 control-label'])}}
                        <div class="col-md-6">
                            {{ Form::tel('customer_phone', null, ['class' => 'form-control col-md-6'] )}}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('Aantal kinderen', null, ['class' => 'col-md-4 control-label'])}}
                        <div class="col-md-6">
                            {{ Form::number('amount',  null, ['style' => 'width: 25%;', 'class' => 'form-control col-md-6'])}}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('Bittergarnituur', null, ['class' => 'col-md-4 control-label'])}}
                        <div class="col-md-6">
                            <div class="checkbox" style="display: inline-block;">
                                <label data-toggle="collapse" data-target="#collapseExample" style="min-height: 25px;">
                                    {{ Form::checkbox('option',1,  null, ['class' => 'form-control', 'style' => 'margin-top: -5px;'] )}}
                                </label>
                            </div>
                            <div class="collapse" id="collapseExample">
                                {{ Form::selectRange('number', 1, 10, null, ['placeholder' => 'Aantal...', 'class' => 'form-control']) }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('Beschrijving', null, ['class' => 'col-md-4 control-label'])}}
                        <div class="col-md-6">
                            {{ Form::textarea('description', null, ['class' => 'form-control', 'style' => 'height: 150px;'] )}}
                        </div>
                    </div>
                  {{ Form::hidden('date', $dateString) }}
                    <div class="col-md-3 col-md-offset-8">
                        {{ Form::submit('Opslaan', array('class' => 'btn btn-primary', 'style' => 'margin-left:15px;' ))}}
                    </div>
                  {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
