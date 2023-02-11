
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
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Store Name</th>
                    <th>Phone Number</th>
                    <th>State</th>
                    <th>City</th>
                    <th>Assign</th>
                  </tr>
                  </thead>
                  <tbody>
                 
                  @forelse($stores as $item)
                  <tr id="tbl_posts_body{{$item->id}}">
                    <td >{{$item->name}}</td>
                    <td>{{$item->phone_number}}</td>
                   
                    <td>{{$item->state}}</td>
                    <td>{{$item->city}}</td>
                    
                    <td>
                    
                        <a href="#!" data-id = "{{$item->id}}" data-toggle="modal" class='btn btn-primary edit'  data-target="#modal-default">Assign To Manager</a>
                   
                    </td>
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

      <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Add Blog</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form id="quickForm1" action="{{route('AssignToManager')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="store_id" id="id">
                   
                    <div class="form-group">
                        <label for="">Manager</label>
                        <div id="manager"></div>
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



<script src="{{asset('assets/js/waitMe.js')}}"></script>
<script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
<script>
    $(function () {
        $(".select2").select2();
        $(".select2bs4").select2({
                theme: "bootstrap4",
        });
  });



$(function () {

 $('#quickForm1').validate({
    rules: {
     
      title: {
       required: true,
      },
      image: {
        extension: 'JPG|JPEG|PNG',
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
                $.ajax({
                    type: 'GET', 
                    url : "{{route('deleteStore')}}", 
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

    $(".add").click(function(e){
       
       $('.modal-title').text('Add Store');
       document.getElementById("quickForm1").reset();
       $("#output").attr("src","")
       $(".cities").html('');
       $("#id").val('');
   });

    $(".edit").click(function(e){
        var id = jQuery(this).attr('data-id');
        $('.modal-title').text('Assign Store');
        $("#manager").empty();
        $.ajax({
                type: 'GET', 
                url : "{{route('getUserForAssingStore')}}", 
                data:{ id: id},
                success : function (data) {
                $("#id").val(data[0].id);
               
                var manager =    '<select name="user_id[]" class="form-control" data-placeholder="Select a Manager" style="width: 100%"   required>';
                for(var i = 0;i<data[1].length;i++){
                   manager += '<option value ='+data[1][i].id+'>'+data[1][i].first_name+' '+data[1][i].last_name+'</option>';
                }
                manager +=    '</select>';
                $("#manager").append(manager) 
                $(".select2").select2();   
             }

        });
    })


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


