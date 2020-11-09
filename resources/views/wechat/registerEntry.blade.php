<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">

        <title>小书童</title>


        <!-- Bootstrap core CSS -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <!-- Favicons -->    
        <meta name="theme-color" content="#563d7c">
        <link rel="icon" href="{{asset('/imgs/logo20.png')}}"  mce_href="{{asset('/img/logo20.png')}}" type="image/x-icon">
    </head>
    <body >
        <div class="container-fluid">

            <div class="card align-middle pt-lg-5">
                <div class="card-header">{{ __('请选择角色注册') }}</div>
                <div class="card-body">
                    <a href="{{route('parent.register')}}" class="btn btn-primary btn-lg btn-block">我是家长</a>
                    <a href="" class="btn btn-primary btn-lg btn-block">我是老师</a>
                </div>
            </div>
        </div>
        <script src="{{ asset('js/app.js') }}" defer></script>
    </body>
</html>
