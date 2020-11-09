@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('新增班级') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('classmodel.store') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="start_date" class="col-md-4 col-form-label text-md-right">{{ __('课程名称') }}</label>

                            <div class="col-md-6">
                                <label class="form-control">{{$course->name}}</label>
                                <input id="course_id" type="hidden" name="course_id" value="{{ $course->id }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('班级名称') }}<span class="text-danger">（必填）</span></label>

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
                            <label for="teacher_id" class="col-md-4 col-form-label text-md-right">{{ __('授课老师') }}<span class="text-danger">（必填）</span></label>

                            <div class="col-md-6">
                                <select class="form-control " name="teacher_id" >
                                    @foreach($teachers as $teacher)
                                    <option value="{{$teacher->id}}">{{$teacher->name}}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="start_date" class="col-md-4 col-form-label text-md-right">{{ __('开始日期') }}<span class="text-danger">（必填）</span></label>

                            <div class="col-md-6">
                                <input id="start_date" type="date" class="form-control @error('start_date') is-invalid @enderror" name="start_date" value="{{ old('start_date') }}">
                                @error('start_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            @if($course->is_speciality_course===1)
                            <label for="end_date" class="col-md-4 col-form-label text-md-right">{{ __('结束日期') }}</label>
                            @else
                             <label for="end_date" class="col-md-4 col-form-label text-md-right">{{ __('结束日期') }}<span class="text-danger">（必填）</span></label>
                            @endif
                            <div class="col-md-6">
                                <input id="end_date" type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date" >

                                @error('end_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                      
                        <div class="form-group row">
                            <label for="end_date" class="col-md-4 col-form-label text-md-right">
                                {{ __('每周上课频率') }}<br>
                             @if($course->is_speciality_course===0)
                             托管课默认每天都托管，如果选择了特定的某天，那么家长和老师只能在那天订餐和签到
                             @else
                             特长课选择哪天上课，以及哪个时段，方便通过微信提醒家长孩子按时上课
                             @endif
                            </label>

                            <div class="col-md-6">
                                <table class="table table-bordered">
                                 <tr>
                                    <th>周几上课</th>
                                     @if($course->is_speciality_course===1) <th>开始时间</th><th>结束时间</th>@endif
                                </tr>
                                @for($i=0;$i<7;$i++)
                                <tr>
                                    <td><label class="checkbox-inline"><input type="checkbox" name="{{$i}}">周{{$i===0?'日':$i}}</label> </td>
                                   @if($course->is_speciality_course===1)  <td><input name="{{$i.'_s'}}" type="time"></td>
                                    <td><input name="{{$i.'_e'}}" type="time"></td>@endif
                                </tr>
                                
                                @endfor
                                </table>
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