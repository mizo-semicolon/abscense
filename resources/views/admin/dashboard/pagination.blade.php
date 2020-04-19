@if($emps->count())
@php 
    $x=1;
@endphp
<tr>
@php
$today = \Carbon\Carbon::today()->toDateTimeString(); // "2015-07-10 00:00:00"
$now = \Carbon\Carbon::now()->toDateTimeString();
@endphp
@foreach($emps as $m)
{{-- ) --}}
<td class="text-center">{{$x}}</td>
<td class="text-center">{{$m->name}}</td>
<td class="text-center">{{$m->phone}}</td>
<td class="text-center">{{$m->declaration_no}}</td>
<td class="text-center">


    <button @if(App\Presence::where(
        'emp_id',$m->id)->whereBetween('created_at', [$today, $now])->count()) disabled @endif class="btn btn-success reg" data-id={{$m->id}} data-period={{$period}}>حضور</button>


</td>
<td class="text-center">
<a class="btn btn-success" href="#">تعديل</a>
</td>

@php 
                    $x++;
                @endphp
</tr>
{{-- @endif --}}
@endforeach 
@else 
       <tr>
           <td colspan="6" class="text-center"><h5>لا يوجد موظفين</h5></td>
       </tr>
       @endif