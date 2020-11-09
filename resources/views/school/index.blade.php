@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('学校列表') }}</div>
                  @if(Auth::user()->can('create',App\Model\School::class))
                    <div class="card-header">
                        <a href="{{route('school.create')}}" type="" class="btn btn-primary btn-sm">{{ __('添加') }}</a>
                    </div>
                  @endif
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">名字</th>
                                <th scope="col">电话</th>
                                <th scope="col">地址</th>
                                <th scope="col">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($schools as $school)
                            @if(Auth::user()->can('view', $school))
                            <tr>
                                <th scope="row">{{$school->id}}</th>
                                <td>{{$school->name}}</td>
                                <td>{{$school->phone}}</td>
                                <td>{{$school->address}}</td>
                                <td>
                                    @if($school->parent_id===null)
                                    <a href="{{route('school.index',['school_id'=>$school->id])}}" class="btn btn-primary btn-sm">{{ __('分校') }}</a>
                                    @endif
                                    <a href="#" class="btn btn-primary btn-sm">{{ __('删除') }}</a>
                                    @can('update',$school)<a href="{{route('school.edit',$school)}}" class="btn btn-primary btn-sm">{{ __('编辑') }}</a>@endcan
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
