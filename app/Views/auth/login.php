<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบยืนยันตัวตนในการเข้าใช้งานอินเตอร์เน็ต วิทยาลัยเทคนิคชัยภูมิ</title>
    <?= csrf_meta() ?>

    <link rel="stylesheet" href="<?= base_url('assets/coreui-template/vendors/simplebar/css/simplebar.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/coreui-template/css/vendors/simplebar.css') ?>">

    <link href="<?= base_url('assets/dist/css/app/style.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/bootstrap-icons/bootstrap-icons.css') ?>">

    <script src="<?= base_url('assets/coreui/js/coreui.bundle.min.js') ?>" defer></script>
    <script src="<?= base_url('assets/coreui-template/vendors/simplebar/js/simplebar.min.js') ?>" defer></script>

    <script src="<?= base_url('assets/js/password-show-hide.js') ?>" defer></script>
    <script src="<?= base_url('assets/alpinejs/dist/cdn.min.js') ?>" defer></script>
</head>

<body>
    <div class="bg-light min-vh-100 d-flex flex-row align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card-group d-block d-md-flex row">
                        <?= view_cell('AlertErrors', [
                            'errors' => $errors ?? null
                        ]) ?>
                        <div class="card col-md-7 p-4 mb-0">
                            <div class="card-body">
                                <h1>เข้าสู่ระบบ</h1>
                                <p class="text-medium-emphasis">ลงชื่อเข้าใช้บัญชีของคุณ</p>
                                <form action="<?= site_url('auth/login') ?>" method="post">
                                    <?= csrf_field() ?>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-person"></i>
                                        </span>
                                        <input class="form-control" type="text" name="username" value="<?= set_value('username') ?>" placeholder="ชื่อผู้ใช้">
                                    </div>
                                    <?= validation_show_error('username', 'show_error') ?>

                                    <div class="input-group mt-3" x-data="passwordShowHide">
                                        <span class="input-group-text">
                                            <i class="bi bi-lock"></i>
                                        </span>
                                        <input class="form-control" type="password" :type="type" name="password" value="<?= set_value('password') ?>" placeholder="รหัสผ่าน">
                                        <span class="input-group-text" @click='toggle' @mouseover="cursorPointer">
                                            <i :class="icon"></i>
                                        </span>
                                    </div>
                                    <?= validation_show_error('password', 'show_error') ?>

                                    <div class="row mt-4">
                                        <div class="col-6">
                                            <button class="btn btn-primary px-4" type="submit">เข้าสู่ระบบ</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card col-md-5 text-white bg-primary py-5">
                            <div class="card-body text-center">
                                <div>
                                    <img src="<?= base_url('assets/img/ctc_logo.png') ?>" alt="" style="height: 5rem;">
                                    <h2 class="h5 mt-3">
                                        ระบบยืนยันตัวตนในการ
                                        <br>เข้าใช้งานอินเตอร์เน็ต
                                        <br>วิทยาลัยเทคนิคชัยภูมิ
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>