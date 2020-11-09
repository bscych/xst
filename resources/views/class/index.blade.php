@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('班级列表') }}</div>
                @if(Auth::user()->can('create',App\Model\Classmodel::class))
                <div class="card-header">
                    <a href="{{route('classmodel.create',['course_id'=>$course_id])}}" type="" class="btn btn-primary btn-sm">{{ __('添加') }}</a>
                </div>
                @endif
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="">操作</th>
                                <th class="">编号</th>
                                <th class="">课程名称</th>
                                <th class="">班级名称</th>
                                <th class="">责任教师</th>
                                <th class="">学生人数</th>
                                <th class="">操作</th>
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
                                <td class="">{{$model->id}} </td>
                                <td class="">{{ $model->course->name }}</td>
                                <td class="">{{ $model->course_name.$model->name }}</td>
                                <td class="">{{ $model->teacher->name }}</td>
                                <td class="">                                    
                                    @if($model->course->is_speciality_course==='1')
                                    <a class="" href="{{route('classmodel.studentList',[$model->id])}}">
                                        {{ $model->students->count()}}
                                    </a>
                                    @else
                                    {{ $model->students->count()}}
                                    @endif
                                </td>
                                <td class=""> 
                                    <form method="POST" action="{{route('classmodel.destroy',[$model->id])}}">                                       
                                        <a class="btn btn-primary btn-sm {{$model->students->count()===0?'disabled':'disable'}}" href="{{route('schedule.month_detail',['classmodel_id'=>$model->id])}}">
                                            考勤报表
                                        </a>
                                         <a class="btn btn-primary btn-sm {{$model->students->count()===0?'disabled':'disable'}}" href="{{route('classmodel.printlist',[$model->id])}}">
                                            打印作业
                                        </a> 
                                      @can('update',$model)<a class="btn btn-primary btn-sm " href="{{route('classmodel.edit',[$model->id])}}">编辑</a>@endcan
                                       
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
