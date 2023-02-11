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
            <form id="quickForm" action="{{route('AddHomeTitle')}}" method="POST" enctype="multipart/form-data">
               @csrf
               <input type="hidden" name="id" id="id" value="{{$hometitle->id}}">
               <div class="row">
                  <div class="col-md-6">
                       <div class="form-group">
                          <label for="exampleInputEmail1">Logo</label>
                          <input type="file" name="logo" class="form-control" id="logo"  placeholder="Logo">
                       </div>
                   </div>
                   
                   <div class="col-md-6">
                       <div class="form-group">
                           <br>
                           <p><img src="{{asset('documents/homeTitle/'.$hometitle->logo)}}" id="output"  style="border:1px solid gray;"></p>
                       </div>
                   </div>
               </div>
               <div class="form-group">
                  <label for="exampleInputEmail1">Artist Title</label>
                  <input type="text" name="artist_title" class="form-control" id="artist_title" value="{{$hometitle->artist_title}}" placeholder="Title">
               </div>
               <!-- <div class="form-group">
                  <label for="exampleInputEmail1">Sub Title</label>
                  <input type="text" name="sub_title" class="form-control" value="{{$hometitle->sub_title}}" id="sub_title" placeholder="Sub Title">
               </div> -->
              
              
               <div class="form-group">
                  <label for="">Artist Desacription</label>
                  <textarea  name="artist_description" id="artist_description"   class="form-control summernote" >{{$hometitle->artist_description}}</textarea>
               </div>

               <div class='row'>
                  <div class='col-md-6'>
                     <div class="form-group">
                         <label for="exampleInputEmail1">Artist Image</label>
                         <input type="file" name="artist_image"  class="form-control" accept="image/*">
                     </div>
                  </div>
                  <div class='col-md-6'>
                  <div class="form-group">
                        <p><img src="{{asset('documents/homeTitle/'.$hometitle->artist_image)}}" id="output" width="150px" /></p>
                     </div>
                  </div>
               </div>
               

               <div class="form-group">
                  <label for="exampleInputEmail1">Fans Title</label>
                  <input type="text" name="fans_title" class="form-control" value="{{$hometitle->fans_title}}" id="fans_title" placeholder="fans title">
               </div>

               <div class="form-group">
                  <label for="">Fans description</label>
                  <textarea  name="fans_description" id="fans_description" class="form-control summernote" >{{$hometitle->fans_description}}</textarea>
               </div>

               <div class='row'>
                  <div class='col-md-6'>
                     <div class="form-group">
                        <label for="exampleInputEmail1">Fans Image</label>
                        <input type="file" name="fans_image" onchange="loadFile(event)"  class="form-control" id="profile" >
                     </div>
                  </div>

                  <div class='col-md-6'>
                     <div class="form-group">
                        <p><img src="{{asset('documents/homeTitle/'.$hometitle->fans_image)}}" id="output" width="150px" /></p>
                     </div>
                  </div>
               </div>



               <div class="form-group">
                  <label for="exampleInputEmail1">Venue Title</label>
                  <input type="text" name="venue_title" class="form-control" value="{{$hometitle->venue_title}}" id="venue_title" placeholder="Venue title">
               </div>

               <div class="form-group">
                  <label for="">Venue description</label>
                  <textarea  name="venue_description" id="venue_description" class="form-control summernote" >{{$hometitle->venue_description}}</textarea>
               </div>

               <div class='row'>
                  <div class='col-md-6'>
                     <div class="form-group">
                        <label for="exampleInputEmail1">Venue Image</label>
                        <input type="file" name="venue_image" onchange="loadFile(event)"  class="form-control" id="profile" >
                     </div>
                  </div>

                  <div class='col-md-6'>
                     <div class="form-group">
                        <p><img src="{{asset('documents/homeTitle/'.$hometitle->venue_image)}}" id="output" width="150px" /></p>
                     </div>
                  </div>
               </div>

               <div class='row'>
                  <div class='col-md-4'>
                     <div class="form-group">
                        <label for="exampleInputEmail1">Video Section Title</label>
                        <input type="text" name="video_title" class="form-control" value="{{$hometitle->video_title}}" id="video_title" placeholder="Video title">
                     </div>
                 </div> 
                 <div class='col-md-4'>
                     <div class="form-group">
                        <label for="exampleInputEmail1">Video Section Sub Title</label>
                        <input type="text" name="video_sub_title" class="form-control" value="{{$hometitle->video_sub_title}}" id="video_sub_title" placeholder="Video title">
                     </div>
               </div> 

               <div class='col-md-4'>
                     <div class="form-group">
                        <label for="exampleInputEmail1">Video url</label>
                        <input type="url" name="video_url" class="form-control" value="{{$hometitle->video_url}}" id="video_url" placeholder="Video url">
                     </div>
               </div>
             </div> 

               <div class="form-group">
                  <label for="">Video description</label>
                  <textarea  name="video_description" id="video_description" class="form-control summernote" >{{$hometitle->video_description}}</textarea>
               </div>

               <div class="form-group">
                  <label for="">Footer description</label>
                  <textarea  name="footer_description" id="footer_description" class="form-control summernote" >{{$hometitle->footer_description}}</textarea>
               </div>

               <div class='row'>
                  <div class='col-md-6'>
                     <div class="form-group">
                        <label for="exampleInputEmail1">Festival title</label>
                        <input type="text" name="festival_title" class="form-control" value="{{$hometitle->festival_title}}" id="festival_title" placeholder="Festival title">
                     </div>
                 </div> 
                 <div class='col-md-6'>
                 <div class="form-group">
                        <label for="exampleInputEmail1">Festival</label>
                        <input type="file" name="festival_image" class="form-control" >
               </div>
               </div> 

             </div> 

             <div class="form-group">
                        <label for="exampleInputEmail1">Festival description</label>
                        <textarea  name="festival_description" id="festival_description" class="form-control summernote" >{{$hometitle->festival_description}}</textarea>
                     </div>
             

               <div class="row">
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="exampleInputEmail1">Phone Number</label>
                        <input type="number" name="phone_number" class="form-control" placeholder="Phone Number" value="12122">
                     </div>
                  </div>
                  

                  <div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Email" value="ca.theis@data-matique.com">
                     </div>
                  </div>

                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="exampleInputEmail1">Address</label>
                        <input type="text" name="address" class="form-control" placeholder="Address" value="2110 Sherwin Street">
                     </div>
                  </div>
               </div>


               <div class="row">
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="exampleInputEmail1">Facebook</label>
                        <input type="url" name="facebook" class="form-control" placeholder="Facebook Url" value="https://www.facebook.com/">
                     </div>
                  </div>
                  

                  <div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Linkdin Url</label>
                        <input type="url" name="linkdin" class="form-control" placeholder="Linkdin Url" value="https://www.linkedin.com/">
                     </div>
                  </div>

                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="exampleInputEmail1">Twiter Url</label>
                        <input type="url" name="twiter" class="form-control" placeholder="Twiter Url" value="https://twitter.com/">
                     </div>
                  </div>
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
   
   var loadFile = function(event) {
      var image = document.getElementById('output');
      image.src = URL.createObjectURL(event.target.files[0]);
      };


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