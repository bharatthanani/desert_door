
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
                          <strong>Name:</strong>
                          {{ $role->name??'N/A' }}
                      </div>
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-12">
                      <div class="form-group">
                          <strong>Permissions:</strong>
                          <div class="row gy-2">
                          @if(!empty($rolePermissions))
                              @foreach($rolePermissions as $v)
                              <div class="col-lg-4">
                                  <label class="label label-success">{{ $v->name }}</label>
                                  </div>
                              @endforeach
                          @else
                          <p>N/A</p>
                          @endif
                          </div>
                       
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

<style>
  .label-success{
    text-transform: capitalize;
    position: relative;
    padding-left: 16px;
  }
  .label-success:before{
    content: "";
    background: #000;
    height: 7px;
    width: 7px;
    border-radius: 50%;
    position: absolute;
    left: 0;
    top: 9px;
  }
</style>

@endsection