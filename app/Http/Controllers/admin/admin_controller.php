<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use App\Employee;
use App\Presence;
use Redirect;
use Session;
use Carbon\Carbon;
//use Image;
use Hash;



class admin_controller extends Controller
{
    
    public function show_login_cpanel(){
        return view('admin.login.index');
    }

    public function show_cpanel() {
        
        
        return view('admin.dashboard.index');
    }

    public function show_add_employee(){
        return view('admin.dashboard.add_employee');
    }

    public function SaveEmployee(Request $request){

        $this->validate($request,[
            '_name'=>'required|max:250|string',
            'id_no'=>'required|unique:employees|numeric',
            '_tel'=>'required|numeric|digits_between:11,16',
            '_declaration'=>'required|numeric'
        ],[
            '_name.required'=>'ادخل الاسم ',
            '_name.max'=>'ادخل الاسم لا يزيد عن 250 حرف',
            '_name.string'=>'ادخل الاسم حروف فقط',
            'id_no.required'=>'ادخل رقم الهوية ',
            'id_no.unique'=>'رقم الهوية مسجل من قبل',
            'id_no.numeric'=>'ادخل رقم الهوية ارقام فقط',
            '_tel.required'=>'ادخل  رقم التليفون ',
            '_tel.numeric'=>'ادخل  رقم التليفون   ارقام فقط',
            '_tel.digits_between'=>' ادخل  رقم التليفون على الاقل 11 رقم وعلى الاكثر 16 رقم',
            '_declaration.required'=>'ادخل  رقم التصريح ',
            '_declaration.numeric'=>'ادخل  رقم التصريح   ارقام فقط',
        ]);

        try{
            $data=[
                'name' => $request['_name'],
                'id_no'  => $request['id_no'],
                'phone' => $request['_tel'],
                'declaration_no' => $request['_declaration']
            ];

            Employee::create($data);
            Session::flash('success','تم الاضافة بنجاح');
        }

        catch(Exception $e) {
            Session::flash('error','خطأ فى عملية الاضافة');
        }

        return Redirect::back();

    }

    public function show_presences($period){
        $emps=Employee::paginate(10);
        return view('admin.dashboard.presences')->with(compact('emps','period'));
    }


   

    public function reg_presence(Request $request){
        if($request->ajax()){


            
            $data=Presence::create([
                'time'=>$request['period'],
                'emp_id'=>$request['empid']
            ]);
             if($data) {
    
                return response()->json(['success'=>'تم بنجاح']);
            }
    
            else {
                return response()->json(['error'=>'خطأ فى تسجيل الحضور']);
            }  
            
            
        }

        
    }

    public function show_stats(){

        $today = Carbon::today();
        //$now = Carbon::now()->toDateTimeString();
        $all_emps=Employee::count();
        $am=Presence::where('time','am')->whereDate('created_at', $today)->count();
        $pm=Presence::where('time','pm')->whereDate('created_at', $today)->count();
        return view('admin.dashboard.stats')->with(compact('am','pm','all_emps'));
    }

    public function show_stats_filter(Request $request){

        $am_filter=Presence::where('time','am')->whereDate('created_at',$request['date'])->count();
        $pm_filter=Presence::where('time','pm')->whereDate('created_at',$request['date'])->count();
        Session::flash('am_filter',$am_filter);
        Session::flash('pm_filter',$pm_filter);
        Session::flash('date',$request['date']);
        return Redirect::back();
    }

