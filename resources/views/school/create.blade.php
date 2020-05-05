@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('新增学校') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('school.store') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('校区名称') }}</label>

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
                            <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('联系方式') }}</label>

                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}">

                                @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('校区地址') }}</label>

                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" >

                                @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="lunch_fee" class="col-md-4 col-form-label text-md-right">{{ __('午餐价格') }}</label>

                            <div class="col-md-6">
                                <input id="lunch_fee" type="number" class="form-control" name="lunch_fee">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="dinner_fee" class="col-md-4 col-form-label text-md-right">{{ __('晚餐价格') }}</label>

                            <div class="col-md-6">
                                <input id="dinner_fee" type="number" class="form-control" name="dinner_fee">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="snack_fee" class="col-md-4 col-form-label text-md-right">{{ __('间点价格') }}</label>

                            <div class="col-md-6">
                                <input id="snack_fee" type="number" class="form-control" name="snack_fee">
                            </div>
                        </div>
                        
                           <div class="form-group row">
                            <label for="threshold" class="col-md-4 col-form-label text-md-right">{{ __('特长课到期提醒阈值') }}</label>

                            <div class="col-md-6">
                                <input id="threshold" type="number" class="form-control" name="threshold">
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="headmaster_id" class="col-md-4 col-form-label text-md-right">{{ __('超级管理员') }}</label>

                            <div class="col-md-6">
                                <select class="form-control" name="headmaster_id" id="headmaster_id">
                                    @foreach($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                </select>                                
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
