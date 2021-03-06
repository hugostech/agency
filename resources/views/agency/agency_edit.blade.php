@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading">Agency management</div>

                    <div class="panel-body">
                        {!! Form::model($agency,['url'=>'agencys/'.$agency->id,'method'=>'PATCH']) !!}
                        <div class="form-group">
                            {!! Form::label('wechat','Wechat') !!}
                            <div class="input-group">
                                {!! Form::text('wechat',null,['class'=>'form-control','placeholder'=>'wechat number']) !!}
                                <span class="input-group-btn">
                                    <a class="btn btn-default" href="{{url('agencys')}}"><span class="glyphicon glyphicon-remove"></span></a>
                                    {!! Form::submit('Change',['class'=>'btn btn-danger']) !!}
                                </span>
                            </div>


                        </div>

                        {!! Form::close() !!}
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection