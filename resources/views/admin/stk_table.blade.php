<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  @include('admin.css')
  <style>
    .h2_font{
        font-size:40px;
        padding-bottom:40px;
    }

    .img-size{
        width:250px;
        height:250px;
    }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{asset('dist/img/AdminLTELogo.png')}}" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->
  @include('admin.navbar')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  @include('admin.sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @if(session()->has('message'))

    <div class='alert alert-success'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
        {{session()->get('message')}}
    </div>
    @endif
  
    <h2 class='h2_font'>View Product</h2>

  <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Phone</th>
                      <th>Amount</th>
                      <th>Reference</th>
                      <th>Description</th>
                      <th>MerchantRequestID </th>
                      <th>CheckoutRequestID</th>
                      <th>Status</th>
                      <th>MpesaReceiptNumber</th>
                      <th>ResultDesc</th>
                      <th>TransactionDate</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($stk as $stk)
                    <tr>
                      <td>{{$stk->id}}</td> 
                      <td>{{$stk->phone}}</td>
                      <td>{{$stk->amount}}</td>
                      
                      <td>{{$stk->reference}}</td>
                      <td>{{$stk->description}}</td>
                      <td>{{$stk->MerchantRequestID}}</td>
                      <td>{{$stk->CheckoutRequestID}}</td>
                      <td>{{$stk->status}}</td>
                      
                      <td>{{$stk->MpesaReceiptNumber}}</td>
                      <td>{{$stk->ResultDesc}}</td>
                      <td>{{$stk->TransactionDate}}</td>
        
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
  <!-- /.content-wrapper -->
  @include('admin.footer')

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
@include('admin.script')
</body>
</html>
