
@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card mb-5">
                <div class="card-header">{{$student->name."的注册码信息"}}</div>

               
                <div class="card-body">
                  <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th class="">注册码</th>
                            <th class="">与学生的关系</th>
                            <th class="">注册时间</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($registerCodes as $model)
                        <tr>
                            <td>{{$model->code}} </td>
                            <td>{{ $model->relationship }}</td>
                            <td>{{ $model->deleted_at }}</td>                         
                        </tr>
                        @endforeach
                    </tbody>
                </table>
               <div class="float-right"><a class="btn btn-primary" href="{{route('student.createRegisterCode',['student_id'=>$student->id])}}">新增注册码</a></div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
