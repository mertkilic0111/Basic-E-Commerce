<?php

@ob_start();
@session_start();
date_default_timezone_set('Europe/Istanbul');
require_once(__DIR__ . '/connect.php');

error_reporting(0);

if (!isset($_POST['token'])) {
    $_SESSION['token'] = md5(microtime());
}

if (!@$_SESSION['adminLanguage']) {
    $_SESSION['adminLanguage'] = 'tr';
    $dil = $_SESSION['adminLanguage'];
} else {
    $dil = $_SESSION['adminLanguage'];
}

@$user = @$_SESSION['userinfo'];

define('CIPHER', 'AES-128-ECB');
define('KEY', 'epJx[Um+]RJInFi');

if (!function_exists('encrypt')) {
    function encrypt($data)
    {
        $encrypted = openssl_encrypt($data, CIPHER, KEY);
        return base64_encode($encrypted);
    }
}

if (!function_exists('decrypt')) {
    function decrypt($data)
    {
        $decoded = base64_decode($data);
        return openssl_decrypt($decoded, CIPHER, KEY);
    }
}

if (!function_exists('uid')) {
    function uid($data = null)
    {
        $data = $data ?? random_bytes(16);

        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}

if (!function_exists('koduret')) {
    function koduret()
    {
        $chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $uid = '';
        for ($i = 0; $i < 4; $i++) {
            for ($j = 0; $j < 4; $j++) {
                $uid .= $chars[mt_rand(0, strlen($chars) - 1)];
            }
            if ($i < 3) {
                $uid .= '-';
            }
        }
        return $uid;
    }
}

if (!function_exists('bindParamTuru')) {
    function bindParamTuru($deger)
    {
        return is_int($deger) ? PDO::PARAM_INT : PDO::PARAM_STR;
    }
}

if (!function_exists('dbRemove')) {
    function dbRemove($tablo, $kosul)
    {
        global $db;

        $kosulMetni = implode(" AND ", array_map(function ($anahtar) {
            return "$anahtar = :$anahtar";
        }, array_keys($kosul)));

        $sorgu = "DELETE FROM $tablo WHERE $kosulMetni";
        $stmt = $db->prepare($sorgu);

        foreach ($kosul as $anahtar => $deger) {
            $paramTuru = bindParamTuru($deger);
            $stmt->bindValue(":$anahtar", $deger, $paramTuru);
        }

        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            die("Veri silinirken hata oluştu: " . $e->getMessage());
        }
    }
}

if (!function_exists('dbEkle')) {
    function dbEkle($tablo, $veri)
    {
        global $db;

        $kolonlar = implode(", ", array_keys($veri));
        $degerler = ":" . implode(", :", array_keys($veri));
        $sorgu = "INSERT INTO $tablo ($kolonlar) VALUES ($degerler)";
        $stmt = $db->prepare($sorgu);

        foreach ($veri as $anahtar => $deger) {
            $paramTuru = bindParamTuru($deger);
            $stmt->bindValue(":$anahtar", $deger, $paramTuru);
        }

        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            die("Veri eklenirken hata oluştu: " . $e->getMessage());
        }
    }
}

if (!function_exists('dbGuncelle')) {
    function dbGuncelle($tablo, $veri, $sart)
    {
        global $db;
        $set = "";
        foreach ($veri as $anahtar => $deger) {
            if ($anahtar !== 'id') {
                $set .= "$anahtar=:$anahtar, ";
            }
        }
        $set = rtrim($set, ", ");
        $sorgu = "UPDATE $tablo SET $set WHERE $sart";
        $stmt = $db->prepare($sorgu);

        foreach ($veri as $anahtar => $deger) {
            $paramTuru = bindParamTuru($deger);
            $stmt->bindValue(":$anahtar", $deger, $paramTuru);
        }

        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            die("Veri güncellenirken hata oluştu: " . $e->getMessage());
        }
    }
}

