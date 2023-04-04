<?= $this->extend('default_layout') ?>

<?= $this->section('head') ?>
<link rel="stylesheet" href="<?= base_url('assets/dist/css/page/portal/portal.css') ?>">
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
            <img src="<?= base_url('assets/svg/success-svgrepo-com.svg') ?>" alt="" class="w-25">
            <h1 class="my-5 h1">เปลี่ยนรหัสผ่านสำเร็จ</h1>
            <div class="d-grid">
                <a href="<?= config('Firewall')->authURL ?>" class="btn btn-primary">
                    ลงชื่อเข้าใช้
                </a>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>