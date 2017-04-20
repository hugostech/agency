@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-info">

                    <div class="panel-heading"><label>{{$agency->wechat}}</label> &nbsp;&nbsp;
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#newOrderModal">New Order</button>
                    </div>

                    <div class="panel-body">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">订单模式</a></li>
                            <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Back Order</a></li>
                            {{--<li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Messages</a></li>--}}
                            {{--<li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Settings</a></li>--}}
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="home">
                                @foreach($orders as $order)

                                    <div class="jumbotron">
                                        <label>Date: {{$order->created_at}} | Total: <font class="text-muted">¥{{$order->total}}</font>
                                        |
                                            @if($order->balance == 0)
                                            <font class="text-success">已付款</font>
                                            @else
                                            <font class="text-danger">Balance: ¥{{$order->balance}} </font>

                                                {!! Form::open(['url'=>'order2pay','id'=>'orderForm'.$order->id]) !!}
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="input-group input-group-sm">
                                                        {!! Form::input('hidden','order_id',$order->id) !!}
                                                        {!! Form::input('number','amount',null,['class'=>'form-control','step'=>'0.01','max'=>$order->balance]) !!}
                                                        <span class="input-group-btn">
                                                            <button type="button" class="btn btn-primary" onclick="payOrder({{$order->id}})">Pay</button>
                                                            {{--{!! Form::submit('Pay',['class'=>'btn btn-info']) !!}--}}

                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                                {!! Form::close() !!}
                                            @endif
                                        </label>
                                        <table class="table">
                                            <tr>
                                                <th>
                                                    Name
                                                </th>
                                                <th>
                                                    Quantity
                                                </th>
                                                <th>
                                                    Price
                                                </th>
                                                <th>
                                                    Status
                                                </th>
                                            </tr>
                                            @foreach($order->items as $item)
                                                <tr>
                                                    <td>{{$item->pivot->item_name}} <label class="text-muted text-info">|</label> <small>库存：</small> <span class="badge">{{$item->stock}}</span></td>
                                                    <td>{{$item->pivot->quantity}} (<font class="text-danger">{{$item->pivot->quantity - $item->pivot->shipped_quantity}}</font>)</td>
                                                    <td>¥{{$item->pivot->price}}</td>
                                                    <td>
                                                        @if($item->pivot->quantity != $item->pivot->shipped_quantity)
                                                            <label class="text-danger">未发货</label>
                                                        @else
                                                            <label class="text-success">已发货</label>
                                                        @endif

                                                    </td>
                                                </tr>

                                            @endforeach
                                            <tr>
                                                <td colspan="4" class="text-right">

                                                    {!! Form::open(['url'=>'orders/'.$order->id,'method'=>'delete']) !!}
                                                    <a href="{{url('orders',[$order->id])}}" class="btn btn-info">Ship</a>
                                                    <button type="submit" class="btn btn-danger">Del</button>
                                                    {!! Form::close() !!}
                                                </td>
                                            </tr>
                                        </table>


                                    </div>
                                @endforeach
                            </div>
                            <div role="tabpanel" class="tab-pane" id="profile">
                                @php
                                    $items = array();
                                    foreach ($orders as $order){
                                        foreach ($order->items as $item){
                                            if ($item->pivot->status=='p'){
                                            if(isset($items[$item->make.$item->name])){
                                            $items[$item->make.$item->name] = $items[$item->make.$item->name]+$item->pivot->quantity;
                                            }else{
                                            $items[$item->make.$item->name] = $item->pivot->quantity;
                                            }
                                            }


                                        }
                                    }


                                @endphp
                                <table class="table">
                                    <tr>
                                        <th>Name</th>
                                        <th>Quantity</th>
                                    </tr>
                                    @foreach($items as $key=>$value)
                                        <tr>
                                            <td>{{$key}}</td>
                                            <td>{{$value}}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                            {{--<div role="tabpanel" class="tab-pane" id="messages">3..</div>--}}
                            {{--<div role="tabpanel" class="tab-pane" id="settings">4..</div>--}}
                        </div>

                    </div>
                    <!-- Modal -->
                    <div class="modal fade bs-example-modal-lg" id="newOrderModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" ng-app="orderApp">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                {!! Form::open(['url'=>'orders']) !!}
                                {!! Form::input('hidden','agency_id',$agency->id) !!}
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">New Order</h4>
                                </div>
                                <div class="modal-body" ng-controller="itemController">
                                    {!! Form::text('itemFinder',null,['class'=>'form-control','placeholder'=>'Item Name','ng-model'=>'itemKey','ng-change'=>'listItems()']) !!}
                                    <li class="list-group" ng-show="items">
                                        <button type="button" class="list-group-item" ng-repeat="(key , n) in items track by $index" ng-click="add2list(key,n)">@{{ n }}</button>
                                    </li>
                                    <table class="table" id="orderContent">
                                        <tr>
                                            <th>Name</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th></th>
                                        </tr>


                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script>
        function payOrder(id){
            if(confirm('确认付款？')){
                $("#orderForm"+id).submit();
            }
        }
        var app = angular.module('orderApp', []);
        app.controller('itemController', function($scope, $http) {
            $scope.items = null;

            $scope.listItems = function(){

                var url = '{{url('/api/items')}}/'+$scope.itemKey;
                $http.get(url)
                    .then(function(response) {
                        $scope.items = response.data;

                    });
            };

            $scope.add2list = function (key,name){
                    var content = '<tr><td><input type="hidden" name="id[]" value="'+key+'">'+name+'</td>';
                    content = content+'<td><input type="number" class="form-control" name="quantity[]" value="1" min="1"></td> <td><input type="number" class="form-control" name="price[]" value="0" min="0" step="0.01"></td> <td><button type="button" class="btn btn-danger btn-sm" onclick="removeItem(this)">Del</button></td> </tr>';
                    content = content + '<input type="hidden" name="item_name[]" value="'+name+'">';
                    $('#orderContent').append(content);
                $scope.items=null;
            };


        });
        function removeItem(item){
            $( item ).parents('tr').remove();
        }
    </script>
@endsection