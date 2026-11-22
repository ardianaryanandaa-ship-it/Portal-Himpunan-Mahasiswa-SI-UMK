<!DOCTYPE html>
<html lang="id">
<head>
    <title><?= esc($title ?? 'Backend - HIMA SI') ?></title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Halaman masuk panel backend HIMA SI Universitas Muria Kudus" />
    <link rel="shortcut icon" href="<?= base_url('assets/media/logos/favicon.ico') ?>" />

    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="<?= base_url('assets/plugins/global/plugins.bundle.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/css/style.bundle.css') ?>" rel="stylesheet" type="text/css" />
    
    <script>
        if (window.top != window.self) {
            window.top.location.replace(window.self.location.href);
        }
    </script>
</head>

<body id="kt_body" class="auth-bg">
    <div class="d-flex flex-column flex-root">
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            
            <!--begin::Logo (Mobile only)-->
            <a href="<?= site_url('/') ?>" class="d-block d-lg-none mx-auto py-20">
                <img alt="Logo HIMA SI" src="<?= base_url('assets/media/logos/default.svg') ?>" class="theme-light-show h-25px" />
            </a>
            
            <!--begin::Aside (Left Side / Form Container)-->
            <main class="d-flex flex-column flex-column-fluid flex-center w-lg-50 p-10" aria-label="Formulir autentikasi">
                <div class="d-flex justify-content-between flex-column-fluid flex-column w-100 mw-450px">
                    
                    <!--begin::Header-->
                    <div class="d-flex flex-stack py-2">
                        <a href="<?= site_url('/') ?>" class="text-gray-900 fw-bold fs-3 text-decoration-none">HIMA SI</a>
                    </div>
                    
                    <!--begin::Body (Form Content)-->
                    <div class="py-20">
                        <?= $this->renderSection('content') ?>
                    </div>
                    
                    <!--begin::Footer-->
                    <div class="m-0 text-muted fs-7">HIMA SI · Panel Backend</div>
                </div>
            </main>

            <!--begin::Body (Right Side / Image)-->
            <div class="d-none d-lg-flex flex-lg-row-fluid w-50 bgi-size-cover bgi-position-y-center bgi-position-x-start bgi-no-repeat" 
                 style="background-image: url(<?= base_url('assets/media/auth/bg11.png') ?>)">
            </div>
        </div>
    </div>

    <!--begin::Global Javascript Bundle-->
    <script src="<?= base_url('assets/plugins/global/plugins.bundle.js') ?>"></script>
    <script src="<?= base_url('assets/js/scripts.bundle.js') ?>"></script>
    <?= $this->renderSection('js') ?>
</body>
</html>