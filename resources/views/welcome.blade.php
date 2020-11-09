
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
        <style>
            .bd-placeholder-img {
                font-size: 1.125rem;
                text-anchor: middle;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
            }

            @media (min-width: 768px) {
                .bd-placeholder-img-lg {
                    font-size: 3.5rem;
                }
            }

            .container {
                max-width: 960px;
            }

            /*
             * Custom translucent site header
             */

            .site-header {
                background-color:  #e3f2fd;
                -webkit-backdrop-filter: saturate(180%) blur(20px);
                backdrop-filter: saturate(180%) blur(20px);
            }
            .site-header a {
                color: #999;
                transition: ease-in-out color .15s;
            }
            .site-header a:hover {
                color: #fff;
                text-decoration: none;
            }

            /*
             * Dummy devices (replace them with your own or something else entirely!)
             */

            .product-device {
                position: absolute;
                right: 10%;
                bottom: -30%;
                width: 300px;
                height: 540px;
                background-color: #333;
                border-radius: 21px;
                -webkit-transform: rotate(30deg);
                transform: rotate(30deg);
            }

            .product-device::before {
                position: absolute;
                top: 10%;
                right: 10px;
                bottom: 10%;
                left: 10px;
                content: "";
                background-color: rgba(255, 255, 255, .1);
                border-radius: 5px;
            }

            .product-device-2 {
                top: -25%;
                right: auto;
                bottom: 0;
                left: 5%;
                background-color: #e5e5e5;
            }


            /*
             * Extra utilities
             */

            .flex-equal > * {
                -ms-flex: 1;
                flex: 1;
            }
            @media (min-width: 768px) {
                .flex-md-equal > * {
                    -ms-flex: 1;
                    flex: 1;
                }
            }

            .overflow-hidden { overflow: hidden; }

        </style>
 <link rel="icon" href="{{asset('/imgs/logo20.png')}}"  mce_href="{{asset('/img/logo20.png')}}" type="image/x-icon">
    </head>
    <body >
        <nav class="site-header sticky-top py-1">
            <div class="container d-flex flex-column flex-md-row justify-content-between">
                <a class="py-2" href="{{ route('login') }}" aria-label="Product">
                    <!--svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="d-block mx-auto" role="img" viewBox="0 0 24 24" focusable="false">
                        <title>PRI</title>
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M14.31 8l5.74 9.94M9.69 8h11.48M7.38 12l5.74-9.94M9.69 16L3.95 6.06M14.31 16H2.83m13.79-4l-5.74 9.94"/>
                    </svg-->
                    <img src="{{asset('imgs/logo20.png')}}" width="30" height="30" class="d-inline-block align-top" alt="">
                </a>
                <!--a class="py-2 d-none d-md-inline-block" href="#">教程</a>
                <a class="py-2 d-none d-md-inline-block" href="#">产品</a>
                <a class="py-2 d-none d-md-inline-block" href="#">特点</a>
                <a class="py-2 d-none d-md-inline-block" href="#">商业</a>
                <a class="py-2 d-none d-md-inline-block" href="#">支持</a>
                <a class="py-2 d-none d-md-inline-block" href="#">价格</a-->               
                @if (Route::has('login'))
                @auth
                <a href="{{ url('/home') }}" class="py-2 d-none d-md-inline-block">后台</a>
                @else
                <a href="{{ route('login') }}" class="py-2 d-none d-md-inline-block">登录</a>
                @endauth

                @endif
            </div>

        </nav>

        <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-light" id="app">
            <div class="col-md-5 p-lg-5 mx-auto my-5">
                <h1 class="display-4 font-weight-normal">小书童在线校管系统</h1>
                <!--p class="lead font-weight-normal">为您量身定做的在线校管系统</p-->
                <!--a class="btn btn-outline-primary" href="#">预约试用</a-->
            </div>
            <div class="product-device shadow-sm d-none d-md-block"></div>
            <div class="product-device product-device-2 shadow-sm d-none d-md-block"></div>
        </div>

        <div class="d-md-flex flex-md-equal w-100 my-md-3 pl-md-3">
            <div class="bg-primary mr-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center text-white overflow-hidden">
                <div class="my-3 py-3">
                    <h2 class="display-5">学生出席考勤</h2>
                    <p class="lead">您还在为整理学生的考勤数据发愁么？</p>
                </div>
                <div class="bg-light shadow-sm mx-auto" style="width: 80%; height: 300px; border-radius: 21px 21px 0 0;"></div>
            </div>
            <div class="bg-lime mr-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center overflow-hidden">
                <div class="my-3 p-3">
                    <h2 class="display-5">老师课时考勤</h2>
                    <p class="lead">您还用每月底基于纸质考勤统计老师的课时么？</p>
                </div>
                <div class="bg-dark shadow-sm mx-auto" style="width: 80%; height: 300px; border-radius: 21px 21px 0 0;"></div>
            </div>
        </div>

        <div class="d-md-flex flex-md-equal w-100 my-md-3 pl-md-3">
            <div class="bg-light mr-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center overflow-hidden">
                <div class="my-3 p-3">
                    <h2 class="display-5">财务明晰</h2>
                    <p class="lead">每月底计算每张发票和收据？</p>
                </div>
                <div class="bg-dark shadow-sm mx-auto" style="width: 80%; height: 300px; border-radius: 21px 21px 0 0;"></div>
            </div>
            <div class="bg-primary mr-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center text-white overflow-hidden">
                <div class="my-3 py-3">
                    <h2 class="display-5">学生餐费账单</h2>
                    <p class="lead">家长自助订餐，月底统计简单</p>
                </div>
                <div class="bg-light shadow-sm mx-auto" style="width: 80%; height: 300px; border-radius: 21px 21px 0 0;"></div>
            </div>
        </div>

        <div class="d-md-flex flex-md-equal w-100 my-md-3 pl-md-3">
            <div class="bg-light mr-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center overflow-hidden">
                <div class="my-3 p-3">
                    <h2 class="display-5">联通微信</h2>
                    <p class="lead">使用微信自动登录，增强校区在朋友圈的粘性</p>
                </div>
                <div class="bg-white shadow-sm mx-auto" style="width: 80%; height: 300px; border-radius: 21px 21px 0 0;"></div>
            </div>
            <div class="bg-light mr-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center overflow-hidden">
                <div class="my-3 py-3">
                    <h2 class="display-5">随时办公查看数据</h2>
                    <p class="lead">外出没法查看数据？</p>
                </div>
                <div class="bg-white shadow-sm mx-auto" style="width: 80%; height: 300px; border-radius: 21px 21px 0 0;"></div>
            </div>
        </div>

        <div class="d-md-flex flex-md-equal w-100 my-md-3 pl-md-3">
            <div class="bg-light mr-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center overflow-hidden">
                <div class="my-3 p-3">
                    <h2 class="display-5">每月回忆老师请假？</h2>
                    <p class="lead">系统帮您记录员工请假，计算每月出勤情况</p>
                </div>
                <div class="bg-white shadow-sm mx-auto" style="width: 80%; height: 300px; border-radius: 21px 21px 0 0;"></div>
            </div>
            <div class="bg-light mr-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center overflow-hidden">
                <div class="my-3 py-3">
                    <h2 class="display-5">老师每天分享码字太辛苦？</h2>
                    <p class="lead">为何不让老师从码字的痛苦中解放出来？</p>
                </div>
                <div class="bg-white shadow-sm mx-auto" style="width: 80%; height: 300px; border-radius: 21px 21px 0 0;"></div>
            </div>
        </div>

        <footer class="container py-5">
            <div class="row">
                <div class="col-12 col-md">
                      <img src="{{asset('imgs/logo20.png')}}" width="30" height="30" class="d-inline-block align-top" alt="">
                      <small class="d-block mb-3 text-muted">&copy; 2018-{{now()->year}}</small>
                </div>
                <div class="col-6 col-md">
                    <h5>家长</h5>
                    <ul class="list-unstyled text-small">
                        <li><a class="text-muted" href="#">微信上使用</a></li>
                        <li><a class="text-muted" href="#">给老师留言</a></li>
                        <li><a class="text-muted" href="#">给孩子订餐</a></li>
                        <li><a class="text-muted" href="#">查看当月餐费</a></li>
                        <li><a class="text-muted" href="#">查看当周餐谱</a></li>
                        <li><a class="text-muted" href="#">课时统计</a></li>
                    </ul>
                </div>
                <div class="col-6 col-md">
                    <h5>老师</h5>
                    <ul class="list-unstyled text-small">
                        <li><a class="text-muted" href="#">班级签到</a></li>
                        <li><a class="text-muted" href="#">查看订餐</a></li>
                        <li><a class="text-muted" href="#">作业上传</a></li>
                        <li><a class="text-muted" href="#">打印作业</a></li>
                    </ul>
                </div>
                <div class="col-6 col-md">
                    <h5>校长</h5>
                    <ul class="list-unstyled text-small">
                        <li><a class="text-muted" href="#">学生管理</a></li>
                        <li><a class="text-muted" href="#">老师管理</a></li>
                        <li><a class="text-muted" href="#">财务管理</a></li>
                        <li><a class="text-muted" href="#">课程、班级管理</a></li>
                    </ul>
                </div>
                <div class="col-6 col-md">
                    <h5>合作老师</h5>
                    <ul class="list-unstyled text-small">
                        <li><a class="text-muted" href="#">按时打卡</a></li>
                        <li><a class="text-muted" href="#">统计上课人数</a></li>
                        <li><a class="text-muted" href="#">统计上课时数</a></li>
                        <li><a class="text-muted" href="#">微信上自动登录</a></li>
                    </ul>
                </div>
            </div>
        </footer>
        <script src="{{ asset('js/app.js') }}" defer></script>
    </body>
</html>
