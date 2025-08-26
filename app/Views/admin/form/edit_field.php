<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit Pertanyaan</h1>

    <form action="/admin/forms/<?= $form_id ?>/fields/<?= $field['id'] ?>/update" method="post">
        <?= csrf_field(); ?>

        <div class="form-group">
            <label>Pertanyaan</label>
            <input type="text" name="label" class="form-control" value="<?= esc($field['label']) ?>" required>
        </div>

        <div class="form-group">
            <label>Jenis</label>
            <select name="type" class="form-control" onchange="toggleOptions(this.value)" required>
                <option value="text" <?= $field['type'] == 'text' ? 'selected' : '' ?>>Teks Pendek</option>
                <option value="textarea" <?= $field['type'] == 'textarea' ? 'selected' : '' ?>>Teks Panjang</option>
                <option value="radio" <?= $field['type'] == 'radio' ? 'selected' : '' ?>>Pilihan Ganda</option>
                <option value="checkbox" <?= $field['type'] == 'checkbox' ? 'selected' : '' ?>>Checkbox</option>
                <option value="select" <?= $field['type'] == 'select' ? 'selected' : '' ?>>Dropdown</option>
                <option value="file" <?= $field['type'] == 'file' ? 'selected' : '' ?>>Upload File</option>
                <option value="image" <?= $field['type'] == 'image' ? 'selected' : '' ?>>Upload Gambar</option>
            </select>
        </div>

        <div class="form-group" id="optionsGroup" style="display: none;">
            <label>Opsi (1 per baris)</label>
            <textarea name="options" class="form-control" rows="4"><?= isset($field['options']) ? implode("\n", json_decode($field['options'], true)) : '' ?></textarea>
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" class="form-check-input" name="required" id="required"
                <?= $field['required'] ? 'checked' : '' ?>>
            <label class="form-check-label" for="required">Wajib diisi</label>
        </div>

        <button class="btn btn-primary">Simpan Perubahan</button>
        <a href="/admin/forms/<?= $form_id ?>/fields" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<script>
    function toggleOptions(value) {
        const optGroup = document.getElementById('optionsGroup');
        const show = ['radio', 'checkbox', 'select'].includes(value);
        optGroup.style.display = show ? 'block' : 'none';
    }

    // Panggil saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function () {
        toggleOptions("<?= $field['type'] ?>");
    });
</script>

<?= $this->endSection(); ?>
