@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class=""><a href="{{route('schedule.last_month_detail',['date'=>$date->format('Y-m-d')])}}">上个月报表</a></div>
                    @php 
                    $str = null;
                    if($students->count()===1){
                        $str = $date->year.'年'.$date->month.'月'.$students->first()->name.'的餐费统计表';
                    }else{
                        $str = $date->year.'年'.$date->month.'月'.$class->name.'的统计报表';
                    }   
                    $col_count = 0;
                    if($class!=null){
                        $col_count=1 ;
                    }
                    $has_lunch = $schedules->where('lunch','1')->count()>0;
                    $has_dinner = $schedules->where('dinner',1)->count()>0;
                    if($has_lunch){$col_count++;}
                    if($has_dinner){$col_count++;}
                    @endphp
                    <div class="text-center">{{$str}} </div>
                    <div>
                        @if(now()->month>$date->month && now()->year>=$date->year)
                        <a href="{{route('schedule.next_month_detail',['date'=>$date->format('Y-m-d')])}}">下个月报表</a>
                        @endif
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th rowspan="2"class="text-center align-middle"><small>日期</small></th>
                                @foreach($students as $student)
                                <th colspan="{{$col_count}}" class="text-center"><small>{{$student->name}}</small></th>
                                @endforeach
                            </tr>
                            <tr>
                                @foreach($students as $student)  
                                @if($class!=null)<th class="text-center"><small>出勤</small></th> @endif
                                @if($has_lunch) <th class="text-center"><small>午餐</small></th>@endif
                                @if($has_dinner)<th class="text-center"><small>晚餐</small></th>@endif
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dates as $whichday)
                            @php 
                            $hasSchedule = $schedules->where('date',$whichday)->count()>0;  
                            $totalLunch = $schedules->where('date',$whichday)->where('lunch','1')->sum('lunch');
                            $totalDinner = $schedules->where('date',$whichday)->where('dinner','1')->sum('dinner');
                            $hasData = ($totalLunch+$totalDinner)>0;
                            @endphp
                            @if($hasSchedule && $hasData)
                            <tr>
                                <td class="text-center">{{$whichday}}</td>
                                @foreach($students as $student)
                                @php 
                                $schedule = $schedules->where('student_id',$student->id)->where('date',$whichday)->first();                                
                                @endphp
                                @if ($schedule!=null)
                                @if($class!=null)
                                  
                                <td class="text-center">√</td>
                                @endif
                                @if($has_lunch)<td class="text-center">{{$schedule->lunch==0?'':'√'}}</td>@endif
                                @if($has_dinner)<td class="text-center">{{$schedule->dinner==0?'':'√'}}</td>@endif
                                @else
                                <td class="text-center"></td>
                                @if($has_lunch)<td class="text-center"></td>@endif
                                @if($has_dinner)<td class="text-center"></td>@endif
                                @endif

                                @endforeach

                            </tr>
                            @endif
                            @endforeach

                            <tr>
                                <td class="text-center align-middle"><small>合计</small></td>
                                @foreach($students as $student)
                                @php
                                $totalLunch = $schedules->where('student_id',$student->id)->where('lunch',1)->count();
                                $totalDinner = $schedules->where('student_id',$student->id)->where('dinner',1)->count();
                                @endphp
                                @if($class!=null)
                                @php $totalAttend = $attendances->where('student_id',$student->id)->count(); @endphp
                                <td class="text-center">出勤{{$totalAttend}}<small> 天</small></td>
                                @endif
                                @if($has_lunch)<td class="text-center">午餐{{$totalLunch}}<small> 餐</small></td>@endif
                                @if($has_dinner)<td class="text-center">晚餐{{$totalDinner}}<small> 餐</small></td>@endif
                                @endforeach

                            </tr>
                           
                            <tr>
                                <td class="text-center align-middle" rowspan="2"><small>费用总计</small></td>
                                @foreach($students as $student)
                                @php
                              
                                $totalLunch = $schedules->where('student_id',$student->id)->where('lunch',1)->count();
                                $totalDinner = $schedules->where('student_id',$student->id)->where('dinner',1)->count();
                                $snack_fee = App\Model\School::find(session('school_id'))->snack_fee;
                                $lunch_fee = App\Model\School::find(session('school_id'))->lunch_fee;
                                $dinner_fee = App\Model\School::find(session('school_id'))->dinner_fee;
                                @endphp
                                <td colspan="{{$col_count}}" class="text-center">                                    
                                    @if($has_lunch)<span>{{'午餐费：'.$totalLunch*$lunch_fee}}</span><br>@endif
                                    @if($has_dinner)<span>{{'晚餐费：'.$totalDinner*$dinner_fee}}</span><br>@endif
                                    <span>{{'  合计：'.($totalDinner*$dinner_fee + $totalLunch*$lunch_fee)}}<span></td>
                                            @endforeach
                            </tr>
                          
                                            </tbody>
                                            </table>
                                            <br>
                                            </div>
                                            <div class="card-body">
                                                <!--a class="btn btn-primary" href="#" data-toggle="modal" data-target="#myModal">{{__('补打卡')}}</a-->
                                            </div>
                                            </div>
                                            </div>
                                            </div>
                                            </div>
                                            @endsection


                                            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                                                 aria-hidden="true">
                                                <form role="form" method="GET" action="{{route('schedule.reCheckIn')}}">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h3>选择补签日期</h3>
                                                                <button type="button" class="close" data-dismiss="modal">×</button>

                                                            </div>
                                                            <div class="modal-body">
                                                                <input type="date" name="date" class="form-control">
                                                              @if($class!=null)
                                                              <input type="hidden" name="class_id" value="{{$class->id}}">
                                                              @endif
                                                            </div>
                                                            <div class="modal-footer">
                                                                <a href="#" class="btn btn-default" data-dismiss="modal">取消</a>
                                                                <button type="submit" class="btn btn-primary">签到</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>