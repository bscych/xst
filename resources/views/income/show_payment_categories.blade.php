@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('交费类别') }}</div>

                <div class="card-header">
                    <h3>{{ __('选择课程类别') }}</h3>
                </div>            
                <div class="card-body">
                    <p>
                        @foreach($incomesCategories as $category)
                        <a class="btn btn-primary btn-lg" href="{{ route('income.studentPayment',[$category->id]) }}">{{$category->label_name}}</a>
                        @endforeach
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection