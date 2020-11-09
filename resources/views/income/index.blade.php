@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('收入列表') }}</div>
                @if(Auth::user()->can('create',App\Model\Income::class))
                <div class="card-header">
                    <a href="{{route('income.create')}}" type="" class="btn btn-primary btn-sm">{{ __('新收入') }}</a>
                </div>
                @endif
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="hidden-sm hidden-xs">编号</th>
                                <th>收入名称</th>
                                <th class="hidden-sm hidden-xs">缴费人</th>
                                <th class="hidden-sm hidden-xs">收入金额</th>
                                <th class="hidden-sm hidden-xs">收入方式</th>
                                <th class="hidden-sm hidden-xs">发生时间</th>
                                <th>备注</th>
                                <th class="hidden-sm hidden-xs">录入人</th>
                               
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($incomes as $model)
                            <tr>
                                <td class="hidden-sm hidden-xs">{{$model->id}} </td>
                                <td>{{ $model->name }}</td>
                                <td class="hidden-sm hidden-xs">{{ $model->paid_by }}</td>
                                <td class="hidden-sm hidden-xs">￥{{ $model->amount}}</td>
                                <td class="hidden-sm hidden-xs">{{ $model->payment_method}}</td>
                                <td class="hidden-sm hidden-xs">{{ $model->created_at}}</td>
                                <td>{{ $model->comment}}</td>
                                <td class="hidden-sm hidden-xs">{{ $model->creator->name}}</td>
                              
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div>{{ $incomes->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection