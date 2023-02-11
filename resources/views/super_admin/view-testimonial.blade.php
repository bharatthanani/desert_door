
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
                <a href="#!" data-toggle="modal"  data-target="#modal-default" >Add Testimonial</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped yajra-datatable">
                  <thead>
                  <tr>
                    <th>Name</th>
                    <th>Rating</th>
                    <th>description</th>
                    <th>Image</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  @forelse($testimonials as $item)
                  <tr id="tbl_posts_body{{$item->id}}">
                    <td width="15%">{{$item->name}}</td>
                    <td width="5%">{{$item->rate}}</td>
                    <td width="45%">{{$item->description}}</td>
                    <td width="15%"><img class="profile-user-img img-fluid" src='{{asset("documents/testimonial/$item->image")}}' alt="User profile picture"></td>
                    <td width="20%">
                        <a href="javascript"  data-id = "{{$item->id}}"  class='btn btn-danger delete-record'>Delete</a> |
                        <a href="#!" data-id = "{{$item->id}}" data-toggle="modal" class='btn btn-primary edit'  data-target="#modal-default">Edit</a>
                   </td>
                  </tr>
                  @empty
                  <tr>
                  <p>No Blog Found</p>
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

      <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Add Testimonial</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form id="quickForm1" action="{{route('addTestimonial')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" id="id">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Name</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Enter name">
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Rating</label>
                    <input type="number" name="rate" class="form-control" id="rate" placeholder="Enter Rating">
                  </div>


                  <div class="form-group">
                    <label for="exampleInputEmail1">Description</label>
                    <textarea name="description" class="form-control" id="description" ></textarea>
                  </div>
                  

                  <div class="form-group">
                    <p><img  id="output" width="200" /></p>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Image</label>
                    <input type="file" name="image" onchange="loadFile(event)"  class="form-control" id="profile" >
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


<script>

$(function () {

 $('#quickForm1').validate({
    rules: {
     
      name: {
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
      "buttons": ["pdf", "print"]
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
                 $.ajax({
                        type: 'GET', 
                        url : "{{route('deleteTestimonial')}}", 
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
              } 
    });

    $(".edit").click(function(e){
        var id = jQuery(this).attr('data-id');
        $('.modal-title').text('Update Model');
        $.ajax({
                type: 'GET', 
                url : "{{route('getBlogUpadate')}}", 
                data:{ id: id},
                success : function (data) {
                $("#id").val(data.id);
                $("#title").val(data.title);
                $("#description").val(data.description);
       
                $("#output").attr("src",APP_URL+"/public/documents/blog/"+data.image);
            
            }

        });
    })


 
</script>

@endsection