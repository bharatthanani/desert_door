
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
            @can('user-create')
             <a class="btn btn-success" href="{{ route('users.create') }}"> Create New User</a>
            @endcan
            </div>
            <!-- /.card-header -->
            <div class="card-body">
            <table class="table table-bordered table-striped example1" >
              <thead>
                <tr>
                    <th width="10%">No</th>
                    <th width="10%">First Name</th>
                    <th width="10%" >Last Name</th>
                    <th width="10%">Email</th>
                    <th width="10%">Phone Number</th>
                    <th width="10%">Profile</th>
                    <th width="5%">Roles</th>
                    @can('user-status')
                    <th width="5%">Status</th>
                    @endcan 
                    <th width="20px">Action</th>
                  </tr>
              </thead>
                
                @forelse ($data as $key => $user)
                 
                  <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $user->first_name }}</td>
                    <td>{{ $user->last_name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone_number }}</td>
                    <td><img class="profile-user-img img-fluid" src='{{asset("documents/profile/$user->profile")}}' alt="User profile picture"></td>
                    
                    <td>
                    @if(!empty($user->getRoleNames()))
                      @foreach($user->getRoleNames() as $v)
                        <label class="badge badge-success">{{ $v }}</label>
                      @endforeach
                    @endif
                     
                    </td>
                    @can('user-status')
                    <td>
                      <div class="form-group">
                        <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                            <input type="checkbox" class="custom-control-input switch-input" id="{{$user->id}}" {{($user->status==1)?"checked":""}}>
                            <label class="custom-control-label" for="{{$user->id}}"></label>
                        </div>
                      </div>
                    </td> 
                    @endcan
                    <td>
                      <a class="btn btn-info" href="{{ route('users.show',$user->id) }}">Show</a>
                      @can('user-edit')
                       <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}">Edit</a>
                      @endcan
                      @can('user-delete')
                      <form method="post" action="{{route('users.destroy',$user->id)}}" style="margin-top: -38px;margin-left: 124px";>
                         @csrf
                         @method('delete')
                          <button type="submit" class="btn btn-danger" onclick="return confirm('Are You Sure Want To Delete This..??')" class="btn btn-default generalsetting_admin">Delete</button>
                       </form>
                       @endcan
                    </td>
                  </tr>
                  @empty
                @endforelse
                </table>
            </div>
            <!-- /.card-body -->
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
    $(".example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": []
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    
  });
</script>

<script type="text/javascript">
 
 var APP_URL = {!! json_encode(url('/')) !!}
 $(".switch-input").change(function(){
    
    if(this.checked)
        var status=1;
    else
        var status=0;
    $.ajax({
        url : "{{route('change-status')}}", 
        type: 'GET',
        /*dataType: 'json',*/
        data: {'id': this.id,'status':status},
        success: function (response) {
          if(response)
            {
             toastr.success(response.message);
            }else{
             toastr.error(response.message);
            } 
        }, error: function (error) {
            toastr.error("Some error occured!");
        }
    });
});


 
</script>

@endsection