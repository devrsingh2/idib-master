<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ config('app.name', 'Laravel') }}</title>
<!-- plugins:css -->
<link rel="stylesheet" href="{{ asset('website-assets/vendors/mdi/css/materialdesignicons.min.css') }}">
<link rel="stylesheet" href="{{ asset('website-assets/vendors/css/vendor.bundle.base.css') }}">
<!-- endinject -->
<!-- Plugin css for this page -->
<link rel="stylesheet" href="{{ asset('website-assets/vendors/flag-icon-css/css/flag-icon.min.css') }}">
<link rel="stylesheet" href="{{ asset('website-assets/vendors/jvectormap/jquery-jvectormap.css') }}">
<!-- End plugin css for this page -->
<!-- Layout styles -->
<link rel="stylesheet" href="{{ asset('website-assets/css/demo/style.css') }}">
<!-- End layout styles -->
<link rel="shortcut icon" href="{{ asset('website-assets/images/favicon.png') }}" />
<style>
    .mdc-text-field:not(.mdc-text-field--disabled) + .mdc-text-field-helper-line .invalid-feedback {
        color: #ff0000;
    }
</style>