    /* public function show_add_main_field() {
        return view('admin.dashboard.add_main_field');
    }

    public function SaveEmployee(Request $request){

        $this->validate($request,[
            'name_ara'=>'required|max:255',
            'name_eng'=>'required|max:255',
            'name_turk'=>'required|max:255'
        ],[
            'name_ara.required'=>'أدخل الاسم بالعربية',
            'name_eng.required'=>'أدخل الاسم بالانجليزية',
            'name_turk.required'=>'أدخل الاسم بالتركية',
            'name_ara.max'=>'أدخل الاسم بالعربية لا يزيد عن 255 حرف',
            'name_eng.max'=>'أدخل الاسم بالانجليزية لا يزيد عن 255 حرف',
            'name_turk.max'=>'أدخل الاسم بالتركية لا يزيد عن 255 حرف',
        ]);

        try{
            $data=[
                'name_arabic' => $request['name_ara'],
                'name_english'  => $request['name_eng'],
                'name_turkish' => $request['name_turk']
            ];

            main_field::create($data);
            Session::flash('success','تم الاضافة بنجاح');
        }

        catch(Exception $e) {
            Session::flash('error','خطأ فى عملية الاضافة');
        }

        return Redirect::back();

    }


    public function show_main_fields(){
        $main=main_field::get();
        return view('admin.dashboard.main_fields')->with(compact('main'));
    }


    public function show_edit_main_field($id) {
        $main=main_field::find($id);
        return view('admin.dashboard.edit_main_field')->with(compact('main'));
    }

    public function do_edit_main_field(Request $request,$id){

        $main=main_field::find($id);
        $this->validate($request,[
            'name_ara'=>'required|max:255',
            'name_eng'=>'required|max:255',
            'name_turk'=>'required|max:255'
        ],[
            'name_ara.required'=>'أدخل الاسم بالعربية',
            'name_eng.required'=>'أدخل الاسم بالانجليزية',
            'name_turk.required'=>'أدخل الاسم بالتركية',
            'name_ara.max'=>'أدخل الاسم بالعربية لا يزيد عن 255 حرف',
            'name_eng.max'=>'أدخل الاسم بالانجليزية لا يزيد عن 255 حرف',
            'name_turk.max'=>'أدخل الاسم بالتركية لا يزيد عن 255 حرف',
        ]);

        if(!($request['name_ara']==$main->name_arabic &&
            $request['name_eng']==$main->name_english &&
            $request['name_turk']==$main->name_turkish)
           ){

            try{
                $main->name_arabic=$request['name_ara'];
                $main->name_english=$request['name_eng'];
                $main->name_turkish=$request['name_turk'];
                $main->save();
                Session::flash('success','تم التعديل بنجاح');
            }
            catch(Exception $e){
                Session::flash('error','خطأ فى عملية التعديل');
            }
               

    }

    else {
        Session::flash('error','قم بتعديل احد المدخلات او جميعها');
    }
    return Redirect::back();
}

    public function destroy_main_field($id) {
            
        $main_category=main_field::find($id);
        $sub_categories=sub_field::where('main_fieldid_no','=',$main_category->id)->get();
        if($sub_categories->count()){
            Session::flash('error','قم بحذف التصنيفات الفرعية اولا');
        }
        else {
            try{
                $main_category->delete();
                Session::flash('success','تم الحذف بنجاح');
            }
    
            catch(Exception $e){
                Session::flash('error','خطأ فى عملية الحذف');
                
            }
    
        }
    
        return Redirect::back();
    }

    public function show_add_sub_field() {
        $mains=main_field::get();
        return view('admin.dashboard.add_sub_field')->with(compact('mains'));
    }

    public function do_add_sub_field(Request $request){

        $this->validate($request,[
            'name_ara'=>'required|max:255',
            'name_eng'=>'required|max:255',
            'name_turk'=>'required|max:255',
            'main_fields'=>'required'
        ],[
            'name_ara.required'=>'أدخل الاسم بالعربية',
            'name_eng.required'=>'أدخل الاسم بالانجليزية',
            'name_turk.required'=>'أدخل الاسم بالتركية',
            'name_ara.max'=>'أدخل الاسم بالعربية لا يزيد عن 255 حرف',
            'name_eng.max'=>'أدخل الاسم بالانجليزية لا يزيد عن 255 حرف',
            'name_turk.max'=>'أدخل الاسم بالتركية لا يزيد عن 255 حرف',
            'main_fields.required'=>'أدخل التصنيف الرئيسى',
        ]);

        try{
            $data=[
                'name_arabic' => $request['name_ara'],
                'name_english'  => $request['name_eng'],
                'name_turkish' => $request['name_turk'],
                'main_fieldid_no' =>$request['main_fields']
            ];

            sub_field::create($data);
            Session::flash('success','تم الاضافة بنجاح');
        }

        catch(Exception $e) {
            Session::flash('error','خطأ فى عملية الاضافة');
        }

        return Redirect::back();

    }


    public function show_sub_fields(){
        $sub=sub_field::paginate(10);
        return view('admin.dashboard.sub_fields')->with(compact('sub'));
    }


    public function show_edit_sub_field($id) {
        $sub=sub_field::find($id);
        $main=main_field::where('id','!=',$sub->main_fieldid_no)->get();
        $current_main=main_field::where('id','=',$sub->main_fieldid_no)->first();
        return view('admin.dashboard.edit_sub_field')->with(compact('sub','main','current_main'));
    }

    public function do_edit_sub_field(Request $request,$id){

        $sub=sub_field::find($id);
        $this->validate($request,[
            'name_ara'=>'required|max:255',
            'name_eng'=>'required|max:255',
            'name_turk'=>'required|max:255'
        ],[
            'name_ara.required'=>'أدخل الاسم بالعربية',
            'name_eng.required'=>'أدخل الاسم بالانجليزية',
            'name_turk.required'=>'أدخل الاسم بالتركية',
            'name_ara.max'=>'أدخل الاسم بالعربية لا يزيد عن 255 حرف',
            'name_eng.max'=>'أدخل الاسم بالانجليزية لا يزيد عن 255 حرف',
            'name_turk.max'=>'أدخل الاسم بالتركية لا يزيد عن 255 حرف',
        ]);

        if(!($request['name_ara']==$sub->name_arabic &&
            $request['name_eng']==$sub->name_english &&
            $request['name_turk']==$sub->name_turkish &&
            $request['main_fields']==$sub->main_fieldid_no
           )){

            try{
                $sub->name_arabic=$request['name_ara'];
                $sub->name_english=$request['name_eng'];
                $sub->name_turkish=$request['name_turk'];
                $sub->main_fieldid_no=$request['main_fields'];
                $sub->save();
                Session::flash('success','تم التعديل بنجاح');
            }
            catch(Exception $e){
                Session::flash('error','خطأ فى عملية التعديل');
            }
               

    }

    else {
        Session::flash('error','قم بتعديل احد المدخلات او جميعها');
    }
    return Redirect::back();
}

    public function destroy_sub_field($id) {
            
        $sub_category=sub_field::find($id);
        $services=service::where('sub_fieldid_no','=',$sub_category->id)->get();
        if($services->count()){
            Session::flash('error','قم بحذف الخدمات المرتبطة اولا');
        }
        else {
            try{
                $sub_category->delete();
                Session::flash('success','تم الحذف بنجاح');
            }
    
            catch(Exception $e){
                Session::flash('error','خطأ فى عملية الحذف');
                
            }
    
        }
    
        return Redirect::back();
    }
    
    public function show_add_service() {
        $mains=main_field::get();
        return view('admin.dashboard.add_service')->with(compact('mains'));
    }
    
    public function get_subs(Request $request) {
        
        $subs = DB::table("sub_fields")
                ->where("main_fieldid_no",$request['main_cat'])
                ->pluck("name_arabic","id");
        return response()->json($subs);
    }

    public function do_add_service(Request $request){

        $this->validate($request,[
            'name_ara'=>'required|max:255',
            'name_eng'=>'required|max:255',
            'name_turk'=>'required|max:255',
            'main_fields'=>'required',
            'sub_fields'=>'required',
            'desc_ara'=>'required',
            'desc_eng'=>'required',
            'desc_turk'=>'required',
            'price' =>'required|numeric',
            'other'=>'nullable',
            'images'=>'required',
            'images.*'=>'image|max:3072'
        ],[
            'name_ara.required'=>'أدخل الاسم بالعربية',
            'name_eng.required'=>'أدخل الاسم بالانجليزية',
            'name_turk.required'=>'أدخل الاسم بالتركية',
            'name_ara.max'=>'أدخل الاسم بالعربية لا يزيد عن 255 حرف',
            'name_eng.max'=>'أدخل الاسم بالانجليزية لا يزيد عن 255 حرف',
            'name_turk.max'=>'أدخل الاسم بالتركية لا يزيد عن 255 حرف',
            'main_fields.required'=>'ادخل التصنيف الرئيسي',
            'sub_fields.required'=>'ادخل التصنيف الفرعى',
            'desc_ara.required'=>'ادخل وصف الخدمة بالعربية',
            'desc_eng.required'=>'ادخل وصف الخدمة بالانجليزية',
            'desc_turk.required'=>'ادخل وصف الخدمة بالتركية',
            'price.required' =>'ادخل سعر الخدمة',
            'price.numeric' =>'ادخل سعر الخدمة ارقام فقط',
            'images.required'=>'ادخل على الاقل صورة واحدة للخدمة',
            'images.*.image'=>'غير مسموح بملفات الا ملفات الصور فقط',
            'images.*.max'=>'الحد الاقصى لحجم الصورة 3 ميجا'
        ]);

        try{
             
            $data=[
                'name_arabic' => $request['name_ara'],
                'name_english'  => $request['name_eng'],
                'name_turkish' => $request['name_turk'],
                'main_fieldid_no' => $request['main_fields'],
                'sub_fieldid_no'  => $request['sub_fields'],
                'description_arabic' => $request['desc_ara'],
                'description_english' => $request['desc_eng'],
                'description_turkish'  => $request['desc_turk'],
                'price' => $request['price'],
                'other_details' => $request['other']
            ];

            $service=service::create($data);
             if($request->hasfile('images'))
          {
                 foreach($request->file('images') as $image) {
                    
                     $ext=$image->getClientOriginalExtension();
                     $filename=md5($image->getClientOriginalName()).'.'.'png';
                     $img=Image::make($image);
                     //$img->resize('250','200');
                     $img->encode('png', 80);
                     $img->save('project/uploads/'.$filename);  
                     service_image::create([
                         'path'=>'project/uploads/'.$filename,
                         'serviceid_no'=>$service->id
                         ]);
                 }
             }  
            Session::flash('success','تم الاضافة بنجاح');
        }

        catch(Exception $e) {
            Session::flash('error','خطأ فى عملية الاضافة');
        }

        return Redirect::back();

    }
    
    public function show_services(){
        $services=service::paginate(10);
        return view('admin.dashboard.services')->with(compact('services'));
    }
    
   
    
    
     public function destroy_service($id) {
            
      
       
            try{
                $service=service::find($id);
                service_image::where('serviceid_no','=',$service->id)->delete();
                $service->delete();
                Session::flash('success','تم الحذف بنجاح');
            }
    
            catch(Exception $e){
                Session::flash('error','خطأ فى عملية الحذف');
                
            }
    
       
    
        return Redirect::back();
    }
    
    public function show_edit_service($id) {
        $service=service::find($id);
        $main=main_field::where('id','!=',$service->main_fieldid_no)->get();
       $main_current=main_field::where('id','=',$service->main_fieldid_no)->first();
       $sub_current=sub_field::where('id','=',$service->sub_fieldid_no)->first();
       $sub_fields=sub_field::where([['main_fieldid_no','=',$service->main_fieldid_no],['id','!=',$service->sub_fieldid_no]])->get();
        return view('admin.dashboard.edit_service')->with(compact('service','main','main_current','sub_current','sub_fields'));
    }
    
    
    public function do_edit_service(Request $request,$id){

        $service=service::find($id);
       
        
       $this->validate($request,[
           'name_ara'=>'required|max:255',
            'name_eng'=>'required|max:255',
            'name_turk'=>'required|max:255',
            'desc_ara'=>'required',
            'desc_eng'=>'required',
            'desc_turk'=>'required',
            'price' =>'required|numeric',
            'other'=>'nullable',
            'images.*'=>'image|max:3072'
        ],[
            'name_ara.required'=>'أدخل الاسم بالعربية',
            'name_eng.required'=>'أدخل الاسم بالانجليزية',
            'name_turk.required'=>'أدخل الاسم بالتركية',
            'name_ara.max'=>'أدخل الاسم بالعربية لا يزيد عن 255 حرف',
            'name_eng.max'=>'أدخل الاسم بالانجليزية لا يزيد عن 255 حرف',
            'name_turk.max'=>'أدخل الاسم بالتركية لا يزيد عن 255 حرف',
            'desc_ara.required'=>'ادخل وصف الخدمة بالعربية',
            'desc_eng.required'=>'ادخل وصف الخدمة بالانجليزية',
            'desc_turk.required'=>'ادخل وصف الخدمة بالتركية',
            'price.required' =>'ادخل سعر الخدمة',
            'price.numeric' =>'ادخل سعر الخدمة ارقام فقط',
            'images.*.image'=>'غير مسموح بملفات الا ملفات الصور فقط',
            'images.*.max'=>'الحد الاقصى لحجم الصورة 3 ميجا'
        ]);

        if(!($request['name_ara']==$service->name_arabic &&
            $request['name_eng']==$service->name_english &&
            $request['name_turk']==$service->name_turkish &&
            $request['main_fields']==$service->main_fieldid_no &&
            $request['sub_fields']==$service->sub_fieldid_no &&
            $request['desc_ara']==$service->description_arabic &&
            $request['desc_eng']==$service->description_english &&
            $request['desc_turk']==$service->description_turkish &&
            $request['price']==$service->price &&
            $request['other']==$service->other_details &&
            empty($request->file('images')))
           ){

            try{
                $service->name_arabic=$request['name_ara'];
                $service->name_english=$request['name_eng'];
                $service->name_turkish=$request['name_turk'];
                $service->main_fieldid_no=$request['main_fields'];
                $service->sub_fieldid_no=$request['sub_fields'];
                $service->description_arabic=$request['desc_ara'];
                $service->description_english=$request['desc_eng'];
                $service->description_turkish=$request['desc_turk'];
                $service->price=$request['price'];
                $service->other_details=$request['other'];
                $service->save();
                service_image::where('serviceid_no','=',$service->id)->delete();
                 if($request->hasfile('images'))
          {
                 foreach($request->file('images') as $image) {
                    
                     $ext=$image->getClientOriginalExtension();
                     $filename=md5($image->getClientOriginalName()).'.'.'png';
                     $img=Image::make($image);
                     //$img->resize('250','200');
                     $img->encode('png', 80);
                     $img->save('project/uploads/'.$filename);  
                     service_image::create([
                         'path'=>'project/uploads/'.$filename,
                         'serviceid_no'=>$service->id
                         ]);
                 }
             }  
                
                Session::flash('success','تم التعديل بنجاح');
            }
            catch(Exception $e){
                Session::flash('error','خطأ فى عملية التعديل');
            }
               

    }

    else {
        Session::flash('error','قم بتعديل احد المدخلات او جميعها');
    }
    return Redirect::back();
}

    public function show_update_account(){
        return view('admin.dashboard.update_account');
    }

    
    public function update_account(Request $request)  {

        $admin=User::find(Auth::user()->id);
        $this->validate($request,[
            '_name'=>'required|max:255',
            '_username'=>'required|max:255',
            '_email'=>'email|required|max:255',
        ],[
            '_name.required'=>'أدخل اسمك ',
            '_name.max'=>'أدخل اسمك  لا يزيد عن 255 حرف',
            '_username.max'=>'أدخل اسم المستخدم  لا يزيد عن 255 حرف',
            '_email.max'=>'أدخل البريد الالكترونى  لا يزيد عن 255 حرف',
            '_username.required'=>'ادخل اسم المستخدم',
            '_email.required'=>'ادخل البريد الالكترونى',
            '_email.email'=>'ادخل البريد الالكترونى بالصيغة السليمة'
        ]);

           if($admin->name==$request['_name'] &&
                    $admin->email==$request['_email'] &&
                    $admin->username==$request['_username']){
                      
                       Session::flash('error','قم بتعديل احد المدخلات او جميعها');
                    }
            else {
                
                try{
                    
                    $admin->update([
                        'name'=>$request['_name'],
                        'email'=>$request['_email'],
                       
                        'username'=>$request['_username']
                    ]);
                    Session::flash('success','تم التعديل بنجاح');
                }
                catch(Exception $e) {
                     Session::flash('error','خطأ فى عملية التعديل');
                }
                
            }        
                   

                    
             return Redirect::back();   
            
           


       
    }
    
    
     public function show_change_password(){
        return view('admin.dashboard.change_password');
    }

    public function change_pasword(Request $request)  {

        
        $admin=User::find(Auth::user()->id);
        $this->validate($request,[
            '_old'=>'required',
            '_new'=>'required|min:8|different:_old',
            '_confirm'=>'required|same:_new'
        ],[
            '_old.required'=>'أدخل كلمة المرور الحالية ',
            '_new.required'=>'أدخل كلمة المرور الجديدة',
            '_new.min'=>'أدخل كلمة المرور الجديدة   لا تقل عن 8 حروف',
            '_new.different'=>'كلمة المرور الجديدة نفس القديمة',
            '_confirm.required'=>'ادخل تأكيد كلمة المرور الجديدة',
            '_confirm.same'=>'كلمة المرور الجديدة يجب ان تتفق مع تأكيدها'
        ]);

            if(!Hash::check($request['_old'],Auth::user()->password)){
            Session::flash('error','كلمة المرور الحالية غير صحيحة');
        }
        else{
                
                try{
                    
                    $admin->update([
                        'password'=>Hash::make($request['_new']),
                        
                    ]);
                    Session::flash('success','تم التعديل بنجاح');
                }
                catch(Exception $e) {
                     Session::flash('error','خطأ فى عملية التعديل');
                }
                
                  
                   
}
                    
             return Redirect::back();   

       
    } */

}