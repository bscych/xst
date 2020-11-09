@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card mb-5">
                <div class="card-header">{{ __('到访') }}</div>

                <div class="card-header">
                    <form role="form" method="GET" action="{{route('visitor.index') }}" class="form-inline">
                        @csrf                        
                        <label class="sr-only" for="inlineFormInputName2">姓名</label>
                        <input type="text" class="form-control mb-2 mr-sm-2" id="inlineFormInputName2" placeholder="查询学生姓名" name="name" value="{{ old('name') }}">
                        <button type="submit" class="btn btn-primary mb-2">查询</button>                        
                    </form>
                </div>
                @if(Auth::user()->can('create',App\Model\Visitor::class))
                <div class="card-header">
                    <a href="{{route('visitor.create')}}" class="btn btn-primary btn-sm">{{ __('添加') }}</a>
                </div>
                @endif
                <div class="card-body"> <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th class="hidden-sm hidden-xs">#</th>
                            <th>姓名</th>
                            <th class="hidden-sm hidden-xs">性别</th>
                            <th class="hidden-sm hidden-xs">生日</th>
                            <th class="hidden-sm hidden-xs">父母</th>
                            <th class="hidden-sm hidden-xs">联系电话</th>
                            <th class="hidden-sm hidden-xs">关心课程</th>
                            <th class="hidden-sm hidden-xs">联系历史</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $model)
                        <tr>
                            <td class="hidden-sm hidden-xs">{{$model->id}}</td>
                            <td><a >{{ $model->name }}</a></td>
                            <td class="hidden-sm hidden-xs">{{ $model->gender }}</td>
                            <td class="hidden-sm hidden-xs">{{ $model->birthday }}</td>
                            <td class="hidden-sm hidden-xs">{{ $model->parent_name}}</td>
                             <td class="hidden-sm hidden-xs">{{ $model->phone}}</td>
                             <td class="hidden-sm hidden-xs">{{ $model->interests}}</td>
                              <td class="hidden-sm hidden-xs">
                                  <ol>
                                  @foreach(collect(json_decode($model->contact_history,JSON_UNESCAPED_UNICODE)) as $history)                                  
                                  <li>{{ $history}}</li>
                                  @endforeach
                                  </ol>
                              </td>
                            <td class="center">
                                <form action="{{ route('visitor.destroy',$model->id)}}" method="post">
                                    <a class="btn btn-primary btn-setting" data-toggle="modal" data-target="#exampleModal" onclick="$('#visitor_id').val({{$model->id}})">
                                        增加联系记录
                                    </a>
                                  
                                    <a class="btn btn-primary" href="{{ route('visitor.convertToStudent',['visitor_id'=>$model->id]) }}">
                                        转化为学生
                                    </a> 
                                </form>
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

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">到访记录</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <form role="form" method="POST" action="{{ route('visitor.addContactHistory') }}">
            @csrf
           <input type="hidden" id='visitor_id' name='visitor_id' value="">

             <div class="form-group">
    <label for="exampleInputEmail1">到访记录</label>
    <textarea  class="form-control" id="contact_history" aria-describedby="emailHelp" name="contact_history"></textarea>
    <small id="emailHelp" class="form-text text-muted"></small>
  </div>
  <div class="form-group">
    <label for="date">沟通日期（默认不填，为今天） </label>
    <input type="date" class="form-control" id="date">
  </div>
  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
        <button type="submit" class="btn btn-primary">提交</button>
         </form>
      </div>
    </div>
  </div>
</div>
