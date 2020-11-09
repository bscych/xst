@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('新增') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('visitor.store') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('姓名（必填）') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="gender" class="col-md-4 col-form-label text-md-right">{{ __('性别（必填）') }}</label>

                            <div class="col-md-6">
                                <select id="gender" class="form-control @error('gender') is-invalid @enderror" name="gender" value="{{ old('gender') }}">
                                <option value="男">男</option>
                                <option value="女">女</option>
                            </select>
                                @error('gender')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        
                           <div class="form-group row">
                            <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('联系方式电话(必填)') }}</label>

                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control" name="phone">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="birthday" class="col-md-4 col-form-label text-md-right">{{ __('生日') }}</label>

                            <div class="col-md-6">
                                <input id="birthday" type="date" class="form-control @error('birthday') is-invalid @enderror" name="birthday" >

                                @error('birthday')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

              
                        <div class="form-group row">
                            <label for="parent_name" class="col-md-4 col-form-label text-md-right">{{ __('父母信息') }}</label>

                            <div class="col-md-6">
                                <input id="parent_name" type="text" class="form-control" name="parent_name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="interests" class="col-md-4 col-form-label text-md-right">{{ __('关注课程') }}</label>

                            <div class="col-md-6">
                                <input id="interests" type="text" class="form-control" name="interests">
                            </div>
                        </div>
                     
                        
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('提交') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
