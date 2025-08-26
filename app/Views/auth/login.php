<!-- app/Views/auth/login.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Bantet</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome & SB Admin CSS -->
    <link href="/assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="/assets/css/sb-admin-2.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #4e73df, #224abe);
        }
        .card {
            border-radius: 1rem;
        }
        .form-control-user {
            border-radius: 10rem;
        }
        .btn-user {
            border-radius: 10rem;
        }
    </style>
</head>
<body>

    <div class="container">

        <!-- Centered Row -->
        <div class="row justify-content-center align-items-center" style="height: 100vh;">

            <div class="col-xl-5 col-lg-6 col-md-8">

                <div class="card o-hidden shadow-lg">
                    <div class="card-body p-5">

                        <!-- Title -->
                        <div class="text-center mb-4">
                            <h1 class="h4 text-gray-900 font-weight-bold">Login <span class="text-primary">Bantet</span></h1>
                            <p class="text-muted small">Silakan masuk dengan akun Anda</p>
                        </div>

                        <!-- Flash Error -->
                        <?php if(session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger">
                                <?= session()->getFlashdata('error') ?>
                            </div>
                        <?php endif ?>

                        <!-- Form Login -->
                        <form action="/auth/login" method="post" class="user">
                            <?= csrf_field(); ?>
                            <div class="form-group">
                                <input type="text" name="username" class="form-control form-control-user" placeholder="Username" required autofocus>
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" class="form-control form-control-user" placeholder="Password" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                <i class="fas fa-sign-in-alt mr-1"></i> Masuk
                            </button>
                        </form>

                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Scripts -->
    <script src="/assets/vendor/jquery/jquery.min.js"></script>
    <script src="/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/sb-admin-2.min.js"></script>

</body>
</html>
