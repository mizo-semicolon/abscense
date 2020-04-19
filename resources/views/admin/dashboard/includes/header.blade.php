<!DOCTYPE html>
    <html lang="ar" dir="rtl">
        <head>
            <meta charset="utf-8">
            <title>@yield('title')</title>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <link href="{{Url('project/css/bootstrap.min.css')}}" rel="stylesheet">
            <link rel="stylesheet" href="{{Url('project/css/font-awesome.min.css')}}">
          
             
           
            <link rel="stylesheet" href="{{url('project/css/style2.css')}}">
        </head>
        <body>
           
            <div class="header">
                <nav class="navbar navbar-inverse">
                    <div class="container">
                        <div class="nav navbar-nav navbar-right">
                          <input type="checkbox" class="openSidebarMenu" id="openSidebarMenu">
                          <span class="logo">الحضور</span>
                          <label for="openSidebarMenu" class="sidebarIconToggle">
                            <div class="spinner diagonal part-1"></div>
                            <div class="spinner horizontal"></div>
                            <div class="spinner diagonal part-2"></div>
                          </label>
                          <div id="sidebarMenu">
                            <ul class="sidebarMenuInner">
                                
                             
                              
                               <li><a href="{{url('dashboard')}}">الرئيسية</a></li>
                               <li><a href="{{url('add_employee')}}">تسجيل الموظفين</a></li>
                               
                               <li class="dropdown">
                                   <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">تسجيل الحضور</a>
                                   <ul class="dropdown-menu">
                                        <li><a href="{{url('add_prescense/am')}}">صباحى</a></li>
                                        <li><a href="{{url('add_prescense/pm')}}">مسائى</a></li>
                                   </ul>    
                               </li>
                               <li><a href="{{url('stats')}}">الاحصائيات</a></li>
                               <li><a href="{{url('logout')}}">تسجيل الخروج</a></li>
                              
                               
                            </ul>
                          </div>
                        </div>
                        <div class="nav navbar-nav navbar-left">
                            <div class="login-info">
                                <span>{{Auth::user()->username}}</span>
                                <img src="{{url('project/img/user-icon.png')}}" class="img-responsive">
                                
                            </div>
                        </div>
                    </div>
                </nav>    
            </div>
            
  