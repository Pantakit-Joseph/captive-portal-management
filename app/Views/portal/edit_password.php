<?= $this->extend('default_layout') ?>

<?= $this->section('head') ?>
<link rel="stylesheet" href="<?= base_url('assets/dist/css/page/portal/portal.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/bootstrap-icons/bootstrap-icons.css') ?>">
<script src="<?= base_url('assets/js/page/portal/edit_pass.js') ?>" defer></script>
<script src="<?= base_url('assets/js/password-show-hide.js') ?>" defer></script>
<?= $this->endSection() ?>

<?= $this->section('body') ?>
<section class="text-center m-auto mt-5 content">
    <img src="<?= base_url('assets/img/ctc_logo.png') ?>" alt="" class="logo">

    <p class="h5 mt-3">
        ระบบยืนยันตัวตนในการเข้าใช้งานอินเตอร์เน็ต
        <br>
        วิทยาลัยเทคนิคชัยภูมิ
    </p>

    <div class="card mt-5 mb-5 shadow-lg rounded-4">
        <div class="card-body p-5">
            <?= view_cell('AlertFeedback', [
                'error'   => $error ?? null,
                'success' => $success ?? null,
                'warning' => $warning ?? null,
                'info'    => $info ?? null,
            ]) ?>
            <h1 class="h3">เปลี่ยนรหัสผ่าน</h1>
            <form action="" method="post" x-data="formEditPassword">
                <?= csrf_field() ?>
                <div class="text-start">
                    <div class="mb-3">
                        <label for="username" class="form-label">ชื่อผู้ใช้</label>
                        <input type="text" class="form-control" name="username" id="username" value="<?= set_value('username') ?>" :class="usernameClass" x-model="username" @input="usernameCheck">
                        <div class="invalid-feedback">
                            กรุณาป้อนชื่อผู้ใช้
                        </div>
                        <?= validation_show_error('username', 'show_error') ?>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">รหัสผ่านปัจุบัน</label>
                        <div class="input-group has-validation" x-data="passwordShowHide">
                            <input type="password" :type="type" class="form-control " name="password" id="password" value="<?= set_value('password') ?>" :class="passwordClass" x-model="password" @input="passwordCheck">
                            <i class="input-group-text bi" :class='icon' @click='toggle' @mouseover="cursorPointer"></i>

                            <div class="invalid-feedback">
                                กรุณาป้อนรหัสผ่านปัจุบัน
                            </div>
                        </div>
                        <?= validation_show_error('password', 'show_error') ?>
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">รหัสผ่านใหม่</label>
                        <div class="input-group has-validation" x-data="passwordShowHide">
                            <input type="password" :type="type" class="form-control " name="new_password" id="new_password" value="<?= set_value('new_password') ?>" :class="newPasswordClass" x-model="newPassword" @input="newPasswordCheck">
                            <i class="input-group-text bi" :class='icon' @click='toggle' @mouseover="cursorPointer"></i>
                            <div class="invalid-feedback">
                                <ul>
                                    <li>ความยาวอย่างน้อย 8 ตัวอักษร</li>
                                    <!-- <li>ประกอบด้วยอักษรตัวพิมพ์ใหญ่อย่างน้อยหนึ่งตัว (<code>A-Z</code>)</li>
                                <li>ประกอบด้วยอักษรตัวพิมพ์เล็กอย่างน้อยหนึ่งตัว (<code>a-z</code>)</li>
                                <li>มีตัวเลขอย่างน้อยหนึ่งหลัก (<code>0-9</code>)</li>
                                <li>มีอักขระพิเศษอย่างน้อยหนึ่งตัว (<code>!@#$%^&*()_+-=[]{};':"\\|,.<>/?</code>)</li> -->
                                </ul>
                            </div>
                        </div>
                        <?= validation_show_error('new_password', 'show_error') ?>
                    </div>
                    <div class="mb-3">
                        <label for="new_password_confirm" class="form-label">ยืนยันรหัสผ่านใหม่</label>
                        <input type="password" class="form-control" name="new_password_confirm" id="new_password_confirm" value="<?= set_value('new_password_confirm') ?>" :class="newPasswordConfirmClass" x-model="newPasswordConfirm" @input="newPasswordConfirmCheck">
                        <div class="invalid-feedback">
                            ยืนยันรหัสผ่านใหม่ ไม่ตรงกับ รหัสผ่านใหม่
                        </div>
                        <?= validation_show_error('new_password_confirm', 'show_error') ?>
                    </div>
                </div>

                <button class="btn btn-primary" type="submit" :disabled="notSubmit">บันทึก</button>

                <p class="mt-5">
                    <a href="<?= config('Firewall')->authURL ?>">ลงชื่อเข้าใช้</a>
                </p>
            </form>
        </div>

    </div>
</section>
<?= $this->endSection() ?>