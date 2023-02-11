@extends('admin/layout/layout')
@section('header-script')

<link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/summernote/summernote-bs4.min.css">
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
            <form id="quickForm" action="{{route('AddAbout')}}" method="POST" enctype="multipart/form-data">
               @csrf
               <input type="hidden" name="id" id="id" value="{{$abouts->id}}">
               <div class="form-group">
                  <label for="exampleInputEmail1">Heading One</label>
                  <input type="text" name="heading1" class="form-control" id="heading" value="{{$abouts->heading1}}"  placeholder="Title">
               </div>
               <div class="form-group">
                  <label for="exampleInputEmail1">description One</label>
                  <textarea  name="description1" class="form-control summernote"  id="description1" placeholder="Description One">{{$abouts->description1}}</textarea>
               </div>

               <div class="form-group">
                  <p><img  id="output" width="200" /></p>
               </div>
               <div class="form-group">
                  <label for="exampleInputEmail1">Image One</label>
                  <input type="file" name="image1" onchange="loadFile(event)"  class="form-control" id="profile" >
               </div>


               <div class="form-group">
                  <label for="exampleInputEmail1">Heading Two</label>
                  <input type="text" name="heading2" class="form-control" id="heading"   value="{{$abouts->heading2}}" placeholder="Title">
               </div>
               <div class="form-group">
                  <label for="exampleInputEmail1">description Two</label>
                  <textarea name="description2" class="form-control summernote"  id="description2" placeholder="Description One">{{$abouts->description2}}</textarea>
               </div>

               <div class="form-group">
                  <p><img  id="output" width="200" /></p>
               </div>
               <div class="form-group">
                  <label for="exampleInputEmail1">Image Two</label>
                  <input type="file" name="image2" onchange="loadFile(event)"  class="form-control" id="profile" >
               </div>

               <div class="form-group">
                  <label for="exampleInputEmail1">Heading Three</label>
                  <input type="text" name="heading3" class="form-control" id="heading"  value="{{$abouts->heading3}}"  placeholder="Title">
               </div>
               <div class="form-group">
                  <label for="exampleInputEmail1">description Three</label>
                  <textarea type="text" name="description3" class="form-control summernote"  id="description2" placeholder="Description One">{{$abouts->description3}}</textarea>
               </div>

               <div class="form-group">
                  <p><img  id="output" width="200" /></p>
               </div>
               <div class="form-group">
                  <label for="exampleInputEmail1">Image Three</label>
                  <input type="file" name="image3" onchange="loadFile(event)"  class="form-control" id="profile" >
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
<script src="{{asset('assets/js/waitMe.js')}}"></script>
<script src="https://adminlte.io/themes/v3/plugins/summernote/summernote-bs4.min.js"></script>


<script>
  var APP_URL = {!! json_encode(url('/')) !!}
  
  
   
</script>
<script type="text/javascript">
      var csrf_token = $('meta[name="csrf-token"]').attr('content');


  $(function () {
    // Summernote
    $('.summernote').summernote()

     // CodeMirror
   //   CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
   //    mode: "htmlmixed",
   //    theme: "monokai"
   //  });

    
  });
</script>


<script>
// $(document).ready(function(){
//   $('.editor').each(function(e) {
//     CKEDITOR.replace( this.id,{
//       allowedContent : true,
//     toolbar: 'Full',
//     enterMode : CKEDITOR.ENTER_BR,
//     shiftEnterMode: CKEDITOR.ENTER_P,
//   });
//   });
// });
</script>

@endsection