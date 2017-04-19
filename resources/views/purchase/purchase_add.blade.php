@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading">New Purchase Order</div>

                    <div class="panel-body" ng-app="orderApp" ng-controller="itemController">
                        {!! Form::open(['url'=>'purchase_orders/newpurchase2']) !!}
                        {!! Form::input('hidden','user_id',\Illuminate\Support\Facades\Auth::user()->id) !!}
                        <div class="form-group">
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
                        <div class="form-group">
                            {!! Form::submit('Next',['class'=>'btn btn-primary btn-block']) !!}
                        </div>

                        {!! Form::close() !!}
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script>
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
                $('#orderContent').append(content);
                $scope.items=null;
                $scope.itemKey='';
            };





        });
        function removeItem(item){
            $( item ).parents('tr').remove();
        }
    </script>
@endsection