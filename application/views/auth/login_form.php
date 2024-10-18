<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - File Sharing Unej</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?=base_url('assets')?>/favicon.png" />

    <!-- Bootstrap icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Main style file -->
    <link rel="stylesheet" href="<?=base_url('assets')?>/css/app.css" type="text/css" />
</head>

<body class="auth">

    <!-- begin::preloader-->
    <div class="preloader">
        <div class="preloader-icon"></div>
    </div>
    <!-- end::preloader -->


    <div class="form-wrapper">
        <div class="container">
            <div class="card">
                <div class="row g-0">
                    <div class="col">
                        <div class="row">
                            <div class="col-md-10 offset-md-1">
                                <div class="d-block d-lg-none text-center text-lg-start">
                                    <img width="60" src="<?=base_url('assets')?>/logo.svg" alt="logo">
                                </div>
                                <div class="my-5 text-center text-lg-start">
                                    <h1 class="display-8">Login</h1>
                                    <p class="text-muted">Sign in to your sister account !!</p>
                                </div>
                                <form class="mb-5" action="<?=base_url('auth/login')?>" method="post">
                                    <div class="mb-3">
                                        <input type="text" class="form-control" name="username"
                                            placeholder="Enter Username" autofocus required>
                                    </div>
                                    <div class="mb-3">
                                        <input type="password" class="form-control" name="password"
                                            placeholder="Enter password" required>
                                    </div>
                                    <div class="text-center text-lg-start">
                                        <!-- <p class="small">Can't access your account? <a href="#">Reset your password
                                                now</a>.</p> -->
                                        <button class="btn btn-primary btn-block w-100">Sign In</button>
                                    </div>
                                </form>
                                <div class="social-links justify-content-center">

                                </div>
                                <p class="text-center d-block d-lg-none mt-5 mt-lg-0">
                                    Don't have an account? <a href="#">Sign up</a>.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div
                        class="col d-none d-lg-flex border-start align-items-center justify-content-between flex-column text-center">
                        <div class="logo">
                            <img width="60" src="<?=base_url('assets')?>/logo.svg" alt="logo">
                        </div>
                        <div>
                            <h3 class="fw-bold">Welcome to File Manager System</h3>
                            <h4 class="fw-bold">Universitas Jember</h4>


                        </div>
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <a href="#">Privacy Policy</a>
                            </li>
                            <li class="list-inline-item">
                                <a href="#">Terms & Conditions</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- JQuery -->
    <script src="<?=base_url('assets')?>/libs/jquery-3.7.1.min.js"></script>

    <!-- Main Javascript file -->
    <script src="<?=base_url('assets')?>/js/app.js"></script>
</body>

</html>