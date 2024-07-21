<?php


$settings = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_CASE => PDO::CASE_NATURAL,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $db = new PDO("mysql:host=localhost;dbname=your_db_name_is_here;charset=utf8", 'your_db_username_is_here', 'your_db_pwd_is_here', $settings);
} catch (PDOExpception $e) {
    echo $e->getMessage();
}
