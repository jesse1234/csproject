<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  @include('admin.css')
  <style>
    .div_center{
        text-align:center;
        padding-top:40px;
    }
    .h2_font{
        font-size:40px;
        padding-bottom:40px;
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
  
    <h2 class='h2_font'>Add Product</h2>

    <form action="{{ url('/add_product') }}" method="POST" enctype='multipart/form-data'>
        @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="title">Product Name</label>
                    <input type="text" class="form-control" name="title" placeholder="Enter Product Name">
                  </div>

                  <div class="card-body">
                  <div class="form-group">
                    <label for="description">Description</label>
                    <input type="text" class="form-control" name="description" placeholder="Enter Description">
                  </div>


                  <div class="form-group">
                    <label for="product_image">Product Image</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" name="product_image">
                        <label class="custom-file-label" for="product_image">Choose file</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text">Upload</span>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="3d_image">3D Image</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" name="_3d_image">
                        <label class="custom-file-label" for="_3d_image">Choose file</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text">Upload</span>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="description">Category ID</label>
                    <input type="number" class="form-control" name="category_id" placeholder="Enter Category ID">
                  </div>

                  <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" class="form-control" name="quantity" placeholder="Enter Quantity" min='0'>
                  </div>

                  <div class="form-group">
                    <label for="price">Price</label>
                    <input type="number" class="form-control" name="price" placeholder="Enter Price" min='0'>
                  </div>

                  <div class="form-group">
                    <label for="discount_price">Discount Price</label>
                    <input type="number" class="form-control" name="discount_price" placeholder="Enter Discount Price" min='0'>
                  </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
 
  

  </div>

  <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Title</th>
                      <th>Description</th>
                      <th>Product Image</th>
                      <th>3D Image</th>
                      <th>Category ID</th>
                      <th>Quantity</th>
                      <th>Price</th>
                      <th>Discount Price</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                        
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td><a href=""><button type='button' class='btn btn-block btn-info tn-sm'>Edit</button></a></td>
                      <td><a onclick = "" href="{{}}"><button type='button' class='btn btn-block btn-danger tn-sm'>Delete</button></a></td>
                    </tr>
                        
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
