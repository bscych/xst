@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-header">{{ __('课程管理') }}</div>

                @if(Auth::user()->can('create',App\Model\Course::class))
                <div class="card-header">
                    <a href="{{route('course.create')}}" type="" class="btn btn-primary btn-sm">{{ __('添加课程') }}</a>
                </div>
                @endif
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="hidden-sm hidden-xs">编号</th>
                                <th>课程名称</th>                              
                                <th>是否是特长课</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($courses as $model)
                            @if(Auth::user()->can('view',$model))
                            <tr>
                                <td class="hidden-sm hidden-xs">{{$model->id}} </td>
                                <td>{{ $model->name }}</td>                               
                                <td>{{ $model->is_speciality_course===1?'特长课':'托管课' }}</td>
                                <td class="center">
                                    <form action="{{ route('course.destroy',$model)}}" method="post">
                                      @can('update',$model)<a class="btn btn-primary" href="{{route('course.edit',$model)}}"> 编辑</a>@endcan
                                      @can('studentList',App\Model\Course::class) <a class="btn btn-primary" href="{{route('course.studentList',[$model->id])}}">学生列表 </a>@endcan
                                        <a class="btn btn-primary" href="{{route('classmodel.index',['course_id'=>$model->id])}}"> 班级管理</a>
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit">结课</button>
                                    </form>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>

                </div>

            </div>

        </div>

    </div>
</div>

@endsection
