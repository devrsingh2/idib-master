<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('website.includes.head')
    <script src="{{ asset('website-assets/js/preloader.js') }}"></script>
    @yield('header')
</head>
<body>
<div class="body-wrapper">
    <div class="main-wrapper">
        @yield('content')
    </div>
</div>
<!-- plugins:js -->
<script src="{{ asset('website-assets/vendors/js/vendor.bundle.base.js') }}"></script>
<!-- endinject -->
<!-- inject:js -->
<script src="{{ asset('website-assets/js/material.js') }}"></script>
<script src="{{ asset('website-assets/js/misc.js') }}"></script>
<!-- endinject -->
</body>
</html>