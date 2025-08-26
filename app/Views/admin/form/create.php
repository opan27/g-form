<!-- app/Views/admin/form/create.php -->
<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<h1 class="h3 mb-4 text-gray-800">Buat Form Baru</h1>

<form action="/admin/forms/store" method="post">
    <?= csrf_field() ?>

    <div class="form-group">
        <label for="judul">Judul Form</label>
        <input type="text" name="judul" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="deskripsi">Deskripsi</label>
        <textarea name="deskripsi" class="form-control" rows="4"></textarea>
    </div>

    <button class="btn btn-success">Simpan</button>
    <a href="/admin/forms" class="btn btn-secondary">Batal</a>
</form>

<?= $this->endSection(); ?>
