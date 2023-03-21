<?= $this->extend('default_layout') ?>

<?= $this->section('head') ?>
<link rel="stylesheet" href="<?= base_url('assets/dist/css/page/portal/portal.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/bootstrap-icons/bootstrap-icons.css') ?>">
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
            <?= view_cell('AlertError', [
                'error' => $error ?? null
            ]) ?>
            <h1 class="h3">รายงานปัญหา</h1>
            <form action="" method="post" x-data="formEditPassword">
                <?= csrf_field() ?>
                <div class="text-start">
                    <div class="row g-3 mb-3">
                        <div class="col">
                            <label for="firstname" class="form-label">ชื่อ</label>
                            <input type="text" class="form-control" name="firstname" id="firstname" value="<?= set_value('firstname') ?>">
                            <div class="invalid-feedback">
                                กรุณาป้อนชื่อ
                            </div>
                            <?= validation_show_error('firstname', 'show_error') ?>
                        </div>
                        <div class="col">
                            <label for="lastname" class="form-label">นามสกุล</label>
                            <input type="text" class="form-control" name="lastname" id="lastname" value="<?= set_value('lastname') ?>">
                            <div class="invalid-feedback">
                                กรุณาป้อนนามสกุล
                            </div>
                            <?= validation_show_error('lastname', 'show_error') ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">อีเมล</label>
                        <input type="email" class="form-control" name="email" id="email" value="<?= set_value('email') ?>">
                        <div class="invalid-feedback">
                            กรุณาป้อนอีเมล
                        </div>
                        <?= validation_show_error('email', 'show_error') ?>
                    </div>
                    <div class="mb-3">
                        <label for="tel" class="form-label">เบอร์โทร</label>
                        <input type="tel" class="form-control" name="tel" id="tel" value="<?= set_value('tel') ?>">
                        <div class="invalid-feedback">
                            กรุณาป้อนเบอร์โทร
                        </div>
                        <?= validation_show_error('tel', 'show_error') ?>
                    </div>
                    <div class="mb-3">
                        <label for="title" class="form-label">หัวข้อ</label>
                        <input type="text" class="form-control" name="title" id="title" value="<?= set_value('title') ?>">
                        <div class="invalid-feedback">
                            กรุณาป้อนหัวข้อ
                        </div>
                        <?= validation_show_error('title', 'show_error') ?>
                    </div>
                    <div class="mb-3">
                        <label for="details" class="form-label">รายละเอียด</label>
                        <textarea name="details" id="details" class="form-control" value="<?= set_value('details') ?>"></textarea>
                        <div class="invalid-feedback">
                            กรุณาป้อนรายละเอียด
                        </div>
                        <?= validation_show_error('details', 'show_error') ?>
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">ประเภทของปัญหา</label>
                        <input type="file" class="form-control" name="file" id="file" value="<?= set_value('type') ?>">
                        <?= validation_show_error('type', 'show_error') ?>
                    </div>
                    <div class="mb-3">
                        <label for="file" class="form-label">รายละเอียด</label>
                        <input type="file" class="form-control" name="file" id="file" value="<?= set_value('file') ?>">
                        <?= validation_show_error('details', 'show_error') ?>
                    </div>
                </div>

                <button class="btn btn-primary mt-4" type="submit">บันทึก</button>

                <p class="mt-5">
                    <a href="<?= config('Firewall')->authURL ?>">ลงชื่อเข้าใช้</a>
                </p>
            </form>
        </div>

    </div>
</section>
<?= $this->endSection() ?>