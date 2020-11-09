@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('支出管理') }}</div>
                  @if(Auth::user()->can('create',App\Model\Spend::class))
                    <div class="card-header">
                        <a href="{{route('spend.create')}}" type="" class="btn btn-primary btn-sm">{{ __('添加') }}</a>
                    </div>
                  @endif
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th class="hidden-sm hidden-xs">编号</th>
                            <th>支出名称</th>
                            <th class="hidden-sm hidden-xs">支出科目</th>
                            <th>支出金额</th>                        
                            <th class="hidden-sm hidden-xs">发生时间</th>
                            <th>备注</th>
                            <th class="hidden-sm hidden-xs">录入人</th>
                            <th class="hidden-sm hidden-xs"> 录入时间</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($spends as $model)
                        <tr>
                            <td class="hidden-sm hidden-xs">{{$model->id}} </td>
                            <td>{{ $model->name }}</td>
                            <td class="hidden-sm hidden-xs">{{$model->constant->label_name}}</td>
                            <td>{{ $model->amount}}</td>
                            <td class="hidden-sm hidden-xs">{{ $model->which_day}}</td>
                            <td>{{ $model->comment}}</td>
                            <td class="hidden-sm hidden-xs">{{ $model->creator->name}}</td>
                            <td class="hidden-sm hidden-xs">{{ $model->created_at}}</td>
                         </tr>
                        @endforeach
                    </tbody>
                    </table>
                    <div>{{ $spends->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
