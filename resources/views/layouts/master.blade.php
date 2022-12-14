<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title> {{config('app.name', 'POS')}} | @yield('title')</title>

  
  <link rel="stylesheet" href="{{ asset('css/app.css')}}">
  <link rel="stylesheet" href="{{ asset('css/style.css')}}">

  <!-- Google Font: Source Sans Pro -->
  <style>
    .nav-sidebar .nav-header {
        font-size: .9rem;
        padding: 0.5rem 0.75rem !important;
    }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper" id="app">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"><i
            class="fas fa-th-large"></i></a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">{{config('app.name', 'POS')}}</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->

       
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ auth()->user()->name}}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{ route('view.index')}}" class="nav-link @yield('view')">
              <i class="nav-icon fas fa-tv"></i>
              <p>
                  Sale
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('customer.index')}}" class="nav-link">
              <i class="nav-icon fas fa-user-tag"></i>
              <p>
                  Users
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('customer.index')}}" class="nav-link @yield('customer')">
              <i class="nav-icon fas fa-chalkboard-teacher"></i>
              <p>
                  Customers
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('category.index')}}" class="nav-link @yield('category')">
              <i class="nav-icon fas fa-wallet"></i>
              <p>Category</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('product.index')}}" class="nav-link @yield('product')">
              <i class="nav-icon fas fa-archive"></i>
              <p>Items</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('table.index')}}" class="nav-link @yield('table')">
              <i class="nav-icon fas fa-table"></i>
              <p>
                  Tables
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('table.index')}}" class="nav-link">
              <i class="nav-icon fas fa-shopping-cart"></i>
              <p>
                  Purchase
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('table.index')}}" class="nav-link">
              <i class="nav-icon fas fa-tags"></i>
              <p>
                  Supplier
              </p>
            </a>
          </li>
          <li class="nav-header">Report List</li>
          <li class="nav-item">
            <a href="{{ route('export.index')}}" class="nav-link">
              <i class="nav-icon fas fa-arrow-circle-down"></i>
              <p>Import</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('export.index')}}" class="nav-link">
              <i class="nav-icon fas fa-arrow-circle-up"></i>
              <p>Export</p>
            </a>
          </li>
          <li class="nav-header">Logout</li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}"
                      onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                <i class="nav-icon fas fa-lock"></i>
                <p>
                  Logout

                </p>
            </a>
          </li>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
          </form>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  @yield('content')

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<script src="{{ asset('js/app.js')}}"></script>

</body>
</html>
