@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('缴费列表') }}</div>
                @if(Auth::user()->can('create',App\Model\Payment::class))
                <div class="card-header">
                    <a href="{{route('payment.create')}}" type="" class="btn btn-primary btn-sm">{{ __('新增缴费') }}</a>
                </div>
                @endif
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="hidden-sm hidden-xs">编号</th>
                                <th>缴费名称</th>
                                <th class="hidden-sm hidden-xs">缴费人</th>
                                <th class="hidden-sm hidden-xs">缴费金额</th>
                                <th class="hidden-sm hidden-xs">缴费方式</th>
                                <th class="hidden-sm hidden-xs">发生时间</th>
                                <th>备注</th>
                                <th class="hidden-sm hidden-xs">收款人</th>
                               
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $model)
                            <tr>
                                <td class="hidden-sm hidden-xs">{{$model->id}} </td>
                                <td>{{ $model->name }}</td>
                                <td class="hidden-sm hidden-xs">{{ $model->student_id }}</td>
                                <td class="hidden-sm hidden-xs">￥{{ $model->total}}</td>
                                <td class="hidden-sm hidden-xs">{{ $model->total}}</td>
                                @php 
                                $date = Carbon\Carbon::createFromDate($model->created_at.'');
                                @endphp
                                <td class="hidden-sm hidden-xs">{{ $date->year.'-'.$date->month.'-'.$date->day}}</td>
                                <td>{{ $model->comment}}</td>
                                <td class="hidden-sm hidden-xs">{{ $model->creator}}</td>
                              
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