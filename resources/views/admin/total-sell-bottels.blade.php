@extends('admin/layout/layout')

@section('header-script')
<style type="text/css">

  .right-border{
    border:none !important;
    border-right: 1px solid #ccc !important;
  }
  .out-sep {
    border-bottom: none !important;
    border-top: none !important;
  }
  
</style>
@endsection

@section('navbar-section')

@endsection

@section('sider-section')
@endsection

@section('body-section')

<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            


            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
                    <i class="fas fa-globe"></i> Desert Door.
                    <small class="float-right">Date: 2/10/2014</small>
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                  <!-- For User -->
                  @if(isset($details->employee))
                    <address>
                      <strong>Employee detail.</strong><br>
                      
                      Name: {{$details->employee['first_name']}} {{$details->employee['last_name']}}<br>
                      Phone: {{$details->employee['phone_number']}}<br>
                      Email: {{$details->employee['email']}}
                    </address>
                    @endif

                    @if(isset($details->store)) 
                    <address>
                      <strong>Store Detail</strong><br>
                      Name: {{$details->store['name']}}<br>
                      Phone: {{$details->store['phone_number']}}<br>
                      State: {{$details->store['state']}}<br>
                      City: {{$details->store['city']}}
                    </address>
                  @endif 
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    @if(isset($details->manager_inventory->manager)) 
                      <address>
                        <strong>Manager Detail</strong><br>
                        Name: {{$details->manager_inventory->manager['first_name']}} {{$details->manager_inventory->manager['last_name']}}<br>
                        Phone: {{$details->manager_inventory->manager['phone_number']}}<br>
                        Email: {{$details->manager_inventory->manager['email']}}
                      </address>
                    @endif 

                  <!-- For Admin -->
                    @if(isset($details->user)) 
                      <address>
                        <strong>Manager Detail</strong><br>
                        Name: {{$details->user['first_name']}} {{$details->user['last_name']}}<br>
                        Phone: {{$details->user['phone_number']}}<br>
                        Email: {{$details->user['email']}}
                      </address>
                    @endif 
                </div>
              
                <!-- /.col -->
                @if(isset($details->employee_sell_invontery))    
                <div class="col-sm-4 invoice-col">
                  @if(isset($details))  
                    <b>Invoice #007612</b><br>
                    <br>
                    <b>Buy Items:</b> {{$details->buy_item}}<br>
                    <b>Sell Item:</b> {{$details->sell_bottels}}<br>
                    <b>Date:</b> {{$details->created_at}}
                  @endforelse  
                </div>
                @endif
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped table-bordered" id="example1">
                    <thead>
                    <tr>
                      @if(auth()->user()->type == 'employee')
                      <th>#no</th>
                      @else
                      <th>Employee</th>
                      <th>Total Buy / Total Sell</th>
                      @endif
                      <!-- <th>Employee 2</th> -->
                      <th>Sell Item</th>
                      <th>Amount</th>
                      <th>Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php $amount = 0; @endphp  
                    <!-- For Employee -->
                    @if(isset($details->employee_sell_invontery))  
                      @forelse($details->employee_sell_invontery as $key => $item)  
                      <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$item->sell_item}}</td>
                        <td>${{$item->amount}}</td>
                        <td>@php $date =  $item->created_at @endphp {{ date("d/m/Y g:iA", strtotime($date));}}</td>
                        
                      </tr>
                      @php $amount += $item->amount; @endphp
                      @empty
                      @endforelse
                    @endif
               
                  <!-- For Admin -->
                  
                  @if(isset($details->employee_inventories)) 
                   
                  
                    @forelse($details->employee_inventories as $key => $value)
                    <tr>
                      @php $number = count($value->employee_sell_invontery) @endphp
                          <td rowspan="{{$number}}">
                            
                          <i class="fas fa-user-circle mr-2 mb-2 text-info"></i>&nbsp;
                            <b>{{$value->employee['first_name']}} {{$value->employee['last_name']}}</b><br>
                            <i class="fas fa-phone mr-2 mb-2 text-info"></i>&nbsp;
                            {{$value->employee['phone_number']}}<br>
                            <i class="fas fa-envelope mr-2 mb-2 text-info"></i>&nbsp;
                            {{$value->employee['email']}}
                              
                          </td>
                          <td rowspan="{{$number}}" align="center"> {{$value['buy_item']}} / {{$value['sell_bottels']}}</td>
                          
                      @forelse($value->employee_sell_invontery as $key => $item) 
                          <td>{{$item->sell_item}}</td>
                          <td>${{$item->amount}}</td>
                          <td>@php $date =  $item->created_at @endphp {{ date("d/m/Y g:iA", strtotime($date));}}</td>
                          
                        </tr>
                        @php $amount += $item->amount; @endphp
                      @empty
                      @endforelse
                    @empty
                    @endforelse
                    @endif

                    
                   
                    
                    
                    
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <div class="row">
                <!-- accepted payments column -->
                <div class="col-6">
                  <p class="lead">Payment Methods:</p>
                  <img src="{{asset('dist/img/credit/visa.png')}}" alt="Visa">
                  <img src="{{asset('dist/img/credit/mastercard.png')}}" alt="Mastercard">
                  <img src="{{asset('dist/img/credit/american-express.png')}}" alt="American Express">
                  <img src="{{asset('dist/img/credit/paypal2.png')}}" alt="Paypal">

                 
                </div>
                <!-- /.col -->
                <div class="col-6">
                 

                  <div class="table-responsive">
                    <table class="table">
                      <!-- <tr>
                        <th style="width:50%">Subtotal:</th>
                        <td>$250.30</td>
                      </tr>
                      <tr>
                        <th>Tax (9.3%)</th>
                        <td>$10.34</td>
                      </tr>
                      <tr>
                        <th>Shipping:</th>
                        <td>$5.80</td>
                      </tr> -->
                      <tr>
                        <th>Total:</th>
                        <td>${{$amount}}</td>
                      </tr>
                    </table>
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

             
            </div>
            <!-- /.invoice -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
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
     });
</script>
@endsection