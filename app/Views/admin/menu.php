<?= $this->section('sidebar_nav') ?>
<li class="nav-item">
    <a class="nav-link" href="<?= site_url('admin/home') ?>">
        <i class="nav-icon cil-home"></i>
        หน้าหลัก
    </a>
</li>
<li class="nav-group">
    <a class="nav-link nav-group-toggle" href="#">
        <i class="nav-icon cil-exclamation"></i>
        รายงานปัญหา
    </a>
    <ul class="nav-group-items">
        <li class="nav-item">
            <a class="nav-link" href="<?= site_url('admin/issues') ?>">
                <i class="nav-icon"></i>
                รายการปัญหา
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= site_url('admin/issues/types') ?>">
                <i class="nav-icon"></i>
                ประเภทของปัญหา
            </a>
        </li>
    </ul>
</li>
<?= $this->endSection() ?>