<?php

include_once(__DIR__ . '/../set/func.php');
usercontrol();
$request = htmlspecialchars($_POST['request']);
if ($request == 'settings-update') {
    $id = 1;

    if ($_FILES['logo']['size'] > 0) {
        $logo = imageSave($_FILES['logo'], '/imgs/', fpost('old_logo'));
    } else {
        $logo = fpost('old_logo');
    }

    if ($_FILES['favicon']['size'] > 0) {
        $favicon = imageSave($_FILES['favicon'], '/imgs/', fpost('old_favicon'));
    } else {
        $favicon = fpost('old_favicon');
    }

    $datas = [];
    $datas = [
        'logo' => $logo,
        'favicon' => $favicon,
        'web_site' => fpost('web_site'),
        'site_title' => fpost('site_title'),
        'site_desc' => fpost('site_desc'),
        'address' => fpost('address'),
        'phone_number' => fpost('phone_number'),
        'e_mail' => fpost('e_mail'),
        'maps_link' => fpost('maps_link'),
        'id' => $id
    ];
    $sart = "(id=:id)";

    $response = dbGuncelle('settings', $datas, $sart);

    if (!empty(fpost('sifre'))) {
        $password = encrypt(fpost('sifre'));
    } else {
        $password = fpost('old_pwd');
    }

    $datas = [];
    $datas = [
        'e_posta' => fpost('e_posta'),
        'sifre' => $password,
        'id' => $id
    ];
    $sart = "(id=:id)";

    $response = dbGuncelle('admins', $datas, $sart);

    headerLocate('genel-ayarlar.html', $response);
    exit;
}
