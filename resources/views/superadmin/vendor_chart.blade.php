<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  @include('superadmin.css')

  <script src="https://cdn.tailwindcss.com"></script>  
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{asset('dist/img/AdminLTELogo.png')}}" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->
  @include('superadmin.navbar')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  @include('superadmin.sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
     <h1 class='text-5xl font-bold'>Admin Graphs</h1>
        <br><br>
        <div class='flex'>
            <div class="w-1/2">
            {!! $user_chart->container() !!}
            </div>

            <div class="w-1/2">
            {!! $status_chart->container() !!}
            </div>
        
            <div class="w-1/2">
            {!! $total_chart->container() !!}
            </div>

        </div>
     

            <div class='flex'>
            <div class="w-1/2">
            {!! $product_chart->container() !!}
            </div> 
            
            <div class="w-1/2">
            {!! $discount_chart->container() !!}
            </div> 
            </div>
        <div>
    
    </div>

  <!-- /.content-wrapper -->
  @include('superadmin.footer')

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
@include('superadmin.script')
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
{!! $user_chart->script() !!}
{!! $status_chart->script() !!}
{!! $total_chart->script() !!}

</html>
