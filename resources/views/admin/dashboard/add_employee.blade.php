@extends('admin.dashboard.master')
@section('title','  لوحة التحكم اضافة موظف')
@section('content')
<div class="clearfix"></div>
<div class="container">
     <div class="col-sm-8 col-md-9">
         <div class="add-sales">
             <h3><span class="fa fa-user"></span>تسجيل موظف</h3>
             <ol class="breadcrumb">
                 <li><a href="{{url('dashboard')}}">الصفحة الرئيسية</a></li>
                 <li>تسجيل موظف</li>
             </ol>
             {!! Form::Open(['class'=>'form-group register-sales']) !!}    
             @if($errors->any())
                <div class="form-group">
                    <div class="alert alert-danger">
                            <ul class="list-unstyled">
                                @foreach($errors->all() as $e)
                                    <li>{{$e}}</li>
                                @endforeach
                            </ul>
                    </div>
                </div>
            @endif
            @if(Session::has('error'))
                <div class="form-group">
                    <p class="alert alert-danger">{{Session::get('error')}}</p>
                </div>
            @endif
            @if(Session::has('success'))
                                    <div class="form-group">
                                        <p class="alert alert-success">{{Session::get('success')}}</p>
                                    </div>    
                                    @endif   
                 <input class="form-control" name="_name" type="text" placeholder="الاسم"> 
                 <input class="form-control" name="id_no" type="text" placeholder="رقم الهوية"> 
                 <input class="form-control" name="_declaration" type="text" placeholder="رقم التصريح"> 
                 <input class="form-control" name="_tel" type="text" placeholder="رقم الموبايل"> 
                 <button class="form-control" type="submit" name="register">اضافة</button>
                 {!! Form::Close() !!}
         </div>
     </div>
</div>
@stop