
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
             
              <!-- /.card-header -->
              <div class="card-body">
              <form id="quickForm1" action="{{route('addContactUsImage')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" id="id">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Title 1</label>
                    <input type="hidden" name="id" value="{{$data->id}}" >
                    <input type="text" name="title1" class="form-control" id="title1" placeholder="Enter Title" value="{{$data->title1}}">
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Title 2</label>
                    <input type="text" name="title1" class="form-control" id="title2" placeholder="Enter Title" value="{{$data->title2}}">
                  </div>

                  <div class="form-group">
                    <p><img  id="output" width="200" src='{{asset("documents/image/$data->image1??null")}}' /></p>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Image 1</label>
                    <input type="file" name="image1" onchange="loadFile(event)"  class="form-control" id="profile" >
                  </div>

                  <div class="form-group">
                    <p><img  id="image2" width="200" src='{{asset("documents/image/$data->image2??null")}}'/></p>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Image 2</label>
                    <input type="file" name="image2" onchange="loadFile2(event)"  class="form-control" id="profile" >
                  </div>


                  <div class="form-group">
                    <p><img  id="image3" width="200" src='{{asset("documents/image/$data->image3??null")}}' /></p>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Image 3</label>
                    <input type="file" name="image3" onchange="loadFile3(event)"  class="form-control" id="profile" >
                  </div>


                  <div class="form-group">
                    <p><img  id="image4" width="200" src='{{asset("documents/image/$data->image4??null")}}' /></p>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Image 4</label>
                    <input type="file" name="image4" onchange="loadFile4(event)"  class="form-control" id="profile" >
                  </div>


                  <div class="form-group">
                    <p><img  id="image5" width="200" src='{{asset("documents/image/$data->image5??null")}}' /></p>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Image 5</label>
                    <input type="file" name="image5" onchange="loadFile5(event)"  class="form-control" id="profile" >
                  </div>

                  <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
        </div>
      </div>

    
@endsection


@section('footer-section')
@endsection

@section('footer-script')


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

var loadFile2 = function(event) {
  var image = document.getElementById('image2');
  image.src = URL.createObjectURL(event.target.files[0]);
};

var loadFile3 = function(event) {
  var image = document.getElementById('image3');
  image.src = URL.createObjectURL(event.target.files[0]);
};


var loadFile4 = function(event) {
  var image = document.getElementById('image4');
  image.src = URL.createObjectURL(event.target.files[0]);
};


var loadFile5 = function(event) {
  var image = document.getElementById('image5');
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
 



 
</script>

@endsection