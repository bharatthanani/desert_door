
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
                  {!! Form::open(array('route' => 'roles.store','method'=>'POST')) !!}
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Name:</strong>
                                {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control','required'=>'true')) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class=" form-group">
                            
                                <strong>Permission:</strong>
                                
                                <div class="row ps-lg-4">
                                @foreach($permission as $value)
                                <div class="col-lg-4">
                                  <div class="my-txt-box">
                                  {{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name form-check-input ')) }}
                                    <label class="my-label" for="checkboxSuccess2">{{ $value->name }} </label>
                                  </div>
                                   
                                    
                                  </div>
                                <br/>
                                @endforeach
                       
                            

                           
                            
                           </div>
                          </div>  
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
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

$('.select2').select2()

//Initialize Select2 Elements
$('.select2bs4').select2({
  theme: 'bootstrap4'
})

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
  .form-check-input{
    border-radius: 0 !important;
    height: 20px;
    width: 20px;
    margin:0;
  }
  
  .form-group strong{
    margin: 0 0 10px;
    width: fit-content;
    display: block;
  }

  .my-txt-box{
    padding: 0 0 10px;
  }
  
  .my-label{
    padding-left: 30px;
    text-transform:capitalize;
  }
  </style>
@endsection