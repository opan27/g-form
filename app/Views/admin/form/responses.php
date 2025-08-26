<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Jawaban Form: <?= esc($form['judul']) ?></h1>

    <a href="/admin/forms" class="btn btn-secondary mb-3">← Kembali ke Daftar Form</a>
    <a href="/admin/forms/<?= $form['id'] ?>/export" class="btn btn-success mb-3" target="_blank">
    📥 Export Jawaban (CSV)
    </a>


    <?php if (empty($responses)): ?>
        <div class="alert alert-info">Belum ada yang mengisi form ini.</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th>#</th>
                        <?php foreach ($fields as $f): ?>
                            <th><?= esc($f['label']) ?></th>
                        <?php endforeach; ?>
                        <th>Waktu Submit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; foreach ($responses as $r): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <?php foreach ($fields as $f): ?>
                            <td><?= esc($data[$r['id']][$f['id']] ?? '-') ?></td>
                        <?php endforeach; ?>
                        <td><?= date('d/m/Y H:i', strtotime($r['created_at'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection(); ?>
