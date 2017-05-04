@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading">Item management</div>

                    <div class="panel-body">
                        {!! Form::open(['url'=>'items']) !!}
                        {!! Form::input('hidden','user_id',\Illuminate\Support\Facades\Auth::user()->id) !!}

                        <div class="form-group">
                            {!! Form::label('make','Make') !!}

                                {!! Form::text('make',null,['class'=>'form-control','placeholder'=>'make']) !!}
                                {{--<span class="input-group-btn">--}}
                                    {{--<a class="btn btn-default" href="{{url('agencys')}}"><span class="glyphicon glyphicon-remove"></span></a>--}}
                                    {{--{!! Form::submit('Insert',['class'=>'btn btn-success']) !!}--}}
                                {{--</span>--}}
                            </div>
                            <div class="form-group">
                                {!! Form::label('name','Name') !!}
                                {!! Form::text('name',null,['class'=>'form-control']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('price','Price') !!}
                                {!! Form::number('price',null,['class'=>'form-control','step'=>'0.01']) !!}
                            </div>
                            <div class="form-group text-right">
                                <a class="btn btn-default" href="{{url('items')}}"><span class="glyphicon glyphicon-remove"></span></a>
                                {!! Form::submit('Insert',['class'=>'btn btn-success']) !!}
                            </div>



                        </div>

                        {!! Form::close() !!}
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection