@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('退费') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('spend.returnfee') }}">
                        @csrf
                        <input type="hidden" name="student_id" value="{{$student->id}}">
                        <div class="form-group row">
                            <label for="category_id" class="col-md-4 col-form-label text-md-right">{{ __('退费方式') }}</label>

                            <div class="col-md-6">
                                <select class="form-control" name="category_id" >
                                @foreach($refundCategories as $model)
                                <option value="{{$model->id}}">{{$model->label_name}}</option>
                                @endforeach
                                </select>                                
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="course_id" class="col-md-4 col-form-label text-md-right">{{ __('退费课程') }}</label>

                            <div class="col-md-6">
                                <select class="form-control" name="course_id" >
                                @foreach($student->classmodels as $classmodel)                               
                                    <option value="{{$classmodel->id}}">{{$classmodel->course->name.$classmodel->name}}</option>                              
                                 @endforeach
                            </select>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="amount" class="col-md-4 col-form-label text-md-right">{{ __('退费金额（必填）') }}</label>

                            <div class="col-md-6">
                                <input id="amount" type="text" class="form-control @error('amount') is-invalid @enderror" name="amount" >

                                @error('amount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="amount" class="col-md-4 col-form-label text-md-right">{{ __('支付方式') }}</label>

                            <div class="col-md-6">
                                <select class="form-control" name="payment_method" >
                                @foreach($paymentMethods as $paymentMethod)
                                <option value="{{$paymentMethod->name}}">{{$paymentMethod->name}}</option>
                                @endforeach
                            </select>
                            </div>
                        </div>
                       
                        <div class="form-group row">
                            <label for="finance_year" class="col-md-4 col-form-label text-md-right">{{ __('财务年份') }}</label>
                            <div class="col-md-6">                                
                                <select class="form-control" name="finance_year"> 
                                    @for($i=2018;$i<=date_format(date_create(),"Y");$i++)
                                    @if($i==date_format(date_create(),"Y"))
                                    <option value="{{$i}}" selected ="selected">{{$i}}年</option>
                                    @else
                                    <option value="{{$i}}">{{$i}}年</option>
                                    @endif
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="finance_month" class="col-md-4 col-form-label text-md-right">{{ __('财务月份') }}</label>

                            <div class="col-md-6">
                                <select class="form-control" name="finance_month">
                                    @for($i=1;$i<=12;$i++)
                                    @if(date_format(date_create(),'m')==$i)
                                    <option value="{{$i}}" selected ="selected">{{$i}}月</option>
                                    @else
                                    <option value="{{$i}}">{{$i}}月</option>
                                    @endif
                                    @endfor
                                </select>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="comment" class="col-md-4 col-form-label text-md-right">{{ __('退费原因') }}</label>

                            <div class="col-md-6">
                                  <input type="text" class="form-control" name="comment" value="{{ old('comment') }}"></input>                            
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="comment" class="col-md-4 col-form-label text-md-right">{{ __('是否退出课程') }}</label>

                            <div class="col-md-6">
                                <select class="form-control" name="quit_class">                                  
                                    <option value="1" selected ="selected">是</option>                                   
                                    <option value="0">否</option>                                   
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
