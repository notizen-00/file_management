<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>404 - CakeAdmin Bootstrap 5 Demo</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?=base_url('assets/images/favicon.png')?>" />

    <!-- Main style file -->
    <link rel="stylesheet" href="<?=base_url('assets/css/app.css')?>" type="text/css">
</head>

<body class="d-md-flex align-items-center justify-content-center">
    <div class="container text-center p-5 p-md-0">
        <div class="row mb-4">
            <div class="col-md-5 m-auto">
                <figure>
                    <img class="img-fluid" src="<?=base_url('assets/images/svg/404.svg')?>" alt="image">
                </figure>
            </div>
        </div>
        <h2 class="display-6">Page not found</h2>
        <p class="text-muted my-4">The page you want to go is not currently available</p>
        <div class="d-flex gap-3 justify-content-center">
            <a href="<?=base_url()?>" class="btn btn-primary">Home Page</a>
            <a href="javascript:history.back()" class="btn bg-white">Back</a>
        </div>
    </div>
</body>

</html>