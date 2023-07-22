<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{asset('dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Vendor Panel</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
         <a href="#" class="d-block">{{ Auth::guard('admin')->user()->name }}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="{{route('admin.dashboard')}}" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
          
          
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Charts
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('admin.charts')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Vendor Charts</p>
                </a>
              </li>
            </ul>
          </li>
          
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Forms
                <i class="fas fa-angle-left right"></i>
                
              </p>
            </a>
            <ul class="nav nav-treeview">
              
              <li class="nav-item">
                <a href="{{ url('/admin/vendor_details') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Vendor Details Form </p>
                  
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('/admin/categories') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Categories Form</p>
                  
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('/view_product') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Products Form </p>
                  
                </a>
              </li>
              <!-- <li class="nav-item">
                <a href="{{ route('import') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Bulk Upload Products</p>
                </a>
              </li> -->
              
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Tables
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('/show_product') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Product Table</p>
                  <span class="badge badge-info right">{{$total_product}}</span>
                  
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('/show_orders') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Orders Table</p>
                  <span class="badge badge-info right">{{$total_order}}</span>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="{{ route('admin.stk') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>STK Request Table</p>
                </a>
              </li>
              
            </ul>
          </li>
          
          
          <li class="nav-header"></li>
          
          <li class="nav-item">
          <form action="{{ route('admin.logout') }}" method="POST">
        @csrf
        <button class="btn btn-block btn-danger">Logout</button>
    </form>
          </a>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>