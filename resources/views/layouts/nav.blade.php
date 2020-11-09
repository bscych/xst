<nav class="navbar navbar-expand-md navbar-light shadow-sm" style="background-color: #e3f2fd;">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            @guest
            <img src="{{asset('imgs/logo20.png')}}" width="30" height="30" class="d-inline-block align-top" alt="">
            {{ config('app.name', '小书童') }}
            @else 
            <div><x-displayer/></div>
            @endguest

        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->

            <ul class="navbar-nav mr-auto">
                @guest

                @else

                @endguest
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">

                <!-- Authentication Links -->
                @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('登录') }}</a>
                </li>
                @else
                @can('view-constant')
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        系统设置 <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">                        
                        <a class="dropdown-item" href="{{ route('constant.index') }}">{{ __('数据字典') }}</a>
                        <a class="dropdown-item" href="{{ route('specialdate.index') }}">{{ __('特殊日期') }}</a>
                        @can('edit',App\Model\School::find(session()->get('school_id')))
                        <a class="dropdown-item" href="{{ route('school.edit',session()->get('school_id')) }}">{{ __('设置学校参数') }}</a>
                        @endcan
                    </div>
                </li>
                @endcan

                @can('view-class')
                <li><a class="nav-link" href="{{ route('classmodel.index') }}">{{ __('我的课程') }}</a></li>   
         
                @endcan
                @can('view-homework')
        
                 <li><a class="nav-link" href="{{ route('homework.index') }}">{{ __('作业') }}</a></li>
                @endcan
                 @can('view-tck-statistic')               
                <li><a class="nav-link" href="{{ route('user.getMyWorkingSheet') }}">{{ __('特长课时统计') }}</a></li>
                @endcan

                @can('view-parent')
                 <li><a class="nav-link" href="{{ route('parent.register') }}">{{ __('课程列表') }}</a></li>
                <li><a class="nav-link" href="{{ route('parent.bookmeal') }}">{{ __('快速订餐') }}</a></li>
                <li><a class="nav-link" href="{{ route('parent.findMyKid') }}">{{ __('绑定子女') }}</a></li>
                <li><a class="nav-link" href="{{ route('parent.bookingHistory') }}">{{ __('孩子的订餐记录') }}</a></li>
               
                @endcan

                @can('view-student')
                <li><a class="nav-link" href="{{ route('student.index') }}">{{ __('学生') }}</a></li>
         
                @endcan
                
                 @can('view-visitor')
               
                 <li><a class="nav-link" href="{{ route('visitor.index') }}">{{ __('到访') }}</a></li>
                  
                @endcan

                @can('view-user')
                <li><a class="nav-link" href="{{ route('user.index') }}">{{ __('用户') }}</a></li>
                @endcan

                @can('view-course')
                <li><a class="nav-link" href="{{ route('course.index') }}">{{ __('课程') }}</a></li>
                
                @endcan

                @can('view-canteen')
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        食堂 <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('menu.index') }}">
                            {{ __('菜单') }}
                        </a>
                        <a class="dropdown-item" href="{{ route('menuitem.index') }}">
                            {{ __('菜品') }}
                        </a>
                    </div>
                </li>
                @endcan

                @can('view-finance')
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        财务 <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('spend.index') }}">
                            {{ __('支出') }}
                        </a>
                        <a class="dropdown-item" href="{{ route('income.index') }}">
                            {{ __('收入') }}
                        </a>
                         <!--a class="dropdown-item" href="{{ route('payment.index') }}">
                            {{ __('缴费') }}
                        </a>
                         <a class="dropdown-item" href="{{ route('payment.index') }}">
                            {{ __('退费') }}
                        </a-->
                        <a class="dropdown-item" href="{{ route('finance.monthList') }}">
                            {{ __('报表') }}
                        </a>                                 
                    </div>
                </li>
                @endcan
                @can('view-school')
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        学校 <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('school.index') }}">
                            {{ __('学校管理') }}
                        </a>
                        <x-selector/>                                        
                    </div>
                </li>
                @endcan
               
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">
                            {{ __('登出') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
