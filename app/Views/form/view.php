<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= esc($form['judul']) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & SB Admin CSS -->
    <link href="/assets/css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fc;
        }
        .form-card {
            max-width: 768px;
            margin: auto;
        }
        img.form-image {
            max-height: 300px;
            object-fit: contain;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="card shadow form-card">
            <div class="card-body">
                
                <!-- Gambar -->
                <?php if (!empty($form['gambar'])): ?>
                    <div class="text-center mb-4">
                        <img src="<?= base_url('uploads/forms/' . $form['gambar']) ?>" 
                             class="img-fluid rounded form-image" 
                             alt="Gambar Form">
                    </div>
                <?php endif; ?>

                <!-- Judul & Deskripsi -->
                <h2 class="text-center mb-2"><?= esc($form['judul']) ?></h2>
                <?php if (!empty($form['deskripsi'])): ?>
                    <p class="text-center text-muted mb-4"><?= esc($form['deskripsi']) ?></p>
                <?php endif; ?>

                <!-- Notifikasi -->
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                <?php endif; ?>

                <!-- Form Input -->
                <form method="post" action="/form/<?= esc($form['slug']) ?>" enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <?php foreach ($fields as $field): ?>
                        <div class="form-group">
                            <label><strong><?= esc($field['label']) ?><?= $field['required'] ? ' *' : '' ?></strong></label>

                            <?php if ($field['type'] === 'text'): ?>
                                <input type="text" name="field_<?= $field['id'] ?>" class="form-control" placeholder="Masukkan jawaban" <?= $field['required'] ? 'required' : '' ?>>

                            <?php elseif ($field['type'] === 'textarea'): ?>
                                <textarea name="field_<?= $field['id'] ?>" class="form-control" rows="3" placeholder="Tulis jawaban..." <?= $field['required'] ? 'required' : '' ?>></textarea>

                            <?php elseif (in_array($field['type'], ['radio', 'checkbox', 'select'])): ?>
                                <?php
                                    $options = json_decode($field['options'], true);
                                    if (!is_array($options)) $options = [];
                                ?>

                                <?php if ($field['type'] === 'select'): ?>
                                    <select name="field_<?= $field['id'] ?>" class="form-control" <?= $field['required'] ? 'required' : '' ?>>
                                        <option value="">-- Pilih salah satu --</option>
                                        <?php foreach ($options as $opt): ?>
                                            <option value="<?= esc($opt) ?>"><?= esc($opt) ?></option>
                                        <?php endforeach ?>
                                    </select>
                                <?php else: ?>
                                    <div class="pl-2">
                                        <?php foreach ($options as $opt): ?>
                                            <div class="form-check">
                                                <input 
                                                    class="form-check-input" 
                                                    type="<?= $field['type'] ?>" 
                                                    name="field_<?= $field['id'] ?><?= $field['type'] === 'checkbox' ? '[]' : '' ?>" 
                                                    value="<?= esc($opt) ?>" 
                                                    id="field_<?= $field['id'] ?>_<?= md5($opt) ?>"
                                                    <?= $field['required'] && $field['type'] === 'radio' ? 'required' : '' ?>
                                                >
                                                <label class="form-check-label" for="field_<?= $field['id'] ?>_<?= md5($opt) ?>">
                                                    <?= esc($opt) ?>
                                                </label>
                                            </div>
                                        <?php endforeach ?>
                                    </div>
                                <?php endif ?>

                            <?php elseif (in_array($field['type'], ['file', 'image'])): ?>
                                <input type="file" name="field_<?= $field['id'] ?>" class="form-control-file" <?= $field['required'] ? 'required' : '' ?>>
                            <?php endif ?>
                        </div>
                    <?php endforeach; ?>

                    <button type="submit" class="btn btn-primary btn-block mt-4">
                        <i class="fas fa-paper-plane"></i> Kirim Jawaban
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Font Awesome (optional for icons) -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
