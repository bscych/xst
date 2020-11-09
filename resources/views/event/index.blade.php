@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('学校事件管理') }}</div>
                
                    <div class="card-header">
                        <a href="{{route('event.create')}}" type="" class="btn btn-primary btn-sm">{{ __('添加') }}</a>
                    </div>
               
                <div class="card-body">
                    <table class="table table-striped responsive">
                    <thead>
                        <tr class="text-center">
                            <th>编号</th>                           
                            <th>事件名称</th>
                            <th>日期</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($events as $event)
                        <tr class="text-center">
                            <td>{{$event->id}} </td>
                           
                            <td>{{ $event->name }}</td>
                            <td>{{ $event->start_date }} 到 {{ $event->end_date }}</td>
                            
                            <td class="center">
                                <a class="btn btn-info" href="{{ URL::to('event/' . $event->id . '/edit') }}">                                    
                                    编辑
                                </a>
                                <a class="btn btn-danger" href="{{ URL::to('event/' . $event->id) }}">                                  
                                    删除
                                </a>
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