@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-header">{{ __('学生列表') .'，共'.$course->students->count().'名'}}</div>              
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>编号</th>
                                <th>名字</th>
                                <th>性别</th>                              
                                <th>班级</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($course->students as $model)
                            <tr>
                                <td>{{$model->id}} </td>
                                <td>{{$model->name}}</td>
                                <td>{{$model->gender}}</td>                               
                                @if( $model->pivot->classmodel_id ===null)
                                <td>未分班</td>
                                @else
                                <td>{{$course->classes->where('id',$model->pivot->classmodel_id)->first()->name }} </h5></td>
                                @endif
                                <td><a href="#" class="btn btn-primary btn-setting" onclick="$('#student_id').val({{$model->id}})" data-target="#myModal" data-toggle="modal">分班</a>
                                    <a href="{{URL::to('quitClass/'.$course->id.'/'.$model->id ) }}" class="btn btn-primary">退班</a>
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

<div class="modal fade in" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: hidden;">
    <div class="modal-dialog">
        <form role="form" method="POST" action="{{ route('studentStatus.divide') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h3>分班</h3>
                    <button type="button" class="close" data-dismiss="modal">×</button>                    
                </div>

                <div class="modal-body">
                    <p>
                        <input type="hidden" name='course_id' value="{{$course->id}}">   
                        <input type="hidden" id='student_id' name='student_id' value="">
                    <div class="">
                        <label class="control-label">班级列表 ： </label>
                        <select class="l" name="class_id" id="class_id">
                            @foreach($course->classes as $class)
                            <option value="{{$class->id}}">{{$class->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    </p>
                </div>

                <div class="modal-footer">
                    <a href="#" class="btn btn-default" data-dismiss="modal">取消</a>

                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-btn fa-user"></i>保存
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    var student_id = "";
</script>