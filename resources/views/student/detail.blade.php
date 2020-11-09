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
                                {{$student->name."的信息"}}
                            </button>
                        </h2>
                    </div>
                    <div id="collapse_income" class="collapse" aria-labelledby="heading_income" data-parent="#accordionExample">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-lg-3">
                                    <label>姓名 ：{{ $student->name}}</label> 
                                </div>
                                <div class="col-lg-3">
                                    <label>性别 ：{{ $student->gender}} </label>
                                </div>
                                <div class="col-lg-3">
                                    <label>生日 ：{{ $student->birthday}} </label>
                                </div>
                                <div class="col-lg-3">
                                    <label>民族 ：{{ $student->nation}} </label>
                                </div>

                                <div class="col-lg-3">
                                    <label>健康状况 ：{{$student->health}} </label>
                                </div>
                                <div class="col-lg-3">
                                    <label >兴趣爱好 ：{{$student->interest}} </label>
                                </div>
                                <div class=" col-lg-3">
                                    <label>家庭住址 ： {{$student->home_address}}</label>
                                </div>
                                <div class="col-lg-3">
                                    <label >父母信息 ：{{$student->parents_info}} </label>
                                </div>

                                <div class="col-lg-3">
                                    <label >就读学校 ：{{$student->school}} </label>
                                </div>


                                <div class="col-lg-3">
                                    <label >班级 ：{{$student->grade}} 年 {{$student->class_room}} 班 </label>

                                </div>
                                <div class="col-lg-3">
                                    <label >班主任姓名 ：</label>
                                </div>
                                <div class="col-lg-3">
                                    <label class="control-label">班主任电话 ：{{$student->class_supervisor_phone}}  </label>
                                </div>

                                <div class="col-lg-3">
                                    <label>语文成绩 ：{{$student->chinese}} </label>
                                </div>

                                <div class="col-lg-3">
                                    <label>数学成绩 ： {{$student->math}}</label>
                                </div>

                                <div class="col-lg-3">
                                    <label>英语成绩 ：{{$student->english}} </label>
                                </div>

                                <div class="col-lg-3">
                                    <label>学习情况简介 ：{{$student->study_brief}} </label>
                                </div>

                                <div class="col-lg-3">
                                    <label >生活情况简介 ：{{$student->live_brief}} </label>
                                </div>

                                <div class="col-lg-3">
                                    <label >性格情况简介 ：{{$student->character_brief}} </label>
                                </div>

                                <div class="col-lg-3">
                                    <label >家长的期望 ：{{$student->expectation}} </label>

                                </div>

                                <div class="col-lg-3">
                                    <label >期望学习的特长 ：{{$student->expect_courses}} </label>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header" id="heading_spend">
                        <h2 class="mb-0">
                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse_spend" aria-expanded="false" aria-controls="collapse_spend">
                                {{__('费用信息')}}
                            </button>
                        </h2>
                    </div>
                    <div id="collapse_spend" class="collapse " aria-labelledby="heading_spend" data-parent="#accordionExample">
                        <div class="card-body">
                            <h2>账户余额：{{$balance}} </h2>
                            <h3>缴费信息</h3>
                            <table class="table table-striped table-bordered bootstrap-datatable responsive">
                                <thead>
                                    <tr>
                                        <th>缴费金额</th>
                                        <th>缴费类别</th>
                                        <th>缴费方式</th>
                                        <th>备注</th>
                                        <th>发生时间</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($payments as $model)
                                    <tr>
                                        <td>{{ $model->amount}}</td>
                                        <td>{{ $model->income_name}}</td>
                                        <td>{{ $model->payment_method}}</td>
                                        <td>{{ $model->comment}}</td>
                                        <td>{{ $model->created_at}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <h3>扣费信息
                            </h3>
                            <table class="table table-striped table-bordered bootstrap-datatable responsive">
                                <thead>
                                    <tr>
                                        <th>扣费金额</th>
                                        <th>扣费类别</th>
                                        <th>所报课程</th>
                                        <th>发生时间</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($enrolls as $model)
                                    <tr>
                                        <td>-{{ $model->paid}}</td>
                                        <td>{{ $model->income_account}}</td>
                                        <td>{{ $model->enrolls_name}}</td>
                                        <td>{{ $model->created_at}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <h3>退费信息</h3>
                            <table class="table table-striped table-bordered bootstrap-datatable responsive">
                                <thead>
                                    <tr>
                                        <th>退费金额</th>
                                        <th>退费方式</th>
                                        <th>涉及课程</th>
                                        <th>备注</th>
                                        <th>发生时间</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($refunds as $model)
                                    <tr>
                                        <td>{{ $model->amount}}</td>
                                        <td>{{ $model->refund_category}}</td>
                                        <td>{{ $model->course_name}}</td>
                                        <td>{{ $model->comment}}</td>
                                        <td>{{ $model->created_at}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>                    
                        </div>

                    </div>
                </div>

                <div class="card">
                    <div class="card-header" id="heading_meal">
                        <h2 class="mb-0">
                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse_meal" aria-expanded="false" aria-controls="collapse_meal">
                                {{__('课程信息')}}
                            </button>
                        </h2>
                    </div>
                    <div id="collapse_meal" class="collapse " aria-labelledby="heading_meal" data-parent="#accordionExample">
                        <div class="card-body">
                            <table class="table table-striped table-bordered bootstrap-datatable responsive">
                                <thead>
                                    <tr>
                                        <th>课程ID</th>
                                        <th>课程名称</th>

                                        <th>特长课剩余次数</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($courses as $model)
                                    <tr>
                                        <td>{{ $model->id}}</td>
                                        <td>{{ $model->name}}</td>
                                        <td>{{$model->is_speciality_course===0?'托管不累计课时数': $model->how_many_left}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>   
            </div>
        </div>
    </div>
</div>
@endsection
