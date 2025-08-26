<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Form: <?= esc($form['judul']) ?></h1>

    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="/admin/forms/<?= $form['id'] ?>/fields" method="post">
                <?= csrf_field() ?>

                <div class="form-group">
                    <label for="label">Pertanyaan</label>
                    <input type="text" name="label" id="label" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="type">Jenis</label>
                    <select name="type" id="type" class="form-control" onchange="toggleOptions(this.value)" required>
                        <option value="text">Teks Pendek</option>
                        <option value="textarea">Teks Panjang</option>
                        <option value="radio">Pilihan Ganda</option>
                        <option value="checkbox">Checkbox</option>
                        <option value="select">Dropdown</option>
                        <option value="file">Upload File</option>
                        <option value="image">Upload Gambar</option>
                    </select>
                </div>

                <div class="form-group" id="optionsGroup" style="display: none;">
                    <label for="options">Opsi (1 per baris)</label>
                    <textarea name="options" id="options" class="form-control" rows="4" placeholder="Contoh:\nPilihan A\nPilihan B\nPilihan C"></textarea>
                </div>

                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" name="required" id="required">
                    <label class="form-check-label" for="required">Wajib diisi</label>
                </div>

                <button class="btn btn-success"><i class="fas fa-plus-circle"></i> Tambah Pertanyaan</button>
            </form>
        </div>
    </div>

    <h4 class="mb-3">Daftar Pertanyaan</h4>
    <div class="card shadow">
        <div class="card-body">
            <table class="table table-bordered table-hover" id="dataTable">
                <thead class="thead-light">
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th>Pertanyaan</th>
                        <th>Jenis</th>
                        <th>Wajib</th>
                        <th style="width: 15%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($fields as $f): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= esc($f['label']) ?></td>
                        <td><?= esc(ucwords($f['type'])) ?></td>
                        <td><?= $f['required'] ? 'Ya' : 'Tidak' ?></td>
                        <td>
                            <div class="d-flex flex-column gap-1">
                                <a href="/admin/forms/<?= $form['id'] ?>/fields/<?= $f['id'] ?>/edit" class="btn btn-sm btn-warning mb-1 w-100">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="/admin/forms/<?= $form['id'] ?>/fields/<?= $f['id'] ?>/delete" method="post" onsubmit="return confirm('Hapus pertanyaan ini?')">
                                    <?= csrf_field(); ?>
                                    <button class="btn btn-sm btn-danger w-100"><i class="fas fa-trash-alt"></i> Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Tambahan JS untuk toggle opsi -->
<script>
function toggleOptions(value) {
    const optGroup = document.getElementById('optionsGroup');
    const show = ['radio', 'checkbox', 'select'].includes(value);
    optGroup.style.display = show ? 'block' : 'none';
}
</script>

<!-- Tambahkan DataTables jika ingin -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
</script>

<?= $this->endSection(); ?>
