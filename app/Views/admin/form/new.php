<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Buat Form Baru</h1>

    <form action="/admin/forms/create" method="post" enctype="multipart/form-data">
        <?= csrf_field(); ?>
        
        <div class="form-group">
            <label>Judul Form</label>
            <input type="text" name="judul" class="form-control" required placeholder="Contoh: Survei Kepuasan Pengguna">
        </div>

        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3" placeholder="Tuliskan keterangan atau tujuan form ini..."></textarea>
        </div>

        <div class="form-group">
            <label>Upload Gambar (opsional)</label>
            <input type="file" name="gambar" class="form-control">
        </div>

        <button class="btn btn-primary">Buat & Tambahkan Pertanyaan</button>
        <a href="/admin/forms" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?= $this->endSection(); ?>