if (!function_exists('dbSelect')) {
    function dbSelect($tablo, $sart, $orderBy = null)
    {
        global $db;

        // Koşulları hazırla
        $kosul = implode(" AND ", array_map(function ($key) {
            return "$key = :$key";
        }, array_keys($sart)));

        // Sorguyu hazırla
        $sorgu = "SELECT * FROM $tablo WHERE $kosul";
        if ($orderBy) {
            $sorgu .= " ORDER BY $orderBy";
        }

        $stmt = $db->prepare($sorgu);

        // Parametreleri bağla
        foreach ($sart as $anahtar => $deger) {
            $paramTuru = bindParamTuru($deger);
            $stmt->bindValue(":$anahtar", $deger, $paramTuru);
        }

        try {
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Veri seçilirken hata oluştu: " . $e->getMessage());
            return false;
        }
    }
}

if (!function_exists('tokenkontrol')) {
    function tokenkontrol($postvalue)
    {
        if ($postvalue != $_SESSION['token']) {
            // echo 'Error: Unexpected token!';
            // exit;
        }
    }
}

if (!function_exists('usercontrol')) {
    function usercontrol()
    {
        global $user, $db;
        $web_site = $db->query("SELECT web_site FROM settings WHERE id=1")->fetch();
        if ($user['e_posta'] == '' || $user['e_posta'] == NULL) {
            header("Location: {$web_site}");
            exit;
        }
    }
}

if (!function_exists('fpost')) {
    function fpost($post)
    {
        return strip_tags(htmlspecialchars($_POST[$post]));
    }
}

if (!function_exists('oes')) {
    function oes($str, $options = array())
    {
        $str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());
        $defaults = array(
            'delimiter' => '-',
            'limit' => null,
            'lowercase' => true,
            'replacements' => array(),
            'transliterate' => true
        );
        $options = array_merge($defaults, $options);
        $char_map = array(
            // Latin
            'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C',
            'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
            'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O',
            'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH',
            'ß' => 'ss',
            'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c',
            'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
            'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o',
            'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ' => 'th',
            'ÿ' => 'y',
            // Latin symbols
            '©' => '(c)',
            // Greek
            'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8',
            'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
            'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
            'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I',
            'Ϋ' => 'Y',
            'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8',
            'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p',
            'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
            'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's',
            'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',
            // Turkish
            'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
            'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g',
            // Russian
            'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
            'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
            'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
            'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
            'Я' => 'Ya',
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
            'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
            'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
            'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
            'я' => 'ya',
            // Ukrainian
            'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
            'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',
            // Czech
            'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U',
            'Ž' => 'Z',
            'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
            'ž' => 'z',
            // Polish
            'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z',
            'Ż' => 'Z',
            'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z',
            'ż' => 'z',
            // Latvian
            'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N',
            'Š' => 'S', 'Ū' => 'u', 'Ž' => 'Z',
            'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n',
            'š' => 's', 'ū' => 'u', 'ž' => 'z'
        );
        $str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);
        if ($options['transliterate']) {
            $str = str_replace(array_keys($char_map), $char_map, $str);
        }
        $str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);
        $str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);
        $str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');
        $str = trim($str, $options['delimiter']);
        return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
    }
}

if (!function_exists("imageSave")) {
    function imageSave($image, $path, $deleteName = null, $key = -1)
    {
        $org_path = $path;
        $path = __DIR__ . '/../../upload';

        if (!empty($deleteName)) {
            imageRemove($deleteName);
        }

        $imageName = $org_path . md5(rand(0, 100000) . (time() * rand(1, 100)));
        if (isset($key) && $key != -1) {
            //$imageName = $imageName . '-' . $image['name'][$key];
            $imageTmpName = $image['tmp_name'][$key];
            $ext = strtolower(pathinfo($image['name'][$key], PATHINFO_EXTENSION));
        } else {
            //$imageName = $imageName . '-' . $image['name'];
            $imageTmpName = $image['tmp_name'];
            $ext = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
        }
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'ico', 'heic', 'pdf', 'doc', 'docx', 'webp'];
        if (in_array($ext, $allowed)) {
            $upload = move_uploaded_file($imageTmpName, $path . "/" . $imageName . '.' . $ext);
            if ($upload) {
                return 'upload' . $imageName . '.' . $ext;
            }
        } else {
            return false;
        }
    }
}

