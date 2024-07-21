<?php

include('func.php');

if (isset($_POST['e_posta']) && isset($_POST['sifre']) && isset($_POST['admingiris'])) {

    $e_posta = fpost('e_posta');
    $sifre = encrypt(fpost('sifre'));

    $datas = $db->prepare("SELECT * FROM admins WHERE e_posta= :e_posta AND sifre= :sifre");
    $datas->bindParam(':e_posta', $e_posta, PDO::PARAM_STR);
    $datas->bindParam(':sifre', $sifre, PDO::PARAM_STR);
    $datas->execute();
    $datasRowCount = $datas->rowCount();
    if ($datasRowCount) {
        $data = $datas->fetch(PDO::FETCH_ASSOC);
        if ($data) {
            $_SESSION['oturum'] = 'ok';
            $_SESSION['userinfo'] = $data;
            header("Location: ../{$data['user_path']}/");
            exit;
        } else {
            header("Location: ../?q=hatali-sfire");
            exit;
        }
    } else {
        header("Location: ../?q=hatali-sfire");
        exit;
    }
} else {
    header("Location: ../?q=eksik-parametre");
    exit;
}
