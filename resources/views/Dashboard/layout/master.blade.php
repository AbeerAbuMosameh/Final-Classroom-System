<!DOCTYPE html>
<html lang="en">
<head>
    <base href="">
    <meta charset="utf-8"/>
    <title>@yield('title', config('app.name'))</title>
    @include('Dashboard.partials.css')
    @stack('css')
</head>
<!--begin::Body-->
<body id="kt_body"
      class="quick-panel-right demo-panel-right offcanvas-right header-fixed header-mobile-fixed aside-enabled aside-static page-loading">
<!--begin::Main-->
<div class="d-flex flex-column flex-root">

    <!--begin::Page-->
    <div class="d-flex flex-row flex-column-fluid page">
        @include('Dashboard.partials.aside')

        <!--begin::Wrapper-->
        <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
            @include('Dashboard.partials.header')
            <!--begin::Content-->
            <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                <!--begin::Entry-->
                <div class="d-flex flex-column-fluid">
                    <!--begin::Container-->
                    <div class="container">
                        @yield('content')
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Entry-->
            </div>
            <!--end::Content-->
            @include('Dashboard.partials.footer')
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Page-->
</div>
<!--end::Main-->

@include('Dashboard.partials.js')
@stack('js')
</body>
<!--end::Body-->
</html>
