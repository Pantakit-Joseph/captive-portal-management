<?= $this->extend('admin/layout') ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('assets/js/form-filter.js') ?>" defer></script>
<script src="<?= base_url('assets/js/page/admin/issues/issues.js') ?>" defer></script>
<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
<li class="breadcrumb-item"><a href="<?= site_url('admin') ?>">หน้าหลัก</a></li>
<li class="breadcrumb-item active"><span>รายงานปัญหา</span></li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        รายการปัญหา
    </div>

    <div class="card-body">
        <form action="" method="get" x-data="formFilter" class="row row-cols-lg-auto g-3 align-items-center justify-content-sm-end">
            <input type="hidden" name="page" value="">
            <div class="col-auto">
                <label for="per_page">จำนวนแถว:</label>
                <select name="per_page" class="form-select d-inline w-auto" id="per_page" @change="submit">
                    <option disabled>จำนวนแถว</option>
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
                    <option value="open" <?= $filter['status'] === 'open' ? 'selected' : '' ?>>เปิดปัญหา</option>
                    <option value="close" <?= $filter['status'] === 'close' ? 'selected' : '' ?>>ปิดปัญหา</option>
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
            <div class="col-sm-auto col-12 d-flex justify-content-end">
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
                        <th>ชื่อ</th>
                        <th>นามสกุล</th>
                        <th>อีเมล</th>
                        <th>เบอร์โทร</th>
                        <th>ประเภทปัญหา</th>
                        <th>หัวข้อ</th>
                        <?php if ($filter['status'] === 'close') : ?>
                            <th>ปิดโดย</th>
                        <?php endif ?>
                        <th>การกระทำ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($issues as $issue) : ?>
                        <tr>
                            <th><?= $issue['id'] ?></th>
                            <td><?= esc($issue['firstname']) ?></td>
                            <td><?= esc($issue['lastname']) ?></td>
                            <td><?= esc($issue['email']) ?></td>
                            <td><?= esc($issue['tel']) ?></td>
                            <td><?= esc($issue['type_name']) ?></td>
                            <td><?= esc($issue['title']) ?></td>
                            <td><?= esc($issue['closed_username']) ?></td>
                            <td>
                                <button type="button" class="btn btn-primary btn-sm lh-1" data-coreui-toggle="modal" data-coreui-target="#details<?= $issue['id'] ?>" data-tooltip="tooltip" title="ดูรายละเอียดปัญหา">
                                    <i class="icon cil-eye"></i>
                                </button>
                                <?php if ($filter['status'] !== 'close') : ?>
                                    <button type="button" class="btn btn-success btn-sm lh-1" value="<?= $issue['id'] ?>" data-tooltip="tooltip" title="ปิดปัญหา" x-data="issuesClose" @click="submit" :disabled="load">
                                        <span x-show="load" class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></span>
                                        <i x-show="!load" class="icon cil-check"></i>
                                    </button>
                                <?php else : ?>
                                    <button type="button" class="btn btn-info btn-sm lh-1" value="<?= $issue['id'] ?>" data-tooltip="tooltip" title="เปิดปัญหาอีกครั้ง" x-data="issuesOpen" @click="submit" :disabled="load">
                                        <span x-show="load" class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></span>
                                        <i x-show="!load" class="icon cil-restore"></i>
                                    </button>
                                <?php endif ?>
                            </td>
                        </tr>

                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
        <?php foreach ($issues as $issue) : ?>
            <div class="modal fade" id="details<?= $issue['id'] ?>" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">รายละเอียดปัญหา</h5>
                            <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="">
                                <table class="table">
                                    <colgroup>
                                        <col class="w-auto">
                                        <col class="">
                                    </colgroup>
                                    <tr>
                                        <th scope="row">รหัส</th>
                                        <th><?= $issue['id'] ?></th>
                                    </tr>
                                    <tr>
                                        <th scope="row">ชื่อ</th>
                                        <td><?= esc($issue['firstname']) ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">นามสกุล</th>
                                        <td><?= esc($issue['lastname']) ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">อีเมล</th>
                                        <td><?= esc($issue['email']) ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">เบอร์โทร</th>
                                        <td><?= esc($issue['tel']) ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">ประเภทปัญหา</th>
                                        <td><?= esc($issue['type_name']) ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">หัวข้อ</th>
                                        <td><?= esc($issue['title']) ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row" colspan="2" class="border-0">รายระเอียด</th>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <textarea class="form-control ps-5" rows="5" readonly><?= esc($issue['details']) ?></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">ไฟล์</th>
                                        <td>
                                            <ul>
                                                <?php foreach ($issue['files'] as $file) : ?>
                                                    <li><a href="<?= base_url($file) ?>" target="_blank"><?= $file ?></a></li>
                                                <?php endforeach ?>
                                            </ul>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">ปิด</button>
                            <!-- <button type="button" class="btn btn-primary" @click="submit" :disabled="load">
                                                <span x-show="load" class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></span>
                                                บันทึก
                                            </button> -->
                        </div>
                    </div>
                </div>
            </div> <!-- end modal -->
        <?php endforeach ?>
        <div class="d-flex justify-content-end">
            <?= $pager->links() ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>