@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-header">{{ __('学生列表') .'，共'.$class->students->count().'名'}}</div>              
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>编号</th>
                                <th>名字</th>
                                <th>性别</th>  
                                <th>剩余次数</th>
                                <th>是否催费</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($class->students as $model)
                            <tr>
                                <td>{{$model->id}} </td>
                                <td>{{$model->name}}</td>
                                <td>{{$model->gender}}</td>  
                                <td>{{$model->pivot->how_many_left}}</td>
                                 <td>
                                     @if($model->pivot->how_many_left-$threshold>=0)
                                     <span class="badge badge-success">正常</span>
                                    @else
                                    <span class="badge badge-danger">催费</span>
                                    @endif
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