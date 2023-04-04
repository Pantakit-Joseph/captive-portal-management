<?= $this->extend('admin/layout') ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('assets/js/page/admin/issues/type.js') ?>" defer></script>
<script src="<?= base_url('assets/js/form-filter.js') ?>" defer></script>
<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
<li class="breadcrumb-item"><a href="<?= site_url('admin') ?>">หน้าหลัก</a></li>
<li class="breadcrumb-item"><a href="<?= site_url('admin/issues') ?>">รายงานปัญหา</a></li>
<li class="breadcrumb-item active"><span>ประเภทของปัญหา</span></li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <div class="">
                รายการประเภทของปัญหา
            </div>

            <button type="button" class="btn btn-sm btn-primary" data-coreui-toggle="modal" data-coreui-target="#add" data-tooltip="tooltip" title="เพิ่มประเภทของปัญหา">
                <i class="icon cil-plus"></i>
                <span class="d-none d-sm-inline">เพิ่ม</span>
            </button>
            <div class="modal fade" id="add" x-data="issuesTypeAdd" tabindex="-1">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">เพิ่มประเภทของปัญหา</h5>
                            <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div x-ref="alert"></div>
                            <div class="row mb-3">
                                <label for="type_name" class="col-sm-3 col-form-label">ประเภทปัญหา</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="type_name" id="type_name" x-model="typeName">
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
                        <th>ประเภทของปัญหา</th>
                        <th>เวลาสร้าง</th>
                        <th>เวลาอัปเดต</th>
                        <?php if ($filter['status'] === 'trashed') : ?>
                            <th>เวลาลบ</th>
                        <?php endif ?>
                        <th>การกระทำ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($types as $type) : ?>
                        <tr>
                            <th><?= $type['id'] ?></th>
                            <td><?= esc($type['type_name']) ?></td>
                            <td><?= $type['created_at'] ?></td>
                            <td><?= $type['updated_at'] ?></td>
                            <?php if ($filter['status'] === 'trashed') : ?>
                                <td><?= $type['deleted_at'] ?></td>
                            <?php endif ?>
                            <td>
                                <button type="button" class="btn btn-warning btn-sm lh-1" data-coreui-toggle="modal" data-coreui-target="#edit<?= $type['id'] ?>" data-tooltip="tooltip" title="แก้ไขประเภทของปัญหา">
                                    <i class="icon cil-pen"></i>
                                </button>
                                <?php if ($filter['status'] === 'trashed') : ?>
                                    <button type="button" class="btn btn-info btn-sm lh-1" value="<?= $type['id'] ?>" data-tooltip="tooltip" title="คืนค่าประเภทของปัญหา" x-data="issuesTypeRestore" @click="submit" :disabled="load">
                                        <span x-show="load" class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></span>
                                        <i x-show="!load" class="icon cil-restore"></i>
                                    </button>

                                    <button type="button" class="btn btn-danger btn-sm lh-1" value="<?= $type['id'] ?>" data-tooltip="tooltip" title="ลบประเภทของปัญหาถาวร" x-data="issuesTypeDelete" @click="submit" data-purge="true" :disabled="load">
                                        <span x-show="load" class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></span>
                                        <i x-show="!load" class="icon cil-trash"></i>
                                    </button>
                                <?php else : ?>
                                    <button type="button" class="btn btn-danger btn-sm lh-1" value="<?= $type['id'] ?>" x-data="issuesTypeDelete" @click="submit" :disabled="load">
                                        <span x-show="load" class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></span>
                                        <i x-show="!load" class="icon cil-trash"></i>
                                    </button>
                                <?php endif ?>
                            </td>

                            <div class="modal fade" id="edit<?= $type['id'] ?>" x-data="issuesTypeEdit" tabindex="-1">
                                <div class="modal-dialog modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">แก้ไขประเภทของปัญหา</h5>
                                            <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div x-ref="alert"></div>
                                            <div class="row mb-3">
                                                <label for="id<?= $type['id'] ?>" class="col-sm-3 col-form-label">รหัส</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="id" id="id<?= $type['id'] ?>" value="<?= $type['id'] ?>" disabled>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="type_name<?= $type['id'] ?>" class="col-sm-3 col-form-label">ประเภทปัญหา</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="type_name" id="type_name<?= $type['id'] ?>" x-model="typeName" value="<?= esc($type['type_name']) ?>">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="created_at<?= $type['id'] ?>" class="col-sm-3 col-form-label">เวลาสร้าง</label>
                                                <div class="col-sm-9">
                                                    <input type="datetime-local" class="form-control" name="created_at" id="created_at<?= $type['id'] ?>" value="<?= $type['created_at'] ?>" disabled>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="updated_at<?= $type['id'] ?>" class="col-sm-3 col-form-label">เวลาอัปเดต</label>
                                                <div class="col-sm-9">
                                                    <input type="datetime-local" class="form-control" name="updated_at" id="updated_at<?= $type['id'] ?>" value="<?= $type['updated_at'] ?>" disabled>
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