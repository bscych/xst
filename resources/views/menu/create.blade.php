@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('新增菜谱') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('menu.store') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="which_day" class="col-md-4 col-form-label text-md-right">{{ __('菜谱日期') }} <span class="text-danger">(必填项)</span></label>

                            <div class="col-md-6">
                                <input id="which_day" type="date" class="form-control @error('which_day') is-invalid @enderror" name="which_day" value="{{ old('which_day') }}" required autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="lunch" class="col-md-4 col-form-label text-md-right">{{ __('午餐(菜品之间要换行)') }}</label>

                            <div class="col-md-6">
                                <textarea id="lunch" class="form-control @error('lunch') is-invalid @enderror" name="lunch" value="{{ old('lunch') }}" >
                                </textarea>
                                @error('lunch')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="dinner" class="col-md-4 col-form-label text-md-right">{{ __('晚餐(菜品之间要换行)') }}</label>

                            <div class="col-md-6">
                                <textarea id="dinner" class="form-control @error('dinner') is-invalid @enderror" name="dinner" >
                                </textarea>

                                @error('dinner')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="morning_snack" class="col-md-4 col-form-label text-md-right">{{ __('上午间点(菜品之间要换行)') }}</label>

                            <div class="col-md-6">
                                <textarea id="morning_snack"  class="form-control" name="morning_snack" >
                                </textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="afternoon_snack" class="col-md-4 col-form-label text-md-right">{{ __('下午间点(菜品之间要换行)') }}</label>

                            <div class="col-md-6">
                                <textarea id="afternoon_snack" class="form-control" name="afternoon_snack" >
                                </textarea>
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

        <div class="col-md-12">
            <table class="table table-bordered">
                <tbody>
                    @php
                    $isBegin=true;
                    @endphp
                    @foreach($menuitems as $menuitem)                        
                    @if($loop->index%7===0)                                                                  
                    @if($isBegin)
                    <tr>@php $isBegin=true; @endphp
                        @else
                    </tr>
                    @endif
                    @endif
                <td class="text-small">{{$menuitem->name}}</td>                         
                @endforeach

                </tbody>
            </table>
            <ul class="list-group">
            </ul>
        </div>
    </div>
</div>
@endsection