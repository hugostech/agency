@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading">Purchase Order</div>


                    <div class="panel-body">
                        {!! Form::open(['url'=>'purchase_orders','class'=>'form-inline']) !!}

                        {!! Form::input('hidden','items',session(\Illuminate\Support\Facades\Input::get('s'))) !!}
                        {!! Form::input('hidden','user_id',\Illuminate\Support\Facades\Auth::user()->id) !!}
                        <div class="form-group">


                            <div class="input-group">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Suppliers <span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                        @foreach($suppliers as $supplier)
                                        <button type="button" class="list-group-item" onclick="pickSupplier(this)">{{$supplier}}</button>
                                        @endforeach
                                    </ul>
                                    <script>
                                        function pickSupplier(btnClick){
                                            $('#supplierTxt').val($(btnClick).text())
                                        }
                                    </script>
                                </div><!-- /btn-group -->
                                {!! Form::text('supplier',null,['class'=>'form-control','required','id'=>'supplierTxt']) !!}

                            </div><!-- /input-group -->
                        </div>
                        <div class="form-group">
                            {!! Form::label('supplier_order','Supplier Order No: ') !!}
                            {!! Form::text('supplier_order',null,['class'=>'form-control','required']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::checkbox('status','f') !!}
                            {!! Form::label('status','Drop Ship') !!}
                        </div>
                        <div class="form-group">
                            {!! Form::submit('Confirm',['class'=>'btn btn-primary']) !!}
                            <button type="button" class="btn btn-danger" onclick="window.history.back()"><span class="glyphicon glyphicon-trash"></span></button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <table class="table table-bordered">
                        <tr>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                        @php
                            $total = 0;
                        @endphp
                        @foreach($data as $key=>$value)
                        <tr>
                            @php
                                $item = \App\Item::find($key);
                                $total = $total+$value[0]*$value[1];
                            @endphp
                            <td class="text-capitalize">{{$item->make.' '.$item->name}}</td>
                            <td>{{$value[0]}}</td>
                            <td>{{$value[1]}}</td>
                            <td>¥{{$value[0]*$value[1]}}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <th colspan="3" class="text-right">Total:</th>
                            <th>¥{{$total}}</th>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection