@extends('client.main')
@section('content')
    <div class="container" ng-app="itemApp" ng-controller="itemController">
        {!! Form::text('item',null,['class'=>'form-control','placeholder'=>'产品名','ng-model'=>'itemKey','ng-change'=>'listItems()']) !!}
        <li class="list-group" ng-show="items">
            <a href="?i=@{{ key }}" class="list-group-item" ng-repeat="(key , n) in items track by $index" ng-click="add2list(key,n)">@{{ n }}</a>
        </li>
    </div>
    <hr>
    @if(!is_null($item))
    <div class="container">
        <div class="panel panel-info">
            <div class="panel-heading">{{$item->make . ' '.$item->name}}</div>
            <div class="panel-body">
                <div class="page-header">
                    <label>价格：</label> <font class="text-danger text-muted">{{$item->price}} RMB</font>
                </div>
                {!! html_entity_decode($item->content) !!}
            </div>
        </div>
    </div>
    @endif
    <script>
        var app = angular.module('itemApp', []);
        app.controller('itemController', function($scope, $http) {
            $scope.items = null;

            $scope.listItems = function(){

                var url = '{{url('/api/client/items')}}/'+$scope.itemKey;
                $http.get(url)
                    .then(function(response) {
                        $scope.items = response.data;

                    });
            };



        });
    </script>
@endsection