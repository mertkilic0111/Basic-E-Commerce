<?php include('header.php'); ?>
<?php
$datas = $db->prepare("SELECT * FROM settings WHERE id=:id");
$datas->execute(['id' => 1]);
$data = $datas->fetch();
if (!$data) {
    require_once('404.php');
    exit;
}

$adminDatas = $db->prepare("SELECT * FROM admins WHERE id=:id");
$adminDatas->execute(['id' => 1]);
$adminData = $adminDatas->fetch();
if (!$data) {
    require_once('404.php');
    exit;
} ?>
<div class="page-content">
    <div class="row">
        <div class="col-md-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title"> Site Ayarları</h6>
                    <form action="../ajax/settings.html" method="POST" enctype="multipart/form-data">
                        <input type="hidden" value="settings-update" name="request">
                        <input type="hidden" value="<?= $_SESSION['token']; ?>" name="token">
                        <input type="hidden" value="<?= $adminData['sifre']; ?>" name="old_pwd">
                        <input type="hidden" value="<?= $data['logo']; ?>" name="old_logo">
                        <input type="hidden" value="<?= $data['favicon']; ?>" name="old_favicon">
                        <div class="row">
                            <div class="col-sm-3 text-center">
                                <img src="../../<?= $data['logo']; ?>" style="width: 100px;" alt="">
                            </div>
                            <div class="col-sm-9">
                                <div class="form-group">
                                    <label>Logo</label>
                                    <div class="input-group col-xs-12">
                                        <input type="file" name="logo" class="form-control" placeholder="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-sm-3 text-center">
                                <img src="../../<?= $data['favicon']; ?>" style="width: 100px;" alt="">
                            </div>
                            <div class="col-sm-9">
                                <div class="form-group">
                                    <label>Favicon</label>
                                    <div class="input-group col-xs-12">
                                        <input type="file" name="favicon" class="form-control" placeholder="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body row">
                            <div class="col-md-6 mt-4">
                                <h6 class="card-title">Yönetim Paneli E-posta</h6>
                                <div>
                                    <input type="text" autocomplete="off" name="e_posta" required value="<?= $adminData['e_posta']; ?>" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6 mt-4">
                                <h6 class="card-title">Yönetim Paneli Şifre</h6>
                                <div>
                                    <input type="text" autocomplete="off" name="sifre" value="<?= $data['sifre']; ?>" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h6 class="card-title">Site Başlık</h6>
                            <p class="mb-2">Oturum sonlandığında yönleneceği sayfadır.</p>
                            <div>
                                <input type="text" autocomplete="off" name="web_site" required value="<?= $data['web_site']; ?>" class="form-control">
                            </div>
                        </div>
                        <div class="card-body">
                            <h6 class="card-title">Site Başlık</h6>
                            <p class="mb-2">Arama motorlarında gözükecek başlıktır.</p>
                            <div>
                                <input type="text" autocomplete="off" name="site_title" value="<?= $data['site_title']; ?>" class="form-control">
                            </div>
                        </div>
                        <div class="card-body">
                            <h6 class="card-title">Site Açıklama</h6>
                            <p class="mb-2">Arama motorlarında gözükecek açıklama yazısıdır.</p>
                            <div>
                                <textarea name="site_desc" class="form-control" rows="5"><?= $data['site_desc']; ?></textarea>
                            </div>
                        </div>
                        <div class="card-body">
                            <h6 class="card-title">Harita Linki</h6>
                            <div>
                                <input type="text" class="form-control" name="maps_link" value="<?= $data['maps_link']; ?>">
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mt-4">
                                    <h6 class="card-title">E-posta</h6>
                                    <div>
                                        <input type="text" autocomplete="off" name="e_mail" value="<?= $data['e_mail']; ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6 mt-4">
                                    <h6 class="card-title">Telefon</h6>
                                    <div>
                                        <input type="text" autocomplete="off" name="phone_number" value="<?= $data['phone_number']; ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12 mt-4">
                                    <h6 class="card-title">Adres</h6>
                                    <div>
                                        <input type="text" autocomplete="off" name="address" value="<?= $data['address']; ?>" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 text-center mt-5">
                                <button type="submit" name="siteYonetimi" class="btn btn-success">Kaydet
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once('footer.php'); ?>