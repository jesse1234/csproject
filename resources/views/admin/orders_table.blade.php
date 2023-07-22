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
        width:100px;
        height:100px;
    }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{asset('dist/img/AdminLTELogo.png')}}" alt="AdminLTELogo" height="60" width="60">
  </div>
  @include('sweetalert::alert')
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
  
    <h2 class='h2_font'>View Orders</h2>

    <div style='padding-left:400px;'>
      <form action="{{url('search')}}" method='get'>
        @csrf
        <input type="text" name='search' placeholder='Search For Orders'>
        <input type="submit" value="Search" class='btn btn-outline-primary'>
      </form>
    </div>

  <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Address</th>
                      <th>Region</th>
                      <th>Image</th>
                      <th>Product Title</th>
                      <th>Price</th>
                      <th>Delivery Status</th>
                      <th>Print PDF</th>
                      <th>Send Email</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($order as $order)
                    <tr>
                      <td>{{$order->id}}</td> 
                      <td>{{$order->name}}</td>
                      <td>{{$order->email}}</td>
                      <td>{{$order->address}}</td>
                      <td>{{$order->region}}</td>
                      <td>
                        <img class = 'img-size' src="product/{{$order->products->image}}" alt="" >
                      </td>
                      <td>{{$order->products->title}}</td>
                      <td>{{$order->total_price}}</td>
                      <td>{{$order->delivery_status}}</td>
                      
                     
                      <td>
                      @if($order->delivery_status == 'pending')  
                      <a href="{{ url('delivered',$order->id) }}" onclick="confirmation(event)"><button type='button' class='btn btn-block btn-info tn-sm'>Delivered</button></a>
                      @else

                    <p style='color:green;'>Delivered</p>

                    @endif

                    <td>
                      <a href="{{url('print_pdf',$order->id)}}" class='btn btn-secondary'>Print PDF</a>
                    </td>

                    <td>
                      <a href="{{url('send_email',$order->id)}}" class='btn btn-info'>Send Email</a>
                    </td>
                    </td>
                      
                      <td><a onclick="confirmation(event)" href="{{ url('/delete_order',$order->id) }}"><button type='button' class='btn btn-block btn-danger tn-sm'>Delete</button></a></td>
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
