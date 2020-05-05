@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('新增特殊日期') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('specialdate.store') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('日期名称') }}</label>

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
                            <label for="type" class="col-md-4 col-form-label text-md-right">{{ __('日期类型') }}</label>

                            <div class="col-md-6">
                                <select class="form-control" name="type" >
                                <option value="0">假期</option>
                                <option value="1">工作日</option>
                            </select>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="which_day" class="col-md-4 col-form-label text-md-right">{{ __('日期') }}</label>

                            <div class="col-md-6">
                                <input id="which_day" type="date" class="form-control @error('which_day') is-invalid @enderror" name="which_day" >

                                @error('which_day')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
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
