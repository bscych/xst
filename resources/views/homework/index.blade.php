@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-header">{{ __('作业管理') }}</div>
                @if(Auth::user()->can('create',App\Model\Homework::class))
                <div class="card-header">
                    <a href="{{route('homework.create')}}" type="" class="btn btn-primary btn-sm">{{ __('添加作业') }}</a>
                </div>
                @endif
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>日期</th>
                            <th>学校</th>
                            <th>班级</th>
                            <th>作业内容</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($homeworks as $model)
                        <tr>
                            <td>{{$model->date}} </td>
                            <td>{{ App\Model\Constant::find($model->constant_school_id)->label_name }}</td>
                            <td>{{ $model->grade.'年'.$model->class.'班' }}</td>
                            <td>{{__('语文:')}}
                                  @foreach(collect(json_decode($model->chinese,JSON_UNESCAPED_UNICODE)) as $chinese_task)
                                {{$loop->index+1 .'. '.$chinese_task}}
                                @endforeach
                               <br>
                                {{__('数学:')}}
                                  @foreach(collect(json_decode($model->math,JSON_UNESCAPED_UNICODE)) as $math_task)
                                {{$loop->index+1 .'. '.$math_task}}
                                @endforeach
                                <br>
                                 {{__('英语:')}}
                                  @foreach(collect(json_decode($model->english,JSON_UNESCAPED_UNICODE)) as $english_task)
                                {{$loop->index+1 .'. '.$english_task}}
                                @endforeach
                                <br>
                                 {{__('托管附加:')}}
                                  @foreach(collect(json_decode($model->other,JSON_UNESCAPED_UNICODE)) as $other_task)
                                {{$loop->index+1 .'. '.$other_task}}
                                @endforeach
                                </td>

                            <td class="center">
                                <a href="{{route('homework.edit',[$model->id])}}" class="btn btn-primary btn-sm">修改</a>
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
