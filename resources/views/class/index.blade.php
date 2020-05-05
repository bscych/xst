@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('班级列表') }}</div>
                @if(Auth::user()->can('create',App\Model\Classmodel::class))
                <div class="card-header">
                    <a href="{{route('class.create',['course_id'=>$course_id])}}" type="" class="btn btn-primary btn-sm">{{ __('添加') }}</a>
                </div>
                @endif
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>操作</th>
                                <th class="hidden-sm hidden-xs">编号</th>
                                <th>课程名称</th>
                                <th class="hidden-sm hidden-xs">班级名称</th>
                                <th class="hidden-sm hidden-xs">责任教师</th>
                                <th class="hidden-sm hidden-xs">学生人数</th>
                                <th>统计报表</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($classes as $model)
                            <tr>
                                <td class="center">
                                    
                                    <a class="btn btn-primary btn-sm {{$model->students->count()===0?'disabled':''}}" href="{{route('schedule.getCalendarList',['classmodel_id'=>$model->id])}}">
                                        考勤管理
                                    </a>  
                                    
                                </td>
                                <td class="hidden-sm hidden-xs">{{$model->id}} </td>
                                <td class="hidden-sm hidden-xs">{{ $model->course->name }}</td>
                                <td >{{ $model->course_name.$model->name }}</td>
                                <td class="hidden-sm hidden-xs">{{ $model->teacher->name }}</td>
                                <td class="hidden-sm hidden-xs">                                    
                                    @if($model->course->is_speciality_course==='1')
                                    <a class="" href="{{route('class.studentList',[$model->id])}}">
                                        {{ $model->students->count()}}
                                    </a>
                                    @else
                                    {{ $model->students->count()}}
                                    @endif
                                </td>
                                <td> 
                                    <form method="POST" action="{{route('class.destroy',[$model->id])}}">                                       
                                        <a class="btn btn-primary btn-sm {{$model->students->count()===0?'disabled':'disable'}}" href="{{route('schedule.month_detail',['classmodel_id'=>$model->id])}}">
                                            考勤报表
                                        </a>                                       
                                        @if(Auth::user()->can('edit',App\Model\Classmodel::class))
                                        <a class="btn btn-primary btn-sm " href="{{route('class.edit',[$model->id])}}">编辑</a>
                                        @endif
                                        @if(Auth::user()->can('delete',$model))
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" type="submit">注销</button>
                                        @endif
                                    </form>
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
