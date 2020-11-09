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
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">{{ __('请输入孩子的注册码，绑定您的孩子') }}</div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('parent.store') }}">
                                @csrf
                                <div class="form-group row" >
                                    <label for="relationship" class="col-md-4 col-form-label text-md-right">{{ __('与孩子的关系') }}</label>

                                    <div class="col-md-6">
                                        <select class="form-control" name="relationship">
                                            <option selected value="妈妈">妈妈</option>
                                            <option value="爸爸">爸爸</option>
                                            <option value="爷爷">爷爷</option>
                                            <option value="奶奶">奶奶</option>
                                            <option value="姥姥">姥姥</option>
                                            <option value="老爷">姥爷</option>
                                        </select>

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="code" class="col-md-4 col-form-label text-md-right">{{ __('验证码（请找班任老师索取）') }}</label>

                                    <div class="col-md-6">
                                        <input id="code" type="text" class="form-control" name="code" required>
                                        @if ($errors->has('code'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('code') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('注册') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{ asset('js/app.js') }}" defer></script>
    </body>
</html>


