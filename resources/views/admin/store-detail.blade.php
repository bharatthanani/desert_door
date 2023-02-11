
@extends('admin/layout/layout')

@section('header-script')
 
 <style type="text/css">
    /* .select2-container--bootstrap4 .select2-selection--multiple .select2-selection__choice {
      background-color: #007bff;
      border-color: #006fe6;
      color: #fff;
    } */
  </style>
@endsection

@section('navbar-section')

@endsection

@section('sider-section')
@endsection

@section('body-section')
 <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
         
          <div class="col-md-12">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active"  href="#settings" data-toggle="tab"> Store</a></li>
                  <li class="nav-item"><a class="nav-link"  href="#managers" data-toggle="tab"> Manager</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  
                

                  <div class="tab-pane active" id="settings">
                    <table class='table table-bordered table-striped example1'>
                      <thead>
                        <tr>
                          <th>Store name</th>
                          <th>Phone number</th>
                          <th>State</th>
                          <th>City</th>
                          <th>Zip</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>{{$store->name??'N/A'}}</td>
                          <td>{{$store->phone_number??'N/A'}}</td>
                          <td>{{$store->state??'N/A'}}</td>
                          <td>{{$store->city??'N/A'}}</td>
                          <td>{{$store->zip??'N/A'}}</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>


                  <div class="tab-pane" id="managers">
                  <table class='table table-bordered table-striped example1'>
                      <thead>
                        <tr>
                          <th>Manager name</th>
                          <th>Phone number</th>
                          <th>Email</th>
                          <th>Address</th>
                          <th>Profile</th>
                        </tr>
                      </thead>
                      <tbody>
                        @if(isset($store->manager))
                        @forelse($store->manager as $item)
                        <tr>
                          <td>{{$item->first_name}} {{$item->last_name}}</td>
                          <td>{{$item->phone_number}}</td>
                          <td>{{$item->email}}</td>
                          <td>{{$item->address}}</td>
                          <td><img class="profile-user-img img-fluid" src='{{asset("documents/profile/$item->profile")}}' alt="User profile picture"></td>
                        </tr>
                        @empty
                        @endforelse
                        @endif
                      </tbody>
                    </table>
                  </div>

                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection


@section('footer-section')
@endsection

@section('footer-script')

<!-- CodeMirror -->


<script>




var loadFile = function(event) {
  var image = document.getElementById('output');
  image.src = URL.createObjectURL(event.target.files[0]);
};


</script>

@endsection