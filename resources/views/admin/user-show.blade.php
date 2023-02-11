
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
                  <div class="col-xs-12 col-sm-12 col-md-12">
                      <div class="form-group">
                          <strong>First Name:</strong>
                          {{ $user->first_name }}
                      </div>
                  </div>

                  <div class="col-xs-12 col-sm-12 col-md-12">
                      <div class="form-group">
                          <strong>Last Name:</strong>
                          {{ $user->last_name }}
                      </div>
                  </div>

                  <div class="col-xs-12 col-sm-12 col-md-12">
                      <div class="form-group">
                          <strong>Email:</strong>
                          {{ $user->email }}
                      </div>
                  </div>

                  <div class="col-xs-12 col-sm-12 col-md-12">
                      <div class="form-group">
                          <strong>Phone Number:</strong>
                          {{ $user->phone_number }}
                      </div>
                  </div>

                  <div class="col-xs-12 col-sm-12 col-md-12">
                      <div class="form-group">
                          <strong>Address:</strong>
                          {{ $user->address }}
                      </div>
                  </div>
                  
                  <div class="col-xs-12 col-sm-12 col-md-12">
                      <div class="form-group">
                          <strong>City:</strong>
                          {{ $user->city }}
                      </div>
                  </div>


                  <div class="col-xs-12 col-sm-12 col-md-12">
                      <div class="form-group">
                          <strong>State:</strong>
                          {{ $user->state }}
                      </div>
                  </div>


                  <div class="col-xs-12 col-sm-12 col-md-12">
                      <div class="form-group">
                          <strong>Zip Code:</strong>
                          {{ $user->zip_code }}
                      </div>
                  </div>

                  <div class="col-xs-12 col-sm-12 col-md-12">
                      <div class="form-group">
                          <strong>Region:</strong>
                          {{ $user->region }}
                      </div>
                  </div>

                  <div class="col-xs-12 col-sm-12 col-md-12">
                      <div class="form-group">
                          <strong>Roles:</strong>
                          @if(!empty($user->getRoleNames()))
                              @foreach($user->getRoleNames() as $v)
                                  <label class="badge badge-success">{{ $v }}</label>
                              @endforeach
                          @endif
                      </div>
                  </div>
                  </div>
              </div> 
          </div>   
        </div>
    </div>
</section>

@endsection


@section('footer-section')
@endsection

@section('footer-script')


<script>



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



 
</script>

@endsection