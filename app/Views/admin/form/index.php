<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Daftar Form</h1>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Tutup">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <a href="/admin/forms/new" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Buat Form Baru
    </a>

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table id="formTable" class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>Judul</th>
                            <th>Deskripsi</th>
                            <th>Link</th>
                            <th class="text-center" style="width: 180px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($forms as $f): ?>
                        <tr>
                            <td><?= esc($f['judul']) ?></td>
                            <td><?= esc($f['deskripsi']) ?></td>
                            <td>
                                <a href="/form/<?= esc($f['slug']) ?>" target="_blank">
                                    /form/<?= esc($f['slug']) ?>
                                </a>
                            </td>
                                <td class="text-center">
                                    <div class="d-flex flex-column align-items-center gap-1">
                                        <a href="/admin/forms/<?= $f['id'] ?>/fields" class="btn btn-sm btn-info mb-1 w-100">
                                            <i class="fas fa-edit"></i> Pertanyaan
                                        </a>
                                        <a href="/admin/forms/<?= $f['id'] ?>/responses" class="btn btn-sm btn-secondary mb-1 w-100">
                                            <i class="fas fa-users"></i> Responden
                                        </a>
                                        <form action="/admin/forms/<?= $f['id'] ?>/delete" method="post"
                                            onsubmit="return confirm('Hapus form ini?')" class="w-100">
                                            <?= csrf_field() ?>
                                            <button class="btn btn-sm btn-danger w-100">
                                                <i class="fas fa-trash-alt"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>

                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- DataTables JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function () {
        $('#formTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
            }
        });
    });
</script>

<?= $this->endSection(); ?>
