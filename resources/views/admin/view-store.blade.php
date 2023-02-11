
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
                @can('store-create')
                <a href="#!" data-toggle="modal" class="add btn btn-primary"  data-target="#modal-default" >Add Store</a>
                @endcan
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Name</th>
                    <th>Phone Number</th>
                    <th>Zip Code</th>
                    <th>Lat / Long</th>
                    <th>State</th>
                    <th>City</th>
                    <th>Image</th>
                    @if(auth()->user()->type == 'super_admin')
                    <th>Action</th>
                    @endif
                  </tr>
                  </thead>
                  <tbody>
                 
                  @forelse($stores as $item)
                  <tr id="tbl_posts_body{{$item->id}}">
                    <td width="10%">{{$item->name}}</td>
                    <td width="15%">{{$item->phone_number}}</td>
                    <td width="8%">{{$item->zip_code}}</td>
                    <td width="18%">{{$item->latitude}} / {{$item->longitude}}</td>
                    <td width="9%">{{$item->state}}</td>
                    <td width="9%">{{$item->city}}</td>
                    <td width="9%"><img class="profile-user-img img-fluid" src='{{asset("documents/stores/$item->image")}}' alt="Store image"></td>
                    @if(auth()->user()->type == 'super_admin')
                    <td width="27%">
                    @can('store-status')
                      @if($item->status == 1)
                        <a onclick="return confirm('Are you sure want to deactive this store?')"  href="{{ route ('changeStoreStatus', ['id' => $item->id,'status' => 0]) }}"  class='btn btn-success change-status'>&nbsp;&nbsp;Active&nbsp;&nbsp;</a> 
                      @else
                      <a onclick="return confirm('Are you sure want to active this store?')"  href="{{ route ('changeStoreStatus', ['id' => $item->id,'status' => 1]) }}" data-id = "{{$item->id}}" class='btn btn-warning change-status'>Deactive</a> 
                      @endif
                     @endcan
                      @can('store-delete')
                        <a href="#!" data-id = "{{$item->id}}" class='btn btn-danger delete-record'>Delete</a> 
                      @endcan
                      @can('store-edit')
                        <a href="#!" data-id = "{{$item->id}}" data-toggle="modal" class='btn btn-primary edit'  data-target="#modal-default">Edit</a>
                      @endcan

                      <a href="{{route('store-detail',$item->id)}}"   class='btn btn-primary' >View detail</a>
                    </td>
                    @endif
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
              <form id="quickForm1" action="{{route('addStore')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" id="id">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Name</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Enter name" required>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Phone Number</label>
                    <input type="number" name="phone_number" class="form-control" id="phone_number" placeholder="Enter phone number" required>
                  </div>
                  <div class="row">
                    <!-- <div class="col-sm-4">
                      <label>Country</label>
                        <select name="country" class="countries form-control" id="countryId">
                          <option value="">Select Country</option>
                      </select>

                    </div> -->
                    <div class="col-sm-6">
                    <label>State</label>
                      <!-- <select name="state" class="states form-control" id="stateId">
                      <option value="">Select State</option>
                    </select> -->

                    <select name="state" class="states form-control" id="stateId" aria-invalid="false" required>
                        <option value="">Select State</option>
                        <option value="Howland Island" stateid="1398">Howland Island</option>
                        <option value="Delaware" stateid="1399">Delaware</option>
                        <option value="Alaska" stateid="1400">Alaska</option>
                        <option value="Maryland" stateid="1401">Maryland</option>
                        <option value="Baker Island" stateid="1402">Baker Island</option>
                        <option value="Kingman Reef" stateid="1403">Kingman Reef</option>
                        <option value="New Hampshire" stateid="1404">New Hampshire</option>
                        <option value="Wake Island" stateid="1405">Wake Island</option>
                        <option value="Kansas" stateid="1406">Kansas</option>
                        <option value="Texas" stateid="1407">Texas</option>
                        <option value="Nebraska" stateid="1408">Nebraska</option>
                        <option value="Vermont" stateid="1409">Vermont</option>
                        <option value="Jarvis Island" stateid="1410">Jarvis Island</option>
                        <option value="Hawaii" stateid="1411">Hawaii</option>
                        <option value="Guam" stateid="1412">Guam</option>
                        <option value="United States Virgin Islands" stateid="1413">United States Virgin Islands</option>
                        <option value="Utah" stateid="1414">Utah</option>
                        <option value="Oregon" stateid="1415">Oregon</option>
                        <option value="California" stateid="1416">California</option>
                        <option value="New Jersey" stateid="1417">New Jersey</option>
                        <option value="North Dakota" stateid="1418">North Dakota</option>
                        <option value="Kentucky" stateid="1419">Kentucky</option>
                        <option value="Minnesota" stateid="1420">Minnesota</option>
                        <option value="Oklahoma" stateid="1421">Oklahoma</option>
                        <option value="Pennsylvania" stateid="1422">Pennsylvania</option>
                        <option value="New Mexico" stateid="1423">New Mexico</option>
                        <option value="American Samoa" stateid="1424">American Samoa</option>
                        <option value="Illinois" stateid="1425">Illinois</option>
                        <option value="Michigan" stateid="1426">Michigan</option>
                        <option value="Virginia" stateid="1427">Virginia</option>
                        <option value="Johnston Atoll" stateid="1428">Johnston Atoll</option>
                        <option value="West Virginia" stateid="1429">West Virginia</option>
                        <option value="Mississippi" stateid="1430">Mississippi</option>
                        <option value="Northern Mariana Islands" stateid="1431">Northern Mariana Islands</option>
                        <option value="United States Minor Outlying Islands" stateid="1432">United States Minor Outlying Islands</option>
                        <option value="Massachusetts" stateid="1433">Massachusetts</option>
                        <option value="Arizona" stateid="1434">Arizona</option>
                        <option value="Connecticut" stateid="1435">Connecticut</option>
                        <option value="Florida" stateid="1436">Florida</option>
                        <option value="District of Columbia" stateid="1437">District of Columbia</option>
                        <option value="Midway Atoll" stateid="1438">Midway Atoll</option>
                        <option value="Navassa Island" stateid="1439">Navassa Island</option>
                        <option value="Indiana" stateid="1440">Indiana</option>
                        <option value="Wisconsin" stateid="1441">Wisconsin</option>
                        <option value="Wyoming" stateid="1442">Wyoming</option>
                        <option value="South Carolina" stateid="1443">South Carolina</option>
                        <option value="Arkansas" stateid="1444">Arkansas</option>
                        <option value="South Dakota" stateid="1445">South Dakota</option>
                        <option value="Montana" stateid="1446">Montana</option>
                        <option value="North Carolina" stateid="1447">North Carolina</option>
                        <option value="Palmyra Atoll" stateid="1448">Palmyra Atoll</option>
                        <option value="Puerto Rico" stateid="1449">Puerto Rico</option>
                        <option value="Colorado" stateid="1450">Colorado</option>
                        <option value="Missouri" stateid="1451">Missouri</option>
                        <option value="New York" stateid="1452">New York</option>
                        <option value="Maine" stateid="1453">Maine</option>
                        <option value="Tennessee" stateid="1454">Tennessee</option>
                        <option value="Georgia" stateid="1455">Georgia</option>
                        <option value="Alabama" stateid="1456">Alabama</option>
                        <option value="Louisiana" stateid="1457">Louisiana</option>
                        <option value="Nevada" stateid="1458">Nevada</option>
                        <option value="Iowa" stateid="1459">Iowa</option>
                        <option value="Idaho" stateid="1460">Idaho</option>
                        <option value="Rhode Island" stateid="1461">Rhode Island</option>
                        <option value="Washington" stateid="1462">Washington</option>
                        <option value="Ohio" stateid="4851">Ohio</option>
                      </select>
                      <div id="getStateId"></div>
                    </div>
                    
                    <div class="col-sm-6">
                    <label>City</label>        
                      <select name="city" class="cities form-control" id="cityId">
                        <option value="">Select City</option>
                    </select>
                    </div>
                  </div> 
                  <div class="form-group">
                    <label for="exampleInputEmail1">Address </label>
                    <input type="text"  name="address" class="form-control" id="pickup_loc_search" placeholder="Enter Address" escribedby="basic-addon2" >
                  </div>

                  <!-- <div class="form-group">
                    <label for="exampleInputEmail1">State</label>
                    <input type="text" name="state" class="form-control" id="state" placeholder="Enter State" required>
                  </div>


                  <div class="form-group">
                    <label for="exampleInputEmail1">City</label>
                    <input type="text" name="city" class="form-control" id="city" placeholder="Enter City" required>
                  </div> -->

                  <div id="loader">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Latitude</label>
                      <input type="text" name="latitude" class="form-control" id="latitude" placeholder="Enter Latitude" readonly>
                    </div>


                    <div class="form-group">
                      <label for="exampleInputEmail1">Longitude</label>
                      <input type="text" name="longitude" class="form-control" id="longitude" placeholder="Enter longitude" readonly>
                    </div>


                    <div class="form-group">
                      <label for="exampleInputEmail1">Zip Code</label>
                      <input type="text" name="zip_code" class="form-control" id="zip_code" placeholder="Enter Zip code">
                    </div>
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

