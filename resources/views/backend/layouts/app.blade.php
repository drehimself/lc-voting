@include('backend.partials.header')

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">

        @include('backend.partials.sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

            @include('backend.partials.top_bar')
                
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">{{ $page ?? 'Dashboard' }}</h1>
                        {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> --}}
                    </div>

                    @include('backend.partials.alerts')
                    <!-- Content Row -->
                    <div class="row ">
                        <div class="col-md-12">
                            @yield('content')
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

@include('backend.partials.footer')