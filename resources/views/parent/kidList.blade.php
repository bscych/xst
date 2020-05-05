@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('孩子列表') }}</div>
           
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>                                
                                <th scope="col">名字</th>                              
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kids as $student)                          
                            <tr>                              
                                <td><a href="{{route('schedule.getCalendarList',['student_id'=>$student->id])}}">{{$student->name}}</a></td>                              
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
