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
  
    <h2 class='h2_font'>Add Category</h2>

    <form action="{{ url('/add_category')}}" method="POST">
        @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="category_name">Category Name</label>
                    <input type="text" class="form-control" name="category_name" placeholder="Enter Category Name">
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
                      <th>Category Name</th>
                      <th>Created At</th>
                      <th>Updated At</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                        @foreach ($data as $data)
                      <td>{{$data->id}}</td>
                      <td>{{$data->category_name}}</td>
                      <td>{{$data->created_at}}</td>
                      <td>{{$data->updated_at}}</td>
                      <td><a href=""><button type='button' class='btn btn-block btn-info tn-sm'>Edit</button></a></td>
                      <td><a onclick = "return confirm('Are you sure you want to delete this?')" href="{{ url('delete_category', $data->id) }}"><button type='button' class='btn btn-block btn-danger tn-sm'>Delete</button></a></td>
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
