@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('课程列表') }}</div>
                <div class="card-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>课程名称</th>
                                <th>统计报表</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($classes as $model)
                            @php $class = App\Model\Classmodel::find($model->id); @endphp
                            <tr>
                                <td class="">{{$class->course->name.' '.$class->name }}</td>
                                <td> 
                                    <a class="btn btn-primary" href="{{ route('schedule.month_detail',['classmodel_id'=>$model->id])}}">
                                        考勤报表
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