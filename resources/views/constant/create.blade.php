@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('创建新数据字典值') }}</div>

                <div class="card-body">
                    <form role="form" method="POST" action="{{ url('/constant') }}">

                        {!! csrf_field() !!}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class="control-label">数据字典名称 ： </label>
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}">   
                            <input type="hidden" name="parent_id" value="{{ $id }}">  
                        </div>
                         <div class="form-group{{ $errors->has('label_name') ? ' has-error' : '' }}">
                            <label class="control-label">数据字典名称 ： </label>
                            <input type="text" class="form-control" name="label_name" value="{{ old('label_name') }}">  
                          
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-btn fa-user"></i>提交
                            </button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
