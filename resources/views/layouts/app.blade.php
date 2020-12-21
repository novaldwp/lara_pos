@include('layouts.header')
@include('layouts.navbar')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            @yield('title', 'Dashboard')
        </h1>
        <ol class="breadcrumb">
            @section('breadcrumb')
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            @show
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        @yield('content')

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->


@include('layouts.footer')
