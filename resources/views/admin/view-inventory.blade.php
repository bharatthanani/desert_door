@extends('admin/layout/layout')
@section('header-script')
@endsection
@section('body-section')
<br>
<section class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-12">
            <div class="card">
               <div class="card-header">
               </div>
               <!-- /.card-header -->
               <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped yajra-datatable">
                     <thead>
                        <tr>
                           <th>#no</th>
                           <th>Number of bottels</th>
                           @if(auth()->user()->type == 'employee')
                           <th>Sell Bottels</th>
                           @endif
                           <th>Date</th>
                           @if(auth()->user()->type == 'super_admin')
                           <th>Status</th>
                           @endif
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @forelse($inventory as $key => $item)
                        <tr id="tbl_posts_body{{$item->id}}">
                           <td>{{$key+1}}</td>
                           @if(auth()->user()->type == 'super_admin')
                           <td id="number_of_botels">{{$item->number_of_botels}}</td>
                           @else
                           <td id="number_of_botels">{{$item->buy_item}}</td>
                           <td id="number_of_botels">{{$item->sell_bottels}}</td>
                           @endif
                           <td id="created_at">{{$item->created_at}}</td>
                           @if(auth()->user()->type == 'super_admin')
                           <td>
                              
                              <div class="form-group">
                                 <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                    <input type="checkbox" class="custom-control-input switch-input" id="{{$item->id}}" {{($item->status==1)?"checked":""}}>
                                    <label class="custom-control-label" for="{{$item->id}}"></label>
                                 </div>
                              </div>
                           </td>
                           @endif
                           <td>
                              @if(auth()->user()->type == 'super_admin')
                                 <a href="javascript:!" data-id = "{{$item->user_id}}" data-status = "employee" data-toggle="modal"  class='btn btn-primary store' data-target="#modal-default">View manager</a> |
                                 <a href="#!" data-id = "{{$item->store_id}}" data-status = "store" data-toggle="modal" class='btn btn-primary store'  data-target="#modal-default">View store</a>
                              @endif

                              @if(auth()->user()->type == 'employee')
                                 <a href="javascript:!" data-id = "{{$item->id}}"   class='btn btn-danger delete-record'>Delete</a> |
                                 <!-- <a href="#!" data-id = "{{$item->id}}" data-status = "inventory"  data-toggle="modal" class='btn btn-primary store'  data-target="#modal-default">Edit</a> -->
                                 <a href="#!" data-id = "{{$item->employee_inventory['store_id']}}" data-status = "store" data-toggle="modal" class='btn btn-primary store'  data-target="#modal-default">View store</a> | 
                                 <a href="javascript:!" data-id = "{{$item->employee_inventory['user_id']}}" data-status = "employee" data-toggle="modal"  class='btn btn-primary store' data-target="#modal-default">View manager</a>
                              @endif
                              @if(auth()->user()->type == 'employee')
                                 @if(isset($item->id))
                                 <a href="{{route('total-sell-bottels',$item->id)}}" target="_blank" class='btn btn-primary'>View total sell bottels</a>
                                 @endif
                              @else
                                @if(isset($item->id))
                                <a href="{{route('total-sell-bottels',$item->id)}}" target="_blank" class='btn btn-primary'>View total sell bottels</a>
                                @endif 
                              @endif   

                              
                           </td>
                        </tr>
                        @empty
                        <tr>
                           <p>No Inventory Found</p>
                        </tr>
                        @endforelse
                     </tbody>
                  </table>
               </div>
               <!-- /.card-body -->
            </div>
         </div>
      </div>
   </div>
</section>

