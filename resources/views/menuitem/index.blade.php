@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('菜品管理') }}</div>
                @if(Auth::user()->can('create',App\Model\Menuitem::class))
                <div class="card-header">
                    <a href="{{route('menuitem.create')}}" type="" class="btn btn-primary btn-sm">{{ __('添加') }}</a>
                </div>
                @endif
                <div class="card-body">
                    <table class="table table-striped table-bordered bootstrap-datatable responsive">
                        <thead>
                            <tr>
                                <th>编号</th>
                                <th>菜品名称</th>                            
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($menuitems as $model)
                            <tr>
                                <td>{{$model->id}}</td>
                                <td>{{ $model->name }}</td>
                                <td class="center">
                                    <a class="btn btn-info" href="{{ URL::to('menuItem/' . $model->id . '/edit') }}">
                                        <i class="glyphicon glyphicon-edit icon-white"></i>
                                        编辑
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