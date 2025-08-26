<!-- app/Views/layout/template.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Admin Panel'; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="/assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="/assets/css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <?= $this->include('layout/sidebar'); ?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <?= $this->include('layout/topbar'); ?>

            <!-- Begin Page Content -->
            <div class="container-fluid">
                <?= $this->renderSection('content'); ?>
            </div>

        </div>

        <!-- Footer -->
        <?= $this->include('layout/footer'); ?>

    </div>
</div>

<script src="/assets/vendor/jquery/jquery.min.js"></script>
<script src="/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/assets/js/sb-admin-2.min.js"></script>

</body>
</html>
