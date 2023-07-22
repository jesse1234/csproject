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
                      <th>User ID</th>
                      <th>Transaction ID</th>
                      <th>Cart</th>
                      <th>Address</th>
                      <th>Region </th>
                    
                    </tr>
                  </thead>
                  <tbody>
                  @foreach($transaction as $transaction)
                    <tr>
                        
                      <td>{{$transaction->id}}</td> 
                      <td>{{$transaction->user_id}}</td>
                      <td>{{$transaction->transaction_id}}</td>
                      
                      <td>{{$transaction->cart}}</td>
                      <td>{{$transaction->address}}</td>
                      <td>{{$transaction->region}}</td>
                      
        
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
