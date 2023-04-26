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
                    <div class="row mb-3">
                        <label for="expire" class="col-sm-3 col-form-label">วันหมดอายุ</label>
                        <div class="col-sm-9">
                            <input type="datetime-local" class="form-control" id="expire" x-model="expire" x-ref="expire">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="description" class="col-sm-3 col-form-label">คำอธิบาย</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="description" x-model="description">
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
        <form action="" method="get" x-data="formFilter" class="row row-cols-lg-auto g-3 align-items-center">
            <input type="hidden" name="page" value="">
            <div class="col-auto">
                <label for="per_page">จำนวนแถว:</label>
                <select name="per_page" class="form-select d-inline w-auto" id="per_page" @change="submit">
                    <option selected disabled>จำนวนแถว</option>
                    <option value="10" <?= $filter['per_page'] === 10 ? 'selected' : '' ?>>10</option>
                    <option value="15" <?= $filter['per_page'] === 15 ? 'selected' : '' ?>>15</option>
                    <option value="25" <?= $filter['per_page'] === 25 ? 'selected' : '' ?>>25</option>
                    <option value="50" <?= $filter['per_page'] === 50 ? 'selected' : '' ?>>50</option>
                    <option value="100" <?= $filter['per_page'] === 100 ? 'selected' : '' ?>>100</option>
                </select>
            </div>
            <div class="col-auto">
                <label for="status">สถานะ:</label>
                <select name="status" class="form-select d-inline w-auto" id="status" @change="submit">
                    <option value="published" <?= $filter['status'] === 'published' ? 'selected' : '' ?>>เผยแพร่</option>
                    <option value="trashed" <?= $filter['status'] === 'trashed' ? 'selected' : '' ?>>อยู่ในถังขยะ</option>
                </select>
            </div>
            <div class="col-auto">
                <div class="input-group">
                    <input type="search" class="form-control" name="search" id="search" value="<?= $filter['search'] ?>" placeholder="ค้นหา">
                    <button type="submit" class="btn btn-outline-secondary">
                        <div class="icon cil-search"></div>
                    </button>
                </div>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">
                    กรอง
                </button>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ชื่อผู้ใช้</th>
                        <?php if ($filter['status'] !== 'trashed') : ?>
                            <th>รหัสผ่าน</th>
                        <?php endif ?>
                        <th>คำอธิบาย</th>
                        <th>เวลาสร้าง</th>
                        <th>วันหมดอายุ</th>
                        <?php if ($filter['status'] === 'trashed') : ?>
                            <th>เวลาลบ</th>
                        <?php endif ?>
                        <?php if ($filter['status'] !== 'trashed') : ?>
                            <th>การกระทำ</th>
                        <?php endif ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($guestUsers as $guestUser) : ?>
                        <tr>
                            <th><?= $guestUser['id'] ?></th>
                            <td><?= esc($guestUser['username']) ?></td>
                            <?php if ($filter['status'] !== 'trashed') : ?>
                                <td><?= esc($guestUser['password']) ?></td>
                            <?php endif ?>
                            <td><?= $guestUser['description'] ?></td>
                            <td><?= $guestUser['created_at'] ?></td>
                            <td><?= esc($guestUser['expire_at']) ?></td>
                            <?php if ($filter['status'] === 'trashed') : ?>
                                <td><?= $guestUser['deleted_at'] ?></td>
                            <?php endif ?>
                            <?php if ($filter['status'] !== 'trashed') : ?>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm lh-1" value="<?= $guestUser['username'] ?>" data-tooltip="tooltip" title="ลบผู้ใช้" x-data="guestsButtonDelete" x-bind="trigger" :disabled="load">
                                        <span x-show="load" class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></span>
                                        <i x-show="!load" class="icon cil-trash"></i>
                                    </button>
                                </td>
                            <?php endif ?>

                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-end">
            <?= $pager->links() ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>