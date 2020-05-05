@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('特殊日期管理') }}</div>
                
                    <div class="card-header">
                        <a href="{{route('specialdate.create')}}" type="" class="btn btn-primary btn-sm">{{ __('添加') }}</a>
                    </div>
               
                <div class="card-body">
                    <table class="table table-striped responsive">
                    <thead>
                        <tr>
                            <th>编号</th>
                            <th>类型</th>
                            <th>假期名称</th>
                            <th>日期</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dates as $model)
                        <tr>
                            <td>{{$model->id}} </td>
                            <td>{{ $model->type==0?'假日':'工作日' }}</td>
                            <td>{{ $model->name }}</td>
                            <td>{{ $model->which_day }}</td>
                            <!--td class="center">
                                <a class="btn btn-info" href="{{ URL::to('classroom/' . $model->id . '/edit') }}">
                                    <i class="glyphicon glyphicon-edit icon-white"></i>
                                    编辑
                                </a>
                                <a class="btn btn-danger" href="{{ URL::to('classroom/' . $model->id) }}">
                                    <i class="glyphicon glyphicon-trash icon-white"></i>
                                    删除
                                </a>
                            </td-->

                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection