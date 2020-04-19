@extends('admin.login.master')
@section('title','دخول المديرين')
@section('content')
<div class="form-login">
   
    <h2>تسجيل الدخول</h2>
    <div class="container">
    {!! Form::Open(['class'=>'form-group login-form']) !!}    
        <form class="form-group login-form" action="cpanel.php" method="post">
            <input class="form-control" name="_username" type="text" placeholder="اسم المستخدم"> 
            <input class="form-control" name="_password" type="password" placeholder="كلمة السر">
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

            @if(Session::has('error_login'))
                <div class="form-group">
                    <p class="alert alert-danger">{{Session::get('error_login')}}</p>
                </div>
            @endif
            <button class="form-control" type="submit" name="log">تسجيل دخول</button>
        {!! Form::Close() !!}
    </div>
</div>
@stop