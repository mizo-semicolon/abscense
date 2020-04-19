<script src="{{Url('project/js/jquery-2.1.1.min.js')}}"></script>

 <script src="{{Url('project/js/bootstrap.min.js')}}"></script>

 <script>

     $(document).ready(function(){


      /*   $(document).on('click', '.pagination a', function(event){
  event.preventDefault(); 
  var page = $(this).attr('href').split('page=')[1];
  fetch_data(page);
 });

 function fetch_data(page)
 {
  $.ajax({
    headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
    url:"/add_prescense/fetch_data?page="+page,
   success:function(data)
   {
    $('.table-orders tbody').html(data);
   }
  });
 } */

         $('.reg').click(function(){
            
            var tr= $(this).closest("tr");
            
             var empid=$(this).attr('data-id');
             var period=$(this).attr('data-period');
             //alert(empid);
            $.ajax({
                headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:"/reg_presence",
                method:'post',
                data:{empid:empid,period:period},
                
                success:function(res){
                  if(res.success){
                        //alert(res.success);
                        tr.find('td').fadeOut(1000,function(){ 
                            tr.remove();                    
                        }); 

                  }
                   else {
                       alert(res.error);
                   }  
                   //alert(res);
                },
                error:function(){
                    alert("خطأ فى تحديث البيانات حاول لاحقا")
                }
            }); 
         });
             
         

     });
 </script>
 
   
</body>
</html>