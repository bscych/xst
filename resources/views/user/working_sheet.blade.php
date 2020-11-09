@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{$month.'月'}}考勤</div>
              
                <div class="card-body">
                 <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center"><small>姓名</small></th>
                            <th class="text-center"><small>总课时数</small></th>
                            <th class="text-center"><small>总课人次</small></th>
                        </tr>
                    </thead>                 
                    <tbody>
                       @foreach($datas as $data)
                       <tr>
                           <td class="text-center"><a href="{{route('user.getTCKListByTeacherId',['year'=>$year,'month'=>$month,'teacher_id'=>$data['teacher']['id']])}}">{{$data['teacher']['name']}}</a></td>
                            <td class="text-center">{{$data['sum_of_class']}}</td>
                            <td class="text-center">{{$data['sum_of_student']}}</td>
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