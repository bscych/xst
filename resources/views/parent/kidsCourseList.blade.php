@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('请选择具体的课程进行订餐，目前出现两个可以订餐的课程，是因为处在放假前，或者假期结束前，') }}</div>

                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr class="text-center">                               
                                <th>班级名称</th>                               
                                <th class="hidden-sm hidden-xs">责任教师</th>
                                <th class="hidden-sm hidden-xs">开始-结束日期</th>
                                <th class="hidden-sm hidden-xs">课程类型</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($classmodels as $model)
                            <tr class="text-center">                                  
                                <td >{{ $model->course_name.$model->name }}</td>
                                <td class="hidden-sm hidden-xs">{{ $model->teacher->name }}</td>
                                 <td class="hidden-sm hidden-xs">{{ $model->start_date.' 到 '.$model->end_date }}</td>
                                <td class="hidden-sm hidden-xs">{{ $model->course->is_speciality_course===1?'特长课':'托管课'}}                                 
                                </td>
                                <td> <a class="btn btn-primary btn-sm" href="{{route('schedule.parentBookMeals',['classmodel_id'=>$model->id,'student_id'=>$student_id])}}">
                                        订餐
                                    </a>
                                    <a class="btn btn-primary btn-sm" href="{{route('schedule.month_detail',['classmodel_id'=>$model->id,'student_id'=>$student_id])}}">
                                        订餐记录
                                    </a>
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
