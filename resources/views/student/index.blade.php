@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card mb-5">
                <div class="card-header">{{ __('学生管理') }}</div>

                <div class="card-header">
                    <form role="form" method="GET" action="{{route('student.index') }}" class="form-inline">
                        @csrf                        
                        <label class="sr-only" for="inlineFormInputName2">姓名</label>
                        <input type="text" class="form-control mb-2 mr-sm-2" id="inlineFormInputName2" placeholder="查询学生姓名" name="name" value="{{ old('name') }}">
                        <button type="submit" class="btn btn-primary mb-2">查询</button>                        
                    </form>
                </div>
                @if(Auth::user()->can('create',App\Model\Student::class))
                <div class="card-header">
                    <a href="{{route('student.create')}}" class="btn btn-primary btn-sm">{{ __('添加学生') }}</a>
                </div>
                @endif
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="hidden-sm hidden-xs">学号</th>
                                <th>姓名</th>
                                <th class="hidden-sm hidden-xs">性别</th>
                                <th class="hidden-sm hidden-xs">生日</th>

                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $model)
                            <tr>
                                <td class="hidden-sm hidden-xs">{{$model->id}} </td>
                                <td><a  href="{{ URL::to('student/'. $model->id) }}">{{ $model->name }}</a></td>
                                <td class="hidden-sm hidden-xs">{{ $model->gender }}</td>
                                <td class="hidden-sm hidden-xs">{{ $model->birthday }}</td>
                                <td class="center">
                                    <form action="{{ route('student.destroy',$model->id)}}" method="post">
                                        <a class="btn btn-info" href="{{ URL::to('student/' . $model->id . '/edit') }}">
                                            编辑
                                        </a>
                                                                             
                                        <a class="btn btn-primary" href="{{route('income.selectPaymentCategories',[$model->id])}}">
                                            交费
                                        </a>

                                        <a class="btn btn-primary" href="#">
                                            退费
                                        </a>
                                        <a class="btn btn-primary" href="#">
                                            注册码管理
                                        </a>
                                        @if ($model-> balance == 0)
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit">注销</button>
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
