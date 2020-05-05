@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="accordion" id="accordionExample">

                @for($i=$start_year;$i<=now()->year;$i++)
                <div class="card">
                    <div class="card-header" id="heading{{$i}}}">
                        <h2 class="mb-0">
                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse{{$i}}" aria-expanded="false" aria-controls="collapse{{$i}}">
                                {{$i}}
                            </button>
                        </h2>
                    </div>
                    <div id="collapse{{$i}}" class="collapse" aria-labelledby="heading{{$i}}" data-parent="#accordionExample">
                        <div class="card-body">
                            @for($j=1;$j<=12;$j++)
                                @if($j<=now()->month || $i < now()->year)
                            <a type="button" class="btn btn-light" href="{{route('finance.detail',['year'=>$i,'month'=>$j])}}">{{$j}}月</a>
                                @endif
                            @endfor
                        </div>
                    </div>
                </div>
                @endfor

                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h2 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                {{__('汇总')}}
                            </button>
                        </h2>
                    </div>

                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                        <div class="card-body">
                             <a type="button" class="btn btn-light">总收入:{{$incomes}}</a>  <a type="button" class="btn btn-light">总支出:{{$spends}}</a> <a type="button" class="btn btn-light">差:{{$incomes-$spends}}</a>
                        </div>
                    </div>
                </div>

            </div>


        </div>
    </div>
</div>
@endsection