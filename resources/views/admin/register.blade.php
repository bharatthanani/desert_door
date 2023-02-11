
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registration</title>

   <style type="text/css">
    /* .btn-primary{
      background: linear-gradient(159deg, rgba(0,132,235,1) 42%, rgba(190,0,254,1) 66%);
      border: 1px solid #6f42c1;
    }

    .btn-primary:hover{
      background: linear-gradient(159deg, rgba(0,132,235,1) 42%, rgba(190,0,254,1) 66%);
      border: 1px solid #6f42c1;
    } */
     body{
    background-color:#000000 !important;
  }

  </style>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="icon" href="{{asset('assets/images/favicon.png')}}" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/css/toastr.min.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/css/waitMe.css')}}" />
</head>
<body class="hold-transition register-page" id="loader">
<div class="register-box">
  <div class="register-logo">
    <img src="{{asset('assets/images/logo.png')}}" alt="">
    <br>
    <br>
    <!-- <a href="javascript:void(0)"><b>Honey Staff LLC</b></a> -->
  </div>

  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">Register a new membership</p>

      <form  method="POST" action="{{route('AdminRegisterPrcess')}}" enctype="multipart/form-data" id="quickForm">
        <div class="input-group mb-3">
          @csrf
          <input type="text" name="first_name" id="first_name" class="form-control" placeholder="First name">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
       
          <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last name">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>

         
        <div class="input-group mb-3">
          <input type="email" name="email" id="email"   class="form-control" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="number" name="phone_number" id="phone_number"   class="form-control" placeholder="Phone Number">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-phone"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="password" name="password" id="password"  class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Retype password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

         <div class="input-group mb-3">
          <input type="file" name="profile" id="profile" class="form-control">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-file"></span>
            </div>
          </div>
        </div>
        <div class="row">
         <!--  <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="agreeTerms" name="terms" value="agree">
              <label for="agreeTerms">
               I agree to the <a href="#">terms</a>
              </label>
            </div>
          </div> -->
          <!-- /.col -->
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <!-- <div class="social-auth-links text-center">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i>
          Sign up using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i>
          Sign up using Google+
        </a>
      </div> -->

      <a href="{{route('user-login')}}" class="text-center">I already have a membership</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<script src="{{asset('assets/js/toastr.min.js')}}"></script>
<script src="{{asset('assets/js/waitMe.js')}}"></script>

<script type="text/javascript">
  $(function () {

     $('#quickForm').validate({
        rules: {
          first_name: {
            required: true,
          },
          last_name: {
            required: true,
          },
          email: {
            required: true,
            email:true,
          },
          phone_number:{
            required:true,
          },
          password: {
            required: true,
            minlength: 5,
          },
          password_confirmation: {
            required: true,
            equalTo: "#password"
          },
          
          profile: {
            // required: true,
            extension: "JPEG|PNG|JPG",
          },
        },
        messages: {
          // terms: "Please accept our terms"
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
          error.addClass('invalid-feedback');
          element.closest('.input-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
          $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
          $(element).removeClass('is-invalid');
        }
      });
});

  var type = "{{ Session::get('type') }}";
      switch (type) {
          case 'info':
              toastr.info("{{ Session::get('message') }}");
              break;

          case 'warning':
              toastr.warning("{{ Session::get('message') }}");
              break;

          case 'success':
              toastr.success("{{ Session::get('message') }}");
              break;

          case 'error':
              toastr.error("{{ Session::get('message') }}");
              break;

      }


      var current_effect ='bounce';
      function full_page()
      {
        $('#quickForm').waitMe({
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

      $(document).on('submit','#quickForm1',(e)=> {
        e.preventDefault();
        full_page();
            let myForm = document.getElementById('quickForm1');
            let formData = new FormData(myForm);
            $.ajax({
            method: "POST",
            url: "{{route('register')}}",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (data) {
              toastr.success("Account created successfully");
              $('#quickForm').waitMe("hide")
            }
            
          })
    })
</script>
</body>
</html>
