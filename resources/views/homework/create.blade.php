@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('创建作业') }}</div>
                <form method="POST" action="{{ route('homework.store') }}">
                        @csrf
                <div class="card-body">
                   
                        <div class="form-group row">
                            <label for="name" class="col-md-3 col-form-label text-md-right">学校<small class="text-danger">（创建后不可修改）</small></label>

                            <div class="col-md-9">
                                <select class="form-control" name="school_id">
                                    @foreach($schools as $school)
                                    <option value="{{$school->id}}">{{$school->label_name}}</option>                                          
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="unit_price" class="col-md-3 col-form-label text-md-right">年级<small class="text-danger">（创建后不可修改）</small></label>

                            <div class="col-md-3">                               
                                <select class="form-control" name="grade">
                                    @for ($i = 0; $i < 9; $i++)
                                    <option value="{{$i+1}}">{{$i+1}}</option> 
                                    @endfor                                         
                                </select>  
                            </div>
                      
                            <label for="unit" class="col-md-3 col-form-label text-md-right">班级<small class="text-danger">（创建后不可修改）</small></label>

                            <div class="col-md-3">
                                <select class="form-control" name="class">
                                    @for ($i = 0; $i < 20; $i++)
                                    <option value="{{$i+1}}">{{$i+1}}</option> 
                                    @endfor                                         
                                </select>   
                            </div>
                        </div>
                </div>
                <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right">语文作业 1 ： </label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="c_1" placeholder="语文作业 1"> 
                            </div>
                        </div>
                       <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right">语文作业 2 ： </label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="c_2" placeholder="语文作业 2"> 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right">语文作业 3 ： </label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="c_3" placeholder="语文作业 3"> 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right">语文作业 4 ： </label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="c_4" placeholder="语文作业 4"> 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right">语文作业 5 ： </label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="c_5" placeholder="语文作业 5"> 
                            </div>
                        </div>
                </div>
                <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right">数学作业 1 ： </label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="m_1" placeholder="数学作业 1"> 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right">数学作业 2 ： </label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="m_2" placeholder="数学作业 2"> 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right">数学作业 3 ： </label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="m_3" placeholder="数学作业 3"> 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right">数学作业 4 ： </label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="m_4" placeholder="数学作业 4"> 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right">数学作业 5 ： </label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="m_5" placeholder="数学作业 5"> 
                            </div>
                        </div>
                 </div>
                <div class="card-body">
                    
                     <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right">英语作业 1 ： </label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="e_1" placeholder="英语作业 1"> 
                            </div>
                     </div>
                    <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right">英语作业 2 ： </label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="e_2" placeholder="英语作业 2"> 
                            </div>
                     </div>
                    <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right">英语作业 3 ： </label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="e_3" placeholder="英语作业 3"> 
                            </div>
                     </div>
                    <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right">英语作业 4 ： </label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="e_4" placeholder="英语作业 4"> 
                            </div>
                     </div>
                    <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right">英语作业 5 ： </label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="e_5" placeholder="英语作业 5"> 
                            </div>
                     </div>
                </div>
                <div class="card-body">    
                    
                      <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right">托管附加 1 ： </label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="o_1" placeholder="托管附加 1"> 
                            </div>
                     </div>
                     <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right">托管附加 2 ： </label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="o_2" placeholder="托管附加 2"> 
                            </div>
                     </div>
                     <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right">托管附加 3 ： </label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="o_3" placeholder="托管附加 3"> 
                            </div>
                     </div>
                     <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right">托管附加 4 ： </label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="o_4" placeholder="托管附加 4"> 
                            </div>
                     </div>
                     <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right">托管附加 5 ： </label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="o_5" placeholder="托管附加 5"> 
                            </div>
                     </div>
                       
                    <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-5">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('提交') }}
                                </button>
                            </div>
                        </div>
                    
                </div><!-- -->
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
