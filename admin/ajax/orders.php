<?php
include_once(__DIR__ . '/../set/func.php');

usercontrol();

$request = fpost('request');

if ($request == 'get-all-orders') {
    $response = [];

    $draw = kelimeTemizle($_POST['draw']);
    $row = kelimeTemizle($_POST['start']);
    $rowperpage = kelimeTemizle($_POST['length']);
    $columnIndex = kelimeTemizle($_POST['order'][0]['column']);
    $columnName = kelimeTemizle($_POST['columns'][$columnIndex]['data']);
    $columnSortOrder = kelimeTemizle($_POST['order'][0]['dir']);
    $searchValue = kelimeTemizle($_POST['search']['value']);

    $searchArray = array();

    $searchQuery = " ";
    if ($searchValue != '') {
        $searchQuery = " (name_surname LIKE :name_surname OR total_payment LIKE :total_payment) ";
        $searchArray = array(
            'name_surname' => "%$searchValue%",
            'total_payment' => "%$searchValue%"
        );
    } else {
        $searchQuery = " 1 ";
    }

    $stmt = $db->prepare("SELECT COUNT(*) as allcount FROM orders GROUP BY visible_order_token");
    $stmt->execute();
    $records = $stmt->fetch();
    $response['recordsTotal'] = $records['allcount'];

    $stmt = $db->prepare("SELECT COUNT(*) as allcount FROM orders WHERE $searchQuery GROUP BY visible_order_token");
    $stmt->execute($searchArray);
    $records = $stmt->fetch();
    $response['recordsFiltered'] = $records['allcount'];

    $stmt = $db->prepare("SELECT * FROM orders
    WHERE $searchQuery GROUP BY visible_order_token ORDER BY $columnName $columnSortOrder LIMIT :limit,:offset");

    foreach ($searchArray as $key => $search) {
        $stmt->bindValue(':' . $key, $search, PDO::PARAM_STR);
    }

    $stmt->bindValue(':limit', (int)$row, PDO::PARAM_INT);
    $stmt->bindValue(':offset', (int)$rowperpage, PDO::PARAM_INT);
    $stmt->execute();
    $datas = $stmt->fetchAll();
    $data = array();
    $response['data'] = [];
    foreach ($datas as $data) {
        $total_payment = 0;
        $order_detail_html = '';

        $orderProductsQuery = "SELECT orders.*, products.name, SUM(orders.price * orders.quantity) as total_payment_sum
        FROM orders 
        JOIN products ON orders.product_id = products.id 
        WHERE orders.visible_order_token = :visible_order_token
        GROUP BY orders.visible_order_token, orders.id, products.name";

        $orderProductsStmt = $db->prepare($orderProductsQuery);
        $orderProductsStmt->execute([':visible_order_token' => $data['visible_order_token']]);

        while ($orderProduct = $orderProductsStmt->fetch()) {
            $order_detail_html .= $orderProduct['name'] . '<br><small class="color-red">' . $orderProduct['price'] . ' x ' . $orderProduct['quantity'] . '</small><br>';
            $total_payment += $orderProduct['total_payment_sum'];
        }

        $response['data'][] = [
            'id' => encrypt($data['id']),
            'name_surname' => kelimeTemizle($data['name_surname']),
            'order_summary' => $order_detail_html,
            'total_payment' => fiyatYazdir($total_payment) . ' ₺',
            'ctime' => date('d.m.Y H:i', $data['ctime']),
            'buttons' => '<a href="javascript:;" onclick="removeOrder(\'' . encrypt($data['visible_order_token']) . '\');" class="btn btn-danger btn-sm ml-2">Sil</a>'
        ];
    }

    echo json_encode($response);
    exit;
} else if ($request == 'remove-order') {
    $visible_order_token = decrypt(fpost('i'));

    $response = dbRemove('orders', ['visible_order_token' => $visible_order_token]);
    if ($response) {
        echo json_encode(['success' => true]);
        exit;
    } else {
        echo json_encode(['success' => false, 'message' => 'Hata oluştu.']);
        exit;
    }
}
