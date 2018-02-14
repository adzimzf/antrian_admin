<!DOCTYPE html>
<html>
<head>
    @include('layouts.header.style')
    <!-- plugin -->
    @stack('css')
    <!-- /plugin -->

    <!-- Theme style -->
    <link rel="stylesheet" href="{{url('/')}}/adminlte/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{url('/')}}/adminlte/dist/css/skins/_all-skins.min.css">

    <!-- App Custome -->
    <link rel="stylesheet" href="{{url('/')}}/css/myapp.css">

</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <!-- include main header -->
    @include('layouts/header/main')
    <!--- /main header -->

    <!-- Left side column. contains the logo and sidebar -->
    @include('layouts/body/leftSidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Main content -->
        @yield('content')
        <!-- /content -->

    </div>
    <!-- /.content-wrapper -->

    @include('layouts/footer/main')

    <!-- Control Sidebar -->
    {{--@include('layouts/body/controlSidebar')--}}
    <!-- /.control-sidebar -->

    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>

</div>
<!-- ./wrapper -->

@include('layouts/footer/script')

<!-- plugin -->
@stack('scripts')
<!-- /plugin -->

<!-- AdminLTE App -->
<script src="{{url('/')}}/adminlte/dist/js/adminlte.min.js"></script>

</body>
</html>
