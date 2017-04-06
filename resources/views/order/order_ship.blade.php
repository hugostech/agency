@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading">Order to Ship {{$order->created_at}}</div>

                    <div class="panel-body">


                    </div>
                    <table class="table">
                        <tr>
                            <th>

                            </th>
                            <th>
                                Name
                            </th>
                            <th>
                                Quantity
                            </th>

                        </tr>
                        @foreach($order->items as $item)
                            <tr>
                                <td class="text-center">{!! Form::checkbox('id[]',null,['class'=>'form-control']) !!}</td>
                                <td>{{$item->make}}{{$item->name}}</td>
                                <td>{{$item->pivot->quantity}}</td>

                            </tr>

                        @endforeach
                        <tr>
                            <td colspan="4" class="text-right">
                                <a href="{{url('orders',[$order->id])}}" class="btn btn-info">Ship</a>
                                <button type="button" class="btn btn-danger">Del</button>
                            </td>
                        </tr>
                    </table>

                    {{--{!! Form::close() !!}--}}
                </div>

            </div>
        </div>
    </div>
    </div>
@endsection