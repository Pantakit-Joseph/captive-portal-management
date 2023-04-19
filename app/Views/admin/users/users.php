<?= $this->extend('admin/layout') ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('assets/js/form-filter.js') ?>" defer></script>
<script src="<?= base_url('assets/js/page/admin/issues/issues.js') ?>" defer></script>
<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
<li class="breadcrumb-item"><a href="<?= site_url('admin') ?>">หน้าหลัก</a></li>
<li class="breadcrumb-item">จัดการผู้ใช้งาน</li>
<li class="breadcrumb-item active"><span>รายการผู้ใช้งาน</span></li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?= $this->endSection() ?>