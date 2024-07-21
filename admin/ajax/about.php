<?php
include_once(__DIR__ . '/../set/func.php');

usercontrol();

$request = fpost('request');

if ($request == 'about-update') {
    $id = 1;
    
    $description = fpost('description');
    $datas = [];
    $datas = [
        'description' => $description,
        'id' => $id
    ];
    $sart = "(id=:id)";

    $response = dbGuncelle('about_us', $datas, $sart);

    headerLocate('hakkimizda.html', $response);
    exit;
}
