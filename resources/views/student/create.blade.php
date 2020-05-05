@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('新增学生') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('student.store') }}">
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
                            <label for="nation" class="col-md-4 col-form-label text-md-right">{{ __('民族') }}</label>

                            <div class="col-md-6">
                                <input id="nation" type="text" class="form-control" name="nation">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="parents_info" class="col-md-4 col-form-label text-md-right">{{ __('父母信息（姓名、电话）') }}</label>

                            <div class="col-md-6">
                                <input id="parents_info" type="text" class="form-control" name="parents_info">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="home_address" class="col-md-4 col-form-label text-md-right">{{ __('家庭住址') }}</label>

                            <div class="col-md-6">
                                <input id="home_address" type="text" class="form-control" name="home_address">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="live_brief" class="col-md-4 col-form-label text-md-right">{{ __('生活简介,食物禁忌，性格特点') }}</label>

                            <div class="col-md-6">
                                <input id="live_brief" type="text" class="form-control" name="live_brief">
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


<!--

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class=""></i> 新增学生</h2>
            </div>
            <div class="box-content">
                <form role="form" method="POST" action="{{ url('/student') }}">

                    @csrf
                    <div class="row">
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-3">
                            <label class="control-label">姓名 ： </label>
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="{{$errors->first('name')}}">   

                        </div>
                        <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }} col-md-3">
                            <label class="control-label">性别 ： </label>
                            <select class="form-control" name="gender" >
                                <option value="男">男</option>
                                <option value="女">女</option>
                            </select>
                        </div>


                        <div id="datetimepicker" class="input-append date form-group{{ $errors->has('birthday') ? ' has-error' : '' }} col-md-3">
                            <label class="control-label">生日 ： </label>
                            <input type="date" class="form-control" name="birthday" value="{{ old('birthday') }}"></input>
                            
                        </div>  
                        <div class="form-group{{ $errors->has('nation') ? ' has-error' : '' }} col-md-3">
                            <label class="control-label">民族 ： </label>
                            <input type="text" class="form-control" name="nation" value="{{ old('nation') }}">   
                        </div>
                    </div>



                    <div class="row">
                        <div class="form-group{{ $errors->has('health') ? ' has-error' : '' }} col-md-3">
                            <label class="control-label">健康状况 ： </label>
                            <input type="text" class="form-control" name="health" value="{{ old('health') }}">   
                        </div>

                        <div class="form-group{{ $errors->has('interest') ? ' has-error' : '' }} col-md-3">
                            <label class="control-label">兴趣爱好 ： </label>
                            <input type="text" class="form-control" name="interest" value="{{ old('interest') }}">   
                        </div>

                        <div class="form-group{{ $errors->has('home_address') ? ' has-error' : '' }} col-md-3">
                            <label class="control-label">家庭住址 ： </label>
                            <input type="text" class="form-control" name="home_address" value="{{ old('home_address') }}">
                        </div>

                        <div class="form-group{{ $errors->has('parents_info') ? ' has-error' : '' }} col-md-3">
                            <label class="control-label">父母信息 ： </label>
                            <input type="text" class="form-control" name="parents_info" value="{{ old('parents_info') }}">
                        </div>

                    </div>
                    <div class="row">
                        <div class="form-group{{ $errors->has('school') ? ' has-error' : '' }} col-md-3">
                            <label class="control-label">就读学校 ： </label>
                            <select class="form-control" name="school" >
                                <option value="高新园区中心小学">高新园区中心小学</option>
                                <option value="普罗旺斯小学">普罗旺斯小学</option>
                                <option value="普罗旺斯一期幼儿园">普罗旺斯一期幼儿园</option>
                                <option value="普罗旺斯二期幼儿园">普罗旺斯二期幼儿园</option>
                            </select>
                        </div>


                        <div class="form-group col-md-3">
                            <label class="control-label">年级 ： </label>
                            <select class="form-control" name="grade" >
                                <option value="0">幼儿园</option>
                                <option value="1">1年级</option>
                                <option value="2">2年级</option>
                                <option value="3">3年级</option>
                                <option value="4">4年级</option>
                                <option value="5">5年级</option>
                                <option value="6">6年级</option>
                                
                            </select>

                        </div>

                        <div class="form-group{{ $errors->has('class_room') ? ' has-error' : '' }} col-md-3">
                            <label class="control-label">班级 ： </label>
                            <input type="number" class="form-control" name="class_room" value="{{ old('class_room') }}"> 
                        </div>

                        <div class="form-group{{ $errors->has('class_supervisor_name') ? ' has-error' : '' }} col-md-3">
                            <label class="control-label">班主任姓名 ： </label>
                            <input type="text" class="form-control" name="class_supervisor_name" value="{{ old('class_supervisor_name') }}"> 
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group{{ $errors->has('class_supervisor_phone') ? ' has-error' : '' }} col-md-3">
                            <label class="control-label">班主任电话 ： </label>
                            <input type="text" class="form-control" name="class_supervisor_phone" value="{{ old('class_supervisor_phone') }}"> 
                        </div>

                        <div class="form-group{{ $errors->has('chinese') ? ' has-error' : '' }} col-md-3">
                            <label class="control-label">语文成绩 ： </label>
                            <input type="number" class="form-control" name="chinese" value="{{ old('chinese') }}"> 
                        </div>

                        <div class="form-group{{ $errors->has('math') ? ' has-error' : '' }} col-md-3">
                            <label class="control-label">数学成绩 ： </label>
                            <input type="number" class="form-control" name="math" value="{{ old('math') }}"> 
                        </div>

                        <div class="form-group{{ $errors->has('english') ? ' has-error' : '' }} col-md-3">
                            <label class="control-label">英语成绩 ： </label>
                            <input type="number" class="form-control" name="english" value="{{ old('english') }}"> 
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group{{ $errors->has('study_brief') ? ' has-error' : '' }} col-md-3">
                            <label class="control-label">学习情况简介 ： </label>
                            <input type="text" class="form-control" name="study_brief" value="{{ old('study_brief') }}"> 
                        </div>

                        <div class="form-group{{ $errors->has('live_brief') ? ' has-error' : '' }} col-md-3">
                            <label class="control-label">生活情况简介 ： </label>
                            <input type="text" class="form-control" name="live_brief" value="{{ old('live_brief') }}"> 
                        </div>

                        <div class="form-group{{ $errors->has('character_brief') ? ' has-error' : '' }} col-md-3">
                            <label class="control-label">性格情况简介 ： </label>
                            <input type="text" class="form-control" name="character_brief" value="{{ old('character_brief') }}"> 
                        </div>

                        <div class="form-group{{ $errors->has('expectation') ? ' has-error' : '' }} col-md-3">
                            <label class="control-label">家长的期望 ： </label>
                            <input type="text" class="form-control" name="expectation" value="{{ old('expectation') }}"> 
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group{{ $errors->has('expect_courses') ? ' has-error' : '' }} col-md-3">
                            <label class="control-label">期望学习的特长 ： </label>
                            <input type="text" class="form-control" name="expect_courses" value="{{ old('expect_courses') }}"> 
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-btn fa-user"></i>提交
                            </button>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    /span

</div>/row-->

@endsection