@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('数据字典') }}</div>
                <div class="card-header"> <a class="btn btn-primary" href="{{ URL::to('/constant/create?id='.$id) }}">创建新数据字典值</a></div>
                <div class="card-body">
                    <table class="table table-striped">
                     <thead>
                        <tr>
                            <th>编号</th>
                            <th>数据字典键名称</th>
                            <th>汉语名称</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($constants as $model)
                        <tr>
                            <td>{{$model->id}} </td>
                            <td>{{$model->name}}</td>
                           <td>{{$model->label_name}}</td>
                              <td class="center">
                                <!--a class="btn btn-info" href="{{ URL::to('constantName/' . $model->id . '/edit') }}">
                                    <i class="glyphicon glyphicon-edit icon-white"></i>
                                    编辑键名称
                                </a-->
                                @if ($model->parent_id==null)
                                <a class="btn btn-primary" href="{{ URL::to('constant/?id=' . $model->id) }}">
                                    显示键值
                                </a>
                                @endif
                                <!--a class="btn btn-danger" href="{{ URL::to('constantCategory/' . $model->id) }}">
                                    <i class="glyphicon glyphicon-trash icon-white"></i>
                                    删除
                                </a-->
                            </td>
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
