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
    
    function submitAutoBookMeal(student_id,which_meal,component_id,url) {
    axios({
    method: 'post',
            url: url,
            data: {
                student_id: student_id,               
                which_meal:which_meal,
                auto_book_meal_singal: $('#'+component_id).prop('checked'),                  
            }});
    }
</script>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
              
                <div class="card-header">{{'给'.$student->name.__('订餐') }}
                    <span class="float-right"><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModalCenter">自动订餐设置</button>
                       
                    </span>
                
                </div>
              @php $menuMissingMsg = '餐谱还没有准备好呢！'; @endphp
                <div class="card-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                               
                                <th class="text-center">日期</th> 
                                @if($class->course->has_lunch==='1' )
                                <th class="text-center" colspan="2">午餐</th>
                                @endif
                                @if($class->course->has_dinner==='1')
                                <th class="text-center" colspan="2">晚餐</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>    
                            @foreach($schedules as $sched)
                               @php $schedule=data_get($sched,config('constants.SCHEDULE_STRING_KEY')); $menu=data_get($sched,config('constants.MENU_STRING_KEY')); $whetherDisplay = data_get($sched,config('constants.CAN_DISPLAY_STRING_KEY'));@endphp
                               @if(!$whetherDisplay)
                               <tr>
                                    <td class="text-right">{{data_get($sched,config('constants.DATE_STRING_KEY'))}}</td>  
                                    <td colspan="4" class="text-center">{{__('今天').$student->name.'不出勤'}}</td>
                               </tr>
                               @else
                               <tr>                              
                                <td class="text-right">{{data_get($sched,config('constants.DATE_STRING_KEY'))}}</td>               
                                @if($class->course->has_lunch==='1')<!--display lunch -->
                                <td class="text-center"> 
                                    @if($menu!=null)<!--is there menu data -->
                                        @foreach(collect(json_decode($menu->lunch,JSON_UNESCAPED_UNICODE)) as $meal)
                                    {{$meal}}<br>
                                    @endforeach
                                    @else 
                                    {{$menuMissingMsg}}
                                    @endif         <!--end menu data check-->                       
                                </td>                               
                                <td class="text-center"> 
                                    <label class="checkbox-inline">
                                       @if(data_get($sched,config('constants.CAN_EDIT_STRING_KEY')))<!--whether user can edit booking record-->
                                       <input type="checkbox" id="{{'lunch'.$student->id}}" onChange="submitSchedule({{$school_id}},{{$class->id}},'{{data_get($sched,config('constants.DATE_STRING_KEY'))}}',{{$student->id}}, 'lunch', '{{route('schedule.store')}}')" {{$schedule->lunch==1?'checked="checked"':''}} >午餐
                                       @else
                                       <input type="checkbox"  disabled {{$schedule->lunch=='1'?'checked="checked"':''}} >午餐
                                       @endif
                                    </label>
                                </td>
                                 @endif
                                @if($class->course->has_dinner==='1')
                                <td> 
                                     @if($menu!=null)
                                    @foreach(collect(json_decode($menu->dinner,JSON_UNESCAPED_UNICODE)) as $meal)
                                {{ $meal}}<br>
                                @endforeach
                                @else
                                {{$menuMissingMsg}}
                                @endif
                                </td>  
                                 <td>                                   
                                    <label class="checkbox-inline">
                                         @if(data_get($sched,config('constants.CAN_EDIT_STRING_KEY')))<!--whether user can edit booking record-->
                                         <input type="checkbox" id="{{'dinner'.$student->id}}" onChange="submitSchedule({{$school_id}},{{$class->id}},'{{data_get($sched,config('constants.DATE_STRING_KEY'))}}',{{$student->id}}, 'dinner', '{{route('schedule.store')}}')" {{$schedule->dinner==1?'checked="checked"':''}} >晚餐
                                        @else
                                        <input type="checkbox"  {{$schedule->dinner=='1'?'checked="checked"':''}} disabled>晚餐
                                        @endif
                                    </label>
                                </td>
                                @endif
                            </tr> 
                            @endif<!--end of whether display check -->
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">设置自动订餐</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <table class="table table-striped table-bordered">
              @php 
              $course = $class->course; 
              $lunch_on = false;
              $dinner_on = false;
              if($auto_book_meal!=null){
              $lunch_on = $auto_book_meal->lunch.''==='1';
              $dinner_on = $auto_book_meal->dinner.''==='1';
              }
              @endphp
              <tr>
                @if($course->has_lunch)  <th>午餐</th> @endif
                @if($course->has_dinner) <th>晚餐</th> @endif
              </tr>
              <tr>
                @if($course->has_lunch)    <td> <div class="input-group mb-3">
                          <div class="input-group-prepend">
                              <div class="input-group-text">
                                  <input type="checkbox" id="auto_book_lunch" onchange="submitAutoBookMeal({{$student->id}},'lunch','auto_book_lunch',{{route('schedule.autoBookMeal')}})" {{$lunch_on?'checked="checked"':''}}>
                              </div>
                          </div>
                          <label class="form-control" >自动订午餐 </label>
                      </div></td>
                @endif
                @if($course->has_dinner)
                      <td> <div class="input-group mb-3">
                          <div class="input-group-prepend">
                              <div class="input-group-text">
                                  <input type="checkbox" id="auto_book_dinner" onchange="submitAutoBookMeal({{$student->id}},{{$class->id}},'dinner','auto_book_dinner','{{route('schedule.autoBookMeal')}}')" {{$dinner_on?'checked="checked"':''}}>
                              </div>
                          </div>
                          <label class="form-control" >自动订晚餐 </label>
                      </div></td>
                @endif
              </tr>
          </table>  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
      
      </div>
    </div>
  </div>
</div>
<!--end Modal-->
@endsection

