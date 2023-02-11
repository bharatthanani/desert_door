
@extends('admin/layout/layout')

@section('header-script')
   <!-- <link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}"> -->
  
@endsection

@section('body-section')
<br>
 <section class="content">
      <div class="container-fluid">
        
        <div class="row">
          <div class="col-12">
             <div class="card">
              <div class="card-header">
                <h3 class="card-title">All User</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Profile</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                   @if(is_object($user))
                    @foreach($user as $item)
                  
                    <?php $profile = $item->profile; ?>
                    <?php $email = $item->email; ?>
                    <tr>
                      
                      <td>{{$item->first_name}} {{$item->last_name}}</td>
                      <td>{{$item->email}}</td>
                      <td>{{$item->phone_number}}</td>
                      <td><img class="profile-user-img img-fluid img-circle" src='{{asset("documents/profile/$email/$profile")}}' alt="User profile picture"></td>
                      <td>
                         @if($item->active_status == '0')
                          <a onclick="return confirm('Are you sure you want to active this user')" href="{{url('admin/active-user')}}/{{$item->id}}/1"  class="badge badge-danger">Deactive</a>
                          @elseif($item->active_status == '1')
                          <a onclick="return confirm('Are you sure you want to deactive this user')" href="{{url('admin/active-user')}}/{{$item->id}}/0" class="badge badge-success">&nbsp;&nbsp;Active&nbsp;&nbsp;&nbsp;</a>
                          @endif

                        <a onclick="return confirm('Are you sure you want to delete this item')" href="{{url('admin/delete-user')}}/{{$item->id}}" class="btn-lg"><i style="color:red" class="fas fa-trash"></i></a>
                        <a href="javascript:void(0)" data-toggle="modal" onclick="updateUser(<?php echo $item->id; ?>)" data-target="#modal-default" class="btn-lg "><i class="fas fa-edit"> </i></a>
                      </td>
                    </tr>
                
                    @endforeach
                    @endif
                    
                 </tbody>
                  
                </table>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Update User</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form id="quickForm1" action="{{route('update-user-process')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" id="user_id">
                  <div class="form-group">
                    <label for="exampleInputEmail1">First name</label>
                    <input type="text" name="first_name" class="form-control" id="user_name" placeholder="Enter Name">
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Last name</label>
                    <input type="text" name="last_name" class="form-control" id="last_name" placeholder="Enter Name">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Email</label>
                    <input type="email" name="email" id="email" class="form-control" readonly="">
                  </div>

                  <div class="form-group">
                    <label for="exampleInputPassword1">Phone Number</label>
                    <input type="text" name="phone_number" id="phone_number" class="form-control" >
                  </div>

                  <div class="form-group">
                    <p><img  id="output" width="200" /></p>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Category Image</label>
                    <input type="file" name="profile" onchange="loadFile(event)"  class="form-control" id="profile" >
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
@endsection


@section('footer-section')
@endsection

@section('footer-script')
<!-- <script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script> -->

<script>


function updateUser(user_id)
  {
    $.ajax({
            type: 'GET', 
            url : "{{route('update-user-profile')}}", 
            data:{ user_id: user_id},
            success : function (data) {
               console.log(data);
                $("#user_name").val(data.first_name)
                $("#last_name").val(data.last_name)
                $("#email").val(data.email)
                $('#phone_number').val(data.phone_number)
                 $("#user_id").val(data.id)
                var APP_URL = {!! json_encode(url('/')) !!}
                document.getElementById("output").src=APP_URL+"/documents/profile/"+data.email+"/"+data.profile;
             }
        });
     }

    

  $(function () {

 $('#quickForm1').validate({
    rules: {
     
      profile: {
       extension: "JPEG|PNG|JPG",
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
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
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
  $(function () {
    
    var table = $('.yajra-datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('get-users') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'first_name', name: 'first_name'},
            {data: 'last_name', name: 'last_name'},
            {data: 'email', name: 'email'},
            {data: 'phone_number', name: 'phone_number'},
            {data: 'gender', name: 'gender'},
            {data: 'birthday', name: 'birthday'},
             {
                data: 'action', 
                name: 'action', 
                orderable: true, 
                searchable: true
            },
        ]
    });
    
  });

  $.extend( $.fn.dataTable.defaults, {
        language: {
            "processing": "Loading. Please wait..."
        },
    
    });
</script>

@endsection