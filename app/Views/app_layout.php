<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <title>ระบบยืนยันตัวตนในการเข้าใช้งานอินเตอร์เน็ต วิทยาลัยเทคนิคชัยภูมิ</title>

    <!-- Vendors styles-->
    <link rel="stylesheet" href="<?= base_url('assets/coreui-template/vendors/simplebar/css/simplebar.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/coreui-template/css/vendors/simplebar.css') ?>">
    <!-- Main styles for this application-->
    <link href="<?= base_url('assets/dist/css/app/style.css') ?>" rel="stylesheet">

    <link rel="stylesheet" href="<?= base_url('assets/icons-pro/css/all.min.css') ?>">

    <!-- CoreUI and necessary plugins-->
    <script src="<?= base_url('assets/coreui/js/coreui.bundle.min.js') ?>" defer></script>
    <script src="<?= base_url('assets/coreui-template/vendors/simplebar/js/simplebar.min.js') ?>" defer></script>
    <!-- Plugins and scripts required by this view-->
    <script src="<?= base_url('assets/coreui-template/vendors/chart.js/js/chart.min.js') ?>" defer></script>
    <script src="<?= base_url('assets/coreui-template/vendors/@coreui/chartjs/js/coreui-chartjs.js') ?>" defer></script>
    <script src="<?= base_url('assets/coreui-template/vendors/@coreui/utils/js/coreui-utils.js') ?>" defer></script>
    <script src="<?= base_url('assets/coreui-template/js/main.js') ?>" defer></script>

    <script src="<?= base_url('assets/js/app.js') ?>" defer></script>

    <?= $this->renderSection('head') ?>

    <script src="<?= base_url('assets/alpinejs/dist/cdn.min.js') ?>" defer></script>

</head>

<body>
    <div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
        <div class="sidebar-brand d-none d-md-flex">
            <div class="sidebar-brand-full">
                <img src="<?= base_url('assets/img/logoITCTC3.png') ?>" height="46" alt="">
            </div>
            <div class="sidebar-brand-narrow">
                <img src="<?= base_url('assets/img/logoITCTC2.png') ?>" height="46" alt="">
            </div>
        </div>
        <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
            <?= $this->renderSection('sidebar_nav') ?>
        </ul>
        <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
    </div>
    <div class="wrapper d-flex flex-column min-vh-100 bg-light">
        <header class="header header-sticky mb-4">
            <div class="container-fluid">
                <button class="header-toggler px-md-0 me-md-3" type="button" onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">
                    <i class="icon icon-lg cil-menu"></i>
                </button>
                <a class="header-brand d-md-none" href="#">
                    <img src="<?= base_url('assets/img/logoITCTC3.png') ?>" height="46" alt="">
                </a>
                <ul class="header-nav d-none d-md-flex">

                </ul>
                <ul class="header-nav ms-auto">

                </ul>
                <ul class="header-nav ms-3">
                    <div class="vr me-1"></div>
                    <li class="nav-item dropdown">
                        <a class="nav-link py-0" data-coreui-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                            <div class="lh-sm fw-bolder">
                                <?= esc(user('username')) ?>
                                <div class="text-end fw-light"><?= auth()->getUserTypeName(user_type()) ?></ก>
                                </div>

                        </a>
                        <div class="dropdown-menu dropdown-menu-end pt-0">
                            <div class="dropdown-header bg-light py-2">
                                <div class="fw-semibold">บัญชี</div>
                            </div>
                            <a class="dropdown-item" href="#">
                                <i class="icon me-2 cil-settings"></i>
                                ตั้งค่า
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?= site_url('auth/logout') ?>">
                                <i class="icon me-2 cil-account-logout"></i>
                                ออกจากระบบ
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="header-divider"></div>
            <div class="container-fluid">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb my-0 ms-2">
                        <?= $this->renderSection('breadcrumb') ?>
                    </ol>
                </nav>
            </div>
        </header>
        <div class="body flex-grow-1 px-3">
            <div class="container-lg">
                <?= view_cell('AlertError', [
                    'error' => $error ?? null
                ]) ?>
                <?= $this->renderSection('content') ?>
            </div>
        </div>
        <footer class="footer">
            <div class="">2023 © เทคโนโลยีสารสนเทศ วิทยาลัยเทคนิคชัยภูมิ</div>
            <div class="ms-auto">พัฒนาโดย นายพันธกิจ มะลิทอง</div>
        </footer>
    </div>
</body>

</html>