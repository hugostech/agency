@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading">Item management</div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <a class="btn btn-block btn-danger" href="{{url('items',['create'])}}">Add New Item</a>
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
                            <th>#</th>
                            <th>Make</th>
                            <th>Name</th>
                            <th>Stock</th>

                            <th>Action</th>
                        </tr>
                        @foreach($items as $key=>$item)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$item->make}}</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->stock}}</td>
                                <td><a href="{{url('items',[$item->id,'edit'])}}" class="btn btn-primary btn-sm">Edit</a></td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="5" class="text-center">{{$items->links()}}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection