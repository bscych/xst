   <table class="table table-striped table-bordered">
                        <thead>

                            <tr>
                                <th rowspan="2"class="text-center align-middle"><small>日期</small></th>
                                @foreach($class->students as $student)
                                <th colspan="3" class="text-center"><small>{{$student->name}}</small></th>
                                @endforeach
                            </tr>
                            <tr>
                                @foreach($class->students as $student)
                                <th class="text-center"><small>出勤</small></th>
                                <th class="text-center"><small>午餐</small></th>
                                <th class="text-center"><small>晚餐</small></th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dates as $whichday)
                                @php 
                                $hasSchedule = $schedules->where('date',$whichday)->count()>0;  
                                $totalAttend = $schedules->where('date',$whichday)->where('attend',1)->sum('attend');
                                $totalLunch = $schedules->where('date',$whichday)->where('lunch',1)->sum('lunch');
                                $totalDinner = $schedules->where('date',$whichday)->where('dinner',1)->sum('dinner');
                                $hasData = ($totalAttend+$totalLunch+$totalDinner)>0;
                                @endphp
                            @if($hasSchedule && $hasData)
                            <tr>
                                <td class="text-center">{{$whichday}}</td>
                                @foreach($class->students as $student)
                                 @php 
                                    $schedule = $schedules->where('student_id','=',$student->id)->where('date','=',$whichday)->first();                                     
                                 @endphp
                                @if ($schedule!=null)
                                <td class="text-center">
                                    {{$schedule->attend==0?'':'√'}}
                                </td>
                                <td class="text-center">
                                    {{$schedule->lunch==0?'':'√'}}
                                </td>
                                <td class="text-center">
                                    {{$schedule->dinner==0?'':'√'}}
                                </td>
                                @else
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                @endif

                                @endforeach

                            </tr>
                            @endif
                            @endforeach

                               <tr>
                                <td class="text-center align-middle"><small>合计</small></td>
                                @foreach($class->students as $student)
                                @php
                                $totalLunch = $schedules->where('student_id',$student->id)->where('lunch',1)->count();
                                $totalDinner = $schedules->where('student_id',$student->id)->where('dinner',1)->count();
                                @endphp
                                <td class="text-center">出勤{{$schedules->where('student_id','=',$student->id)->where('attend','=',1)->count()}}<small>天</small></td>
                                <td class="text-center">午餐{{$totalLunch}}<small> 餐</small></td>
                                 <td class="text-center">晚餐{{$totalDinner}}<small> 餐</small></td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="text-center align-middle" rowspan="2"><small>费用总计</small></td>
                                @foreach($class->students as $student)
                                @php
                                $totalAttend = $schedules->where('student_id',$student->id)->where('attend',1)->count();
                                $totalLunch = $schedules->where('student_id',$student->id)->where('lunch',1)->count();
                                $totalDinner = $schedules->where('student_id',$student->id)->where('dinner',1)->count();
                                $snack_fee = $class->course->school->snack_fee;
                                $lunch_fee = $class->course->school->lunch_fee;
                                $dinner_fee = $class->course->school->dinner_fee;
                                @endphp
                                <td colspan="3" class="text-center">
                                    <span>{{'间点费：'.$totalAttend*$snack_fee}}</span><br>
                                    <span>{{'午餐费：'.$totalLunch*$lunch_fee}}</span><br>
                                    <span>{{'晚餐费：'.$totalDinner*$dinner_fee}}</span><br>
                                    <span>{{'  合计：'.($totalAttend*$snack_fee + $totalLunch*$lunch_fee + $totalDinner*$dinner_fee)}}<span></td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>