if (!function_exists("post")) {
    function post($post)
    {
        return isset($_POST[$post]) ? strip_tags(htmlspecialchars(mb_strtoupper(bosluksil(pre_up($_POST[$post], 'UTF-8'))))) : null;
    }
}

if (!function_exists("kelimeTemizle")) {
    function kelimeTemizle($word)
    {
        return isset($word) ? strip_tags(htmlspecialchars(mb_strtoupper(bosluksil(pre_up($word, 'UTF-8'))))) : null;
    }
}

if (!function_exists("fiyatKaydet")) {
    function fiyatKaydet($word)
    {
        if (isset($word)) {
            // Önce noktaları sil ve virgülleri nokta ile değiştir
            $word = str_replace('.', '', $word);
            $word = str_replace(',', '.', $word);

            // Noktadan sonra sadece 2 karakter kaydet
            if (strpos($word, '.') !== false) {
                $parts = explode('.', $word);
                $word = $parts[0] . '.' . substr($parts[1], 0, 2);
            }

            // Diğer işlemler
            return strip_tags(htmlspecialchars(mb_strtoupper(bosluksil(pre_up($word, 'UTF-8')))));
        }
        return null;
    }
}

if (!function_exists("fiyatYazdir")) {
    function fiyatYazdir($number)
    {
        if (isset($number)) {
            // Sayıyı 2 ondalık basamakla yuvarla
            $number = number_format($number, 2, ',', '.');
            return $number;
        }
        return null;
    }
}

if (!function_exists("numeric")) {
    function numeric($post)
    {
        if (!is_numeric($post)) {
            echo "NON NUMERIC";
            return exit;
        }
    }
}

if (!function_exists('bosluksil')) {
    function bosluksil($string)
    {
        $string = preg_replace("/\s+/", " ", $string);
        $string = trim($string);
        return $string;
    }
}

if (!function_exists('uzantibul')) {
    function uzantibul($file)
    {
        $array = explode('.', $file);
        $key   = count($array) - 1;
        $ext   = $array[$key];
        return $ext;
    }
}

if (!function_exists('pre_up')) {
    function pre_up($str)
    {
        $str = str_replace('i', 'İ', $str);
        $str = str_replace('ı', 'I', $str);
        return $str;
    }
}

if (!function_exists('kucuk_yap')) {
    function kucuk_yap($gelen)
    {
        $gelen = str_replace('Ç', 'ç', $gelen);
        $gelen = str_replace('Ğ', 'ğ', $gelen);
        $gelen = str_replace('I', 'ı', $gelen);
        $gelen = str_replace('İ', 'i', $gelen);
        $gelen = str_replace('Ö', 'ö', $gelen);
        $gelen = str_replace('Ş', 'ş', $gelen);
        $gelen = str_replace('Ü', 'ü', $gelen);
        $gelen = strtolower($gelen);

        return $gelen;
    }
}

if (!function_exists("headerLocate")) {
    function headerLocate($url, $control, $mobile = 0, $params = 0, $seperator = '&')
    {

        global $user;
        if ($mobile == 1) {
            //$url = '../m.' . $user['user_path'] . '/' . $url;
        } else {
            $url = '../' . $user['user_path'] . '/' . $url;
        }
        if ($params == 0) {
            if ($control == true) {
                $control = '?e=ok';
            } else {
                $control = '?e=no';
            }
        } else {
            if ($control == true) {
                $control = $seperator . 'e=ok';
            } else {
                $control = $seperator . 'e=no';
            }
        }
        return header('Location: ' . $url . $control);
        exit;
    }
}
