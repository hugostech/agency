@extends('layouts.app')

@section('content')
    <style type="text/css">
        #detail_input {
            width: 100%;
            height: 500px;
        }
    </style>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading"><a href="{{url('items')}}">Item management</a>
                        @if($item->status == 'y')
                            <a href="{{ url('items',[$item->id]) }}" class="btn btn-danger btn-sm"
                               onclick="event.preventDefault();
                                                     document.getElementById('itemDel-form').submit();">
                                <span class="glyphicon glyphicon-eye-close"></span>
                            </a>
                        @else
                            <a href="{{ url('items',[$item->id]) }}" class="btn btn-success btn-sm"
                               onclick="event.preventDefault();
                                                     document.getElementById('itemDel-form').submit();">
                                <span class="glyphicon glyphicon-eye-open"></span>
                            </a>
                        @endif


                        {{--<form id="itemDel-form" action="{{ url('items',[$item->id]) }}" method="DELETE" style="display: none;">--}}
                            {{--{{ csrf_field() }}--}}
                        {{--</form>--}}
                        {!! Form::open(['url'=>'items/'.$item->id,'method'=>'delete','class'=>'sy-only','id'=>'itemDel-form']) !!}

                        {!! Form::close() !!}
                    </div>

                    <div class="panel-body">
                        {!! Form::model($item,['url'=>'items/'.$item->id,'method'=>'patch','id'=>'formItemEdit']) !!}
                        <div class="form-group">
                            {!! Form::label('make','Make') !!}

                            {!! Form::text('make',null,['class'=>'form-control','placeholder'=>'make']) !!}
                            {{--<span class="input-group-btn">--}}
                            {{--<a class="btn btn-default" href="{{url('agencys')}}"><span class="glyphicon glyphicon-remove"></span></a>--}}
                            {{--{!! Form::submit('Insert',['class'=>'btn btn-success']) !!}--}}
                            {{--</span>--}}
                        </div>
                        <div class="form-group">
                            {!! Form::label('name','Name') !!}
                            {!! Form::text('name',null,['class'=>'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('price','Price') !!}
                            {!! Form::number('price',null,['class'=>'form-control','step'=>'0.01']) !!}
                        </div>
                        <div class="form-group">
                            <div id="detail_input" name="content" style="height:500px;max-height:600px;">
                                {!! html_entity_decode($item->content) !!}
                            </div>

                        </div>
                        {!! Form::input('hidden','content',null,['id'=>'item_content']) !!}



                        {{--<div class="form-group">--}}
                            {{--{!! html_entity_decode($item->content) !!}--}}
                        {{--</div>--}}
                        <div class="form-group text-right">
                            <a class="btn btn-default" href="{{url('items')}}"><span class="glyphicon glyphicon-remove"></span></a>

                            <button type="button" id="btnSubmit" class="btn btn-success">Edit</button>

                        </div>


                    </div>

                    {!! Form::close() !!}
                </div>

            </div>
        </div>
    </div>
    </div>
@endsection

@section('bl_js')
    <script type="text/javascript">
        $(function () {
            var editor = new wangEditor('detail_input');
            // 上传图片（举例）
            editor.config.uploadImgUrl = '{{url('utility',['images','upload'])}}';

            // 配置自定义参数（举例）
            editor.config.uploadParams = {
                _token: '{{csrf_token()}}',
                user: 'item'
            };

            // 设置 headers（举例）
            editor.config.uploadHeaders = {
                'Accept' : 'text/x-json'
            };

            // 隐藏掉插入网络图片功能。该配置，只有在你正确配置了图片上传功能之后才可用。
            editor.config.hideLinkImg = true;

            editor.create();

            $('#btnSubmit').click(function () {

                $('#item_content').val(editor.$txt.html());
//                alert(editor.$txt.html());
                $('#formItemEdit').submit();
            });
        });

    </script>
@endsection