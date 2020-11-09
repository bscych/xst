@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('本周考勤') }}</div>

                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">考勤日期</th>                               
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($calendar as $date)                          
                            <tr>                           
                                <td class="center">
                                    @php $theDate = data_get($date,config()->get('constants.DATE_STRING_KEY')) @endphp
                                    <a class="btn btn-primary {{data_get($date,config()->get('constants.SUBMITTABLE_STRING_KEY'))?'':'disabled'}}" href="{{route('schedule.create',['date'=>$theDate])}}">周{{ \Illuminate\Support\Carbon::make($theDate)->dayOfWeek===0?'日':\Illuminate\Support\Carbon::make($theDate)->dayOfWeek}}({{$theDate}}) </a>
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