<script src="{{asset('assets/js/countrystatecity.js?v2')}}"></script>
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-149371669-1"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false&key=AIzaSyDMzBtl2TKTecLe_NEmSup5U-nkj93Ch7o"></script>
<script src="{{asset('assets/js/waitMe.js')}}"></script>
<script>




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
 


var loadFile = function(event) {
  var image = document.getElementById('output');
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
        $('.modal-title').text('Update Store');
        var rootUrl = "https://geodata.phplift.net/api/index.php";
       var call = new ajaxCall();
        // $(".cities").empty();
        $.ajax({
                type: 'GET', 
                url : "{{url('updateStore')}}", 
                data:{ id: id},
                success : function (data) {
                $("#id").val(data.id);
                $("#name").val(data.name);
                $("#pickup_loc_search").val(data.address)
                $("#phone_number").val(data.phone_number);
                $("#latitude").val(data.latitude);
                $("#longitude").val(data.longitude);
                $("#zip_code").val(data.zip_code);
                $(".cities").val(data.city);
                $(".cities").html('<option value='+data.city+'>'+data.city+'</option>')
                $("#stateId").val(data.state);
                $("#output").attr("src",APP_URL+"/public/documents/stores/"+data.image);

                var url = rootUrl + "?type=getCities&countryId=" + "&stateId=" +data.stateId;
                  var method = "post";
                  var data = {};
                  // jQuery(".cities").find("option:eq(0)").html("Please wait..");
                  call.send(data, url, method, function (data) {
                      // jQuery(".cities").find("option:eq(0)").html("Select City");
                      var listlen = Object.keys(data["result"]).length;

                      if (listlen > 0) {
                          jQuery.each(data["result"], function (key, val) {
                              var option = jQuery("<option />");
                              option.attr("value", val.name).text(val.name);
                              jQuery(".cities").append(option);
                          });
                      }

                      jQuery(".cities").prop("disabled", false);
                  });
            
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


    $("#cityId").change(function(){
      $("#zip_code").val('');
      $("#latitude").val('');
      $("#longitude").val('');
      loader()
      var geocoder1 =  new google.maps.Geocoder();
            geocoder1.geocode( { 'address': $('#cityId').val()}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
              
                $("#latitude").val(results[0].geometry.location.lat())
                $("#longitude").val(results[0].geometry.location.lng())

                    var lat = results[0].geometry.location.lat();
                    var lng = results[0].geometry.location.lng();
                    var geocoder = new google.maps.Geocoder();
                    var latlng = new google.maps.LatLng(lat, lng);

                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
                            for (var i = 0; i < results[0].address_components.length; i++) {
                                var types = results[0].address_components[i].types;

                                for (var typeIdx = 0; typeIdx < types.length; typeIdx++) {
                                  // console.log(results[0].address_components[i]);
                                    if (types[typeIdx] == 'postal_code') {
                                        // console.log(results[0].address_components[i]);
                                        $("#zip_code").val(results[0].address_components[i].short_name);
                                    }
                                }
                            }

                            
                        } else {
                            console.log("No results found");
                        }
                    }
              } 
              $('#loader').waitMe("hide")
            });

            
    });

  
   
 
</script>


<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-149371669-1');
</script>










@endsection


