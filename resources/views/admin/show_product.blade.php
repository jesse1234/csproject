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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

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
  
    <h2 class='h2_font'>View Product</h2>

  <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Title</th>
                      <th>Description</th>
                      <th>Product Image</th>
                      <th>3D Image Name</th>
                      <th>Category ID</th>
                      <th>Quantity</th>
                      <th>Price</th>
                      <th>Discount Price</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($product as $product)
                    <tr>
                      <td>{{$product->id}}</td> 
                      <td>{{$product->title}}</td>
                      <td>{{$product->description}}</td>
                      <td>
                        <img class = 'img-size' src="product/{{$product->image}}" alt="" style='width:100px; height:100px;'>
                      </td>
                      <td>{{$product->image_3d}}</td>
                      <td>{{$product->category_id}}</td>
                      <td>{{$product->quantity}}</td>
                      <td>{{$product->price}}</td>
                      <td>{{$product->discount_price}}</td>
                      <td><a href="{{ url('/update_product',$product->id) }}"><button type='button' class='btn btn-block btn-info tn-sm'>Edit</button></a></td>
                      <td><a onclick= "confirmation(event)"  href="{{ url('/delete_product',$product->id) }}"><button type='button' class='btn btn-block btn-danger tn-sm'>Delete</button></a></td>
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
