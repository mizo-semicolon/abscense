@extends('admin.dashboard.master')
@section('title','   لوحة التحكم   تسجيل حضور الموظفين')
@section('content')
<div class="clearfix"></div>
<div class="container">
     <div class="col-sm-8 col-md-9">
         <div class="add-sales">
             <h3><span class="fa fa-list-alt"></span>التصنيفات الرئيسية</h3>
             <ol class="breadcrumb">
                 <li><a href="{{Url('dashboard')}}">الصفحة الرئيسية</a></li>
                 <li>تسجيل حضور الموظفين</li>         
             </ol>
        </div>   
       
        <table class="table table-hover table-orders">
           
            <thead>
                <th class="text-center">#</th>
                <th class="text-center">الاسم</th>
                <th class="text-center">رقم الجوال</th>
                <th class="text-center">رقم التصريح</th>
                <th class="text-center">الحضور</th>
                <th class="text-center">تعديل</th>
            </thead>
            <tbody>
               
                

               @include('admin.dashboard.pagination')
            </tbody>
        </table>
        <div class="pagination-box text-left">
            {!! $emps->links("pagination::bootstrap-4") !!}  
        </div>
    </div>   
</div>   
@stop