

@extends('layouts.app')

@section('script')
@parent
<script>
    function submitSchedule(schedule_id, field, url) {
    axios({
    method: 'post',
            url: url,
            data: {
            schedule_id: schedule_id,
                    field: field,
                    value: $('#' + field + schedule_id).prop('checked')
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
                                <th>姓名</th>
                                <th>日期:{{$date}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($student_id===null)
                            @foreach ($schedules as $schedule)                           
                            <tr>
                                <td>{{$schedule->student->name}} </td>
                                <td>
                                     <label class="checkbox-inline"><input type="checkbox"  onChange=" submitSchedule({{$schedule->id}}, 'attend', '{{route('schedule.store')}}')"  id="{{'attend'.$schedule->id}}" {{$schedule->attend==1?'checked="checked"':''}} >出勤</label>
                                    @if($schedule->classmodel->course->has_lunch==1)
                                    <label class="checkbox-inline"><input type="checkbox" onChange="submitSchedule({{$schedule->id}}, 'lunch','{{route('schedule.store')}}')" id="{{'lunch'.$schedule->id}}" {{$schedule->lunch==1?'checked="checked"':''}} >午餐</label>
                                    @endif
                                    @if( $schedule->classmodel->course->has_dinner==1)
                                     <label class="checkbox-inline"><input type="checkbox" onChange="submitSchedule({{$schedule->id}}, 'dinner','{{route('schedule.store')}}')" id="{{'dinner'.$schedule->id}}" {{$schedule->dinner==1?'checked="checked"':''}} >晚餐</label>
                                    @endif
                                </td>
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
                                    @if($schedules->where('student_id',$student_id)->first()->classmodel->course->has_lunch==1)
                                    <label class="checkbox-inline"><input type="checkbox" onChange="submitSchedule({{$schedule->id}}, 'lunch','{{route('schedule.store')}}')" id="{{'lunch'.$schedule->id}}" {{$schedule->lunch==1?'checked="checked"':''}} >午餐</label>
                                    @endif
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

