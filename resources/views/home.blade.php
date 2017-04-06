@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">

                </div>
                <table class="table">
                    <tr>
                        <th>Name</th>
                        <th>Back Order</th>
                    </tr>
                    @foreach($backorder as $name=>$item)
                        <tr>
                            <td>
                                {{$name}}
                            </td>
                            <td>
                                {{$item}}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
