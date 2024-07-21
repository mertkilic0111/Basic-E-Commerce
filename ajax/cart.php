<?php require_once('../admin/set/func.php');

$request = fpost('request');

if ($request == 'add-cart') {
    $id = post('i');
    numeric($id);
    $quantity = post('quantity');
    numeric($quantity);

    $_SESSION['cart'][$id] = [
        'quantity' => $quantity
    ];

    echo 1;
    exit;
} else if ($request == 'remove-cart') {
    $id = post('i');
    decrypt($id);

    unset($_SESSION['cart'][$id]);

    echo 1;
    exit;
} else if ($request == 'update-cart') {
    $id = post('i');
    decrypt($id);

    unset($_SESSION['cart'][$id]);

    $quantity = post('quantity');
    numeric($quantity);

    $_SESSION['cart'][$id] = [
        'quantity' => $quantity
    ];

    echo 1;
    exit;
} else if ($request == 'save-cart') {
    $name_surname = post('name_surname');
    $ctime = time();
    $visible_order_token = koduret();
    $order_token =  $visible_order_token . '-' . encrypt(microtime());

    if (isset($_SESSION['cart']) && count($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $cartItem => $cartItemValue) {
            numeric($cartItem);
            $products = $db->prepare("SELECT * FROM products WHERE id=:id");
            $products->execute([':id' => $cartItem]);
            $product = $products->fetch();
            if ($product) {
                $total_payment = fiyatKaydet(fiyatYazdir($cartItemValue['quantity'] * $product['price']));
                $datas = [];
                $datas = [
                    'order_token' => $order_token,
                    'visible_order_token' => $visible_order_token,
                    'name_surname' => $name_surname,
                    'product_id' => $cartItem,
                    'quantity' => $cartItemValue['quantity'],
                    'price' => $product['price'],
                    'total_payment' => $total_payment,
                    'ctime' => $ctime
                ];
                dbEkle('orders', $datas);
            } else {
                echo 0;
                exit;
            }
        }

        $_SESSION['cart'] = [];

        echo 1;
        exit;
    } else {
        echo 0;
        exit;
    }
}
