@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card mb-5">
                <div class="card-header">{{ __('学生管理') }}</div>
                <div class="card-body">
                    @foreach($schools as $school)
                    <a type="button" class="btn btn-primary" href="{{route('student.index',['school_id'=>$school->id])}}">{{$school->name}}</a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
