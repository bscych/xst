@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('信息') }}</div>
           
                <div class="card-body">
                      <h5 class="card-title">{{__('系统没查到').$student->name.__('可以订餐的课程数据，请联系老师了解详情。')}}</h5>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