<div class="modal fade" id="modal-default">
<div class="modal-dialog">
   <div class="modal-content">
      <div class="modal-header">
         <h4 class="modal-title">Edit Inventory</h4>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
         <span aria-hidden="true">&times;</span>
         </button>
      </div>
      <div class="modal-body">
         <div class="row">
            <div class="col-12">
               <div class="card">
                  <div class="card-header">
                     <div class="row" id="show">
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>
</div>
<!-- /.modal -->
@endsection
@section('footer-section')
@endsection
@section('footer-script')
<script src="{{asset('assets/js/waitMe.js')}}"></script>
<script>
   $(function () {
   
    $('#quickForm1').validate({
       rules: {
        
         title: {
          required: true,
         },
         description: {
          required: true,
         },
         
       },
       messages: {
         // terms: "Please accept our terms"
       },
       errorElement: 'span',
       errorPlacement: function (error, element) {
         error.addClass('invalid-feedback');
         element.closest('.form-group').append(error);
       },
       highlight: function (element, errorClass, validClass) {
         $(element).addClass('is-invalid');
       },
       unhighlight: function (element, errorClass, validClass) {
         $(element).removeClass('is-invalid');
       }
     });
   });
    
   
   
   var loadFile = function(event) {
     var image = document.getElementById('output');
     image.src = URL.createObjectURL(event.target.files[0]);
   };
   
     $(function () {
       $("#example1").DataTable({
         "responsive": true, "lengthChange": false, "autoWidth": false,
         "buttons": []
       }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
      
     });
</script>
<script type="text/javascript">
   var APP_URL = {!! json_encode(url('/')) !!}
   
    jQuery(document).delegate('a.delete-record', 'click', function(e) {
                  e.preventDefault();
                  var id = jQuery(this).attr('data-id');
                  var didConfirm = confirm("Are you sure You want to delete");
                  if (didConfirm == true) {
                  
                          $.ajax({
                          type: 'GET', 
                          url : "{{route('deleteInventory')}}", 
                          data:{ id: id},
                          success : function (data) {
                          var type = data.type;
                          switch (type) {
                             case 'success':
                                  toastr.success(data.message);
                                  break;
   
                              case 'error':
                                  toastr.error(data.message);
                                  break;
                          } 
                          $("#tbl_posts_body"+id).hide();
                      
                      }
   
                      });
                      
                  // return true;
              }
      });
   
      $(".employee").click(function(e){
         
         $('.modal-title').text('View Manager');
         document.getElementById("quickForm1").reset();
         $("#output").attr("src","")
     });
   
      $(".store").click(function(e){
          var id = jQuery(this).attr('data-id');
          var status = $(this).attr("data-status")
          if(status == 'employee'){
              $('.modal-title').text('View Manager');
          }else if(status == 'store'){
              $('.modal-title').text('View Store');  
          }else{
            $('.modal-title').text('Edit Inventory'); 
          }
          $("#show").empty();
          var html;
          full_page()
          $.ajax({
                  type: 'GET', 
                  url : "{{route('get-store-and-employee')}}", 
                  data:{ id: id,status:status},
                  success : function (data) {
                     console.log(data);
                      if(status == 'employee'){
                          var  html = '<div class="col-md-6"><b>Employee name</b></div>';
                             html += '<div class="col-md-6">'+data.first_name+' '+data.last_name+'</div>';
                             
                             html += '<div class="col-md-6"><b>Employee Email</b></div>';
                             html += '<div class="col-md-6">'+data.email+'</div>';
   
                             html += '<div class="col-md-6"><b>Employee Phone</b></div>';
                             html += '<div class="col-md-6">'+data.phone_number+'</div>';
   
                             html += '<div class="col-md-6"><b>Address</b></div>';
                             html += '<div class="col-md-6">'+data.address+'</div>';
   
                             html += '<div class="col-md-6"><b>City</b></div>';
                             html += '<div class="col-md-6">'+data.city+'</div>';
   
                             html += '<div class="col-md-6"><b>State</b></div>';
                             html += '<div class="col-md-6">'+data.state+'</div>';
   
                             html += '<div class="col-md-6"><b>Zip code</b></div>';
                             html += '<div class="col-md-6">'+data.zip_code+'</div>';
   
   
                             html += '<div class="col-md-6"><b>Region</b></div>';
                             html += '<div class="col-md-6">'+data.region+'</div>';
                          
                             $("#show").html(html);
                       
                      }else if(status == 'store'){
                            var html = '<div class="col-md-6"><b>Store name</b></div>';
                             html += '<div class="col-md-6">'+data.name+'</div>';
   
                             html += '<div class="col-md-6"><b>Phone Number</b></div>';
                             html += '<div class="col-md-6">'+data.phone_number+'</div>';
   
                             html += '<div class="col-md-6"><b>Address</b></div>';
                             html += '<div class="col-md-6">'+data.address+'</div>';
   
                             html += '<div class="col-md-6"><b>City</b></div>';
                             html += '<div class="col-md-6">'+data.city+'</div>';
   
                             html += '<div class="col-md-6"><b>State</b></div>';
                             html += '<div class="col-md-6">'+data.state+'</div>';
   
                             html += '<div class="col-md-6"><b>Zip code</b></div>';
                             html += '<div class="col-md-6">'+data.zip_code+'</div>';
                             $("#show").html(html);
                      }else{
                           var html = '<div class="col-md-12">';
                           html += '<form method="POST" action="{{ URL::to('updateInventory') }}">';
                            html += '<div class="form-group">';
                            html += '<label>Number of Inventory</label>';
                            html += '@csrf';
                            html += '<input type="hidden" name="id" class="form-control" value='+data.id+'>';
                            html += '<input type="text" name="number_of_botels" class="form-control" value='+data.number_of_botels+'>';
                            html += '</div>';
                            html += '<div class="card-footer">';
                            html +='<button type="submit" class="btn btn-primary">Submit</button>';
                            html += '</div>';
                            html += '</form>';
                            html += '</div>';
                           $("#show").html(html);
                           // $("#created_at").text(data.created_at)
                           // $("#number_of_botels").text(data.number_of_botels)
                      }
                     
                      $('#container').waitMe("hide")
              }
   
          });
      })
   
      $(".switch-input").change(function(){
      
      if(this.checked)
          var status=1;
      else
          var status=0;
      $.ajax({
          url : "{{route('change-inventory-status')}}", 
          type: 'GET',
          /*dataType: 'json',*/
          data: {'id': this.id,'status':status},
          success: function (response) {
            if(response)
              {
               toastr.success(response.message);
              }else{
               toastr.error(response.message);
              } 
          }, error: function (error) {
              toastr.error("Some error occured!");
          }
      });
   });
   
</script>
@endsection