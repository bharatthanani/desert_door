
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
                  {!! Form::model($user, ['method' => 'PATCH','route' => ['users.update', $user->id],'enctype'=>'multipart/form-data']) !!}
                  <div class="row">
                      <div class="col-xs-12 col-sm-12 col-md-12">
                          <div class="form-group">
                              <strong>First Name:</strong>
                              {!! Form::text('first_name', null, array('placeholder' => 'First Name','class' => 'form-control')) !!}
                          </div>
                      </div>

                      <div class="col-xs-12 col-sm-12 col-md-12">
                          <div class="form-group">
                              <strong>Last Name:</strong>
                              {!! Form::text('last_name', null, array('placeholder' => 'Last Name','class' => 'form-control')) !!}
                          </div>
                      </div>

                      <div class="col-xs-12 col-sm-12 col-md-12">
                          <div class="form-group">
                              <strong>Email:</strong>
                              {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control','readonly'=>true)) !!}
                          </div>
                      </div>

                      <div class="col-xs-12 col-sm-12 col-md-12">
                          <div class="form-group">
                              <strong>Phone Number:</strong>
                              {!! Form::number('phone_number', null, array('placeholder' => 'Phone Number','class' => 'form-control')) !!}
                          </div>
                      </div>

                      <div class="col-xs-12 col-sm-12 col-md-12">
                          <div class="form-group">
                              <strong>Address:</strong>
                              {!! Form::textarea('address', null, array('placeholder' => 'Address','class' => 'form-control','rows' => '5')) !!}
                          </div>
                      </div>

                      
                      <div class="col-xs-12 col-sm-12 col-md-12">
                          <div class="form-group">
                              <strong>Region:</strong>
                              <!-- {!! Form::text('region', null, array('placeholder' => 'Region','class' => 'form-control')) !!} -->
                              <!-- {!! Form::select('region', $user ,$user['region'] , array('class' => 'form-control')) !!} -->
                             <select name="region" id="countryId" class="countries form-control" selected>
                                <option value="{{$user->region}}">{{$user->region}}</option>
                             </select>
                            </div>
                        </div>
                        
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>State:</strong>
                                {!! Form::text('state', null, array('placeholder' => 'State','class' => 'form-control')) !!}
                            </div>
                        </div>
                        
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>City:</strong>
                                {!! Form::text('city', null, array('placeholder' => 'City','class' => 'form-control')) !!}
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Zip Code:</strong>
                                {!! Form::text('zip_code', null, array('placeholder' => 'Zip Code','class' => 'form-control')) !!}
                            </div>
                        </div>




                      <div class="col-xs-12 col-sm-12 col-md-12">
                          <div class="form-group">
                              <strong>Profile:</strong>
                              {!! Form::file('profile',  array('class' => 'form-control')) !!}
                          </div>
                      </div>

                      @if(auth()->user()->type == 'super_admin')
                      <div class="col-xs-12 col-sm-12 col-md-12">
                          <div class="form-group">
                              <strong>Role:</strong>
                              {!! Form::select('role_id', $roles,$userRole, array('class' => 'form-control')) !!}
                          </div>
                      </div>
                      @endif
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

<script async src="https://www.googletagmanager.com/gtag/js?id=UA-149371669-1"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false&key=AIzaSyDMzBtl2TKTecLe_NEmSup5U-nkj93Ch7o"></script>
<script src="{{asset('assets/js/waitMe.js')}}"></script>
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
 $('.select2').select2()

//Initialize Select2 Elements
$('.select2bs4').select2({
  theme: 'bootstrap4'
})
 var APP_URL = {!! json_encode(url('/')) !!}


 function ajaxCall() {
    this.send = function(data, url, method, success, type) {
        type = 'json';
        var successRes = function(data) {
            success(data);
        }

        var errorRes = function(xhr, ajaxOptions, thrownError) {
            
            console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);

        }
        jQuery.ajax({
            url: url,
            type: method,
            data: data,
            success: successRes,
            error: errorRes,
            dataType: type,
            timeout: 60000
        });

    }

}


function locationInfo() {
    var rootUrl = "https://geodata.phplift.net/api/index.php";
    var call = new ajaxCall();



    this.getCities = function(id) {
        jQuery(".cities option:gt(0)").remove();
        //get additional fields
        
        var url = rootUrl+'?type=getCities&countryId='+ '&stateId=' + id;
        var method = "post";
        var data = {};
        jQuery('.cities').find("option:eq(0)").html("Please wait..");
        call.send(data, url, method, function(data) {
            jQuery('.cities').find("option:eq(0)").html("Select City");
                var listlen = Object.keys(data['result']).length;

                if(listlen > 0)
                {
                    jQuery.each(data['result'], function(key, val) {

                        var option = jQuery('<option />');
                        option.attr('value', val.name).text(val.name);
                        jQuery('.cities').append(option);
                    });
                }
                

                jQuery(".cities").prop("disabled",false);
            
        });
    };

    this.getStates = function(id) {
        jQuery(".states option:gt(0)").remove();
        jQuery(".cities option:gt(0)").remove();
        //get additional fields
        var stateClasses = jQuery('#stateId').attr('class');

        
        var url = rootUrl+'?type=getStates&countryId=' + id;
        var method = "post";
        var data = {};
        jQuery('.states').find("option:eq(0)").html("Please wait..");
        call.send(data, url, method, function(data) {
            jQuery('.states').find("option:eq(0)").html("Select State");
            
                jQuery.each(data['result'], function(key, val) {
                    var option = jQuery('<option />');
                    option.attr('value', val.name).text(val.name);
                    option.attr('stateid', val.id);
                    jQuery('.states').append(option);
                });
                jQuery(".states").prop("disabled",false);
            
        });
    };

    this.getCountries = function() {
        var url = rootUrl+'?type=getCountries';
        var method = "post";
        var data = {};
        jQuery('.countries').find("option:eq(0)").html("Please wait..");
        call.send(data, url, method, function(data) {
            jQuery('.countries').find("option:eq(0)").html("Select Country");
            
            jQuery.each(data['result'], function(key, val) {
                var option = jQuery('<option />');
                
                option.attr('value', val.name).text(val.name);
                option.attr('countryid', val.id);
                
                jQuery('.countries').append(option);
            });
                // jQuery(".countries").prop("disabled",false);
            
        });
    };

}

jQuery(function() {
    var loc = new locationInfo();
    loc.getCountries();
    jQuery(".countries").on("change", function(ev) {
        var countryId = jQuery("option:selected", this).attr('countryid');
        if(countryId != ''){
            loc.getStates(countryId);
        }
        else{
            jQuery(".states option:gt(0)").remove();
        }
    });
    jQuery(".states").on("change", function(ev) {
        var stateId = jQuery("option:selected", this).attr('stateid');
        if(stateId != ''){
            loc.getCities(stateId);
        }
        else{
            jQuery(".cities option:gt(0)").remove();
        }
    });
});

 
</script>

@endsection