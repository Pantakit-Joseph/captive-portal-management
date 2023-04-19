<?= $this->extend('admin/layout') ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('assets/js/form-filter.js') ?>" defer></script>
<script src="<?= base_url('assets/js/page/admin/users/guests.js') ?>" defer></script>
<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
<li class="breadcrumb-item"><a href="<?= site_url('admin') ?>">หน้าหลัก</a></li>
<li class="breadcrumb-item">จัดการผู้ใช้งาน</li>
<li class="breadcrumb-item active"><span>รายการผู้ใช้ชั่วคราว</span></li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-end gap-3 mb-4">
    <button class="btn btn-primary" data-coreui-toggle="modal" data-coreui-target="#add" data-tooltip="tooltip" title="เพิ่มผู้ใช้ชั่วคราว">
        <i class="cil-user-plus"></i>
        เพิ่ม
    </button>
    <div class="modal fade" id="add" x-data="guestsAdd" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">เพิ่มผู้ใช้ชั่วคราว</h5>
                    <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div x-ref="alert"></div>
                    <div class="row mb-3">
                        <label for="numberofusers" class="col-sm-3 col-form-label">จำนวนผู้ใช้<sup class="text-danger">*</sup></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="numberofusers" x-model="numberOfUsers" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="prefix" class="col-sm-3 col-form-label">คำนำหน้าชื่อผู้ใช้</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="prefix" x-model="prefix">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">ปิด</button>
                    <button type="button" class="btn btn-primary" @click="submit" :disabled="load">
                        <span x-show="load" class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></span>
                        บันทึก
                    </button>
                </div>
            </div>
        </div>
    </div> <!-- end modal -->
</div>

<div class="card">
    <div class="card-header">
        รายการผู้ใช้ชั่วคราว
    </div>

    <div class="card-body">
    </div>
</div>
<?= $this->endSection() ?>