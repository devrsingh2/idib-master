<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('admin.includes.head')
    <script src="{{ asset('website-assets/js/preloader.js') }}"></script>
    @toastr_css
    @yield('header')
</head>
<body>
<div class="body-wrapper">
    <!-- partial:partials/_sidebar.html -->
    @include('admin.includes.sidebar')
<!-- partial -->
    <div class="main-wrapper mdc-drawer-app-content">
        <!-- partial:partials/_navbar.html -->
    @include('admin.includes.header')
    <!-- partial -->
        <div class="page-wrapper mdc-toolbar-fixed-adjust">
        @yield('content')
        <!-- partial:partials/_footer.html -->
        @include('admin.includes.footer')
        <!-- partial -->
        </div>
    </div>
</div>
<!-- plugins:js -->
<script src="{{ asset('website-assets/vendors/js/vendor.bundle.base.js') }}"></script>
<!-- endinject -->
<!-- Plugin js for this page-->
<script src="{{ asset('website-assets/vendors/chartjs/Chart.min.js') }}"></script>
<script src="{{ asset('website-assets/vendors/jvectormap/jquery-jvectormap.min.js') }}"></script>
<script src="{{ asset('website-assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<!-- End plugin js for this page-->
<!-- inject:js -->
<script src="{{ asset('website-assets/js/material.js') }}"></script>
<script src="{{ asset('website-assets/js/misc.js') }}"></script>
<!-- endinject -->
<!-- Custom js for this page-->
<script src="{{ asset('website-assets/js/dashboard.js') }}"></script>
<!-- End custom js for this page-->
@toastr_js
@yield('footer')
</body>
</html>