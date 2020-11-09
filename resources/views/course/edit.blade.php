@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('编辑课程') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('course.update',$model) }}">
                        @method('PUT')
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('课程名称（必填）') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $model->name }}" required autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="unit_price" class="col-md-4 col-form-label text-md-right">{{ __('课程单价') }}</label>

                            <div class="col-md-6">
                                <input id="unit_price" type="number" class="form-control @error('unit_price') is-invalid @enderror" name="unit_price"  value="{{$model->unit_price}}">

                                @error('unit_price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="unit" class="col-md-4 col-form-label text-md-right">{{ __('单位') }}</label>

                            <div class="col-md-6">
                                <input id="unit" type="text" class="form-control @error('unit') is-invalid @enderror disabled" name="unit"  value="{{$model->unit}}">

                                @error('unit')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="duration" class="col-md-4 col-form-label text-md-right">{{ __('总时长') }}</label>

                            <div class="col-md-6">
                                <input id="duration" type="number" class="form-control @error('duration') is-invalid @enderror" name="duration" value="{{$model->duration}}">

                                @error('duration')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="is_speciality_course" class="col-md-4 col-form-label text-md-right">{{ __('是否是特长课') }}<span class="small text-danger">（幼小，小学托管不属于特长课）</span></label>

                            <div class="col-md-6">
                                <select name="is_speciality_course" class="form-control">
                                    <option value="1" {{$model->is_speciality_course==='1'?'selected':''}}>是</option>
                                    <option value="0" {{$model->is_speciality_course==='0'?'selected':''}}>否</option>
                                </select>   
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="has_snack" class="col-md-4 col-form-label text-md-right">{{ __('是否提供间点') }}</label>

                            <div class="col-md-6">
                                <select name="has_snack" class="form-control">
                                    <option value="1" {{$model->has_snack==='1'?'selected':''}}>是</option>
                                    <option value="0" {{$model->has_snack==='0'?'selected':''}}>否</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="has_lunch" class="col-md-4 col-form-label text-md-right">{{ __('是否提供午餐') }}</label>

                            <div class="col-md-6">
                                <select name="has_lunch" class="form-control">
                                    <option value="1" {{$model->has_lunch==='1'?'selected':''}}>是</option>
                                    <option value="0" {{$model->has_lunch==='0'?'selected':''}}>否</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="has_dinner" class="col-md-4 col-form-label text-md-right">{{ __('是否提供晚餐') }}</label>

                            <div class="col-md-6">
                                <select name="has_dinner" class="form-control">
                                    <option value="1" {{$model->has_dinner==='1'?'selected':''}}>是</option>
                                    <option value="0" {{$model->has_dinner==='0'?'selected':''}}>否</option>
                                </select>   
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="in_count" class="col-md-4 col-form-label text-md-right">{{ __('是否纳入用统计') }}</label>

                            <div class="col-md-6">
                                <select name="in_count" class="form-control">
                                    <option value="1" {{$model->in_count==='1'?'selected':''}}>是</option>
                                    <option value="0" {{$model->in_count==='0'?'selected':''}}>否</option>
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
