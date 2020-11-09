@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('请选择您的一个孩子进行下一步操作') }}</div>
           
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>                                
                                <th scope="col">名字</th>   
                                <th scope="col">快速订餐</th> 
                                <th scope="col">订餐记录</th> 
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kids as $student)                          
                            <tr>                              
                                <td>{{$student->name}}</td>   
                                <td><a href="{{route('parent.bookmeal',['student_id'=>$student->id])}}" class="btn btn-primary">快速订餐</a></td> 
                                <td><a href="{{route('parent.bookingHistory',['student_id'=>$student->id])}}" class="btn btn-primary">订餐记录</a></td> 
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
