@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="accordion" id="accordionExample">


                <div class="card">
                    <div class="card-header" id="heading_income">
                        <h2 class="mb-0">
                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse_income" aria-expanded="false" aria-controls="collapse_income">
                                {{__('收入')}}
                            </button>
                        </h2>
                    </div>
                    <div id="collapse_income" class="collapse" aria-labelledby="heading_income" data-parent="#accordionExample">
                        <div class="card-body">
                            @foreach($incomeCategories as $category)
                            <a type="button" class="btn btn-light" href="{{ URL::to('detail/' .$parameters.'/incomes/'.$category->id) }}">{{$category->label_name.':'.$incomes->where('name_of_account',$category->id)->sum('amount')}}</a>
                            @endforeach
                            <br>
                            <a href="#">总计：{{$incomes->sum('amount')}}</a>                        
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header" id="heading_spend">
                        <h2 class="mb-0">
                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse_spend" aria-expanded="false" aria-controls="collapse_spend">
                                {{__('支出')}}
                            </button>
                        </h2>
                    </div>
                    <div id="collapse_spend" class="collapse " aria-labelledby="heading_spend" data-parent="#accordionExample">
                        <div class="card-body">
                            @foreach($spendCategories as $category)                    
                            <a type="button" class="btn btn-light" href="{{ URL::to('detail/' .$parameters.'/spends/'.$category->id) }}">{{$category->label_name.':'.$spends->where('name_of_account',$category->id)->sum('amount')}}</a>                       
                            @endforeach  
                            <br>
                            <a href="#">总计：{{$spends->sum('amount')}}</a>                        
                        </div>

                    </div>
                </div>

                <div class="card">
                    <div class="card-header" id="heading_meal">
                        <h2 class="mb-0">
                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse_meal" aria-expanded="false" aria-controls="collapse_meal">
                                {{__('用餐详细')}}
                            </button>
                        </h2>
                    </div>
                    <div id="collapse_meal" class="collapse " aria-labelledby="heading_meal" data-parent="#accordionExample">
                        <div class="card-body">
                        <a type="button" class="btn btn-light" href="#">午餐：{{$lunch}}</a> 
                        <a type="button" class="btn btn-light" href="#">晚餐：{{$dinner}}</a> 
                        <br>
                        <a type="button" class="btn btn-light" href="#">总计：{{$lunch+$dinner}}</a>
                        </div>
                    </div>

                </div>       



        <div class="card">
            <div class="card-header" id="headingOne">
                <h2 class="mb-0">
                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        {{__('总览')}}
                    </button>
                </h2>
            </div>

            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                <div class="card-body">
                    <a type="button" class="btn btn-light">总收入:{{$incomes->sum('amount')}}</a>  <a type="button" class="btn btn-light">总支出:{{$spends->sum('amount')}}</a> <a type="button" class="btn btn-light">差:{{$incomes->sum('amount')-$spends->sum('amount')}}</a>
                </div>
            </div>
        </div>

    </div>


</div>
</div>
</div>
@endsection