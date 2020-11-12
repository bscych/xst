

@extends('layouts.app')

@section('script')
@parent
<script>
    function submitSchedule(school_id,class_id,date_str,student_id, field, url) {
    axios({
    method: 'post',
            url: url,
            data: {
                    school_id:school_id,
                    class_id:class_id,
                    student_id: student_id,
                    date:date_str,
                    field: field,
                    value: $('#' + field + student_id).prop('checked')
            }});
    }

</script>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                @if($student_id==null)
                <div class="card-header">{{ __('签到') }}</div>            
                @else
                <div class="card-header">{{ __('订餐') }}</div>
                @endif
                <div class="card-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">姓名</th>
                                <th colspan="3" class="text-center">日期:{{$date}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($student_id===null)
                            @foreach ($schedules as $schedule)                           
                            <tr>
                                <td class="text-right">{{$schedule->student->name}} </td>
                                <td>
                                     <label class="checkbox-inline"><input type="checkbox"  onChange=" submitSchedule({{$school_id}},{{$class->id}},'{{$date}}',{{$schedule->student->id}}, 'attend', '{{route('schedule.store')}}')"  id="{{'attend'.$schedule->student->id}}" {{$schedule->attend==1?'checked="checked"':''}} >出勤</label>
                                </td>
                                 @if($class->course->has_lunch==1)<td>                                    
                                    <label class="checkbox-inline"><input type="checkbox" onChange="submitSchedule({{$school_id}},{{$class->id}},'{{$date}}',{{$schedule->student->id}}, 'lunch','{{route('schedule.store')}}')" id="{{'lunch'.$schedule->student->id}}" {{$schedule->lunch==1?'checked="checked"':''}} >午餐</label>
                                    </td>@endif
                                 
                                 @if( $class->course->has_dinner==1)<td>
                                    <label class="checkbox-inline"><input type="checkbox" onChange="submitSchedule({{$school_id}},{{$class->id}},'{{$date}}',{{$schedule->student->id}}, 'dinner','{{route('schedule.store')}}')" id="{{'dinner'.$schedule->student->id}}" {{$schedule->dinner==1?'checked="checked"':''}} >晚餐</label>
                                 </td> @endif
                            </tr>                         
                            @endforeach
                            @else
                            
                            <tr>
                                @php
                                $schedule = $schedules->where('student_id',$student_id)->first();
                                @endphp
                                <td>{{$schedule->student->name}} </td>
                                <td>
                                    <!--parents can not tick kid's attend 
                                    <label class="checkbox-inline"><input type="checkbox"  onChange=" submitSchedule({{$schedule->id}}, 'attend', '{{route('schedule.store')}}')"  id="{{'attend'.$schedule->id}}" {{$schedule->attend==1?'checked="checked"':''}} >出勤</label>
                                    -->
                                </td>
                                <td>
                                    @if($schedules->where('student_id',$student_id)->first()->classmodel->course->has_lunch==1)
                                    <label class="checkbox-inline"><input type="checkbox" onChange="submitSchedule({{$schedule->id}}, 'lunch','{{route('schedule.store')}}')" id="{{'lunch'.$schedule->id}}" {{$schedule->lunch==1?'checked="checked"':''}} >午餐</label>
                                    @endif
                                </td>
                                <td>
                                    @if( $schedules->where('student_id',$student_id)->first()->classmodel->course->has_dinner==1)
                                    <label class="checkbox-inline"><input type="checkbox" onChange="submitSchedule({{$schedule->id}}, 'dinner','{{route('schedule.store')}}')" id="{{'dinner'.$schedule->id}}" {{$schedule->dinner==1?'checked="checked"':''}} >晚餐</label>
                                    @endif
                                </td>
                            </tr>    
                            @endif
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

