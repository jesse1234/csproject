<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Vendor | Dashboard</title>

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
  
    <h2 class='h2_font'>Add Vendor Detail</h2>

    <form action="{{ route('vendor.details') }}" method="POST" enctype='multipart/form-data'>
        @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="title">Business Name</label>
                    <input type="text" class="form-control" name="business_name" placeholder="Enter Business Name">
                  </div>

                  <div class="card-body">
                  <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" name="address" placeholder="Enter Description">
                  </div>


                  <div class="form-group">
                    <label for="image">KRA Certificate</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file"  name="image">
                
                      </div>
                    </div>
                  </div>

                  

                  

                  

                  

                  
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
 
  

  </div>

                
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
