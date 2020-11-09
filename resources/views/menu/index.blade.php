@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('菜单管理') }}</div>
                  @if(Auth::user()->can('create',App\Model\Menu::class))
                    <div class="card-header">
                        <a href="{{route('menu.create')}}" type="" class="btn btn-primary btn-sm">{{ __('添加') }}</a>
                    </div>
                  @endif
                <div class="card-body">
                    <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>日期</th>

                            <th>上午间点</th>
                            <th>午餐</th>
                            <th>下午间点</th>
                            <th>晚餐</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($menus as $menu)
                        <tr>
                            <td>{{ $menu->which_day}}</td>
                            <td>
                                @foreach(collect(json_decode($menu->morning_snack,JSON_UNESCAPED_UNICODE)) as $meal)
                                {{$meal}}<br>
                                @endforeach
                            </td>
                            <td>
                                @foreach(collect(json_decode($menu->lunch,JSON_UNESCAPED_UNICODE)) as $meal)
                                {{$meal}}<br>
                                @endforeach
                            </td>
                            <td>
                                @foreach(collect(json_decode($menu->afternoon_snack,JSON_UNESCAPED_UNICODE)) as $meal)
                                {{ $meal}}<br>
                                @endforeach
                            </td>
                            <td>
                                @foreach(collect(json_decode($menu->dinner,JSON_UNESCAPED_UNICODE)) as $meal)
                                {{ $meal}}<br>
                                @endforeach
                            </td>
                          
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
