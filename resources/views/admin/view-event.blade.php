
@extends('admin/layout/layout')

@section('header-script')

  <style>
    .dataTables_wrapper .dataTables_processing {
    background: white;
    border: 1px solid black;
    border-radius: 3px;
    }
  </style>
@endsection

@section('body-section')
<br>
 <section class="content">
      <div class="container-fluid">
        
        <div class="row">
          <div class="col-12">
             <div class="card">
              <div class="card-header">
               @if(auth()->user()->type == 'manager') 
                <a href="#!" data-toggle="modal" class="add btn btn-primary"  data-target="#modal-default-event" >Create Event</a>
                @endif
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>#no</th>
                    <th>Number of botels</th>
                    <th>Store name</th>
                    <th>Status</th>
                    @if(auth()->user()->type == 'manager' || auth()->user()->type == 'super_admin') 
                    <th>Action</th>
                    @endif
                  </tr>
                  </thead>
                  <tbody>
                 
                @forelse($inventory as $key => $item)
                  <tr id="tbl_posts_body{{$item->id}}">
                    <td>{{$key+1}}</td>
                    <td>{{$item->number_of_botels}}</td>
                    <td>{{$item->store['name']}}</td>
                    <td>
                    @if(auth()->user()->type == 'super_admin')
                      <div class="form-group">
                          <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                            <input type="checkbox" class="custom-control-input switch-input" id="{{$item->id}}" {{($item->status==1)?"checked":""}}>
                            <label class="custom-control-label" for="{{$item->id}}"></label>
                          </div>
                      </div>
                      @endif

                      @if(auth()->user()->type == 'manager')
                       <div class="form-group">
                            @if($item->status == 1)
                            <label class="badge badge-success">Active</label>
                            @else
                            <label class="badge badge-danger">Inactive</label>
                            @endif
                        </div>
                       @endif

                    </td>
                    @if(auth()->user()->type == 'super_admin')
                    <td>
                        <a href="javascript:!" data-id = "{{$item->user_id}}" data-status = "employee" data-toggle="modal"  class='btn btn-primary store' data-target="#modal-default">View Manager</a> |
                        <a href="#!" data-id = "{{$item->store_id}}" data-status = "store" data-toggle="modal" class='btn btn-primary store'  data-target="#modal-default">View store</a>
                    </td>
                    @endif
                    @if(auth()->user()->type == 'manager') 
                    <td>
                    <a href="#!" data-toggle="modal" class="add btn btn-primary updateEvent" data-id = "{{$item->id}}" data-store_id = "{{$item->store_id}}"  data-target="#modal-default-event" >Update Event</a>
                      <a href="#!"  class="add btn btn-danger delete-record" data-id = "{{$item->id}}"  >Delete Event</a>
                  </td>
                    @endif 
                  </tr>
                 @empty
                 @endforelse  
                  
                    
                 </tbody>
                  
                </table>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="modal-default-event">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Create Event</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form id="quickForm1" action="{{route('create-event')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" id="id">
                  
                    <div class="form-group">
                      <label for="exampleInputEmail1">Number of bottles</label>
                      <input type="number" name="number_of_botels" class="form-control" id="number_of_botels" minlength="15" placeholder="Number of bottles" required>
                    </div>

                  <div class="form-group">
                      <label for="exampleInputEmail1">Store name</label>
                      <select name="store_id" class="form-control" id="store_id" placeholder="Select Store" required>
                        <option value=""></option>
                        @forelse($stores as $item)
                        <option value="{{ $item->id}}">{{ $item->name}}</option>
                        @empty
                        @endforelse
                      </select>
                    </div>
                  </div>
                  <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
            
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

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
@endsection


@section('footer-section')
@endsection

@section('footer-script')

<script src="{{asset('assets/js/countrystatecity.js?v2')}}"></script>
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-149371669-1"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false&key=AIzaSyDMzBtl2TKTecLe_NEmSup5U-nkj93Ch7o"></script>
<script src="{{asset('assets/js/waitMe.js')}}"></script>

<script>




$(function () {

 $('#quickForm1').validate({
    rules: {
      number_of_botels: {
       required: true,
       minlength: 15
      },
      store_id: {
        required: true,
      },
    },
    messages: {
      number_of_botels:{
        minlength: "Please enter at least 15 bottles."

      }
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
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>

<script type="text/javascript">
 
 var APP_URL = {!! json_encode(url('/')) !!}

        jQuery(document).delegate('a.delete-record', 'click', function(e) {
            e.preventDefault();
            var id = jQuery(this).attr('data-id');
            var didConfirm = confirm("Are you sure You want to delete");
            if (didConfirm == true) {
               full_page()
                $.ajax({
                    type: 'GET', 
                    url : "{{route('deleteEvent')}}", 
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
                    $('#container').waitMe("hide")
                }
                });
            }
        });
        
    $(".add").click(function(e){
       
       $('.modal-title').text('Add Event');
       document.getElementById("quickForm1").reset();
       $("#output").attr("src","")
       $(".cities").html('');
       $("#id").val('');
   });

   $(".updateEvent").click(function(e){
      var id = jQuery(this).attr('data-id');
      var  store_id = $(this).attr("data-store_id");
      $('.modal-title').text('Update Event');
        $.ajax({
                type: 'GET', 
                url : "{{route('updateEvent')}}", 
                data:{ id: id,store_id:store_id},
                success : function (data) {
                  $("#id").val(data[0].id)
                  $("#number_of_botels").val(data[0].number_of_botels)
                  $("#store_id").val(data[1].id)
                }
        });
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
      });

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

   


    function loader()
      {
        $('#loader').waitMe({
          effect : 'bounce',
          text : '',
          bg : 'rgba(255,255,255,0.7)',
          color : '#000',
          maxSize : '',
          waitTime : -1,
          textPos : 'vertical',
          fontSize : '',
          source : '',
          onClose : function() {}
          });
      }


  

  
   
 
</script>


<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-149371669-1');
</script>










@endsection


