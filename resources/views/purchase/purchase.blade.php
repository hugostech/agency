@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading">Purchase management</div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <a class="btn btn-block btn-danger" href="{{url('purchase_orders',['create'])}}">New Purchase Order</a>
                            </div>
                            <div class="col-sm-4 col-sm-offset-2">

                                <div class="input-group" ng-app="myApp">
                                    <input type="text" class="form-control" ng-model="search">
                                    <span class="input-group-btn">
                                    <a href="?s=@{{search}}" class="btn btn-default">Search</a>
                                </span>
                                </div>

                            </div>
                        </div>

                    </div>
                    <table class="table">
                        <tr>
                            <th class="col-sm-1">Date</th>
                            <th class="col-sm-2">Supplier</th>
                            <th class="col-sm-2">Supplier No</th>
                            <th class="col-sm-3">Total</th>
                            <th class="col-sm-2">Status</th>
                            <th class="col-sm-2"></th>

                        </tr>
                        @foreach($purchase_orders as $order)
                            <tr>
                                <td>{{\Carbon\Carbon::parse($order->created_at)->format('y-M-d')}}</td>
                                <td>{{$order->supplier}}</td>
                                <td>{{$order->supplier_order}}</td>
                                <td>{{$order->total}}</td>
                                <td>{{$order->status}}</td>
                                <td></td>
                            </tr>
                        @endforeach
                        <tr>
                        <td colspan="6" class="text-center">{{$purchase_orders->links()}}</td>
                        </tr>
                        {{--@foreach($items as $key=>$item)--}}
                            {{--<tr>--}}
                                {{--<td>{{$key+1}}</td>--}}
                                {{--<td>{{$item->make}}</td>--}}
                                {{--<td>{{$item->name}}</td>--}}
                                {{--<td>{{$item->stock}}</td>--}}
                                {{--<td><a href="{{url('items',[$item->id,'edit'])}}" class="btn btn-primary btn-sm">Edit</a></td>--}}
                            {{--</tr>--}}
                        {{--@endforeach--}}

                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection