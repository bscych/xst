@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('用户管理') }}</div>
                @if(Auth::user()->can('create',App\User::class))
                <div class="card-header">
                    <a class="btn btn-primary btn-sm" href="{{ route('user.create') }}">新增用户</a> 
                </div>
                @endif
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">名字</th>
                                <!--th scope="col">电子邮邮箱</th--> 
                                <th scope="col">权限</th> 
                                <th scope="col">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $usr)
                            @if(Auth::user()->can('view', $usr))
                            <tr>
                                <th scope="row">{{$loop->index+1}}</th>
                                <td>{{$usr->name}}</td>
                                <!--td>{{$usr->email}}</td-->
                                <td>{{$usr->roles->count()===0?'':$usr->roles->first()->label_name}}</td>
                                <td>
                                    <a class="btn btn-info btn-sm" href="{{ URL::to('user/' . $usr->id . '/edit') }}"> 编辑</a>
                                    <a class="btn btn-danger btn-sm" href="{{ URL::to('user/' . $usr->id) }}"> 删除</a>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                     <div>{{ $users->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
