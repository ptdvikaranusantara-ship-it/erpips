<!DOCTYPE html>
@php
    use App\Models\Utility;

    $logo = Utility::get_file('uploads/logo/');
    $company_logo_dark = Utility::getValByName('company_logo_dark');
    $company_logo_light = Utility::getValByName('company_logo_light');
    $company_favicon = Utility::getValByName('company_favicon');
    $setting = Utility::colorset();
    $mode_setting = Utility::mode_layout();
    $color = (!empty($setting['color'])) ? $setting['color'] : 'theme-3';
    $SITE_RTL = isset($setting['SITE_RTL']) ? $setting['SITE_RTL'] : 'off';

    $getseo = Utility::getSeoSetting();
    $metatitle = $getseo['meta_title'] ?? '';
    $metadesc = $getseo['meta_desc'] ?? '';
    $meta_image = Utility::get_file('uploads/meta/');
    $meta_logo = $getseo['meta_image'] ?? '';
    $get_cookie = Utility::getCookieSetting();
@endphp

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      dir="{{ $SITE_RTL == 'on' ? 'rtl' : '' }}">

<head>
    <title>
        {{ Utility::getValByName('title_text') ?? config('app.name', 'ERP') }}
        - @yield('page-title')
    </title>

    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <meta name="title" content="{{ $metatitle }}">
    <meta name="description" content="{{ $metadesc }}">

    <link rel="icon"
          href="{{ $logo.'/'.($company_favicon ?: 'favicon.svg') }}"
          type="image/x-icon"/>

    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}">

    <!-- Main CSS -->
    @if ($SITE_RTL == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style-rtl.css') }}" id="main-style-link">
    @elseif($setting['cust_darklayout'] == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style-dark.css') }}" id="main-style-link">
    @else
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">
    @endif

    <link rel="stylesheet" href="{{ asset('assets/css/customizer.css') }}">

    {{-- ===== FORCE COLOR OVERRIDE (HIJAU → BIRU) ===== --}}
    <style>
        /* Background luar */
        .bg-auth-side,
        .bg-auth-side.bg-primary {
            background-color: #042d63 !important;
        }

        /* Card kanan */
        .img-card-side {
            background-color: #042d63 !important;
        }

        .auth-img-content {
            background-color: #042d63 !important;
            height: 100%;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        /* Text kanan */
        .auth-img-content h3,
        .auth-img-content p {
            color: #ffffff !important;
        }

        /* Button primary */
        .btn-primary {
            background-color: #042d63 !important;
            border-color: #042d63 !important;
        }
    </style>
    {{-- ============================================== --}}
</head>

<body class="{{ $color }}">

<div class="auth-wrapper auth-v3">

    {{-- Background kiri --}}
    <div class="bg-auth-side bg-primary"></div>

    <div class="auth-content">

        {{-- TOP NAV --}}
        <nav class="navbar navbar-expand-md navbar-light default">
            <div class="container-fluid pe-2">
                <a class="navbar-brand" href="#">
                    @if($mode_setting['cust_darklayout'] == 'on')
                        <img src="{{ $logo.'/'.$company_logo_light }}"
                             class="logo w-50">
                    @else
                        <img src="{{ $logo.'/'.$company_logo_dark }}"
                             class="logo w-50">
                    @endif
                </a>

                <div class="collapse navbar-collapse" style="flex-grow:0;">
                    <ul class="navbar-nav ms-auto align-items-center">
                        @yield('auth-topbar')
                    </ul>
                </div>
            </div>
        </nav>

        {{-- CARD --}}
        <div class="card">
            <div class="row align-items-center text-start">

                {{-- LEFT --}}
                <div class="col-xl-6">
                    <div class="card-body">
                        @yield('content')
                    </div>
                </div>

                {{-- RIGHT --}}
                <div class="col-xl-6 img-card-side">
                    <div class="auth-img-content">
                        <img src="{{ asset('assets/images/auth/img-auth-3.svg') }}"
                             class="img-fluid mb-4" />
                        <h3 class="mb-3">“Attention is the new currency”</h3>
                        <p>
                            The more effortless the writing looks,
                            the more effort the writer actually put into the process.
                        </p>
                    </div>
                </div>

            </div>
        </div>

        {{-- FOOTER --}}
        <div class="auth-footer">
            <div class="container-fluid">
                <p class="mb-0">
                    {{ Utility::getValByName('footer_text') ?? 'Copyright ERP' }}
                    {{ date('Y') }}
                </p>
            </div>
        </div>

    </div>
</div>

<!-- JS -->
<script src="{{ asset('assets/js/vendor-all.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>
<script>feather.replace();</script>

@stack('custom-scripts')

@if($get_cookie['enable_cookie'] == 'on')
    @include('layouts.cookie_consent')
@endif

</body>
</html>