@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('新缴费') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('payment.store') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('收入名称（必填）') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name_of_account" class="col-md-4 col-form-label text-md-right">{{ __('会计科目') }}</label>

                            <div class="col-md-6">
                                 <select class="form-control" name="name_of_account" >
                                @foreach($name_of_accounts as $name_of_account)
                                <option value="{{$name_of_account->id}}">{{$name_of_account->label_name}}</option>
                                @endforeach
                            </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="amount" class="col-md-4 col-form-label text-md-right">{{ __('金额(非必填)') }}</label>

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
                            <label for="finance_year" class="col-md-4 col-form-label text-md-right">{{ __('财务年份') }}</label>

                            <div class="col-md-6">
                               <select class="form-control" name="finance_year"> 
                                @for($i=2020;$i<=date_format(date_create(),"Y");$i++)
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
                            <label for="which_day" class="col-md-4 col-form-label text-md-right">{{ __('发生日期（不填默认为今天）') }}</label>

                            <div class="col-md-6">
                                <input id="which_day" type="date" class="form-control @error('which_day') is-invalid @enderror" name="which_day" >

                                @error('which_day')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="comment" class="col-md-4 col-form-label text-md-right">{{ __('备注') }}</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="comment" value="{{ old('comment') }}"></input>  
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
