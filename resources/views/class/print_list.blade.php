@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('学生列表') }}</div>

                <div class="card-body">
                    <table class="table table-striped table-bordered">
                        <thead>

                            <tr>
                                <th class="text-center"><small>学生名字</small></th>                          
                                <th class="text-center"><small>就读学校</small></th>
                                <th class="text-center"><small>所在班级</small></th>
                                <th class="text-center"><small>打印作业</small></th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $student)
                            <tr>
                                <td class="text-center">{{$student->name}}</td>                           
                                <td class="text-center">
                                    {{App\Model\Constant::find($student->constant_school_id)->label_name}}
                                </td>
                                <td class="text-center">
                                    {{$student->grade.'年'.$student->class_room.'班'}}                             
                                </td>
                                <td class="text-center">
                                    @php
                                    $homework = $homeworks->where('constant_school_id',$student->constant_school_id)->where('grade',$student->grade)->where('class',$student->class_room)->first();
                                    @endphp
                                    @if($student->attend==='0')
                                    <label class="text-warning">今天不出勤</label> 
                                    @else                            
                                    @if($homework!=null)
                                    <a href="{{route('classmodel.print',['student_id'=>$student->id,'class_id'=>$classmodel_id])}}" target="_blank" class="btn btn-primary btn-sm">打印</a>   
                                    @else
                                    <label class="text-danger">作业还没上传</label>                            
                                    @endif
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
