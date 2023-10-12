@extends('Layout.master')
@section('main')
<div id="wrapper">
    @include('Admin.Components.sidebar')
    <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @include('Admin.Components.nav')
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    @yield('page')

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2020</span>
                    </div>
                </div>
            </footer>
        </div>
</div>
@endsection
