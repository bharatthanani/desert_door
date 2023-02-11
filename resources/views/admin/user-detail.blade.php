@extends('admin/layout/layout')
@section('header-script')
@endsection
@section('body-section')

<section class="content">
   <!-- Default box -->
   <div class="card">
      <div class="card-body">
         <div class="row">
            <div class="col-12 col-md-12 col-lg-12 order-2 order-md-1">
               <div class="row">
                  
                  <!-- <div class="col-12 col-sm-4">
                     <div class="info-box bg-light">
                       <div class="info-box-content">
                         <span class="info-box-text text-center text-muted">Total amount spent</span>
                         <span class="info-box-number text-center text-muted mb-0">2000</span>
                       </div>
                     </div>
                     </div> -->
                  <!-- <div class="col-12 col-sm-4">
                     <div class="info-box bg-light">
                       <div class="info-box-content">
                         <span class="info-box-text text-center text-muted">Estimated project duration</span>
                         <span class="info-box-number text-center text-muted mb-0">20</span>
                       </div>
                     </div>
                     </div> -->
               </div>
               <div class="row">
                  <div class="col-12">
                     <div class="post">
                        <h3>Manager detail</h3>
                        <!-- /.user-block -->
                        <table class="table table-bordered table-striped example1">
                           <thead>
                              <tr>
                                 <th>Employee name</th>
                                 <th>Email</th>
                                 <th>Phone Number</th>
                                 <th>Address</th>
                                 <th>State</th>
                                 <th>City</th>
                                 <th>Zip Code</th>
                                 <th>Region</th>
                              </tr>
                           </thead>
                           <tbody>
                              <tr>
                                 <td>{{$employee_detail->first_name??null}} {{$employee_detail->last_name??null}}</td>
                                 <td>{{$employee_detail->email??null}}</td>
                                 <td>{{$employee_detail->phone_number??null}}</td>
                                 <td>{{$employee_detail->address??null}}</td>
                                 <td>{{$employee_detail->state??null}}</td>
                                 <td>{{$employee_detail->city??null}}</td>
                                 <td>{{$employee_detail->zip_code??null}}</td>
                                 <td>{{$employee_detail->region??null}}</td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                     <div class="post clearfix">
                        <h3>Store detail</h3>
                        <!-- /.user-block -->
                        <table class="table table-bordered table-striped example1">
                        <thead>
                           <tr>
                              <th width="15%">Total Inventory / Buy Inventory</th>
                              <th width="15%">Store name</th>
                              <th width="15%">Phone Number</th>
                              <th width="15%">Address</th>
                              <th width="15%">State</th>
                              <th>City</th>
                              <th>Zip Code</th>
                              <th>Image</th>
                           </tr>
                        </thead>
                        <tbody>
                           @if(isset($employee_detail->inventory))
                           @forelse($employee_detail->inventory as $item)
                           @if(!empty($item['store']) )
                           <tr>
                              <?php $image = $item['store']->image; ?>
                              <td>{{$item->quantity}} / {{$item->number_of_botels}}</td>
                              <td>
                                 {{$item['store']->name}}
                                 
                              </td>
                              <td>{{$item['store']->phone_number}}</td>
                              <td>{{$item['store']->address}}</td>
                              <td>{{$item['store']->state}}</td>
                              <td>{{$item['store']->city}}</td>
                              <td>{{$item['store']->zip_code}}</td>
                              <td><img class="profile-user-img img-fluid" src='{{asset("documents/stores/$image")}}' alt="Store image"></td>
                           </tr>
                           @endif
                           @empty
                           @endforelse
                           @endif   
                        <tbody>
                           <table>
                     </div>
                     <div class="post">
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- /.card-body -->
   </div>
   <!-- /.card -->
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
@endsection