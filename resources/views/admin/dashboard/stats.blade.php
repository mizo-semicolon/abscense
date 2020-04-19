@extends('admin.dashboard.master')
@section('title','   لوحة التحكم   احصائيات حضور الموظفين')
@section('content')
<div class="clearfix"></div>
<div class="container">
     <div class="col-sm-8 col-md-9">
         <div class="add-sales">
             <h3><span class="fa fa-list-alt"></span>التصنيفات الرئيسية</h3>
             <ol class="breadcrumb">
                 <li><a href="{{Url('dashboard')}}">الصفحة الرئيسية</a></li>
                 <li>احصائيات حضور الموظفين</li>         
             </ol>
        </div>  
        <h4>احصائيات تاريخ</h4>
        {!! Form::Open() !!}     
            <div class="form-group">
                <input class="form-control" name="date" type="date"> 
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success">عرض</button>
            </div> 
        {!! Form::Close() !!}
        <table class="table table-hover table-orders">
           
            <thead>
                <th class="text-center">#</th>
                <th class="text-center">التاريخ</th>
                <th class="text-center">الحاضرين صباحا</th>
                <th class="text-center">الحاضرين مساءا</th>
                <th class="text-center">الاجمالى</th>
            </thead>
            <tbody>
                
                <tr >
                
                   <td class="text-center">#</td>
                   <td class="text-center">@if(session()->has('date')){{Session::get('date')}} @else {{\Carbon\Carbon::now()->toDateString()}} @endif</td>
                   <td class="text-center">@if(session()->has('am_filter')){{Session::get('am_filter')}} @else {{$am}} @endif</td>
                   <td class="text-center">@if(session()->has('pm_filter')){{Session::get('pm_filter')}} @else {{$pm}} @endif</td>
                   <td class="text-center">{{$all_emps}}</td>
                    
                </tr>
                
            </tbody>
        </table>
    </div>   
</div>   
@stop