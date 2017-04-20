@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading">Order to Ship {{$order->created_at}}</div>

                    <div class="panel-body">


                    </div>
                    {!! Form::open(['url'=>'order2ship']) !!}
                    {!! Form::input('hidden','order_id',$order->id) !!}
                    <table class="table">
                        <tr>
                            <th class="col-md-1">

                            </th>
                            <th class="col-md-5">
                                Name
                            </th>
                            <th class="col-md-3">
                                Quantity
                            </th>
                            <th class="col-md-3">
                                Status
                            </th>

                        </tr>
                        @foreach($order->items as $item)
                            <tr>
                                <td class="text-center">

                                    {!! Form::input('hidden','id[]',$item->id) !!}

                                </td>
                                <td>{{$item->make}}{{$item->name}}</td>
                                <td>
                                    @if($item->pivot->status == 'p')
                                        {!! Form::input('number','quantity[]',0,['class'=>'form-control']) !!}
                                    @else
                                        {!! Form::input('hidden','quantity[]',0) !!} 0
                                    @endif
                                </td>
                                <td>
                                    @if($item->pivot->status == 'p')
                                        <label class="text-danger">未发货</label>
                                    @else
                                        <label class="text-success">已发货</label>
                                    @endif

                                </td>
                            </tr>

                        @endforeach
                        <tr>

                            <td colspan="4" class="text-right">
                                {!! form::submit('Ship',['class'=>'btn btn-primary']) !!}
                                <a href="{{url('/agencys',[$order->agency->id])}}" class="btn btn-danger">Back</a>
                            </td>
                        </tr>
                    </table>

                    {!! Form::close() !!}
                </div>

            </div>
        </div>
    </div>
    </div>
@endsection