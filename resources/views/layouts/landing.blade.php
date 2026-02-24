@php
    use App\Models\Utility;

    $settings = Utility::settings();
    $logo = asset('uploads/logo');
    $company_logo = Utility::getValByName('company_logo_dark');
    $company_logos = Utility::getValByName('company_logo_light');

    $setting = \App\Models\Utility::colorset();
    $color = (!empty($setting['color'])) ? $setting['color'] : 'theme-3';
    $SITE_RTL = Utility::getValByName('SITE_RTL');

    $getseo = App\Models\Utility::getSeoSetting();
    $metatitle = isset($getseo['meta_title']) ? $getseo['meta_title'] : 'ERPIPS';
    $metsdesc = isset($getseo['meta_desc']) ? $getseo['meta_desc'] : 'ERPIPS business workspace';
    $meta_image = \App\Models\Utility::get_file('uploads/meta/');
    $meta_logo = isset($getseo['meta_image']) ? $getseo['meta_image'] : '';
    $get_cookie = Utility::getCookieSetting();

    $brandLogo = !empty($company_logos) ? $company_logos : (!empty($company_logo) ? $company_logo : 'erpips.png');
@endphp
<!DOCTYPE html>
<html lang="en" dir="{{ $setting['SITE_RTL'] == 'on' ? 'rtl' : '' }}">
<head>
    <title>{{ __('ERPIPS') }}</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="title" content="{{ $metatitle }}">
    <meta name="description" content="{{ $metsdesc }}">

    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ env('APP_URL') }}">
    <meta property="og:title" content="{{ $metatitle }}">
    <meta property="og:description" content="{{ $metsdesc }}">
    <meta property="og:image" content="{{ $meta_image . $meta_logo }}">

    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ env('APP_URL') }}">
    <meta property="twitter:title" content="{{ $metatitle }}">
    <meta property="twitter:description" content="{{ $metsdesc }}">
    <meta property="twitter:image" content="{{ $meta_image . $meta_logo }}">

    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/x-icon" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@500;600;700;800&family=Sora:wght@600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/plugins/animate.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}">

    @if ($SITE_RTL == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style-rtl.css') }}">
    @endif
    @if ($setting['cust_darklayout'] == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style-dark.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">
    @endif

    <style>
        :root {
            --bg: #f6faf8;
            --ink: #0f2b25;
            --muted: #5d736c;
            --primary: #0d7a63;
            --accent: #f39f2e;
            --line: #d8e8e2;
            --card: #ffffff;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Manrope', sans-serif;
            color: var(--ink);
            background:
                radial-gradient(60rem 40rem at 110% -10%, #d6f7ea 0%, transparent 60%),
                radial-gradient(50rem 30rem at -10% 15%, #e5f1ff 0%, transparent 55%),
                var(--bg);
        }

        h1,
        h2,
        h3,
        h4,
        h5 {
            font-family: 'Sora', sans-serif;
            letter-spacing: -0.02em;
        }

        .topbar {
            background: rgba(8, 46, 38, 0.85);
            backdrop-filter: blur(8px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.12);
        }

        .topbar .nav-link {
            color: #d7f7ee;
            font-weight: 600;
        }

        .topbar .nav-link:hover {
            color: #fff;
        }

        .btn-brand {
            background: var(--primary);
            border-color: var(--primary);
            color: #fff;
        }

        .btn-brand:hover {
            background: #0a654f;
            border-color: #0a654f;
            color: #fff;
        }

        .btn-line {
            border: 1px solid #b7d5cc;
            color: var(--ink);
            background: #fff;
        }

        .hero {
            padding-top: 125px;
            padding-bottom: 78px;
        }

        .badge-chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: 1px solid #cde7df;
            background: #ecf8f4;
            color: #0a614d;
            padding: 8px 14px;
            border-radius: 999px;
            font-weight: 700;
            font-size: 13px;
        }

        .hero-title {
            font-size: clamp(2rem, 4.7vw, 3.7rem);
            line-height: 1.05;
            margin: 16px 0;
        }

        .hero-note {
            color: var(--muted);
            font-size: 1.02rem;
            max-width: 560px;
        }

        .visual-frame {
            border: 1px solid #cfe2dc;
            background: linear-gradient(160deg, #fff, #f3faf7);
            border-radius: 24px;
            padding: 14px;
            box-shadow: 0 18px 45px rgba(19, 83, 68, 0.12);
        }

        .metric-strip {
            margin-top: 18px;
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
        }

        .metric-item {
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 14px;
        }

        .metric-item h4 {
            margin: 0;
            color: var(--primary);
            font-size: 1.25rem;
        }

        .section {
            padding: 74px 0;
        }

        .section-title {
            font-size: clamp(1.7rem, 3vw, 2.4rem);
            margin-bottom: 10px;
        }

        .section-sub {
            color: var(--muted);
            max-width: 640px;
            margin: 0 auto;
        }

        .surface {
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: 18px;
            box-shadow: 0 12px 30px rgba(15, 57, 47, 0.08);
        }

        .feature-box {
            height: 100%;
            padding: 24px;
        }

        .feature-mark {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #ecf8f4;
            color: var(--primary);
            font-size: 1.3rem;
            margin-bottom: 14px;
        }

        .journey {
            background: linear-gradient(180deg, #f0f7f3, #f7fbfa);
            border-top: 1px solid #e0ece7;
            border-bottom: 1px solid #e0ece7;
        }

        .journey-step {
            position: relative;
            padding: 24px;
            padding-left: 62px;
        }

        .journey-step::before {
            content: attr(data-step);
            position: absolute;
            left: 18px;
            top: 21px;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--primary);
            color: #fff;
            font-weight: 700;
            font-size: 12px;
        }

        .quote {
            padding: 24px;
            height: 100%;
            border-left: 4px solid #1f9b7f;
        }

        .package {
            padding: 28px;
            height: 100%;
        }

        .package .price {
            font-size: 2rem;
            color: var(--primary);
            margin: 4px 0 12px;
            font-family: 'Sora', sans-serif;
        }

        .faq-wrap .accordion-item {
            border: 1px solid var(--line);
            border-radius: 12px;
            margin-bottom: 10px;
            overflow: hidden;
        }

        .faq-wrap .accordion-button {
            font-weight: 700;
            color: var(--ink);
        }

        .footer {
            border-top: 1px solid var(--line);
            background: #fff;
            padding: 22px 0;
            margin-top: 36px;
        }

        @media (max-width: 992px) {
            .metric-strip {
                grid-template-columns: 1fr;
            }

            .hero {
                padding-top: 105px;
            }
        }
    </style>
</head>
<body class="{{ $color }}">
<nav class="navbar navbar-expand-lg navbar-dark topbar fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#home">
            <img src="{{ $logo . '/' . $brandLogo }}" alt="ERPIPS" style="height: 42px; width: auto;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#landingNav" aria-controls="landingNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="landingNav">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#features">Keunggulan</a></li>
                <li class="nav-item"><a class="nav-link" href="#testimonial">Cerita Tim</a></li>
                <li class="nav-item"><a class="nav-link" href="#pricing">Aktivasi</a></li>
                <li class="nav-item"><a class="nav-link" href="#faq">FAQ</a></li>
                <li class="nav-item ms-lg-2"><a class="btn btn-light btn-sm" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                @if($settings['enable_signup'] == 'on')
                    <li class="nav-item ms-lg-2"><a class="btn btn-brand btn-sm" href="{{ route('register') }}">{{ __('Register') }}</a></li>
                @endif
            </ul>
        </div>
    </div>
</nav>

<header id="home" class="hero">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-6">
                <span class="badge-chip wow animate__fadeInUp" data-wow-delay="0.1s"><i class="ti ti-sparkles"></i>ERPIPS Business Operating System</span>
                <h1 class="hero-title wow animate__fadeInUp" data-wow-delay="0.2s">Operasional multi-company jadi rapi, cepat, dan mudah dikendalikan.</h1>
                <p class="hero-note wow animate__fadeInUp" data-wow-delay="0.3s">Dari finance sampai project, semua modul berjalan dalam satu ekosistem. Super admin bisa buka-tutup fitur per company tanpa drama plan.</p>
                <div class="d-flex flex-wrap gap-2 mt-4 wow animate__fadeInUp" data-wow-delay="0.4s">
                    <a href="{{ route('login') }}" class="btn btn-brand"><i class="ti ti-layout-dashboard me-1"></i>Masuk Dashboard</a>
                    @if($settings['enable_signup'] == 'on')
                        <a href="{{ route('register') }}" class="btn btn-line"><i class="ti ti-user-plus me-1"></i>Daftarkan Company</a>
                    @endif
                </div>
            </div>
            <div class="col-lg-6">
                <div class="visual-frame wow animate__fadeInRight" data-wow-delay="0.2s">
                    <img src="{{ asset('assets/images/front/header-mokeup.svg') }}" alt="ERPIPS dashboard" class="img-fluid rounded-3">
                </div>
                <div class="metric-strip wow animate__fadeInUp" data-wow-delay="0.35s">
                    <div class="metric-item">
                        <h4>5 Modul</h4>
                        <small class="text-muted">Accounting, HRM, CRM, Project, POS</small>
                    </div>
                    <div class="metric-item">
                        <h4>Per Company</h4>
                        <small class="text-muted">Feature toggle independen</small>
                    </div>
                    <div class="metric-item">
                        <h4>1 Dashboard</h4>
                        <small class="text-muted">Satu tempat untuk monitoring</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<section id="features" class="section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Keunggulan ERPIPS</h2>
            <p class="section-sub">Dirancang untuk kebutuhan operasional nyata: kompleks secukupnya, cepat diadopsi tim, dan tetap terukur.</p>
        </div>
        <div class="row g-3">
            <div class="col-md-6 col-lg-4">
                <div class="surface feature-box wow animate__fadeInUp" data-wow-delay="0.1s">
                    <div class="feature-mark"><i class="ti ti-building-bank"></i></div>
                    <h5>Accounting Terstruktur</h5>
                    <p class="text-muted mb-0">Arus kas, invoice, bill, dan laporan keuangan dalam alur yang konsisten.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="surface feature-box wow animate__fadeInUp" data-wow-delay="0.2s">
                    <div class="feature-mark"><i class="ti ti-users-group"></i></div>
                    <h5>HRM Terkoneksi</h5>
                    <p class="text-muted mb-0">Data kehadiran, payroll, dan performa kerja terkumpul dalam satu sistem.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="surface feature-box wow animate__fadeInUp" data-wow-delay="0.3s">
                    <div class="feature-mark"><i class="ti ti-target"></i></div>
                    <h5>CRM Berbasis Pipeline</h5>
                    <p class="text-muted mb-0">Leads dan deals terlihat jelas, memudahkan prioritas aksi tim sales.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="surface feature-box wow animate__fadeInUp" data-wow-delay="0.4s">
                    <div class="feature-mark"><i class="ti ti-kanban"></i></div>
                    <h5>Project Delivery</h5>
                    <p class="text-muted mb-0">Pantau progress, task, dan timesheet agar implementasi tidak meleset.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="surface feature-box wow animate__fadeInUp" data-wow-delay="0.5s">
                    <div class="feature-mark"><i class="ti ti-shopping-cart"></i></div>
                    <h5>POS Operasional</h5>
                    <p class="text-muted mb-0">Transaksi kasir dan stok tetap sinkron dengan laporan keuangan.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="surface feature-box wow animate__fadeInUp" data-wow-delay="0.6s">
                    <div class="feature-mark"><i class="ti ti-settings-cog"></i></div>
                    <h5>Control per Company</h5>
                    <p class="text-muted mb-0">Super admin mengatur akses modul per company sesuai strategi bisnis.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section journey">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="section-title">Alur Implementasi</h2>
            <p class="section-sub">Dibuat supaya tim bisa mulai cepat tanpa kehilangan kontrol.</p>
        </div>
        <div class="row g-3">
            <div class="col-md-4">
                <div class="surface journey-step h-100" data-step="01">
                    <h5>Setup Company</h5>
                    <p class="text-muted mb-0">Tambahkan company, atur struktur user, lalu aktifkan modul yang dibutuhkan.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="surface journey-step h-100" data-step="02">
                    <h5>Jalankan Operasional</h5>
                    <p class="text-muted mb-0">Gunakan dashboard sesuai unit kerja: finance, HR, sales, project, dan outlet.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="surface journey-step h-100" data-step="03">
                    <h5>Review Kinerja</h5>
                    <p class="text-muted mb-0">Pantau metrik utama dan sesuaikan fitur company secara berkala dari super admin.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="testimonial" class="section">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="section-title">Cerita Tim Pengguna</h2>
            <p class="section-sub">Pengalaman operasional setelah memakai ERPIPS sebagai pusat kontrol bisnis.</p>
        </div>
        <div class="row g-3">
            <div class="col-md-4">
                <div class="surface quote wow animate__fadeInUp" data-wow-delay="0.1s">
                    <p>"Kami bisa onboarding company baru lebih cepat karena module control per company sudah langsung tersedia."</p>
                    <strong>Head of Operations</strong>
                    <div class="text-muted small">Holding Multi-Unit</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="surface quote wow animate__fadeInUp" data-wow-delay="0.2s">
                    <p>"Finance, HR, dan tim project sekarang pakai satu sumber data. Laporan mingguan jadi jauh lebih tenang."</p>
                    <strong>General Manager</strong>
                    <div class="text-muted small">Professional Service</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="surface quote wow animate__fadeInUp" data-wow-delay="0.3s">
                    <p>"Dashboard yang fokus membantu kami lihat bottleneck lebih cepat tanpa harus buka banyak tools."</p>
                    <strong>Business Controller</strong>
                    <div class="text-muted small">Retail & Distribution</div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="pricing" class="section" style="background: #f0f7f3; border-top:1px solid #e0ece7; border-bottom:1px solid #e0ece7;">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="section-title">Pilihan Aktivasi</h2>
            <p class="section-sub">Pilih sesuai tahap pertumbuhan dan kompleksitas proses bisnismu.</p>
        </div>
        <div class="row g-3 justify-content-center">
            <div class="col-lg-5">
                <div class="surface package wow animate__fadeInUp" data-wow-delay="0.1s">
                    <h5>Starter Launch</h5>
                    <div class="price">Rp0</div>
                    <p class="text-muted">Untuk mulai digitalisasi proses inti.</p>
                    <ul class="list-unstyled text-muted">
                        <li class="mb-2"><i class="ti ti-check text-success me-2"></i>Setup company dasar</li>
                        <li class="mb-2"><i class="ti ti-check text-success me-2"></i>Aktivasi modul inti</li>
                        <li class="mb-2"><i class="ti ti-check text-success me-2"></i>Akses role management</li>
                    </ul>
                    <a href="{{ route('register') }}" class="btn btn-line w-100">Mulai Sekarang</a>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="surface package wow animate__fadeInUp" data-wow-delay="0.2s" style="border: 2px solid #83bea8;">
                    <h5>Scale & Control</h5>
                    <div class="price">Custom</div>
                    <p class="text-muted">Untuk operasi multi-company dengan kontrol modul detail.</p>
                    <ul class="list-unstyled text-muted">
                        <li class="mb-2"><i class="ti ti-check text-success me-2"></i>Feature toggle per company</li>
                        <li class="mb-2"><i class="ti ti-check text-success me-2"></i>Workflow lintas divisi</li>
                        <li class="mb-2"><i class="ti ti-check text-success me-2"></i>Pendampingan implementasi</li>
                    </ul>
                    <a href="{{ route('login') }}" class="btn btn-brand w-100">Masuk & Konfigurasi</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="faq" class="section">
    <div class="container faq-wrap">
        <div class="text-center mb-4">
            <h2 class="section-title">Pertanyaan Umum</h2>
            <p class="section-sub">Jawaban cepat untuk hal paling penting sebelum go-live ERPIPS.</p>
        </div>

        <div class="accordion" id="faqAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header" id="faqOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Bisa atur modul berbeda untuk tiap company?
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="faqOne" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">Bisa. Super admin dapat mengaktifkan/nonaktifkan Accounting, HRM, CRM, Project, dan POS per company.</div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="faqTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Cocok untuk perusahaan dengan banyak unit usaha?
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="faqTwo" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">Cocok. Setiap company bisa punya konfigurasi sendiri tapi tetap dalam kontrol dashboard utama super admin.</div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="faqThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        Apakah tampilan sudah nyaman di mobile?
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="faqThree" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">Ya. Struktur komponen sudah responsif sehingga navigasi dan CTA tetap jelas di layar kecil.</div>
                </div>
            </div>
        </div>
    </div>
</section>

<footer class="footer">
    <div class="container d-flex flex-wrap justify-content-between align-items-center gap-3">
        <img src="{{ $logo . '/' . $brandLogo }}" alt="ERPIPS" style="height: 36px; width: auto;">
        <span class="text-muted">Copyright {{ date('Y') }} ERPIPS. Built for real operations.</span>
    </div>
</footer>

<script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/wow.min.js') }}"></script>
<script>
    const wow = new WOW({ animateClass: 'animate__animated' });
    wow.init();

    document.querySelectorAll('.navbar .nav-link').forEach((link) => {
        link.addEventListener('click', () => {
            const nav = document.getElementById('landingNav');
            if (nav.classList.contains('show')) {
                nav.classList.remove('show');
            }
        });
    });
</script>
@if($get_cookie['enable_cookie'] == 'on')
    @include('layouts.cookie_consent')
@endif
</body>
</html>
