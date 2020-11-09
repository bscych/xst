@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('编辑班级') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('classmodel.update',$class) }}">
                        @method('PUT')
                        @csrf

                        <div class="form-group row">
                            <label for="start_date" class="col-md-4 col-form-label text-md-right">{{ __('课程名称') }}</label>

                            <div class="col-md-6">
                                <label class="form-control">{{$class->course->name}}</label>
                                <input id="course_id" type="hidden" name="course_id" value="{{ $class->course->id }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('班级名称（必填）') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $class->name }}" required autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="teacher_id" class="col-md-4 col-form-label text-md-right">{{ __('授课老师(必填)') }}</label>

                            <div class="col-md-6">
                                <select class="form-control " name="teacher_id" >
                                    @foreach($teachers as $teacher)
                                    <option value="{{$teacher->id}}" {{$class->teacher_id===$teacher->id?"selected":""}}>{{$teacher->name}}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="start_date" class="col-md-4 col-form-label text-md-right">{{ __('开始日期（必填）') }}</label>

                            <div class="col-md-6">
                                <input id="start_date" type="date" class="form-control @error('start_date') is-invalid @enderror" name="start_date" value="{{ $class->start_date }}">
                                @error('start_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="end_date" class="col-md-4 col-form-label text-md-right">{{ __('结束日期(非必填)') }}</label>

                            <div class="col-md-6">
                                <input id="end_date" type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date" value="{{ $class->end_date }}" >

                                @error('end_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        @if($class->course->is_speciality_course==='1')
                        <div class="form-group row">
                            <label for="end_date" class="col-md-4 col-form-label text-md-right">{{ __('每周上课频率') }}</label>

                            <div class="col-md-6">
                                @for($i=0;$i<7;$i++)
                                <label class="checkbox-inline"><input type="checkbox" name="{{$i}}" {{$class->which_days->contains($i)?'checked':''}}>周{{$i===0?'日':$i}}</label>
                                @endfor
                            </div>
                        </div>
                        @endif
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