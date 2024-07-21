<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Giriş Yapınız</title>
    <link rel="stylesheet" href="assets/vendors/core/core.css">
    <link rel="stylesheet" href="assets/fonts/feather-font/css/iconfont.css">
    <link rel="stylesheet" href="assets/css/demo_1/style.css">
</head>

<body>
    <div class="main-wrapper">
        <div class="page-wrapper full-page">
            <div class="page-content d-flex align-items-center justify-content-center">
                <div class="row w-100 mx-0 auth-page">
                    <div class="col-md-8 col-xl-6 mx-auto">
                        <div class="card">
                            <div class="row">
                                <div class="col-md-12 pl-md-0">
                                    <div class="auth-form-wrapper px-4 py-5">
                                        <form class="forms-sample" action="set/login.html" method="post" id="login-form">
                                            <div class="mt-5 text-center">
                                                <h6 class="card-title">Giriş Yapınız</h6>
                                            </div>
                                            <div class="form-group mt-3">
                                                <label for="exampleInputEmail1">E-posta Adresiniz</label>
                                                <input type="text" name="e_posta" class="form-control" id="e_posta" autocomplete="off" placeholder="E-posta Adresiniz">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Şifre</label>
                                                <input type="password" name="sifre" class="form-control" id="sifre" autocomplete="off" autocomplete="current-password" placeholder="Şifre">
                                            </div>
                                            <div class="mt-5 text-center">
                                                <button type="submit" name="admingiris" class="btn btn-primary mr-2 mb-2 mb-md-0 text-white" style="background: #d2a042e0 !important; border-color: #d2a042e0 !important;">Giriş
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script src="assets/vendors/core/core.js"></script>
    <script src="assets/vendors/feather-icons/feather.min.js"></script>
    <script src="assets/js/template.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        <?php if (@$_GET['q'] == 'c') { ?>
            Swal.fire(
                '',
                'Tekrar görüşmek üzere !',
                'success'
            )
        <?php } ?>
    </script>
</body>

</html>