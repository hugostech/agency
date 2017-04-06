@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">Agency management</div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <a class="btn btn-block btn-danger" href="{{url('agencys',['create'])}}">Add New Agency</a>
                        </div>
                        <div class="col-sm-4 col-sm-offset-2">

                            <div class="input-group" ng-app="">
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
                        <th>Wechat</th>
                        <th>Balance</th>

                        <th>Action</th>
                    </tr>
                    @foreach($agencys as $key=>$agency)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td><a href="{{url('agencys',[$agency->id])}}">{{$agency->wechat}}</a></td>
                        <td>{{$agency->balance}}</td>
                        <td><a href="{{url('agencys',[$agency->id,'edit'])}}" class="btn btn-primary btn-sm">Edit</a></td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="4" class="text-center">{{$agencys->links()}}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection